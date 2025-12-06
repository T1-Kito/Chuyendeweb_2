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
            <button type="button" class="btn btn-voucher ms-auto" data-bs-toggle="modal" data-bs-target="#voucherModal">Mã Voucher</button>
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
              <div class="cart-line py-3" data-price="{{ (float) $item->price_per_month }}" data-stock="{{ $item->product->stock_quantity ?? 0 }}" data-item-id="{{ $item->id }}">
                <div class="d-flex align-items-start">
                  <div class="line-thumb me-3"><img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}"></div>
                  <div class="flex-grow-1">
                    <div class="fw-semibold mb-1">{{ $item->product->name }}</div>
                    @if($item->product->description)
                      <div class="small text-muted mb-1">{{ \Illuminate\Support\Str::limit($item->product->description, 80) }}</div>
                    @endif
                    <div class="small text-muted mb-2">
                      <span class="badge bg-secondary">{{ $item->rental_duration }} tháng</span>
                      <span class="ms-2">{{ number_format($item->price_per_month) }}đ / tháng</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                      <form action="{{ route('cart.update', $item) }}" method="post" class="d-inline-flex align-items-center cart-qty" onsubmit="return validateQty(this, event)">
                        @csrf
                        @method('patch')
                        <button class="btn btn-sm btn-outline-secondary btn-minus" type="button" title="Giảm số lượng">−</button>
                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock_quantity ?? 999 }}" class="form-control form-control-sm text-center mx-2 qty-input" style="width:60px" required>
                        <button class="btn btn-sm btn-outline-secondary btn-plus" type="button" title="Tăng số lượng">+</button>
                        <button class="btn btn-sm btn-outline-primary ms-2 btn-save" type="submit">Lưu</button>
                      </form>
                      <form action="{{ route('cart.remove', $item) }}" method="post" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng không?');">
                        @csrf
                        @method('delete')
                        <button class="btn btn-sm btn-link text-danger" type="submit" title="Xóa sản phẩm"><i class="fas fa-trash-alt"></i> Xóa</button>
                      </form>
                    </div>
                    <div class="mt-2 small fw-semibold text-dark item-total">Tổng: {{ number_format($item->total_price) }}đ</div>
                    <div class="small text-danger qty-error" style="display:none;"></div>
                  </div>
                </div>
                <hr class="my-3">
              </div>
              @endforeach
            @endif

            <!-- Voucher & totals -->
            <div id="voucherBox" class="voucher-box p-2 rounded mb-2 {{ isset($voucher) && $voucher ? 'bg-success-subtle' : 'bg-light' }}">
              @if(isset($voucher) && $voucher)
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <div>
                    <div class="small fw-semibold text-success"><i class="fas fa-ticket-alt me-1"></i>{{ $voucher->code }} áp dụng</div>
                    <div class="small text-muted">Giảm: -{{ number_format($discount) }}đ</div>
                  </div>
                  <form action="{{ route('cart.remove-voucher') }}" method="post" onsubmit="return confirm('Gỡ voucher hiện tại?');">
                    @csrf
                    @method('delete')
                    <button class="btn btn-sm btn-outline-danger" title="Gỡ voucher hiện tại"><i class="fas fa-times"></i></button>
                  </form>
                </div>
              @endif

              <form action="{{ route('cart.apply-voucher') }}" method="post" class="d-flex gap-2 align-items-center" id="applyVoucherForm">
                @csrf
                <input type="text" name="code" class="form-control form-control-sm" placeholder="Nhập mã voucher" maxlength="50" id="voucherCodeInput" value="">
                <button class="btn btn-sm btn-outline-primary">Áp dụng</button>
              </form>
            </div>

            <div class="d-flex justify-content-between small mb-2">
              <span class="text-muted">Số món</span>
              <span class="item-count">{{ isset($itemCount) ? $itemCount : $items->sum('quantity') }}</span>
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
            @if($items->isEmpty())
              <button class="btn btn-dark w-100 py-2 mt-2" disabled><i class="fas fa-credit-card me-2"></i>Tiến Hành Thanh Toán</button>
              <div class="text-center text-muted small mt-2">Vui lòng thêm sản phẩm vào giỏ hàng trước khi thanh toán</div>
            @else
              <button onclick="window.location.href='{{ route('checkout.index') }}'" class="btn btn-dark w-100 py-2 mt-2"><i class="fas fa-credit-card me-2"></i>Tiến Hành Thanh Toán</button>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Voucher list modal -->
