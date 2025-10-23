<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CheckIn extends Model
{
    protected $fillable = [
        'user_id',
        'check_in_date',
        'day_number',
        'reward_type',
        'reward_value',
        'reward_description',
        'is_claimed',
        'claimed_at'
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'is_claimed' => 'boolean',
        'claimed_at' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Lấy cấu hình phần thưởng theo ngày
     */
    public static function getRewardConfig($dayNumber)
    {
        $rewards = [
            1 => ['type' => 'day', 'value' => '1', 'description' => 'Ngày 1'],
            2 => ['type' => 'day', 'value' => '2', 'description' => 'Ngày 2'],
            3 => ['type' => 'voucher', 'value' => '10%', 'description' => 'Voucher 10%'],
            4 => ['type' => 'day', 'value' => '4', 'description' => 'Ngày 4'],
            5 => ['type' => 'day', 'value' => '5', 'description' => 'Ngày 5'],
            6 => ['type' => 'day', 'value' => '6', 'description' => 'Ngày 6'],
            7 => ['type' => 'day', 'value' => '7', 'description' => 'Ngày 7'],
            8 => ['type' => 'voucher', 'value' => '15%', 'description' => 'Voucher 15%'],
            9 => ['type' => 'day', 'value' => '9', 'description' => 'Ngày 9'],
            10 => ['type' => 'day', 'value' => '10', 'description' => 'Ngày 10'],
            11 => ['type' => 'day', 'value' => '11', 'description' => 'Ngày 11'],
            12 => ['type' => 'day', 'value' => '12', 'description' => 'Ngày 12'],
            13 => ['type' => 'day', 'value' => '13', 'description' => 'Ngày 13'],
            14 => ['type' => 'voucher', 'value' => '15%', 'description' => 'Voucher 15%'],
        ];

        return $rewards[$dayNumber] ?? ['type' => 'day', 'value' => (string)$dayNumber, 'description' => "Ngày {$dayNumber}"];
    }

    /**
     * Kiểm tra user đã điểm danh hôm nay chưa
     */
    public static function hasCheckedInToday($userId)
    {
        return static::where('user_id', $userId)
                    ->where('check_in_date', today())
                    ->exists();
    }

    /**
     * Lấy chuỗi điểm danh hiện tại của user
     */
    public static function getCurrentStreak($userId)
    {
        $lastCheckIn = static::where('user_id', $userId)
                           ->orderBy('check_in_date', 'desc')
                           ->first();

        if (!$lastCheckIn) {
            return 0;
        }

        // Nếu điểm danh cuối cùng không phải hôm qua, reset về 0
        if ($lastCheckIn->check_in_date->diffInDays(today()) > 1) {
            return 0;
        }

        return $lastCheckIn->day_number;
    }

    /**
     * Tạo điểm danh mới
     */
    public static function createCheckIn($userId)
    {
        if (static::hasCheckedInToday($userId)) {
            return false;
        }

        $currentStreak = static::getCurrentStreak($userId);
        $dayNumber = $currentStreak + 1;
        $rewardConfig = static::getRewardConfig($dayNumber);

        return static::create([
            'user_id' => $userId,
            'check_in_date' => today(),
            'day_number' => $dayNumber,
            'reward_type' => $rewardConfig['type'],
            'reward_value' => $rewardConfig['value'],
            'reward_description' => $rewardConfig['description'],
        ]);
    }
}
