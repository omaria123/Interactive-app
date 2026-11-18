@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div style="margin-bottom: 15px;">
    <a href="{{ route('posts.index') }}" style="color: #2563eb; text-decoration: none;">&larr; Назад к списку</a>
</div>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card" style="margin-bottom: 30px;">
    <h1 style="margin-bottom: 15px;">{{ $post->title }}</h1>

    <div style="font-size: 14px; color: #64748b; margin-bottom: 20px; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px;">
        Автор: <strong>{{ $post->user->name ?? 'Неизвестен' }}</strong> |
        Просмотров: <strong>{{ $post->views_count }}</strong> |
        Статус: <strong>{{ $post->status }}</strong>
    </div>

    <p style="font-size: 16px; line-height: 1.7; margin-bottom: 25px;">
        {{ $post->content }}
    </p>

    <div style="margin-bottom: 25px;">
        <strong>Теги публикации:</strong>
        @forelse ($post->tags as $tag)
            <span style="background: #e2e8f0; font-size: 13px; padding: 4px 10px; border-radius: 4px; margin-left: 5px;">#{{ $tag->name }}</span>
        @empty
            <span style="color: #94a3b8; margin-left: 5px;">без тегов</span>
        @endforelse
    </div>

    <div style="display: flex; gap: 10px; border-top: 1px solid #e2e8f0; padding-top: 20px;">
        <a href="{{ route('posts.edit', $post) }}" class="btn" style="background: #f59e0b;">Редактировать</a>

        <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Отправить запись в корзину (Soft Delete)?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn" style="background: #ef4444;">Удалить</button>
        </form>
    </div>
</div>

<div class="card">
    <h3 style="margin-bottom: 20px;">Комментарии ({{ $post->comments->count() }})</h3>

    <div style="display: flex; flex-direction: column; gap: 15px; margin-bottom: 25px;">
        @forelse ($post->comments as $comment)
            <div style="background: #f8fafc; border-left: 3px solid #2563eb; padding: 12px 15px; border-radius: 4px;">
                <p style="margin-bottom: 5px;">{{ $comment->body }}</p>
                <small style="color: #94a3b8;">{{ $comment->created_at->format('d.m.Y H:i') }}</small>
            </div>
        @empty
            <p style="color: #64748b;">Комментариев пока нет. Будьте первыми!</p>
        @endforelse
    </div>

    <form action="{{ route('posts.comments.store', $post) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="body" class="form-label">Оставить комментарий:</label>
            <textarea name="body" id="body" rows="3" class="form-control" placeholder="Текст комментария..." required></textarea>
        </div>
        <button type="submit" class="btn">Отправить комментарий</button>
    </form>
</div>
@endsection