@extends('layouts.app')

@section('title', 'Điểm Danh Nhận Quà')

@section('content')
<div class="container py-5">
    <!-- Header Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="checkin-header text-center">
                <h1 class="display-4 fw-bold text-primary mb-3">
                    <i class="fas fa-calendar-check me-3"></i>
                    ĐIỂM DANH NHẬN QUÀ
                </h1>
                <p class="lead text-muted">Điểm danh hàng ngày để nhận những phần thưởng hấp dẫn!</p>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="row mb-5">
        <div class="col-md-4">
            <div class="stat-card text-center">
                <div class="stat-icon bg-primary">
                    <i class="fas fa-fire"></i>
                </div>
                <h3 class="stat-number">{{ $currentStreak }}</h3>
                <p class="stat-label">Ngày liên tiếp</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card text-center">
                <div class="stat-icon bg-success">
                    <i class="fas fa-gift"></i>
                </div>
                <h3 class="stat-number">{{ $checkInHistory->where('is_claimed', true)->count() }}</h3>
                <p class="stat-label">Phần thưởng đã nhận</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card text-center">
                <div class="stat-icon bg-warning">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <h3 class="stat-number">{{ $checkInHistory->count() }}</h3>
                <p class="stat-label">Tổng ngày điểm danh</p>
            </div>
        </div>
    </div>

    <!-- Check-in Button -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            @if($hasCheckedInToday)
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>Đã điểm danh hôm nay!</strong> Hãy quay lại vào ngày mai để tiếp tục chuỗi điểm danh.
                </div>
            @else
                <button class="btn btn-primary btn-lg checkin-btn" id="checkinBtn">
                    <i class="fas fa-calendar-plus me-2"></i>
                    ĐIỂM DANH NGAY
                </button>
            @endif
        </div>
    </div>

    <!-- Check-in Grid -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="checkin-grid-container">
                <h3 class="text-center mb-4">
                    <i class="fas fa-grid-3x3 me-2"></i>
                    Lịch Điểm Danh 21 Ngày
                </h3>
                
                <div class="checkin-grid">
                    @foreach($checkInGrid as $rowIndex => $row)
                        <div class="checkin-row">
                            @foreach($row as $dayData)
                                <div class="checkin-day {{ $dayData['is_completed'] ? 'completed' : '' }} {{ $dayData['is_today'] ? 'today' : '' }}"
                                     data-day="{{ $dayData['day'] }}"
                                     data-reward-type="{{ $dayData['reward_type'] }}"
                                     data-reward-value="{{ $dayData['reward_value'] }}"
                                     data-reward-description="{{ $dayData['reward_description'] }}">
                                    
                                    <div class="day-number">{{ $dayData['day'] }}</div>
                                    
                                    @if($dayData['reward_type'] === 'voucher')
                                        <div class="reward-badge voucher">
                                            <i class="fas fa-ticket-alt"></i>
                                            <span>{{ $dayData['reward_value'] }}</span>
                                        </div>
                                    @else
                                        <div class="reward-badge day">
                                            <i class="fas fa-calendar-day"></i>
                                            <span>{{ $dayData['reward_value'] }}</span>
                                        </div>
                                    @endif
                                    
                                    @if($dayData['is_completed'])
                                        <div class="status-icon completed">
                                            <i class="fas fa-check"></i>
                                        </div>
                                    @elseif($dayData['is_today'])
                                        <div class="status-icon today">
                                            <i class="fas fa-star"></i>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Check-ins -->
    <div class="row">
        <div class="col-12">
            <div class="recent-checkins">
                <h3 class="mb-4">
                    <i class="fas fa-history me-2"></i>
                    Lịch Sử Điểm Danh Gần Đây
                </h3>
                
                @if($checkInHistory->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Ngày</th>
                                    <th>Ngày thứ</th>
                                    <th>Phần thưởng</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($checkInHistory as $checkIn)
                                    <tr>
                                        <td>{{ $checkIn->check_in_date->format('d/m/Y') }}</td>
                                        <td>
                                            <span class="badge bg-primary">Ngày {{ $checkIn->day_number }}</span>
                                        </td>
                                        <td>
                                            @if($checkIn->reward_type === 'voucher')
                                                <span class="badge bg-warning">
                                                    <i class="fas fa-ticket-alt me-1"></i>
                                                    {{ $checkIn->reward_description }}
                                                </span>
                                            @else
                                                <span class="badge bg-info">
                                                    <i class="fas fa-calendar-day me-1"></i>
                                                    {{ $checkIn->reward_description }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($checkIn->is_claimed)
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check me-1"></i>
                                                    Đã nhận
                                                </span>
                                            @elseif($checkIn->reward_type === 'voucher')
                                                <button class="btn btn-sm btn-outline-primary claim-btn" 
                                                        data-checkin-id="{{ $checkIn->id }}">
                                                    <i class="fas fa-gift me-1"></i>
                                                    Nhận quà
                                                </button>
                                            @else
                                                <span class="text-muted">Không có quà</span>
                                            @endif
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                {{ $checkIn->created_at->format('H:i') }}
                                            </small>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Chưa có lịch sử điểm danh nào</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-check-circle me-2"></i>
                    Thành công!
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <div class="success-icon mb-3">
                    <i class="fas fa-gift fa-4x text-success"></i>
                </div>
                <h4 id="successMessage">Điểm danh thành công!</h4>
                <p id="successDetails" class="text-muted"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<style>
/* Check-in Styles */
.checkin-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.stat-card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    border: 1px solid #e9ecef;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    color: white;
    font-size: 1.5rem;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0;
    color: #2d3748;
}

.stat-label {
    color: #718096;
    font-weight: 500;
    margin: 0;
}

.checkin-btn {
    padding: 1rem 3rem;
    font-size: 1.2rem;
    border-radius: 50px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    transition: all 0.3s ease;
}

.checkin-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(102, 126, 234, 0.4);
}

.checkin-grid-container {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e9ecef;
}

.checkin-grid {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.checkin-row {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 1rem;
}

.checkin-day {
    aspect-ratio: 1;
    border-radius: 15px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    position: relative;
    transition: all 0.3s ease;
    cursor: pointer;
    border: 2px solid #e9ecef;
    background: #f8f9fa;
}

.checkin-day:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.checkin-day.completed {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    border-color: #10b981;
}

.checkin-day.today {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
    border-color: #f59e0b;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.day-number {
    font-weight: 700;
    font-size: 1.1rem;
    margin-bottom: 0.5rem;
}

.reward-badge {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.8rem;
    font-weight: 600;
    padding: 0.25rem 0.5rem;
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.2);
}

.reward-badge.voucher {
    background: rgba(245, 158, 11, 0.9);
    color: white;
}

.reward-badge.day {
    background: rgba(59, 130, 246, 0.9);
    color: white;
}

.status-icon {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.7rem;
}

.status-icon.completed {
    background: #10b981;
    color: white;
}

.status-icon.today {
    background: #f59e0b;
    color: white;
}

.recent-checkins {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e9ecef;
}

.claim-btn {
    border-radius: 20px;
    padding: 0.25rem 0.75rem;
    font-size: 0.8rem;
}

/* Responsive */
@media (max-width: 768px) {
    .checkin-row {
        grid-template-columns: repeat(4, 1fr);
        gap: 0.5rem;
    }
    
    .checkin-day {
        font-size: 0.8rem;
    }
    
    .day-number {
        font-size: 0.9rem;
    }
    
    .reward-badge {
        font-size: 0.7rem;
        padding: 0.2rem 0.4rem;
    }
    
    .stat-card {
        padding: 1.5rem;
    }
    
    .stat-number {
        font-size: 2rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkinBtn = document.getElementById('checkinBtn');
    const claimBtns = document.querySelectorAll('.claim-btn');
    const successModal = new bootstrap.Modal(document.getElementById('successModal'));

    // Check-in functionality
    if (checkinBtn) {
        checkinBtn.addEventListener('click', function() {
            fetch('{{ route("checkin.checkin") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('successMessage').textContent = data.message;
                    document.getElementById('successDetails').textContent = 
                        `Bạn đã điểm danh ngày thứ ${data.currentStreak}!`;
                    successModal.show();
                    
                    // Reload page after 2 seconds
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra, vui lòng thử lại!');
            });
        });
    }

    // Claim reward functionality
    claimBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const checkinId = this.dataset.checkinId;
            
            fetch(`/checkin/${checkinId}/claim`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('successMessage').textContent = data.message;
                    document.getElementById('successDetails').textContent = 
                        `Bạn đã nhận được: ${data.reward.description}`;
                    successModal.show();
                    
                    // Reload page after 2 seconds
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra, vui lòng thử lại!');
            });
        });
    });

    // Day hover effects
    document.querySelectorAll('.checkin-day').forEach(day => {
        day.addEventListener('mouseenter', function() {
            if (!this.classList.contains('completed') && !this.classList.contains('today')) {
                this.style.background = '#e2e8f0';
                this.style.borderColor = '#cbd5e0';
            }
        });
        
        day.addEventListener('mouseleave', function() {
            if (!this.classList.contains('completed') && !this.classList.contains('today')) {
                this.style.background = '#f8f9fa';
                this.style.borderColor = '#e9ecef';
            }
        });
    });
});
</script>
@endsection
