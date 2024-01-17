@extends('layouts.main')

@section('css')

<style>
    .btn-primary {
        --bs-btn-color: #fff;
        --bs-btn-bg: #f6a615;
        --bs-btn-border-color: #f6a615;
        --bs-btn-hover-color: #fff;
        --bs-btn-hover-bg: #e09914;
        --bs-btn-hover-border-color: #e09914;
        --bs-btn-focus-shadow-rgb: 49,132,253;
        --bs-btn-active-color: #fff;
        --bs-btn-active-bg: #e09914;
        --bs-btn-active-border-color: #e09914;
        --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
        --bs-btn-disabled-color: #fff;
        --bs-btn-disabled-bg: #f6a615;
        --bs-btn-disabled-border-color: #f6a615;
    }
    .form-control:focus {
        color: #212529;
        background-color: #fff;
        border-color: #ffc864;
        outline: 0;
        box-shadow: none;
    }
    .form-check-input:checked {
        background-color: #f6a615;
        border-color: #ffc107;
    }
    .form-check-input:focus {
        border-color: none;
        outline: 0;
        box-shadow: none;
    }
    .profile-info{
        padding-left: 10px;
        width: 100%;
    }
    .profile-info h2 {
        font-size: 24px;
        font-weight: 700;
        color: rgb(44, 56, 78);
        margin: 10px 0px 0px;
    }
    .profile-info h3 {
        font-size: 18px;
    }
    .mr-1{
        margin-right: 20px;
    }
    .accordion-button i {
         padding-right: 5px;
    }
    .card{
        border-radius: 10px;
    }
    .card-title {
        padding: 15px 0 0px 0;
    }
    .dashboard .sales-card .card-icon {
        background: none;
    }
    .accordion-button:not(.collapsed) {
        color: #fff;
        background-color: #f6a615;
    }
    .profile .label {
        font-weight: 600;
        color: rgba(1, 41, 112, 0.6);
    }
    .input-group .btn {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }
    .table-hover thead tr {
        color: #1bc5bd;
        background-color: rgba(27,197,189,.1);
    }
</style>
    
@endsection

