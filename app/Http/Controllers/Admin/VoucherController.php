<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VoucherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Hiển thị danh sách voucher
     */
    public function index()
    {
        $this->ensureAdmin();
        
        $vouchers = Voucher::orderBy('created_at', 'desc')->get();
        
        return view('admin.vouchers.index', compact('vouchers'));
    }

    /**
     * Hiển thị form tạo voucher
     */
    public function create()
    {
        $this->ensureAdmin();
        
        return view('admin.vouchers.create');
    }

    /**
     * Lưu voucher mới
     */
    public function store(Request $request)
    {
        $this->ensureAdmin();
        
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:starts_at',
            'is_active' => 'boolean'
        ]);

        // Tạo mã voucher tự động nếu không có
        if (!$request->has('code') || empty($request->code)) {
            $data['code'] = $this->generateVoucherCode();
        } else {
            $data['code'] = strtoupper($request->code);
        }

        // Xử lý boolean
        $data['is_active'] = $request->has('is_active');

        Voucher::create($data);

        return redirect()->route('admin.vouchers.index')
                        ->with('success', 'Voucher đã được tạo thành công!');
    }

    /**
     * Hiển thị form chỉnh sửa voucher
     */
    public function edit(Voucher $voucher)
    {
        $this->ensureAdmin();
        
        return view('admin.vouchers.edit', compact('voucher'));
    }

    /**
     * Cập nhật voucher
     */
    public function update(Request $request, Voucher $voucher)
    {
        $this->ensureAdmin();
        
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:starts_at',
            'is_active' => 'boolean'
        ]);

        // Xử lý boolean
        $data['is_active'] = $request->has('is_active');

        $voucher->update($data);

        return redirect()->route('admin.vouchers.index')
                        ->with('success', 'Voucher đã được cập nhật thành công!');
    }

    /**
     * Xóa voucher
     */
    public function destroy(Voucher $voucher)
    {
        $this->ensureAdmin();
        
        $voucher->delete();
        
        return redirect()->route('admin.vouchers.index')
                        ->with('success', 'Voucher đã được xóa thành công!');
    }

    /**
     * Toggle trạng thái voucher
     */
    public function toggleStatus(Voucher $voucher)
    {
        $this->ensureAdmin();
        
        $voucher->update(['is_active' => !$voucher->is_active]);
        
        $status = $voucher->is_active ? 'kích hoạt' : 'tạm dừng';
        
        return redirect()->route('admin.vouchers.index')
                        ->with('success', "Voucher đã được {$status}!");
    }

    /**
     * Tạo mã voucher tự động
     */
    private function generateVoucherCode()
    {
        do {
            $code = 'VK' . strtoupper(Str::random(8));
        } while (Voucher::where('code', $code)->exists());
        
        return $code;
    }

}
