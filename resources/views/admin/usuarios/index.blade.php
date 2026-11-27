@extends('admin.layouts.panel')


@section('title', 'Usuarios y permisos')

@section('content')
  {{-- Encabezado de la página --}}
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-3" style="gap:1rem">
    <div>
      <h1 class="page-title">Usuarios y permisos</h1>
      <p class="page-subtitle">Da acceso al panel a tu equipo: administradores, recepcionistas y esteticistas</p>
    </div>
    <button class="btn btn-primary" data-toggle="modal" data-target="#modal-usuario">
      <i class="fas fa-user-plus mr-1"></i> Agregar usuario
    </button>
  </div>

  {{-- Mensaje de éxito después de guardar --}}
  @if (session('mensaje'))
    <div class="alert alert-success">{{ session('mensaje') }}</div>
  @endif

  {{-- Los errores de validación se muestran dentro del modal, debajo de cada campo --}}

  @php
    // Roles disponibles (después pueden salir de la base de datos)
    $roles = [
      'admin'         => 'Administrador',
      'recepcionista' => 'Recepcionista',
      'esteticista'   => 'Esteticista',
      'cliente'       => 'Cliente',
    ];

    // Permisos de ejemplo: true = el rol lo tiene marcado
    $permisos = [
      ['nombre' => 'Ver citas',                 'recepcionista' => true,  'esteticista' => true],
      ['nombre' => 'Crear / reprogramar citas', 'recepcionista' => true,  'esteticista' => false],
      ['nombre' => 'Cancelar citas',            'recepcionista' => true,  'esteticista' => false],
      ['nombre' => 'Marcar cita realizada',     'recepcionista' => true,  'esteticista' => true],
      ['nombre' => 'Editar servicios',          'recepcionista' => false, 'esteticista' => false],
      ['nombre' => 'Editar horarios',           'recepcionista' => true,  'esteticista' => false],
      ['nombre' => 'Gestionar usuarios',        'recepcionista' => false, 'esteticista' => false],
    ];

    $usuario = Auth::user();
  @endphp

  {{-- Lista de usuarios --}}
  <div class="card mb-3">
    <div class="card-header"><h3 class="card-title mb-0">Equipo</h3></div>
    <div class="card-body p-0 table-responsive">
      <table class="table mb-0">
        <thead>
          <tr>
            <th class="pl-4">Usuario</th>
            <th>Rol</th>
            <th class="text-right pr-4">Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($usuarios as $user)
            <tr>
              <td class="pl-4">
                <div class="d-flex align-items-center">
                  <span class="avatar mr-2">{{ strtoupper(mb_substr($user->name, 0, 1)) }}</span>
                  <div>
                    <strong>{{ $user->name }}</strong>
                    @if ($user->id === Auth::id())
                      <small class="text-primary">(tú)</small>
                    @endif
                    <small class="d-block text-muted">{{ $user->email }}</small>
                  </div>
                </div>
              </td>
              <td><span class="role role-admin">Administrador</span></td>
              <td class="text-right pr-4">
                <button type="button" class="btn btn-icon" title="Editar" data-toggle="modal" data-target="#modal-editar">
                  <i class="fas fa-pen"></i>
                </button>
                {{-- TODO: conectar con la ruta de borrar --}}
                <button type="button" class="btn btn-icon btn-icon-danger ml-1" title="Borrar">
                  <i class="fas fa-trash"></i>
                </button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  

  {{-- Permisos por rol --}}
  <form class="card" method="POST" action="#">
    @csrf
    <div class="card-header"><h3 class="card-title mb-0">¿Qué puede hacer cada rol?</h3></div>
    <div class="card-body p-0 table-responsive">
      <table class="table perm-table mb-0">
        <thead>
          <tr>
            <th class="pl-4">Permiso</th>
            <th><span class="role role-admin">Administrador</span></th>
            <th><span class="role role-recepcionista">Recepcionista</span></th>
            <th><span class="role role-esteticista">Esteticista</span></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($permisos as $i => $permiso)
            <tr>
              <td class="pl-4">{{ $permiso['nombre'] }}</td>
              {{-- El administrador siempre tiene todos los permisos --}}
              <td><input type="checkbox" class="check" checked disabled title="El administrador tiene todos los permisos"></td>
              <td>
                <input type="checkbox" class="check" name="permisos[{{ $i }}][recepcionista]" value="1"
                       {{ $permiso['recepcionista'] ? 'checked' : '' }}>
              </td>
              <td>
                <input type="checkbox" class="check" name="permisos[{{ $i }}][esteticista]" value="1"
                       {{ $permiso['esteticista'] ? 'checked' : '' }}>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="card-footer text-right">
      {{-- TODO: volver a type="submit" cuando exista la ruta --}}
      <button type="button" class="btn btn-primary">Guardar permisos</button>
    </div>
  </form>

  {{-- Modal: nuevo usuario --}}
  <div class="modal fade" id="modal-usuario" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <form class="modal-content" method="POST" action="{{ route('admin.usuarios.store') }}">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title font-weight-bold">Agregar usuario</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}"
                   class="form-control @error('name') is-invalid @enderror" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
          <div class="form-group">
            <label for="email">Correo</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}"
                   class="form-control @error('email') is-invalid @enderror" required>
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
          <!-- <div class="form-group">
            <label for="rol">Rol</label>
            <select id="rol" name="rol" class="custom-select">
              @foreach ($roles as $clave => $nombre)
                <option value="{{ $clave }}">{{ $nombre }}</option>
              @endforeach
            </select>
          </div> -->
          <div class="form-row">
            <div class="form-group col-sm-6 mb-0">
              <label for="password">Contraseña</label>
              <input type="password" id="password" name="password"
                     class="form-control @error('password') is-invalid @enderror" required minlength="8">
              @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group col-sm-6 mb-0">
              <label for="password_confirmation">Confirmar</label>
              <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Agregar</button>
        </div>
      </form>
    </div>
  </div>

  {{-- Modal: editar usuario --}}
  <div class="modal fade" id="modal-editar" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <form class="modal-content" method="POST" action="#">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title font-weight-bold">Editar usuario</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="editar-name">Nombre</label>
            <input type="text" id="editar-name" name="name" class="form-control" value="{{ $usuario->name }}" required>
          </div>
          <div class="form-group">
            <label for="editar-email">Correo</label>
            <input type="email" id="editar-email" name="email" class="form-control" value="{{ $usuario->email }}" required>
          </div>
          <div class="form-group">
            <label for="editar-rol">Rol</label>
            <select id="editar-rol" name="rol" class="custom-select" disabled>
              @foreach ($roles as $clave => $nombre)
                <option value="{{ $clave }}" {{ $clave === 'admin' ? 'selected' : '' }}>{{ $nombre }}</option>
              @endforeach
            </select>
            <small class="text-muted">No puedes cambiar tu propio rol.</small>
          </div>
          <div class="form-row">
            <div class="form-group col-sm-6 mb-0">
              <label for="editar-password">Nueva contraseña</label>
              <input type="password" id="editar-password" name="password" class="form-control" minlength="8"
                     placeholder="Dejar vacío para no cambiar">
            </div>
            <div class="form-group col-sm-6 mb-0">
              <label for="editar-password2">Confirmar</label>
              <input type="password" id="editar-password2" name="password_confirmation" class="form-control">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
          {{-- TODO: volver a type="submit" cuando exista la ruta --}}
          <button type="button" class="btn btn-primary" data-dismiss="modal">Guardar cambios</button>
        </div>
      </form>
    </div>
  </div>
@endsection

{{-- Si el guardado falló por validación, volver a abrir el modal con los errores --}}
@if ($errors->any())
  @push('scripts')
    <script>
      $(function () { $('#modal-usuario').modal('show'); });
    </script>
  @endpush
@endif