@section('content')

    <section class="section dashboard">
      <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body profile-card pt-4"> 
                    <div class="row">
                        <div class="col-lg-2">
                            <img src="{{asset($img_profile)}}" alt="Profile" class="rounded-circle img-fluid">
                        </div>
                        <div class="col-lg-10">
                            <div class="profile-info">
                                <h2>{{$infoPersonal['razonSocial']}} <i class="bi bi-patch-check-fill text-success"></i></h2>
                                <span class="mr-1"><i class="bi bi-person"></i> {{$infoPersonal['nombreComercial']}}</span>
                                <span class="mr-1"><i class="bi bi-person-vcard-fill"></i> {{$infoPersonal['ruc']}}</span>
                                <span class="mr-1"><i class="bi bi-flag"></i> {{$infoPersonal['estadoContribuyente']}}</span>
                                
                                @if ($infoPersonal['provincia'])
                                    <span class="mr-1"><i class="bi bi-pin-map"></i> {{$infoPersonal['provincia']}}</span>
                                @endif

                                @if ($infoPersonal['actividadEconomica'])
                                    <p class="mr-1 mt-1"><i class="bi bi-bookmark-fill"></i> {{$infoPersonal['actividadEconomica']}}</p>
                                @endif
                                {{-- <div class="mt-3">
                                    @if ($infoPersonal['assessment'])
                                        <p>Este cliente tiene <b>{{$infoPersonal['assessment'] ? $infoPersonal['assessment'] : 1}}% de evaluación crediticia.</b></p>
                                        <p>Calificacion {{ $infoPersonal['qualification'] ? $infoPersonal['qualification'] : "Z" }}</p>
                                    @else
                                        <p>Este cliente no tiene evaluación</p>
                                    @endif
                                </div> --}}
                                
                            </div>
                        </div>
                        {{-- <div class="offset-lg-2 col-lg-8 col-12">
                            <b>Valoración:</b>
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="{{$infoPersonal['assessment']}}" aria-valuemin="0" aria-valuemax="100">{{$infoPersonal['assessment']}}%</div>
                            </div>
                        </div> --}}
                        
                    </div>
                </div>
            </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
            <div class="accordion" id="accordionExample">
                {{-- general --}}
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                     <i class="bi bi-person"></i> General
                    </button>
                  </h2>
                  <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="row profile">
                            <div class="col-lg-3 col-md-4 label ">Razon social</div>
                            <div class="col-lg-9 col-md-8">{{$infoPersonal['razonSocial']}}</div>
                        </div>
                        <div class="row profile">
                            <div class="col-lg-3 col-md-4 label ">Nombre comercial</div>
                            <div class="col-lg-9 col-md-8">{{$infoPersonal['nombreComercial']}}</div>
                        </div>
                        <div class="row profile">
                            <div class="col-lg-3 col-md-4 label ">Nombre fantasia</div>
                            <div class="col-lg-9 col-md-8">{{$infoPersonal['nombreComercial2']}}</div>
                        </div>
                        <div class="row profile">
                            <div class="col-lg-3 col-md-4 label ">Fecha inicio de actividades</div>
                            <div class="col-lg-9 col-md-8">{{$infoPersonal['fechaInicioActividades']}}</div>
                        </div>
                        <div class="row profile">
                            <div class="col-lg-3 col-md-4 label ">RUC</div>
                            <div class="col-lg-9 col-md-8">{{$infoPersonal['ruc']}}</div>
                        </div>
                        <div class="row profile">
                            <div class="col-lg-3 col-md-4 label ">Actividad economica</div>
                            <div class="col-lg-9 col-md-8">{{$infoPersonal['actividadEconomica']}}</div>
                        </div>
                        <div class="row profile">
                            <div class="col-lg-3 col-md-4 label ">Provincia</div>
                            <div class="col-lg-9 col-md-8">{{$infoPersonal['provincia']}}</div>
                        </div>
                        <div class="row profile">
                            <div class="col-lg-3 col-md-4 label ">Dirección</div>
                            <div class="col-lg-9 col-md-8">{{$infoPersonal['direccion']}}</div>
                        </div>
                        <div class="row profile">
                            <div class="col-lg-3 col-md-4 label ">Teléfono</div>
                            <div class="col-lg-9 col-md-8">{{$infoPersonal['telefono']}}</div>
                        </div>
                    </div>
                  </div>
                </div>
                {{-- contacto --}}
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                      <i class="bi bi-phone"></i> Contacto
                    </button>
                  </h2>
                  <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <div class="accordion-body" id="contacto-body">
                        <div class="spinner-border" role="status" style="width: 20px;height: 20px;"> <span class="visually-hidden">Loading...</span></div>
                    </div>
                  </div>
                </div>
                {{-- empleados --}}
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#empleados" aria-expanded="false" aria-controls="collapseThree">
                      <i class="bi bi-person-workspace"></i> Empleados
                    </button>
                  </h2>
                  <div id="empleados" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="row mb-3">
                            <div class="col-12">
                                <table class="table table-hover">
                                    <tr>
                                        <th>Cedula</th>
                                        <th>Nombre Completo</th>
                                        <th>Ocupación</th>
                                        <th>Sueldo</th>
                                        <th>Fecha de ingreso</th>
                                    </tr>
                                    @foreach ($payroll as $emp)
                                        <tr>
                                            <td>
                                                {{$emp->dni}}
                                                <form action="{{route('buscar')}}" method="POST" class="form-company" target="_blank">
                                                    @csrf
                                                    <input type="hidden" name="tipo" value="dni">
                                                    <input type="hidden" name="nombre" value="{{$emp->dni}}"/>
                                                    <button type="submit" class="btn btn-primary btn-company"><i class="bi bi-search"></i></button>
                                                </form>
                                            </td>
                                            <td>{{$emp->nombre}}</td>
                                            <td>{{$emp->ocupacion}}</td>
                                            <td>${{number_format($emp->sueldo,2,',','.')}}</td>
                                            <td>{{$emp->fechaIngreso}}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
                {{-- vehiculos --}}
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#ac-vehiculos" aria-expanded="true" aria-controls="collapseOne">
                     <i class="bi bi-car-front-fill"></i> @if(!Auth::user()->isDemo()) Vehiculos y @endif Propiedades
                    </button>
                  </h2>
                  <div id="ac-vehiculos" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body" id="vehiculos-body">
                        <div class="spinner-border" role="status" style="width: 20px;height: 20px;"> <span class="visually-hidden">Loading...</span></div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
      </div>
    </section>

    {{-- modal confirmar --}}
    <div class="modal fade" id="modalConfirm" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar contacto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="dni" class="input-dni">
                    <input type="hidden" name="contact" class="input-contact">
                    <input type="hidden" name="color" class="input-color">
                    <input type="hidden" class="input-id">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="gridRadios1" value="0">
                        <label class="form-check-label" for="gridRadios1"> <i class="bi bi-check-all text-success"></i> Verificado</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="gridRadios2" value="1">
                        <label class="form-check-label" for="gridRadios2"><i class="bi bi-check-all text-warning"></i> Por verificar</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="gridRadios3" value="2">
                        <label class="form-check-label" for="gridRadios3"> <i class="bi bi-check-all text-danger"></i> No verificado</label>
                    </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary btn-contact">Guardar</button>
            </div>
            </form>
            </div>
        </div>
    </div>

