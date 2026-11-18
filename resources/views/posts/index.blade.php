@extends('layouts.app')

@section('title', 'Список статей')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
    <h2>Каталог публикаций</h2>
    <a href="{{ route('posts.create') }}" class="btn">+ Написать статью</a>
</div>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div style="margin-bottom: 25px; display: flex; gap: 10px; flex-wrap: wrap;">
    <a href="{{ route('posts.index') }}" class="btn" style="background: {{ request('filter') ? '#64748b' : '#2563eb' }}">
        Опубликованные
    </a>
    <a href="{{ route('posts.index', ['filter' => 'popular']) }}" class="btn" style="background: {{ request('filter') === 'popular' ? '#2563eb' : '#64748b' }}">
        Популярные
    </a>
    <a href="{{ route('posts.index', ['filter' => 'drafts']) }}" class="btn" style="background: {{ request('filter') === 'drafts' ? '#2563eb' : '#64748b' }}">
        Черновики
    </a>
    <a href="{{ route('posts.index', ['filter' => 'trash']) }}" class="btn" style="background: {{ request('filter') === 'trash' ? '#ef4444' : '#64748b' }}">
        Корзина (Удаленные)
    </a>
</div>

@if ($posts->isEmpty())
    <div class="alert" style="background: #e0f2fe; color: #0369a1;">
        В этой категории нет записей.
    </div>
@else
    <div style="display: flex; flex-direction: column; gap: 20px;">
        @foreach ($posts as $post)
            <div class="card" style="{{ $post->trashed() ? 'border: 1px dashed #ef4444; background: #fff5f5;' : '' }}">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <h3 style="margin-bottom: 8px;">
                            @if ($post->trashed())
                                <span style="color: #ef4444;">[В КОРЗИНЕ]</span> {{ $post->title }}
                            @else
                                <a href="{{ route('posts.show', $post) }}" style="text-decoration: none; color: #1e293b;">
                                    {{ $post->title }}
                                </a>
                            @endif
                        </h3>
                        <p style="color: #64748b; font-size: 14px; margin-bottom: 12px;">
                            Автор: <strong>{{ $post->user->name ?? 'Неизвестен' }}</strong> |
                            Просмотров: <strong>{{ $post->views_count }}</strong> |
                            Статус: <strong style="color: {{ $post->status === 'published' ? '#166534' : '#b45309' }}">{{ $post->status }}</strong>
                        </p>
                    </div>

                    @if ($post->trashed())
                        <form action="{{ route('posts.restore', $post->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn" style="background: #10b981; font-size: 13px; padding: 6px 12px;">Восстановить</button>
                        </form>
                    @endif
                </div>

                <p style="margin-bottom: 15px; line-height: 1.5;">
                    {{ Str::limit($post->content, 140) }}
                </p>

                <div style="display: flex; gap: 6px; align-items: center; flex-wrap: wrap;">
                    <span style="font-size: 13px; color: #64748b;">Теги:</span>
                    @forelse ($post->tags as $tag)
                        <span class="badge">#{{ $tag->name }}</span>
                    @empty
                        <span style="font-size: 12px; color: #94a3b8;">нет тегов</span>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection