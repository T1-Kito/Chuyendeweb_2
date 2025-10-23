@extends('layouts.admin')

@section('title', 'Quản Lý Voucher')

@section('page-title', 'Quản Lý Voucher')
@section('page-description', 'Tạo, sửa và quản lý voucher giảm giá')

@section('content')

<!-- Header Section -->
<div class="vouchers-header mb-4">
    <div class="row align-items-center">
        <div class="col-md-8">
            <div class="header-content">
                <h2 class="fw-bold mb-1">
                    <i class="fas fa-ticket-alt me-2"></i>Quản Lý Voucher
                </h2>
                <div class="stats-summary">
                    <span class="stat-item">
                        <i class="fas fa-ticket-alt text-primary"></i>
                        Tổng: {{ $vouchers->count() }} voucher
                    </span>
                    <span class="stat-item">
                        <i class="fas fa-check-circle text-success"></i>
                        Hoạt động: {{ $vouchers->where('is_active', true)->count() }}
                    </span>
                    <span class="fas fa-clock text-warning"></i>
                        Hết hạn: {{ $vouchers->where('expires_at', '<', now())->count() }}
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.vouchers.create') }}" class="btn btn-success">
                <i class="fas fa-plus me-1"></i>Tạo Voucher Mới
            </a>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Vouchers Table -->
<div class="vouchers-table-container">
    @if($vouchers->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover vouchers-table">
                <thead class="table-dark">
                    <tr>
                        <th width="50">#</th>
                        <th width="120">Mã Voucher</th>
                        <th>Tên Voucher</th>
                        <th width="100">Loại</th>
                        <th width="100">Giá Trị</th>
                        <th width="120">Đơn Tối Thiểu</th>
                        <th width="100">Đã Dùng</th>
                        <th width="100">Trạng Thái</th>
                        <th width="120">Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vouchers as $index => $voucher)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>
                            <div class="voucher-code">
                                <code class="text-primary fw-bold">{{ $voucher->code }}</code>
                            </div>
                        </td>
                        <td>
                            <div class="voucher-info">
                                <div class="voucher-name fw-bold">{{ $voucher->name }}</div>
                                @if($voucher->description)
                                    <div class="voucher-desc text-muted small">{{ Str::limit($voucher->description, 50) }}</div>
                                @endif
                            </div>
                        </td>
                        <td class="text-center">
                            @if($voucher->type === 'percentage')
                                <span class="badge bg-info">
                                    <i class="fas fa-percentage me-1"></i>Phần trăm
                                </span>
                            @else
                                <span class="badge bg-warning">
                                    <i class="fas fa-money-bill me-1"></i>Cố định
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="value-display">
                                @if($voucher->type === 'percentage')
                                    <span class="fw-bold text-primary">{{ $voucher->value }}%</span>
                                @else
                                    <span class="fw-bold text-success">{{ number_format($voucher->value) }}đ</span>
                                @endif
                            </div>
                        </td>
                        <td class="text-center">
                            @if($voucher->min_order_amount)
                                <span class="text-muted">{{ number_format($voucher->min_order_amount) }}đ</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="usage-info">
                                <span class="fw-bold">{{ $voucher->used_count }}</span>
                                @if($voucher->usage_limit)
                                    <span class="text-muted">/ {{ $voucher->usage_limit }}</span>
                                @else
                                    <span class="text-muted">/ ∞</span>
                                @endif
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-{{ $voucher->status_color }}">
                                {{ $voucher->status_text }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="action-buttons">
                                <a href="{{ route('admin.vouchers.edit', $voucher) }}" 
                                   class="btn btn-sm btn-primary" title="Sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <form method="POST" action="{{ route('admin.vouchers.toggle', $voucher) }}" 
                                      style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-{{ $voucher->is_active ? 'warning' : 'success' }}" 
                                            title="{{ $voucher->is_active ? 'Tạm dừng' : 'Kích hoạt' }}">
                                        <i class="fas fa-{{ $voucher->is_active ? 'pause' : 'play' }}"></i>
                                    </button>
                                </form>
                                
                                <button class="btn btn-sm btn-danger" 
                                        onclick="deleteVoucher({{ $voucher->id }})" 
                                        title="Xóa">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="fas fa-ticket-alt"></i>
            </div>
            <h3 class="empty-state-title">Chưa có voucher nào</h3>
            <p class="empty-state-description">
                Bắt đầu bằng cách tạo voucher đầu tiên
            </p>
            <a href="{{ route('admin.vouchers.create') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-plus me-2"></i>Tạo Voucher Đầu Tiên
            </a>
        </div>
    @endif
</div>

<!-- Delete Voucher Form (Hidden) -->
<form id="deleteVoucherForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<style>
/* Voucher Management Styles */
.vouchers-header {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 1.5rem;
}

.stats-summary {
    display: flex;
    gap: 1.5rem;
    flex-wrap: wrap;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
    color: #6c757d;
}

.stat-item i {
    font-size: 1rem;
}

.vouchers-table-container {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    overflow: hidden;
}

.vouchers-table {
    margin-bottom: 0;
}

.vouchers-table thead th {
    background: #2c3e50;
    color: white;
    border: none;
    padding: 12px 8px;
    font-weight: 600;
    font-size: 0.9rem;
    text-align: center;
    vertical-align: middle;
}

.vouchers-table tbody td {
    padding: 12px 8px;
    vertical-align: middle;
    border-bottom: 1px solid #e9ecef;
}

.vouchers-table tbody tr:hover {
    background-color: #f8f9fa;
}

.voucher-code code {
    background: #f8f9fa;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.8rem;
}

.voucher-info {
    text-align: left;
}

.voucher-name {
    color: #2c3e50;
    margin-bottom: 4px;
    font-size: 0.9rem;
}

.voucher-desc {
    font-size: 0.8rem;
    line-height: 1.3;
}

.value-display {
    font-size: 0.9rem;
}

.usage-info {
    font-size: 0.9rem;
}

.action-buttons {
    display: flex;
    gap: 4px;
    justify-content: center;
}

.action-buttons .btn {
    font-size: 0.8rem;
    padding: 4px 8px;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.empty-state-icon {
    width: 120px;
    height: 120px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 2rem;
    color: white;
    font-size: 3rem;
}

.empty-state-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 1rem;
}

.empty-state-description {
    color: #718096;
    font-size: 1.1rem;
    margin-bottom: 2rem;
}

/* Responsive */
@media (max-width: 768px) {
    .vouchers-table {
        font-size: 0.8rem;
    }
    
    .vouchers-table thead th,
    .vouchers-table tbody td {
        padding: 8px 4px;
    }
    
    .action-buttons {
        flex-direction: column;
        gap: 2px;
    }
    
    .action-buttons .btn {
        font-size: 0.7rem;
        padding: 2px 4px;
    }
    
    .stats-summary {
        gap: 1rem;
    }
    
    .stat-item {
        font-size: 0.8rem;
    }
}
</style>

<script>
function deleteVoucher(voucherId) {
    if (confirm('Bạn có chắc muốn xóa voucher này?')) {
        const form = document.getElementById('deleteVoucherForm');
        form.action = `/admin/vouchers/${voucherId}`;
        form.submit();
    }
}

// Add smooth animations
document.addEventListener('DOMContentLoaded', function() {
    // Animate table rows
    const tableRows = document.querySelectorAll('.vouchers-table tbody tr');
    tableRows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            row.style.transition = 'all 0.6s ease';
            row.style.opacity = '1';
            row.style.transform = 'translateY(0)';
        }, index * 50);
    });
});
</script>
@endsection
