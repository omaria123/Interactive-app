@extends('layouts.app')

@section('title', 'Форма обратной связи')

@section('content')
<div style="max-width: 500px; margin: 0 auto;">
    <div class="card">
        <h2 style="margin-bottom: 20px; text-align: center;">Анкета пользователя</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('form.submit') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name" class="form-label">Ваше имя *</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email *</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label for="message" class="form-label">Сообщение *</label>
                <textarea name="message" id="message" rows="4" class="form-control">{{ old('message') }}</textarea>
            </div>

            <button type="submit" class="btn btn-block">Сохранить в JSON</button>
        </form>
    </div>
</div>
@endsection