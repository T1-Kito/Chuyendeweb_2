<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CheckIn;
use Illuminate\Support\Facades\Auth;

class CheckInController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Hiển thị trang điểm danh
     */
    public function index()
    {
        $user = Auth::user();
        $hasCheckedInToday = CheckIn::hasCheckedInToday($user->id);
        $currentStreak = CheckIn::getCurrentStreak($user->id);
        $checkInHistory = CheckIn::where('user_id', $user->id)
                              ->orderBy('check_in_date', 'desc')
                              ->limit(30)
                              ->get();

        // Tạo grid 21 ngày (3 hàng x 7 cột)
        $checkInGrid = $this->generateCheckInGrid($user->id);

        return view('checkin.index', compact(
            'hasCheckedInToday',
            'currentStreak',
            'checkInHistory',
            'checkInGrid'
        ));
    }

    /**
     * Thực hiện điểm danh
     */
    public function checkIn(Request $request)
    {
        $user = Auth::user();

        // Kiểm tra đã điểm danh hôm nay chưa
        if (CheckIn::hasCheckedInToday($user->id)) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn đã điểm danh hôm nay rồi!'
            ]);
        }

        // Tạo điểm danh mới
        $checkIn = CheckIn::createCheckIn($user->id);

        if (!$checkIn) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể tạo điểm danh!'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Điểm danh thành công!',
            'checkIn' => $checkIn,
            'currentStreak' => $checkIn->day_number
        ]);
    }

    /**
     * Nhận phần thưởng
     */
    public function claimReward(Request $request, $checkInId)
    {
        $user = Auth::user();
        $checkIn = CheckIn::where('id', $checkInId)
                         ->where('user_id', $user->id)
                         ->first();

        if (!$checkIn) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy điểm danh!'
            ]);
        }

        if ($checkIn->is_claimed) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn đã nhận phần thưởng này rồi!'
            ]);
        }

        // Cập nhật trạng thái đã nhận
        $checkIn->update([
            'is_claimed' => true,
            'claimed_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Nhận phần thưởng thành công!',
            'reward' => [
                'type' => $checkIn->reward_type,
                'value' => $checkIn->reward_value,
                'description' => $checkIn->reward_description
            ]
        ]);
    }

    /**
     * Tạo grid điểm danh 21 ngày
     */
    private function generateCheckInGrid($userId)
    {
        $grid = [];
        $checkIns = CheckIn::where('user_id', $userId)
                          ->orderBy('check_in_date', 'desc')
                          ->get()
                          ->keyBy('day_number');

        // Tạo 21 ngày (3 hàng x 7 cột)
        for ($day = 1; $day <= 21; $day++) {
            $rewardConfig = CheckIn::getRewardConfig($day);
            $isCompleted = isset($checkIns[$day]);
            $isToday = $day === (CheckIn::getCurrentStreak($userId) + 1);

            $grid[] = [
                'day' => $day,
                'reward_type' => $rewardConfig['type'],
                'reward_value' => $rewardConfig['value'],
                'reward_description' => $rewardConfig['description'],
                'is_completed' => $isCompleted,
                'is_today' => $isToday,
                'check_in' => $checkIns[$day] ?? null
            ];
        }

        return array_chunk($grid, 7); // Chia thành 3 hàng, mỗi hàng 7 ngày
    }
}
