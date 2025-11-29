<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CheckIn;
use App\Models\User;
use Illuminate\Http\Request;

class CheckInController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        // Validate pagination parameter (Test case 10: URL parameters)
        $perPage = $request->input('per_page', 20);
        if (!is_numeric($perPage) || $perPage < 1 || $perPage > 100) {
            $perPage = 20;
        }

        $query = CheckIn::with(['user'])
            ->orderByDesc('check_in_date')
            ->orderByDesc('created_at');

        // Filter by user
        if ($request->has('user_id') && $request->user_id != '') {
            // Validate user_id (Test case 3: ID không tồn tại)
            if (!is_numeric($request->user_id) || !User::find($request->user_id)) {
                return back()->with('error', 'Người dùng không tồn tại.');
            }
            $query->where('user_id', $request->user_id);
        }

        // Filter by date
        if ($request->has('date_from') && $request->date_from != '') {
            $query->where('check_in_date', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to != '') {
            $query->where('check_in_date', '<=', $request->date_to);
        }

        // Filter by reward type
        if ($request->has('reward_type') && $request->reward_type != '') {
            $query->where('reward_type', $request->reward_type);
        }

        // Search by user name or email
        if ($request->has('search') && $request->search != '') {
            $search = trim($request->search);
            // Kiểm tra khoảng trắng (Test case 6)
            if (!empty($search)) {
                $query->whereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            }
        }

        $checkIns = $query->paginate((int)$perPage)->withQueryString();
        
        // Lấy danh sách users để filter
        $users = User::orderBy('name')->get(['id', 'name', 'email']);

        return view('admin.checkins.index', compact('checkIns', 'users'));
    }

    public function store(Request $request)
    {
        // Test case 4: Validate form
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'check_in_date' => ['required', 'date', 'before_or_equal:today'],
            'day_number' => ['nullable', 'integer', 'min:1'],
        ], [
            'user_id.required' => 'Vui lòng chọn người dùng.',
            'user_id.exists' => 'Người dùng không tồn tại.',
            'check_in_date.required' => 'Vui lòng chọn ngày điểm danh.',
            'check_in_date.date' => 'Ngày điểm danh không hợp lệ.',
            'check_in_date.before_or_equal' => 'Không thể điểm danh cho ngày tương lai. Vui lòng chọn ngày hôm nay hoặc ngày đã qua.',
            'day_number.integer' => 'Số ngày phải là số nguyên.',
            'day_number.min' => 'Số ngày phải lớn hơn 0.',
        ]);

        try {
            // Kiểm tra xem user đã điểm danh ngày này chưa (Test case 9: Trùng lặp dữ liệu)
            $existingCheckIn = CheckIn::where('user_id', $validated['user_id'])
                ->where('check_in_date', $validated['check_in_date'])
                ->first();

            if ($existingCheckIn) {
                return back()->with('error', 'Người dùng này đã điểm danh vào ngày ' . date('d/m/Y', strtotime($validated['check_in_date'])) . ' rồi.');
            }

            // Tính day_number nếu không được cung cấp
            $dayNumber = $validated['day_number'] ?? null;
            if (!$dayNumber) {
                $currentStreak = CheckIn::getCurrentStreak($validated['user_id']);
                $dayNumber = $currentStreak + 1;
            }

            // Lấy cấu hình phần thưởng
            $rewardConfig = CheckIn::getRewardConfig($dayNumber);

            $checkIn = CheckIn::create([
                'user_id' => $validated['user_id'],
                'check_in_date' => $validated['check_in_date'],
                'day_number' => $dayNumber,
                'reward_type' => $rewardConfig['type'],
                'reward_value' => $rewardConfig['value'],
                'reward_description' => $rewardConfig['description'],
            ]);

            return back()->with('success', 'Đã thêm điểm danh thành công cho người dùng.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Error creating check-in', [
                'error' => $e->getMessage(),
                'data' => $validated,
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Có lỗi xảy ra khi thêm điểm danh. Vui lòng thử lại.')->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            // Test case 1: Xóa mục không tồn tại (concurrent delete)
            // Test case 3: ID không tồn tại
            // Validate ID
            if (!is_numeric($id)) {
                return back()->with('error', 'ID không hợp lệ.');
            }

            $checkIn = CheckIn::find($id);
            
            // Kiểm tra xem check-in có tồn tại không
            if (!$checkIn) {
                return back()->with('error', 'Điểm danh này đã được xóa. Vui lòng tải lại trang.');
            }

            $userName = $checkIn->user->name ?? 'Người dùng';
            $checkInDate = $checkIn->check_in_date->format('d/m/Y');
            
            $checkIn->delete();

            return back()->with('success', "Đã xóa điểm danh của {$userName} ngày {$checkInDate} thành công.");
        } catch (\Exception $e) {
            \Log::error('Error deleting check-in', [
                'error' => $e->getMessage(),
                'check_in_id' => $id ?? null,
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Có lỗi xảy ra khi xóa điểm danh. Vui lòng tải lại trang.');
        }
    }
}
