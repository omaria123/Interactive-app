@extends('layouts.app')

@section('title', 'Все записи')

@section('content')
    <h2 style="margin-bottom: 20px;">Список сохраненных записей</h2>

    @if (empty($records))
        <div class="alert" style="background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd;">
            Записей пока нет. <a href="{{ route('form.show') }}" style="color: #0284c7; font-weight: bold;">Заполните форму</a>, чтобы добавить первую!
        </div>
    @else
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Имя</th>
                        <th>Email</th>
                        <th>Сообщение</th>
                        <th>Дата отправки</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($records as $index => $record)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $record['name'] ?? '' }}</td>
                            <td>{{ $record['email'] ?? '' }}</td>
                            <td>{{ $record['message'] ?? '' }}</td>
                            <td>{{ $record['created_at'] ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection