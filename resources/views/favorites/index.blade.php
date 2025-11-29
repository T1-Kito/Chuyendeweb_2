@extends('layouts.app')

@section('title', 'Sản phẩm yêu thích')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">
                <i class="fas fa-heart text-danger me-2"></i>
                Sản phẩm yêu thích
            </h2>
        </div>
    </div>

    @if($favorites->count() > 0)
        <div class="row">
            @foreach($favorites as $favorite)
                @php
                    $product = $favorite->product;
                @endphp
                @if($product)
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="position-relative">
                                <a href="{{ route('products.show', $product->slug) }}">
                                    <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                                </a>
                                <button class="btn btn-sm position-absolute top-0 end-0 m-2 favorite-btn favorited" 
                                        data-product-id="{{ $product->id }}"
                                        title="Bỏ yêu thích"
                                        style="background: rgba(255,255,255,0.9); border: none; z-index: 10;">
                                    <i class="fas fa-heart" style="color: #e74c3c;"></i>
                                </button>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">
                                    <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none text-dark">
                                        {{ $product->name }}
                                    </a>
                                </h5>
                                <p class="card-text text-muted small flex-grow-1">
                                    {{ Str::limit($product->description, 100) }}
                                </p>
                                <div class="mt-auto">
                                    <div class="mb-2">
                                        <strong class="text-primary">
                                            {{ $product->getFormattedPriceByMonths(6) }}
                                        </strong>
                                        <small class="text-muted">/6 tháng</small>
                                    </div>
                                    <a href="{{ route('products.show', $product->slug) }}" class="btn btn-primary btn-sm w-100">
                                        Xem chi tiết
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <div class="row mt-4">
            <div class="col-12">
                {{ $favorites->links() }}
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-12 text-center py-5">
                <i class="fas fa-heart-broken fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">Bạn chưa có sản phẩm yêu thích nào</h4>
                <p class="text-muted">Hãy khám phá và thêm các sản phẩm bạn yêu thích!</p>
                <a href="{{ route('home') }}" class="btn btn-primary mt-3">
                    <i class="fas fa-shopping-bag me-2"></i>Xem sản phẩm
                </a>
            </div>
        </div>
    @endif
</div>

@push('styles')
<style>
    .favorite-btn {
        transition: all 0.3s ease;
    }
    
    .favorite-btn:hover {
        transform: scale(1.1);
    }
    
    @keyframes heartBeat {
        0%, 100% { transform: scale(1); }
        25% { transform: scale(1.2); }
        50% { transform: scale(1.1); }
        75% { transform: scale(1.15); }
    }
</style>
@endpush

@push('scripts')
<script>
    // Favorite button functionality
    document.querySelectorAll('.favorite-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const productId = this.getAttribute('data-product-id');
            const icon = this.querySelector('i');
            const card = this.closest('.col-md-3');
            
            // Disable button during request
            this.disabled = true;
            
            fetch(`/products/${productId}/favorite`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify({})
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    if (!data.is_favorited) {
                        // Remove from favorites - hide the card with animation
                        card.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                        card.style.opacity = '0';
                        card.style.transform = 'scale(0.8)';
                        setTimeout(() => {
                            card.remove();
                            // Check if no more favorites
                            if (document.querySelectorAll('.favorite-btn').length === 0) {
                                location.reload();
                            }
                        }, 300);
                    }
                } else {
                    alert(data.message || 'Có lỗi xảy ra. Vui lòng thử lại.');
                    this.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra. Vui lòng thử lại.');
                this.disabled = false;
            });
        });
    });
</script>
@endpush
@endsection