@endsection

@section('script')

    <script>

        let dni = "{{$infoPersonal['ruc']}}";
        let route_contact = "{{route('store.favorites')}}";

        let route_contacto = "{{route('company.contact')}}";
        let route_vehiculos = "{{route('buscar.vehiculos')}}";

        $( document ).ready(function(){
            cargarDatos(route_contacto,'#contacto-body');
            cargarDatos(route_vehiculos,'#vehiculos-body');
        });

        // enviar favoritos dni, contacto =  (tel,correo) ,estado
        $('.btn-contact-data').click(function(){
            let contact = $(this).data('contact');
            let dni = $(this).data('dni');
            $('.input-dni').val(dni);
            $('.input-contact').val(contact);
            $('.input-color').val($(this).data('color'));
            $('.input-id').val($(this).data('id'));
        });

        $('.btn-contact').click(function(){
            let dni = $('.input-dni').val();
            let contact = $('.input-contact').val();
            let status = $('input[name="status"]:checked').val();
            let color = $('.input-color').val();

            let icon = $('.input-id').val();

            $(this).prop( "disabled", true );

            let spin = $(this).append('<div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>'); 

            $.ajax({ 
                url: route_contact,
                data: {"dni": dni,"contact": contact,"status": status,"_token": "{{ csrf_token() }}"},
                type: 'post',
                success: function(result)
                {
                    console.log(result);
                    $('#modalConfirm').modal('toggle');
                    setTimeout(function() 
                    {
                        
                        icon.removeClass('text-'+color);
                        icon.addClass('text-'+result.color);
                        // $('#content-historico').html(result);
                        // $('#content-historico').show();
                        // $(".btn-historico").text('Consultar Historico');
                        // $(".btn-historico").prop( "disabled", false );
                    }, 800);
                }
            });
        });

        function cargarDatos(route,id){
            $.ajax
            ({ 
                url: route,
                data: {"nombre": dni,"_token": "{{ csrf_token() }}"},
                type: 'post',
                success: function(result)
                {
                    setTimeout(function() 
                    {
                        $(id).html(result);
                        $(id).fadeIn();
                        // $(".btn-historico").text('Consultar Historico');
                        // $(".btn-historico").prop( "disabled", false );
                    }, 800);
                }
            });
        }

    </script>
    
@endsection