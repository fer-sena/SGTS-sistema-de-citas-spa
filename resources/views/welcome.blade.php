@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-center shadow-sm">
                <div class="card-body py-5">
                    <h1 class="mb-3">{{ config('app.name', 'Laravel') }}</h1>
                    <p class="lead text-muted mb-4">Sistema de gestión de citas</p>

                    <!-- @auth
                        <a href="{{ route('home') }}" class="btn btn-primary btn-lg">Ir al panel</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg me-2">Iniciar sesión</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">Registrarse</a>
                        @endif
                    @endauth -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
