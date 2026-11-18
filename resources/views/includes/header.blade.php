<header class="header">
    <div class="container">
        <div class="header-inner">
            <a href="/" class="logo-link">
                <img src="{{ asset('images/logo.png') }}" alt="Логотип" class="logo-img">
                <span>InteractiveApp</span>
            </a>
            <ul class="nav-links">
                <li><a href="/">Главная</a></li>
                <li><a href="{{ route('posts.index') }}">Статьи</a></li>
                <li><a href="{{ route('form.show') }}">Форма</a></li>
                <li><a href="{{ route('records') }}">Таблица файлов</a></li>
            </ul>
        </div>
    </div>
</header>