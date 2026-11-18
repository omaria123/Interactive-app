@extends('layouts.app')

@section('title', 'Написать публикацию')

@section('content')
<div style="max-width: 600px; margin: 0 auto;">
    <div class="card">
        <h2 style="margin-bottom: 20px;">Новая публикация</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('posts.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="author_name" class="form-label">Ваше имя *</label>
                <input type="text" name="author_name" id="author_name" class="form-control" value="{{ old('author_name') }}" placeholder="Например: Анна" required>
            </div>

            <div class="form-group">
                <label for="author_email" class="form-label">Ваш Email *</label>
                <input type="email" name="author_email" id="author_email" class="form-control" value="{{ old('author_email') }}" placeholder="anna@example.com" required>
            </div>

            <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 20px 0;">

            <div class="form-group">
                <label for="title" class="form-label">Название статьи *</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" placeholder="О чем статья?" required>
            </div>

            <div class="form-group">
                <label for="content" class="form-label">Текст статьи *</label>
                <textarea name="content" id="content" rows="5" class="form-control" placeholder="Напишите текст публикации..." required>{{ old('content') }}</textarea>
            </div>

            <div class="form-group">
                <label for="status" class="form-label">Статус *</label>
                <select name="status" id="status" class="form-control">
                    <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Опубликовано сразу</option>
                    <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Сохранить в черновик</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Теги статьи:</label>
                <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                    @foreach ($tags as $tag)
                        <label style="display: flex; align-items: center; gap: 5px; font-size: 14px; cursor: pointer;">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                {{ is_array(old('tags')) && in_array($tag->id, old('tags')) ? 'checked' : '' }}>
                            #{{ $tag->name }}
                        </label>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="btn btn-block">Опубликовать статью</button>
        </form>
    </div>
</div>
@endsection