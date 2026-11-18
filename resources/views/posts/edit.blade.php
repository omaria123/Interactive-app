@extends('layouts.app')

@section('title', 'Редактирование статьи')

@section('content')
<div style="max-width: 600px; margin: 0 auto;">
    <div class="card">
        <h2 style="margin-bottom: 20px;">Редактировать публикацию</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('posts.update', $post) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title" class="form-label">Заголовок *</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $post->title) }}" required>
            </div>

            <div class="form-group">
                <label for="content" class="form-label">Содержимое *</label>
                <textarea name="content" id="content" rows="5" class="form-control" required>{{ old('content', $post->content) }}</textarea>
            </div>

            <div class="form-group">
                <label for="status" class="form-label">Статус публикации *</label>
                <select name="status" id="status" class="form-control">
                    <option value="published" {{ old('status', $post->status) === 'published' ? 'selected' : '' }}>Опубликовано (published)</option>
                    <option value="draft" {{ old('status', $post->status) === 'draft' ? 'selected' : '' }}>Черновик (draft)</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Теги:</label>
                <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                    @php $currentTagIds = $post->tags->pluck('id')->toArray(); @endphp
                    @foreach ($tags as $tag)
                        <label style="display: flex; align-items: center; gap: 5px; font-size: 14px; cursor: pointer;">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                {{ in_array($tag->id, old('tags', $currentTagIds)) ? 'checked' : '' }}>
                            #{{ $tag->name }}
                        </label>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="btn btn-block">Обновить статью</button>
        </form>
    </div>
</div>
@endsection