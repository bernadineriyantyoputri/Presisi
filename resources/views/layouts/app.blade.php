<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRESISI — @yield('title', 'Dashboard')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/perangkat.css') }}">

    @stack('styles')

    <style>
        body {
            background: #f5f6fa;
        }
        .content {
            flex: 1;
            min-height: 100vh;
        }
    </style>
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

    <div class="content p-4 w-100">
        @yield('content')
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

</body>
</html>