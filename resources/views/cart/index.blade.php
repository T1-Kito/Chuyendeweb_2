@extends('layouts.app')

@push('styles')
<style>
/* Cart Page Styles (clean) */
.page-hero{background:#f0e9ea;border:1px solid #eed7da}
.left-panel{background:#e9ecef}
.suggest-tile{color:#111;text-decoration:none}
.suggest-tile:hover .tile-thumb{border-color:#c8cdd2}
.tile-thumb{height:120px;border-radius:8px;background:#fff;border:1px solid #dee2e6;display:flex;align-items:center;justify-content:center;padding:8px}
.tile-thumb img{max-width:100%;max-height:100%;object-fit:contain}
.btn-voucher{background:#f1b5b5;border:1px solid #eaa9a9;color:#5b2d2d;font-weight:600;padding:.45rem 1.1rem;border-radius:4px}
.btn-voucher:hover{background:#eaa9a9;color:#4a2626}
.cart-panel{border:1px solid #d9d9d9;border-radius:10px}
.cart-panel h3{font-size:1.55rem}
.line-thumb{width:64px;height:64px;border:1px solid #edf2f7;border-radius:8px;background:#fff;display:flex;align-items:center;justify-content:center}
.line-thumb img{max-width:90%;max-height:90%;object-fit:contain}
.voucher-box{border:1px dashed #cbd5e1}
@media (max-width:991px){.page-hero h2{font-size:1.9rem}.left-panel{margin-bottom:1.25rem}}
</style>
@endpush

@section('content')
<section class="py-5">
  <div class="container">
    <div class="page-hero rounded-3 mb-4 px-3 py-3"><h2 class="fw-bold mb-0">Quản Lý Giỏ Hàng</h2></div>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row g-4 cart-layout">
      <!-- Suggestions panel -->
      <div class="col-lg-7">
        <div class="left-panel p-3 p-lg-4 rounded-3">
          <h5 class="fw-bold mb-3">Gợi ý các sản phẩm yêu thích</h5>
          <div class="row g-3 g-lg-4">
            @if(isset($suggestions) && $suggestions->isNotEmpty())
              @foreach($suggestions as $sp)
              <div class="col-6 col-md-4">
                <a href="{{ route('products.show', $sp->slug) }}" class="suggest-tile">
                  <div class="tile-thumb mb-2"><img src="{{ $sp->image_url }}" alt="{{ $sp->name }}"></div>
                  <div class="small text-dark fw-semibold">{{ \Illuminate\Support\Str::limit($sp->name, 36) }}</div>
                  <div class="small text-muted">{{ number_format($sp->price_6_months ?? 0) }}đ</div>
                </a>
              </div>
              @if($loop->iteration >= 6) @break @endif
              @endforeach
            @else
              <div class="col-12 text-muted small">Đang tải gợi ý...</div>
            @endif
          </div>
          <div class="d-flex align-items-center justify-content-between mt-4">
            <a href="/" class="btn btn-sm btn-outline-dark px-3">xem tất cả</a>
            <a href="#voucherBox" class="btn btn-voucher ms-auto">Mã Voucher</a>
          </div>
        </div>
      </div>

      <!-- Cart panel -->
      <div class="col-lg-5">
        <div class="cart-panel card border-0 shadow-sm">
          <div class="card-body">
            <h3 class="text-center fw-bold mb-4">Giỏ Hàng</h3>

            @if($items->isEmpty())
              <div class="text-center text-muted py-4">
                <i class="fas fa-cart-arrow-down fa-3x mb-3 opacity-50"></i>
                <div class="mb-2">Chưa có sản phẩm nào trong giỏ.</div>
                <a href="/" class="btn btn-outline-primary">Tiếp tục mua sắm</a>
              </div>
            @else
              @foreach($items as $item)
              <div class="cart-line py-3" data-price="{{ (float) $item->price_per_month }}">
                <div class="d-flex align-items-center">
                  <div class="line-thumb me-3"><img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}"></div>
                  <div class="flex-grow-1">
                    <div class="fw-semibold">{{ $item->product->name }}</div>
                    <div class="small text-muted">{{ number_format($item->price_per_month) }}đ / {{ $item->rental_duration }} tháng</div>
                  </div>
                  <form action="{{ route('cart.update', $item) }}" method="post" class="d-inline-flex align-items-center cart-qty" onsubmit="return validateQty(this)">
                    @csrf
                    @method('patch')
                    <button class="btn btn-sm btn-outline-secondary btn-minus" type="button">−</button>
                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control form-control-sm text-center mx-2 qty-input" style="width:60px">
                    <button class="btn btn-sm btn-outline-secondary btn-plus" type="button">+</button>
                    <button class="btn btn-sm btn-outline-primary ms-2 btn-save">Lưu</button>
                  </form>
                  <form action="{{ route('cart.remove', $item) }}" method="post" class="ms-3 d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?');">
                    @csrf
                    @method('delete')
                    <button class="btn btn-sm btn-link text-danger">Xóa</button>
                  </form>
                </div>
                <div class="mt-2 small fw-semibold text-dark item-total">{{ number_format($item->total_price) }}đ</div>
                <hr class="my-3">
              </div>
              @endforeach
            @endif

            <!-- Voucher & totals -->
            <div id="voucherBox" class="voucher-box p-2 rounded mb-2 {{ isset($voucher) && $voucher ? 'bg-success-subtle' : 'bg-light' }}">
              @if(isset($voucher) && $voucher)
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <div class="small fw-semibold text-success"><i class="fas fa-ticket-alt me-1"></i>{{ $voucher->code }} áp dụng</div>
                    <div class="small text-muted">Giảm: -{{ number_format($discount) }}đ</div>
                  </div>
                  <form action="{{ route('cart.remove-voucher') }}" method="post" onsubmit="return confirm('Gỡ voucher hiện tại?');">
                    @csrf
                    @method('delete')
                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-times"></i></button>
                  </form>
                </div>
              @else
                <form action="{{ route('cart.apply-voucher') }}" method="post" class="d-flex gap-2 align-items-center">
                  @csrf
                  <input type="text" name="code" class="form-control form-control-sm" placeholder="Nhập mã voucher" maxlength="50">
                  <button class="btn btn-sm btn-outline-primary">Áp dụng</button>
                </form>
              @endif
            </div>

            <div class="d-flex justify-content-between small mb-2">
              <span class="text-muted">Tạm tính</span>
              <span class="subtotal-amount">{{ number_format($total) }}đ</span>
            </div>
            @if(isset($voucher) && $voucher)
            <div class="d-flex justify-content-between small mb-2 text-success">
              <span>Voucher ({{ $voucher->code }})</span>
              <span class="discount-amount">-{{ number_format($discount) }}đ</span>
            </div>
            @endif
            <div class="d-flex justify-content-between align-items-center py-2">
              <span class="fw-semibold">Tổng cộng</span>
              <span class="fs-5 fw-bold text-danger grand-total">{{ number_format(isset($grandTotal) ? $grandTotal : $total) }}đ</span>
            </div>
            <button onclick="window.location.href='{{ route('checkout.index') }}'" class="btn btn-dark w-100 py-2 mt-2" {{ $items->isEmpty() ? 'disabled' : '' }}><i class="fas fa-credit-card me-2"></i>Tiến Hành Thanh Toán</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
function formatCurrency(n){try{return new Intl.NumberFormat('vi-VN').format(n)+'đ'}catch(e){return (Math.round(n)).toLocaleString('vi-VN')+'đ'}}
function clampQty(val){val=parseInt(val||1,10);return isNaN(val)||val<1?1:val}
function validateQty(form){const input=form.querySelector('.qty-input');const v=clampQty(input.value);if(v!==parseInt(input.value,10))input.value=v;return v>=1}
document.querySelectorAll('.cart-line').forEach(function(card){const price=parseFloat(card.getAttribute('data-price')||'0');const form=card.querySelector('form.cart-qty');const input=form?.querySelector('.qty-input');const minus=form?.querySelector('.btn-minus');const plus=form?.querySelector('.btn-plus');const save=form?.querySelector('.btn-save');const itemTotalEl=card.querySelector('.item-total');function recalc(){if(!input)return;const qty=clampQty(input.value);const itemTotal=price*qty; if(itemTotalEl)itemTotalEl.textContent=formatCurrency(itemTotal);let subtotal=0;document.querySelectorAll('.cart-line').forEach(function(c){const p=parseFloat(c.getAttribute('data-price')||'0');const q=clampQty(c.querySelector('.qty-input')?.value||'1');subtotal+=p*q});const discountText=document.querySelector('.discount-amount')?.textContent||'';const discountVal=parseInt(discountText.replace(/[^0-9]/g,''))||0;document.querySelector('.subtotal-amount')?.replaceChildren(document.createTextNode(formatCurrency(subtotal)));document.querySelector('.grand-total')?.replaceChildren(document.createTextNode(formatCurrency(Math.max(0, subtotal-discountVal))));}
if(minus)minus.addEventListener('click',function(){input.value=clampQty((parseInt(input.value||1,10)-1));recalc();form.submit()});
if(plus)plus.addEventListener('click',function(){input.value=clampQty((parseInt(input.value||1,10)+1));recalc();form.submit()});
if(input)input.addEventListener('input',function(){input.value=clampQty(input.value);recalc()});
if(save)save.addEventListener('click',function(e){if(!validateQty(form)){e.preventDefault()}});
});
</script>
@endsection