@if(isset($availableVouchers) && $availableVouchers->isNotEmpty())
<div class="modal fade" id="voucherModal" tabindex="-1" aria-labelledby="voucherModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="voucherModalLabel">Chọn Mã Voucher</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="small text-muted mb-2">Chọn một mã bên dưới, hệ thống sẽ tự điền vào ô voucher của giỏ hàng.</p>
        <div class="list-group">
          @foreach($availableVouchers as $vc)
          <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center voucher-option" data-code="{{ $vc->code }}">
            <div>
              <div class="fw-semibold">{{ $vc->code }}</div>
              @if($vc->description)
              <div class="small text-muted">{{ $vc->description }}</div>
              @endif
            </div>
            <span class="badge bg-primary rounded-pill">
              @if($vc->type === 'percentage')
                {{ (float) $vc->value }}%
              @else
                -{{ number_format($vc->value) }}đ
              @endif
            </span>
          </button>
          @endforeach
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>
@endif

<script>
function formatCurrency(n) {
    try {
        return new Intl.NumberFormat('vi-VN').format(n) + 'đ';
    } catch(e) {
        return (Math.round(n)).toLocaleString('vi-VN') + 'đ';
    }
}

function clampQty(val, maxStock) {
    val = parseInt(val || 1, 10);
    if (isNaN(val) || val < 1) return 1;
    if (maxStock && val > maxStock) return maxStock;
    return val;
}

function validateQty(form, event) {
    const cartLine = form.closest('.cart-line');
    const input = form.querySelector('.qty-input');
    const stock = parseInt(cartLine.getAttribute('data-stock') || '999', 10);
    const errorEl = cartLine.querySelector('.qty-error');

    let qty = parseInt(input.value, 10);

    // Kiểm tra số lượng hợp lệ
    if (isNaN(qty) || qty < 1) {
        if (errorEl) {
            errorEl.textContent = 'Vui lòng nhập số lượng hợp lệ';
            errorEl.style.display = 'block';
        }
        if (event) event.preventDefault();
        input.value = 1;
        return false;
    }

    // Kiểm tra vượt quá tồn kho
    if (qty > stock) {
        if (errorEl) {
            errorEl.textContent = 'Số lượng không được vượt quá số tồn kho (' + stock + ')';
            errorEl.style.display = 'block';
        }
        if (event) event.preventDefault();
        input.value = stock;
        return false;
    }

    // Ẩn thông báo lỗi nếu hợp lệ
    if (errorEl) {
        errorEl.style.display = 'none';
    }

    return true;
}

function updateCartSummary() {
    let subtotal = 0;
    let itemCount = 0;

    document.querySelectorAll('.cart-line').forEach(function(card) {
        const price = parseFloat(card.getAttribute('data-price') || '0');
        const input = card.querySelector('.qty-input');
        if (input) {
            const qty = parseInt(input.value || '1', 10);
            if (!isNaN(qty) && qty > 0) {
                subtotal += price * qty;
                itemCount += qty;
            }
        }
    });

    // Cập nhật số món
    const itemCountEl = document.querySelector('.item-count');
    if (itemCountEl) {
        itemCountEl.textContent = itemCount;
    }

    // Cập nhật tạm tính
    const subtotalEl = document.querySelector('.subtotal-amount');
    if (subtotalEl) {
        subtotalEl.textContent = formatCurrency(subtotal);
    }

    // Tính discount nếu có
    const discountText = document.querySelector('.discount-amount')?.textContent || '';
    const discountVal = parseInt(discountText.replace(/[^0-9]/g, '')) || 0;

    // Cập nhật tổng cộng
    const grandTotalEl = document.querySelector('.grand-total');
    if (grandTotalEl) {
        grandTotalEl.textContent = formatCurrency(Math.max(0, subtotal - discountVal));
    }
}

