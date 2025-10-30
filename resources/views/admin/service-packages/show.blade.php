@extends('layouts.app')

@section('title', 'Chi Tiết Gói Dịch Vụ')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-eye me-2"></i>
                        Chi Tiết Gói Dịch Vụ
                    </h3>
                    <div>
                        <a href="{{ route('admin.service-packages.edit', $servicePackage) }}" class="btn btn-warning me-2">
                            <i class="fas fa-edit me-1"></i>
                            Chỉnh Sửa
                        </a>
                        <a href="{{ route('admin.service-packages.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>
                            Quay Lại
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-4">
                                <h4 class="text-primary">{{ $servicePackage->name }}</h4>
                                @if(trim((string)$servicePackage->description) !== '')
                                    <p class="text-muted mb-0">{!! nl2br(e($servicePackage->description)) !!}</p>
                                @else
                                    <p class="text-muted mb-0 fst-italic text-secondary">Chưa có mô tả</p>
                                @endif
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6 class="text-muted">Thời Gian (tháng)</h6>
                                    @php
                                        // Try to extract numeric months from stored duration (e.g. "12 Tháng" or "12")
                                        $months = null;
                                        if (!empty($servicePackage->duration)) {
                                            if (preg_match('/(\d+)/', $servicePackage->duration, $match)) {
                                                $months = (int)$match[1];
                                            }
                                        }
                                    @endphp
                                    <p class="h5 text-info">{{ $months !== null ? $months : 'Không xác định' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted">Thứ Tự Sắp Xếp</h6>
                                    <p class="h5">{{ $servicePackage->sort_order }}</p>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h6 class="text-muted mb-3">Tính Năng</h6>
                                @if($servicePackage->features && is_array($servicePackage->features) && count($servicePackage->features) > 0)
                                    <ul class="list-group list-group-flush">
                                        @foreach($servicePackage->features as $feature)
                                            <li class="list-group-item d-flex align-items-center border-0 py-2">
                                                <i class="fas fa-check text-success me-3"></i>
                                                <span>{!! e($feature) !!}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-muted fst-italic">Chưa có tính năng</p>
                                @endif
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-muted">Nút Hành Động</h6>
                                    <div class="d-flex align-items-center gap-2">
                                        @if($servicePackage->button_icon)
                                            <i class="fas fa-{{ $servicePackage->button_icon }} me-2"></i>
                                        @endif
                                        <span class="me-2">{{ $servicePackage->button_text ?? 'Chọn gói' }}</span>
                                        @php
                                            $btnColor = $servicePackage->button_color ?: 'primary';
                                            // clamp to known bootstrap colors: primary, secondary, success, danger, warning, info, light, dark
                                            $allowed = ['primary','secondary','success','danger','warning','info','light','dark'];
                                            if (!in_array($btnColor, $allowed)) { $badgeClass = 'bg-secondary text-white'; } else { $badgeClass = 'bg-'.$btnColor; }
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">
                                            {{ ucfirst($servicePackage->button_color ?? 'secondary') }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted">Icon Gói</h6>
                                    @if($servicePackage->icon)
                                        <i class="fas fa-{{ $servicePackage->icon }} fa-2x text-primary"></i>
                                    @else
                                        <span class="text-muted">Không có icon</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <h6 class="mb-0">Thông Tin Bổ Sung</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <h6 class="text-muted">Trạng Thái</h6>
                                        @if($servicePackage->is_active)
                                            <span class="badge bg-success fs-6">Hoạt Động</span>
                                        @else
                                            <span class="badge bg-danger fs-6">Không Hoạt Động</span>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        <h6 class="text-muted">Phổ Biến</h6>
                                        @if($servicePackage->is_popular)
                                            <span class="badge bg-warning text-dark fs-6">Có</span>
                                        @else
                                            <span class="badge bg-light text-muted fs-6">Không</span>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        <h6 class="text-muted">Ngày Tạo</h6>
                                        <p class="mb-0">{{ $servicePackage->created_at->format('d/m/Y H:i') }}</p>
                                    </div>

                                    <div class="mb-3">
                                        <h6 class="text-muted">Cập Nhật Lần Cuối</h6>
                                        <p class="mb-0">{{ $servicePackage->updated_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="card mt-3">
                                <div class="card-header">
                                    <h6 class="mb-0">Xem Trước</h6>
                                </div>
                                <div class="card-body text-center">
                                    <div class="service-package-preview">
                                        @if($servicePackage->icon)
                                            <div class="icon-circle mb-3">
                                                <i class="fas fa-{{ $servicePackage->icon }} fa-2x text-primary"></i>
                                            </div>
                                        @endif
                                        <h5 class="mb-2">{{ $servicePackage->name }}</h5>
                                        @if($servicePackage->features && count($servicePackage->features) > 0)
                                            <ul class="list-unstyled text-start">
                                                @foreach(array_slice($servicePackage->features, 0, 3) as $feature)
                                                    <li class="mb-1">
                                                        <i class="fas fa-check text-success me-2"></i>
                                                        {{ Str::limit($feature, 30) }}
                                                    </li>
                                                @endforeach
                                                @if(count($servicePackage->features) > 3)
                                                    <li class="text-muted small">+{{ count($servicePackage->features) - 3 }} tính năng khác</li>
                                                @endif
                                            </ul>
                                        @endif
                                        <button class="btn btn-{{ $servicePackage->button_color }} mt-3">
                                            @if($servicePackage->button_icon)
                                                <i class="fas fa-{{ $servicePackage->button_icon }} me-1"></i>
                                            @endif
                                            {{ $servicePackage->button_text }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.icon-circle {
    width: 60px;
    height: 60px;
    background: #f8f9fa;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

.service-package-preview {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 20px;
    background: white;
}
</style>
@endpush
@endsection
