@extends('layouts.app')

@section('title', 'Quản lý đánh giá sản phẩm')

@section('content')
<div class="container py-5">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-3 mb-md-0">Quản lý đánh giá sản phẩm</h1>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-2"></i>Quay về trang chủ
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Trạng thái</label>
                    <select name="status" class="form-select">
                        <option value="">Tất cả</option>
                        <option value="{{ \App\Models\Rating::STATUS_PENDING }}" {{ request('status') === \App\Models\Rating::STATUS_PENDING ? 'selected' : '' }}>Chờ duyệt</option>
                        <option value="{{ \App\Models\Rating::STATUS_APPROVED }}" {{ request('status') === \App\Models\Rating::STATUS_APPROVED ? 'selected' : '' }}>Đã duyệt</option>
                        <option value="{{ \App\Models\Rating::STATUS_HIDDEN }}" {{ request('status') === \App\Models\Rating::STATUS_HIDDEN ? 'selected' : '' }}>Đã ẩn</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Sản phẩm</label>
                    <select name="product_id" class="form-select">
                        <option value="">Tất cả</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ (string) request('product_id') === (string) $product->id ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Từ khoá</label>
                    <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control" placeholder="Tên người dùng, email hoặc sản phẩm">
                </div>
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search me-2"></i>Lọc</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <div class="text-muted small mb-1">Điểm trung bình</div>
                    <div class="display-5 fw-bold">{{ number_format($averageRating, 1) }}</div>
                    <div>
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="{{ $i <= floor($averageRating) ? 'fas' : ($i - $averageRating <= 0.5 ? 'fas fa-star-half-alt' : 'far') }} fa-star text-warning"></i>
                        @endfor
                    </div>
                    <div class="text-muted small mt-2">{{ $totalApproved }} đánh giá đã duyệt</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <div class="text-muted small mb-2">Thống kê theo trạng thái</div>
                    @php
                        $statusLabels = [
                            \App\Models\Rating::STATUS_PENDING => 'Chờ duyệt',
                            \App\Models\Rating::STATUS_APPROVED => 'Đã duyệt',
                            \App\Models\Rating::STATUS_HIDDEN => 'Đã ẩn',
                        ];
                    @endphp
                    @foreach($statusLabels as $key => $label)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>{{ $label }}</span>
                            <span class="badge bg-light text-dark">{{ $statusCounts[$key] ?? 0 }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <div class="text-muted small mb-2">Phân bổ số sao</div>
                    @foreach($ratingStats as $stars => $stat)
                        <div class="mb-2">
                            <div class="d-flex justify-content-between small mb-1">
                                <span>{{ $stars }} sao</span>
                                <span>{{ $stat['count'] }} ({{ $stat['percentage'] }}%)</span>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $stat['percentage'] }}%;"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if($ratings->count())
                <div class="table-responsive">
                    <table class="table align-middle table-striped">
                        <thead>
                            <tr>
                                <th style="width: 180px;">Người dùng</th>
                                <th>Sản phẩm</th>
                                <th style="width: 140px;">Số sao</th>
                                <th style="width: 160px;">Gói</th>
                                <th>Nội dung</th>
                                <th style="width: 120px;">Trạng thái</th>
                                <th style="width: 160px;">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ratings as $rating)
                                @php
                                    $content = $rating->content ?? '';
                                    $isLong = \Illuminate\Support\Str::length($content) > 200;
                                    $preview = $isLong ? \Illuminate\Support\Str::limit($content, 200) : $content;
                                @endphp
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $rating->user->name ?? 'Người dùng' }}</div>
                                        <div class="small text-muted">{{ $rating->user->email ?? 'Không có email' }}</div>
                                        <div class="small text-muted mt-1">{{ $rating->created_at->format('d/m/Y H:i') }}</div>
                                    </td>
                                    <td>
                                        @if($rating->product)
                                            <a href="{{ route('products.show', $rating->product->slug ?? $rating->product->id) }}" target="_blank">
                                                {{ $rating->product->name }}
                                            </a>
                                        @else
                                            <span class="text-muted">Đã xoá</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div>
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="{{ $i <= $rating->stars ? 'fas' : 'far' }} fa-star text-warning"></i>
                                            @endfor
                                        </div>
                                        <div class="small text-muted mt-1">{{ $rating->stars }} / 5</div>
                                    </td>
                                    <td>
                                        @if($rating->package_months)
                                            <span class="badge bg-light text-dark">{{ $rating->package_months }} tháng</span>
                                            <div class="small text-muted mt-1">
                                                {{ $rating->product ? $rating->product->getFormattedPriceByMonths($rating->package_months) : '' }}
                                            </div>
                                        @else
                                            <span class="text-muted small">Chưa chọn</span>
                                        @endif
                                    </td>
                                    <td style="max-width: 320px;">
                                        @if($content)
                                            <div id="admin-rating-preview-{{ $rating->id }}">{!! nl2br(e($preview)) !!}</div>
                                            @if($isLong)
                                                <div id="admin-rating-full-{{ $rating->id }}" class="d-none">{!! nl2br(e($content)) !!}</div>
                                                <button type="button" class="btn btn-link p-0 small toggle-admin-rating" data-target="{{ $rating->id }}">Xem thêm</button>
                                            @endif
                                        @else
                                            <span class="text-muted small">(Không có nội dung)</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $statusClass = match ($rating->status) {
                                                \App\Models\Rating::STATUS_APPROVED => 'bg-success',
                                                \App\Models\Rating::STATUS_HIDDEN => 'bg-secondary',
                                                default => 'bg-warning text-dark'
                                            };
                                            $statusLabel = match ($rating->status) {
                                                \App\Models\Rating::STATUS_APPROVED => 'Đã duyệt',
                                                \App\Models\Rating::STATUS_HIDDEN => 'Đã ẩn',
                                                default => 'Chờ duyệt'
                                            };
                                        @endphp
                                        <span class="badge {{ $statusClass }}">{{ $statusLabel }}</span>
                                        @if($rating->reviewed_at)
                                            <div class="small text-muted mt-1">{{ $rating->reviewed_at->format('d/m/Y H:i') }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column gap-2">
                                            <form method="POST" action="{{ route('admin.ratings.update-status', $rating->id) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="{{ \App\Models\Rating::STATUS_APPROVED }}">
                                                <button type="submit" class="btn btn-sm btn-success" {{ $rating->status === \App\Models\Rating::STATUS_APPROVED ? 'disabled' : '' }}>Duyệt</button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.ratings.update-status', $rating->id) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="{{ \App\Models\Rating::STATUS_HIDDEN }}">
                                                <button type="submit" class="btn btn-sm btn-outline-secondary" {{ $rating->status === \App\Models\Rating::STATUS_HIDDEN ? 'disabled' : '' }}>Ẩn</button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.ratings.destroy', $rating->id) }}" onsubmit="return confirm('Bạn có chắc chắn muốn xóa đánh giá này không?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $ratings->onEachSide(1)->links() }}
                </div>
            @else
                <div class="text-muted text-center py-5">Chưa có đánh giá nào.</div>
            @endif
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.toggle-admin-rating').forEach(button => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-target');
                const preview = document.getElementById(`admin-rating-preview-${id}`);
                const full = document.getElementById(`admin-rating-full-${id}`);
                if (!preview || !full) return;
                const expanded = !full.classList.contains('d-none');
                if (expanded) {
                    full.classList.add('d-none');
                    preview.classList.remove('d-none');
                    button.textContent = 'Xem thêm';
                } else {
                    full.classList.remove('d-none');
                    preview.classList.add('d-none');
                    button.textContent = 'Thu gọn';
                }
            });
        });
    });
</script>
@endpush
