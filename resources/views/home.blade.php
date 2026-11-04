@extends('layouts.app')

@section('title', 'Главная страница')

@section('content')
    <div class="card" style="text-align: center; padding: 50px 20px;">
        <h1 style="font-size: 28px; margin-bottom: 15px; color: #1e293b;">
            Добро пожаловать в Interactive App!
        </h1>
        <p style="font-size: 16px; color: #64748b; max-width: 600px; margin: 0 auto 25px auto; line-height: 1.6;">
            Основа веб-приложения на Laravel. Здесь вы можете отправлять данные через форму и просматривать сохраненные JSON-файлы.
        </p>
        <div>
            <a href="{{ route('form.show') }}" class="btn">Перейти к форме</a>
        </div>
    </div>
@endsection