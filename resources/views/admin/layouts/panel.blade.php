<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Panel') | Aura Zen</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;500;600;700&display=swap">
  <link rel="stylesheet" href="{{url('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Iconos de bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.2/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="{{url('dist/css/adminlte.min.css')}}">
  <link rel="stylesheet" href="{{url('css/panel.css')}}">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  {{-- Barra superior --}}
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link d-flex align-items-center" data-toggle="dropdown" href="#">
          <span class="avatar mr-2" style="width:30px;height:30px;font-size:.75rem">
            {{ strtoupper(mb_substr(Auth::user()->name, 0, 1)) }}
          </span>
          <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
          <a href="{{ route('logout') }}" class="dropdown-item"
             onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt mr-2 text-primary"></i> Cerrar sesión
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </div>
      </li>
    </ul>
  </nav>

  {{-- Menú lateral --}}
  <aside class="main-sidebar elevation-0">
    <a href="{{ route('admin.index') }}" class="brand-link">
      <span class="brand-logo"><i class="fas fa-spa"></i></span>
      <span class="brand-text">Aura Zen</span>
    </a>

    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
        <span class="avatar ml-2">{{ strtoupper(mb_substr(Auth::user()->name, 0, 1)) }}</span>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
          <small>Administrador</small>
        </div>
      </div>

      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
          <li class="nav-item">
            <a href="{{ route('admin.index') }}" class="nav-link {{ request()->routeIs('admin.index') ? 'active' : '' }}">
              <i class="nav-icon fas fa-home"></i><p>Panel principal</p>
            </a>
          </li>
          <li class="nav-header">EQUIPO</li>
          <li class="nav-item">
            <a href="{{ route('admin.usuarios.index') }}" class="nav-link {{ request()->routeIs('admin.usuarios.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-user-shield"></i><p>Usuarios y permisos</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

  {{-- Contenido: aquí entra lo que cada vista ponga en @section('content') --}}
  <div class="content-wrapper">
    <div class="container-fluid pt-3">
      @yield('content')
    </div>
  </div>

  <footer class="main-footer">
    &copy; {{ date('Y') }} <strong class="text-primary">Aura Zen</strong> · Centro de Bienestar &amp; Spa
  </footer>
</div>

<script src="{{url('plugins/jquery/jquery.min.js')}}"></script>
<script src="{{url('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{url('dist/js/adminlte.min.js')}}"></script>
@stack('scripts')
</body>
</html>
