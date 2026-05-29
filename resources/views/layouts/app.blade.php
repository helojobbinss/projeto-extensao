<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Vida e Saúde - ADRA</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="app-shell">

    <aside class="app-sidebar">
        <div class="sidebar-user">
            <strong>ADMINISTRADOR</strong>
            <small>{{ auth()->user()->email ?? '' }}</small>
        </div>

        <nav>
            <a href="{{ route('projects') }}"     class="{{ request()->routeIs('projects*')     ? 'active' : '' }}">🏠 PROJETOS</a>
            <a href="{{ route('events') }}"       class="{{ request()->routeIs('events*')       ? 'active' : '' }}">📅 EVENTOS</a>
            <a href="{{ route('calendar') }}"       class="{{ request()->routeIs('calendar*')       ? 'active' : '' }}">📅 CALENDÁRIO</a>
            <a href="{{ route('classrooms') }}"       class="{{ request()->routeIs('classrooms*')       ? 'active' : '' }}">📅 Classes</a>
            <a href="{{ route('participants') }}"       class="{{ request()->routeIs('participants*') ? 'active' : '' }}">👥 PARTICIPANTES</a>
            <a href="{{ route('attendances') }}"   class="{{ request()->routeIs('attendances*')   ? 'active' : '' }}">📋 CHAMADA</a>
            <a href="{{ route('volunteers') }}"   class="{{ request()->routeIs('volunteers*')   ? 'active' : '' }}">🤝 VOLUNTÁRIOS</a>
        </nav>

        <a href="{{ route('logout') }}" class="sidebar-logout"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            SAIR
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
    </aside>

    <div class="app-main">
        <header class="app-header">
            <div class="brand">
                <img src="{{ asset('img/adra-logo.png') }}" alt="ADRA">
                Vida e Saúde - ADRA
            </div>
            <div class="user-info">👤 ADMINISTRADOR</div>
        </header>

        <main class="app-content">
            @yield('content')
        </main>
    </div>
</div>
<script>
    @if ($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Erro!',
            html: `{!! implode('<br>', $errors->all()) !!}`
        });
    @endif

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Sucesso!',
            text: "{{ session('success') }}"
        });
    @endif
</script>

@yield('scripts')

</body>
</html>
</body>
</html>

