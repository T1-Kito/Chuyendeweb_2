@extends('layouts.app')

@section('title', $servicePackage->name ?? 'Chi Tiết Gói Dịch Vụ')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h2 class="mb-2">{{ $servicePackage->name }}</h2>
                            <p class="text-muted">{{ $servicePackage->description }}</p>

                            <div class="row my-4">
                                <div class="col-md-6">
                                    <h6 class="text-muted">Thời gian</h6>
                                    <p class="h5 text-info">{{ $servicePackage->duration }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted">Thứ tự</h6>
                                    <p class="h5">{{ $servicePackage->sort_order }}</p>
                                </div>
                            </div>

                            <h6 class="text-muted">Tính năng</h6>
                            @if($servicePackage->features && count($servicePackage->features) > 0)
                                <ul class="list-group mb-4">
                                    @foreach($servicePackage->features as $feature)
                                        <li class="list-group-item">{{ $feature }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">Chưa có tính năng nào</p>
                            @endif

                            <a href="#products" class="btn btn-primary">Xem sản phẩm liên quan</a>
                        </div>

                        <div class="col-md-4">
                            <div class="card bg-light mb-3">
                                <div class="card-body text-center">
                                    @if($servicePackage->icon)
                                        <div class="mb-3"><i class="fas fa-{{ $servicePackage->icon }} fa-3x text-primary"></i></div>
                                    @endif
                                    <h4>{{ $servicePackage->name }}</h4>
                                    @if($servicePackage->is_active)
                                        <span class="badge bg-success">Hoạt động</span>
                                    @else
                                        <span class="badge bg-secondary">Tạm dừng</span>
                                    @endif

                                    <div class="mt-3">
                                        <button class="btn btn-{{ $servicePackage->button_color }}">
                                            @if($servicePackage->button_icon)
                                                <i class="fas fa-{{ $servicePackage->button_icon }} me-1"></i>
                                            @endif
                                            {{ $servicePackage->button_text }}
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body small text-muted">
                                    <div>Ngày tạo: {{ $servicePackage->created_at->format('d/m/Y H:i') }}</div>
                                    <div>Cập nhật: {{ $servicePackage->updated_at->format('d/m/Y H:i') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
