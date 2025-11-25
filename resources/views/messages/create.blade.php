@extends('layouts.app')

@section('title', 'Tạo tin nhắn mới')

@section('content')
<div class="container py-5" style="margin-top: 80px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-paper-plane me-2"></i>Tạo tin nhắn hỗ trợ mới</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('messages.start') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="subject" class="form-label">Chủ đề (tùy chọn)</label>
                            <input type="text" class="form-control @error('subject') is-invalid @enderror" 
                                   id="subject" name="subject" value="{{ old('subject') }}" 
                                   placeholder="Ví dụ: Hỏi về sản phẩm, Hỗ trợ đơn hàng...">
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Nội dung tin nhắn <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" name="content" rows="6" 
                                      placeholder="Nhập nội dung tin nhắn của bạn..." required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Tối đa 2000 ký tự</small>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i>Gửi tin nhắn
                            </button>
                            <a href="{{ route('messages.index') }}" class="btn btn-secondary">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

