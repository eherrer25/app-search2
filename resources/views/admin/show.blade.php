@extends('layouts.main')

@section('content')

    <div class="pagetitle">
      <h1>Usuarios de {{$admin->name}}</h1>
        {{-- <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item active"></li>
            </ol>
        </nav> --}}
    </div>
    <!-- End Page Title -->

    @include('messages.message')

    <section class="section dashboard">
      <div class="row">
        <div class="col-3 contact">
            <div class="info-box card">
                <span><h3>Compañia:</h3>{{$admin->company}}</span>
            </div>
        </div>
        <div class="col-3 contact">
            <div class="info-box card">
                <span><h3>Correo:</h3>{{$admin->email}}</span>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                @role('Administrador')
                <div class="card-header d-flex flex-row-reverse">
                    {{-- <a href="" class="btn btn-success rounded-pill" data-bs-toggle="modal" data-bs-target="#agregarUsuario"><i class="bi bi-plus"></i></a> --}}
                    <a href="" class="btn btn-success rounded-pill btn-otro" data-bs-toggle="modal" data-bs-target="#agregarOtro" data-id="{{$admin->id}}"><i class="bi bi-person-plus"></i></a>
                </div>
                @endrole
                <div class="card-body">
                    <div class="table-responsive mt-3">
                        <table class="table">
                            <tr>
                                <th>Nombre</th>
                                <th>estado</th>
                                <th></th>
                            </tr>
                            @foreach ($admin->getUsers() as $user )
                            <tr>
                                <td>{{$user->name}}</td>
                                <td><span class="badge rounded-pill bg-success">{{$user->name_status}}</span></td>
                                <td>
                                    @if(!$user->hasRole('admin'))
                                    {{-- <div class="btn-group"> --}}
                                        <a href="" class="btn btn-primary btn-sm btn-edit" data-bs-toggle="modal" data-bs-target="#editarUsuario" data-id="{{$user->id}}"><i class="bi bi-pencil-square"></i></a>
                                    {{-- </div> --}}
                                    

                                    <form action="{{route('user.delete',$user->id)}}" method="post" id="form-delete" class="d-inline">
                                        @method('DELETE')
                                        @csrf
                                        <button type="button" class="btn btn-danger btn-sm btn-delete" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                            <span class="spinner-border spinner-border-sm s-spin" style="display: none;"></span>
                                        </button>
                                        
                                    </form>
                                    @endif
                                    {{-- <a href="" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a> --}}
                                </td>
                            </tr>
                                
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </section>



    <div class="modal fade" id="agregarUsuario" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('user.save') }}">
                    @csrf
                    <input type="hidden" name="type" value="1">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Nombre</label>
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Correo</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Nombre Compañia</label>
                                    <input id="company" type="text" class="form-control" name="company" value="{{ old('company') }}" required autocomplete="company">
                                </div>
                            </div>
                            {{-- <div class="col-12">
                                <div class="form-group">
                                    <label for="">Ocupación</label>
                                    <input id="occupation" type="text" class="form-control" name="occupation" value="{{ old('occupation') }}" required autocomplete="occupation">
                                </div>
                            </div> --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="password">Contraseña</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

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
        </div>
    </div>
    <!-- End Vertically centered Modal-->

    <div class="modal fade" id="editarUsuario" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            
        </div>
    </div>

    <div class="modal fade" id="agregarOtro" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            
        </div>
    </div>
    
@endsection

@section('script')

{{-- <script src="{{mix('js/main.js')}}"></script> --}}
<script>
    
    $('.btn-delete').on('click',function(e){

         $(this).prop( "disabled", true );

        let spin = $(this).find('.s-spin'); 
        let trash = $(this).find('.bi-trash');
        trash.hide();
        spin.show();

        setTimeout(() => {
            $('#form-delete').submit();
        }, 1000);

        // console.log('prueba');

    });

    $('.btn-edit').on('click',function(e){

        let id = $(this).data('id');

        $.ajax({
           type:'POST',
           url:"{{ route('user.modal-edit') }}",
           headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
           data:{id:id},
           success:function(data){
                $('#editarUsuario').find('.modal-dialog').html(data);
           }
        });

    });

    $('.btn-otro').on('click',function(e){

        let id = $(this).data('id');

        $.ajax({
           type:'POST',
           url:"{{ route('user.modal-otro') }}",
           headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
           data:{id:id},
           success:function(data){
                $('#agregarOtro').find('.modal-dialog').html(data);
           }
        });

    });


</script>
    
@endsection