function recalcItemTotal(card) {
    const price = parseFloat(card.getAttribute('data-price') || '0');
    const input = card.querySelector('.qty-input');
    const itemTotalEl = card.querySelector('.item-total');
    const stock = parseInt(card.getAttribute('data-stock') || '999', 10);
    const errorEl = card.querySelector('.qty-error');

    if (!input) return;

    let qty = parseInt(input.value || '1', 10);

    // Validate và clamp
    if (isNaN(qty) || qty < 1) {
        qty = 1;
        input.value = 1;
        if (errorEl) errorEl.style.display = 'none';
    } else if (qty > stock) {
        qty = stock;
        input.value = stock;
        if (errorEl) {
            errorEl.textContent = 'Số lượng không được vượt quá số tồn kho (' + stock + ')';
            errorEl.style.display = 'block';
        }
    } else {
        if (errorEl) errorEl.style.display = 'none';
    }

    const itemTotal = price * qty;
    if (itemTotalEl) {
        itemTotalEl.innerHTML = 'Tổng: ' + formatCurrency(itemTotal);
    }

    updateCartSummary();
}

// Khởi tạo cho mỗi cart line
document.querySelectorAll('.cart-line').forEach(function(card) {
    const form = card.querySelector('form.cart-qty');
    const input = form?.querySelector('.qty-input');
    const minus = form?.querySelector('.btn-minus');
    const plus = form?.querySelector('.btn-plus');
    const stock = parseInt(card.getAttribute('data-stock') || '999', 10);

    // Nút giảm
    if (minus) {
        minus.addEventListener('click', function() {
            let currentQty = parseInt(input.value || '1', 10);
            if (currentQty > 1) {
                input.value = currentQty - 1;
                recalcItemTotal(card);
                form.submit();
            }
        });
    }

    // Nút tăng
    if (plus) {
        plus.addEventListener('click', function() {
            let currentQty = parseInt(input.value || '1', 10);
            if (currentQty < stock) {
                input.value = currentQty + 1;
                recalcItemTotal(card);
                form.submit();
            } else {
                const errorEl = card.querySelector('.qty-error');
                if (errorEl) {
                    errorEl.textContent = 'Số lượng không được vượt quá số tồn kho (' + stock + ')';
                    errorEl.style.display = 'block';
                }
            }
        });
    }

    // Khi nhập trực tiếp
    if (input) {
        input.addEventListener('input', function() {
            recalcItemTotal(card);
        });

        input.addEventListener('blur', function() {
            recalcItemTotal(card);
        });
    }

    // Validate khi submit form
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!validateQty(form, e)) {
                e.preventDefault();
                return false;
            }
        });
    }
});

// Khởi tạo tổng kết ban đầu
updateCartSummary();

// Chọn voucher từ modal và tự điền vào ô nhập mã
document.querySelectorAll('.voucher-option').forEach(function(btn) {
  btn.addEventListener('click', function() {
    var code = this.getAttribute('data-code') || '';
    var input = document.getElementById('voucherCodeInput');
    if (input) {
      input.value = code;
      input.focus();
    }
    // Đóng modal nếu bootstrap JS có mặt
    if (typeof bootstrap !== 'undefined') {
      var modalEl = document.getElementById('voucherModal');
      if (modalEl) {
        var modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
        modal.hide();
      }
    }
    // Scroll tới vùng voucher
    var box = document.getElementById('voucherBox');
    if (box) {
      box.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
  });
});

</script>
@endsection
