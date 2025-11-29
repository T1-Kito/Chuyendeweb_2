@extends('layouts.app')

@section('title', 'Sản phẩm yêu thích')

@section('content')
<div class="container py-5" style="margin-top: 80px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">
            <i class="fas fa-heart text-danger me-2"></i>Sản phẩm yêu thích
        </h1>
        <span class="badge bg-primary">{{ $favorites->total() }} sản phẩm</span>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($favorites->count() > 0)
        <div class="row g-4">
            @foreach($favorites as $product)
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card h-100 product-card shadow-sm" data-url="{{ route('products.show', $product->slug ?? $product->id) }}">
                    <div class="position-relative">
                        <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                        <button type="button" 
                                class="btn btn-link p-2 position-absolute top-0 end-0 favorite-btn favorited" 
                                data-product-id="{{ $product->id }}"
                                onclick="event.stopPropagation();"
                                title="Bỏ yêu thích">
                            <i class="fas fa-heart" style="font-size: 1.5rem; color: #e74c3c;"></i>
                        </button>
                        @if($product->isPromotionActive)
                            <span class="badge bg-danger position-absolute top-0 start-0 m-2">
                                {{ $product->promotion_badge }}
                            </span>
                        @endif
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ Str::limit($product->name, 50) }}</h5>
                        <p class="card-text text-muted small flex-grow-1">{{ Str::limit($product->description, 80) }}</p>
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="h5 mb-0 text-primary fw-bold">
                                    {{ $product->formatted_price_by_months ?? 'Liên hệ' }}
                                </span>
                                @if($product->average_rating > 0)
                                    <div class="text-warning small">
                                        <i class="fas fa-star"></i> {{ number_format($product->average_rating, 1) }}
                                    </div>
                                @endif
                            </div>
                            <a href="{{ route('products.show', $product->slug ?? $product->id) }}" class="btn btn-primary w-100" onclick="event.stopPropagation();">
                                <i class="fas fa-eye me-1"></i>Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $favorites->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-heart-broken fa-4x text-muted mb-3"></i>
            <h4 class="text-muted">Bạn chưa có sản phẩm yêu thích nào</h4>
            <p class="text-muted">Hãy khám phá và thêm sản phẩm vào danh sách yêu thích của bạn!</p>
            <a href="{{ route('home') }}" class="btn btn-primary mt-3">
                <i class="fas fa-shopping-bag me-2"></i>Xem sản phẩm
            </a>
        </div>
    @endif
</div>

<style>
.product-card {
    transition: transform 0.2s, box-shadow 0.2s;
    cursor: pointer;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.favorite-btn {
    background: rgba(255, 255, 255, 0.9);
    border-radius: 50%;
    transition: all 0.3s;
}

.favorite-btn:hover {
    background: rgba(255, 255, 255, 1);
    transform: scale(1.1);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Favorite button functionality
    document.querySelectorAll('.favorite-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.getAttribute('data-product-id');
            const icon = this.querySelector('i');
            const card = this.closest('.product-card');
            
            // Disable button during request
            this.disabled = true;
            
            fetch(`/products/${productId}/favorite`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (!data.is_favorited) {
                        // Remove card with animation
                        card.style.transition = 'opacity 0.3s, transform 0.3s';
                        card.style.opacity = '0';
                        card.style.transform = 'scale(0.9)';
                        setTimeout(() => {
                            card.remove();
                            // Reload if no products left
                            if (document.querySelectorAll('.product-card').length === 0) {
                                window.location.reload();
                            }
                        }, 300);
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra. Vui lòng thử lại.');
            })
            .finally(() => {
                this.disabled = false;
            });
        });
    });
});
</script>
@endsection

