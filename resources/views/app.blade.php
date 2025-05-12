<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Sistema de Produtos')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Prioridade ao .ico por compatibilidade -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- PNG para navegadores modernos -->
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @endif

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    @stack('styles')
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('produtos.index') }}">
                <img src="{{ asset('favicon.png') }}" alt="Logo" width="24" height="24">
                Gestão de Produtos
            </a>
        </div>
    </nav>

    <main class="container flex-grow-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-auto">
        <div class="container">
            &copy; {{ date('Y') }} Lucas Souza. Todos os direitos reservados.
        </div>
    </footer>

    <x-alert-message />
    @yield ('scripts')

    @if (session('error'))
        <script>
            alertaErro('Erro', "{{ session('error') }}");
        </script>
    @endif

    @if (session('success'))
        <script>
            alertaErro('Sucesso', "{{ session('success') }}");
        </script>
    @endif

</body>

</html>
