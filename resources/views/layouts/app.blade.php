<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRESISI — @yield('title', 'Dashboard')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/perangkat.css') }}">

    @stack('styles')


</head>

<body>

    <div class="d-flex">

        @auth
            @php $role = auth()->user()->role; @endphp

            @if($role == 'admin_bapenda')
                @include('partials.admin.sidebar')
            @elseif($role == 'admin_perangkat')
                @include('partials.perangkat.sidebar')
            @endif
        @endauth

        <div class="main-content">

            @if(auth()->check() && auth()->user()->role == 'admin_perangkat')
                @include('partials.perangkat.topbar', [
                    'title' => 'PRESISI',
                    'subtitle' => 'Realisasi Penerimaan Retribusi Daerah'
                ])
            @elseif(auth()->check() && auth()->user()->role == 'admin_bapenda')
                @include('partials.admin.topbar', [
                    'title' => 'PRESISI',
                    'subtitle' => 'Realisasi Penerimaan Retribusi Daerah'
                ])
            @endif

            @yield('content')

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')

</body>

</html>