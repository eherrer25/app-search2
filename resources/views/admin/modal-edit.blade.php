<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Editar usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form method="POST" action="{{ route('user.update',$user->id) }}">
        @method('PUT')
        @csrf
        <div class="modal-body">
            <div class="row">
                @role('Administrador')
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="">Nombre</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$user->name }}" required autocomplete="name" autofocus>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="">Correo</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$user->email }}" required autocomplete="email">

                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group mt-3">
                        <label for="">Nombre Compañia</label>
                        <input id="company" type="text" class="form-control" name="company" value="{{ $user->company }}" required autocomplete="company">
                    </div>
                </div>
                <div class="col-12 col-md-6 mt-3">
                    <div class="form-group">
                        <label for="">Fecha Api</label>
                        <input id="company" type="text" class="form-control" name="fecha_api" value="{{ Carbon\Carbon::parse($user->fecha_cont)->format('d-m-Y') }}" disabled>
                    </div>
                </div>
                
                <div class="col-12 col-md-6 mt-3">
                    <div class="form-group">
                        <label for="">Cantidad</label>
                        <input id="company" type="text" class="form-control" name="cont" value="{{ $user->cont }}">
                    </div>
                </div>
                <div class="col-12 col-md-6 mt-3 mb-3">
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="" name="habilitado" value="si"  @if($user->habilitado == 'si') checked @endif>
                      <label class="form-check-label" for="flexSwitchCheckChecked">Habilitado API</label>
                    </div>
                </div>
                @endrole
                {{-- <div class="col-12">
                    <div class="form-group">
                        <label for="">Ocupación</label>
                        <input id="occupation" type="text" class="form-control" name="occupation" value="{{ old('occupation') }}" required autocomplete="occupation">
                    </div>
                </div> --}}
                <div class="col-12 col-md-6 mt-3">
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </form>
</div>