@extends('layouts.app')

@section('title', 'Quản lý bình luận')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Quản lý bình luận sản phẩm</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card">
        <div class="card-body">
            @if($comments->count())
            <table class="table align-middle table-bordered table-striped mb-0">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Sản phẩm</th>
                        <th>Nội dung</th>
                        <th>Thời gian</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($comments as $comment)
                    <tr>
                        <td>
                            <strong>{{ $comment->user->name ?? 'N/A' }}</strong><br>
                            <small>{{ $comment->user->email ?? '' }}</small>
                        </td>
                        <td>
                            @if($comment->product)
                            <a href="{{ route('products.show', $comment->product->slug ?? $comment->product->id) }}" target="_blank">
                                {{ $comment->product->name }}
                            </a>
                            @endif
                        </td>
                        <td style="max-width:360px;word-break:break-word;">{!! nl2br(e($comment->content)) !!}</td>
                        <td><small>{{ $comment->created_at->format('d/m/Y H:i') }}<br>{{ $comment->created_at->diffForHumans() }}</small></td>
                        <td>
                            <form method="POST" action="{{ route('admin.comments.destroy', $comment->id) }}" onsubmit="return confirm('Bạn chắc chắn muốn xoá bình luận này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Xoá</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                {{ $comments->links() }}
            </div>
            @else
                <div class="text-muted py-5 text-center">Chưa có bình luận nào.</div>
            @endif
        </div>
    </div>
</div>
@endsection
