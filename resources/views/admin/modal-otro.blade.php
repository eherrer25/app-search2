<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Agregar usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form method="POST" action="{{ route('user.save') }}" autocomplete="off">
        <div class="modal-body">
                {{-- @method('POST') --}}
                @csrf
                <input type="hidden" name="type" value="2">
                <input type="hidden" name="company" value="{{$user->company}}">
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="">Nombre</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="" required autofocus>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="">Correo</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="" required>

                        </div>
                    </div>
                    {{-- <div class="col-12">
                        <div class="form-group">
                            <label for="">Ocupación</label>
                            <input id="occupation" type="text" class="form-control" name="occupation" value="{{ old('occupation') }}" required autocomplete="occupation">
                        </div>
                    </div> --}}
                    <div class="col-4">
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
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