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

    <?php
        $isDemo = Auth::user()->isDemo();
    ?>

    <section class="section dashboard">
      <div class="row">
        <div class="col-12">
            @include('message.index')
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body profile-card pt-4"> 
                    <div class="row">
                        <div class="col-lg-2">
                            <img src="{{asset($img_profile)}}" alt="Profile" class="rounded-circle img-fluid">
                        </div>
                        <div class="col-lg-10">
                            <div class="profile-info">
                                <h2>{{$infoPersonal['fullname']}} ({{$infoPersonal['age']}}) <i class="bi bi-patch-check-fill text-{{$infoPersonal['dateOfDeath'] ? 'secondary' : 'success'}}"></i></h2>
                                <span class="mr-1"><i class="bi bi-person"></i> {{$infoPersonal['gender']}}</span>
                                <span class="mr-1"><i class="bi bi-person-vcard-fill"></i> {{$infoPersonal['dni']}}</span>
                                <span class="mr-1"><i class="bi bi-flag"></i> {{$infoPersonal['citizenship']}}</span>
                                @if ($infoPersonal['profession'])
                                    <span class="mr-1"><i class="bi bi-person-workspace"></i> {{$infoPersonal['profession']}}</span>
                                @endif
                                @if ($infoPersonal['studyLevel'])
                                    <span class="mr-1"><i class="bi bi-person-workspace"></i> {{$infoPersonal['studyLevel']}}</span>
                                @endif
                                <div class="mt-3">
                                    @if ($infoPersonal['assessment'])
                                        <p>Este cliente tiene <b>{{$infoPersonal['assessment'] ? $infoPersonal['assessment'] : 1}}% de evaluación crediticia.</b></p>
                                        <p>Calificacion {{ $infoPersonal['qualification'] ? $infoPersonal['qualification'] : "Z" }}</p>
                                    @else
                                        <p>Este cliente no tiene evaluación</p>
                                    @endif
                                </div>
                                
                            </div>
                        </div>
                        <div class="offset-lg-2 col-lg-8 col-12">
                            <b>Valoración:</b>
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="{{$infoPersonal['assessment'] ? $infoPersonal['assessment'] : 1}}" aria-valuemin="0" aria-valuemax="100">{{ $infoPersonal['assessment'] ? $infoPersonal['assessment'] : 1}}%</div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <?php
            $sal = $salario ?  $salario['SALARIO'] : 0;
            $contCreditos = 0;
            $contAutos = $countV ? $countV['total'] : 0;

            // foreach ($laboral['jobInfoCompany'] as $value) {
            //     $salario += $value['salary'];
            // }

            foreach ($infoPersonal['credits'] as $value) {
                $contCreditos++;
            }

            // foreach ($vehiculos as $value) {
            //     $contAutos++;
            // }
        
        ?>
        <div class="col-lg-3">
            <div class="card info-card sales-card">
                <div class="card-body">
                    <h5 class="card-title">Posible sueldo:</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon d-flex align-items-center justify-content-center"> <i class="bi bi-currency-dollar"></i></div>
                        <div class="ps-3"><h6 id="salario">{{$sal}}</h6></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card info-card sales-card">
                <div class="card-body">
                    <h5 class="card-title">Creditos y tarjetas:</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon d-flex align-items-center justify-content-center"> <i class="bi bi-bank"></i></div>
                        <div class="ps-3"><h6>{{$contCreditos}}</h6></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card info-card sales-card">
                <div class="card-body">
                    <h5 class="card-title">Estado Civil:</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon d-flex align-items-center justify-content-center"> <i class="bi bi-person-badge"></i></div>
                        <div class="ps-3"><h6>{{$infoPersonal['civilStatus']}}</h6></div>
                    </div>
                </div>
            </div>
        </div>
        @if(!$isDemo)
        <div class="col-lg-3">
            <div class="card info-card sales-card">
                <div class="card-body">
                    <h5 class="card-title">Vehiculos:</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon d-flex align-items-center justify-content-center"> <i class="bi bi-car-front"></i></div>
                        <div class="ps-3"><h6>{{$contAutos}}</h6></div>
                    </div>
                </div>
            </div>
        </div>
        @endif
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
                            <div class="col-lg-3 col-md-4 label ">Nombre Completo</div>
                            <div class="col-lg-9 col-md-8">{{$infoPersonal['fullname']}}</div>
                        </div>
                        <div class="row profile">
                            <div class="col-lg-3 col-md-4 label ">Fecha de Nacimiento</div>
                            <div class="col-lg-9 col-md-8">{{$infoPersonal['dateOfBirth']}}</div>
                        </div>
                        <div class="row profile">
                            <div class="col-lg-3 col-md-4 label ">Cedula</div>
                            <div class="col-lg-9 col-md-8">{{$infoPersonal['dni']}}</div>
                        </div>
                        <div class="row profile">
                            <div class="col-lg-3 col-md-4 label ">Genero</div>
                            <div class="col-lg-9 col-md-8">{{$infoPersonal['gender']}}</div>
                        </div>
                        <div class="row profile">
                            <div class="col-lg-3 col-md-4 label ">Descripción</div>
                            <div class="col-lg-9 col-md-8">{{$infoPersonal['citizenship']}}</div>
                        </div>
                        <div class="row profile">
                            <div class="col-lg-3 col-md-4 label ">Estado Civil</div>
                            <div class="col-lg-9 col-md-8">{{$infoPersonal['civilStatus']}}</div>
                        </div>
                        <div class="row profile">
                            <div class="col-lg-3 col-md-4 label ">Fecha de matrimonio</div>
                            <div class="col-lg-9 col-md-8">{{$infoPersonal['marriageDate']}}</div>
                        </div>
                        <div class="row profile">
                            <div class="col-lg-3 col-md-4 label ">Dirección</div>
                            <div class="col-lg-9 col-md-8">{{$infoPersonal['address']}}</div>
                        </div>
                        <div class="row profile">
                            <div class="col-lg-3 col-md-4 label ">Provincia</div>
                            <div class="col-lg-9 col-md-8">{{$infoPersonal['placeOfBirth']}}</div>
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
                
                @if(!$isDemo)
                {{-- genoma --}}
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                      <i class="bi bi-people-fill"></i> Genoma
                    </button>
                  </h2>
                  <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="row mb-3">
                            <label  class="col-sm-1 col-form-label">Padre</label>
                            <div class="col-sm-5"> 
                                <div class="input-group">
                                    <input type="text" class="form-control disabled" disabled value="{{$infoPersonal['familyName']['dad']['nombre']}}">
                                    <div class="input-group-append">
                                        <form action="{{route('buscar.familia')}}" method="POST" target="_blank">
                                            @csrf
                                            <input type="hidden" name="name" value="{{$infoPersonal['familyName']['dad']['nombre']}}">
                                            <button class="btn btn-outline-secondary btn-familia" type="submit"><i class="bi bi-search"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <label  class="col-sm-1 col-form-label">Madre</label>
                            <div class="col-sm-5"> 
                                <div class="input-group">
                                    <input type="text" class="form-control disabled" disabled value="{{$infoPersonal['familyName']['mom']['nombre']}}">
                                    <div class="input-group-append">
                                        <form action="{{route('buscar.familia')}}" method="POST" target="_blank">
                                            @csrf
                                            <input type="hidden" name="name" value="{{$infoPersonal['familyName']['mom']['nombre']}}">
                                            <button class="btn btn-outline-secondary btn-familia" type="submit"><i class="bi bi-search"></i></button>
                                         </form>
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                        <button type="button" class="btn btn-primary btn-arbol col-12">Ampliar árbol genealógico</button>

                        <div class="row">
                            <div class="col-12 arbol-content" style="display: none;">

                            </div>
                        </div>

                    </div>
                  </div>
                </div>
                
                {{-- profesional --}}
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#profesional" aria-expanded="false" aria-controls="collapseThree">
                      <i class="bi bi-person-workspace"></i> Profesional
                    </button>
                  </h2>
                  <div id="profesional" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                    <div class="accordion-body" id="laboral-body">
                        <div class="spinner-border" role="status" style="width: 20px;height: 20px;"> <span class="visually-hidden">Loading...</span></div>
                    </div>
                  </div>
                </div>
                @endif
                {{-- finanzas --}}
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#ac-finanzas" aria-expanded="true" aria-controls="collapseOne">
                     <i class="bi bi-bank"></i> Finanzas
                    </button>
                  </h2>
                  <div id="ac-finanzas" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Banco</th>
                                    <th>Valoración</th>
                                    <th>Tipo</th>
                                    <th>Credito</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($infoPersonal['credits'] as $credit)
                                <tr>
                                    <td>{{$credit['banck']}}</td>
                                    <td><span class="badge bg-light text-dark"> {{$credit['CALIFICACI']}}</span></td>
                                    <td>{{$credit['type']}}</td>
                                    <td>{{$credit['cedit']}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                  </div>
                </div>
                {{-- vehiculos --}}
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#ac-vehiculos" aria-expanded="true" aria-controls="collapseOne">
                     <i class="bi bi-car-front-fill"></i>@if(!$isDemo) Vehiculos y @endif Propiedades
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

        let bar ="{{$infoPersonal['assessment']}}";
        let dni = "{{$infoPersonal['dni']}}";
        let route_historico = "{{route('consulta.laboral-historico')}}";

        let route_laboral = "{{route('buscar.laboral')}}";
        let route_contacto = "{{route('buscar.contacto')}}";
        let route_vehiculos = "{{route('buscar.vehiculos')}}";

        let route_arbol = "{{route('consulta.arbol')}}";
        let route_contact = "{{route('store.favorites')}}";

        document.addEventListener("DOMContentLoaded", () => {
            cargarDatos(route_contacto,'#contacto-body');
            cargarDatos(route_laboral,'#laboral-body');
            cargarDatos(route_vehiculos,'#vehiculos-body');
        });
  
        // Set the width to animate the progress bar
        // Along with time duration in milliseconds
        $(".progress-bar").animate({
                width: bar+"%",
        }, 2000);

        $(".btn-historico").click(function(){
            $(this).prop( "disabled", true );
            $(this).append('<div class="spinner-border" role="status" style="width: 20px;height: 20px;"> <span class="visually-hidden">Loading...</span></div>');
        });

        // $(".btn-familia").click(function(){
        //     // $(this).prop( "disabled", true );
        //     $(this).html('<div class="spinner-border" role="status" style="width: 20px;height: 20px;"> <span class="visually-hidden">Loading...</span></div>');
        // });

        $('.btn-company').click(function(e){
            e.preventDefault();
            $(this).attr("disabled", true);
            $(this).html(' <div class="spinner-border" role="status" style="width: 20px;height: 20px;"> <span class="visually-hidden">Loading...</span></div>');

            // console.log($(this).parent().closest('form'));
            $(this).parent().closest('form').submit();
        });


        $('.btn-historico').click(function(){

            $.ajax
            ({ 
                url: route_historico,
                data: {"dni": dni,"_token": "{{ csrf_token() }}"},
                type: 'post',
                success: function(result)
                {
                    setTimeout(function() 
                    {
                        $('#content-historico').html(result);
                        $('#content-historico').show();
                        $(".btn-historico").text('Consultar Historico');
                        $(".btn-historico").prop( "disabled", false );
                    }, 800);
                }
            });
        });

        $('.btn-arbol').click(function(){

            $(this).prop( "disabled", true );
            $(this).append('<div class="spinner-border" role="status" style="width: 20px;height: 20px;"> <span class="visually-hidden">Loading...</span></div>');

            $.ajax
            ({ 
                url: route_arbol,
                data: {"nombre": dni,"_token": "{{ csrf_token() }}"},
                type: 'post',
                success: function(result)
                {
                    setTimeout(function() 
                    {
                        console.log(result);
                        $('.arbol-content').html(result).fadeIn();
                        $(".btn-arbol").text('Ampliar árbol genealógico');
                        $(".btn-arbol").prop( "disabled", false );
                    }, 800);
                }
            });
        });

        // enviar favoritos dni, contacto =  (tel,correo) ,estado
        $(document).on("click",'.btn-contact-data',function(){
            let contact = $(this).data('contact');
            let dni = $(this).data('dni');
            $('.input-dni').val(dni);
            $('.input-contact').val(contact);
            $('.input-color').val($(this).data('color'));
            $('.input-id').val($(this).data('id'));
        });

        $(document).on("click",'.btn-contact',function(){
            let dni = $('.input-dni').val();
            let contact = $('.input-contact').val();
            let status = $('input[name="status"]:checked').val();
            let color = $('.input-color').val();

            let icon = $('#'+ $('.input-id').val());

            $(this).prop( "disabled", true );

            let spin = $(this).append('<div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>'); 

            $.ajax({ 
                url: route_contact,
                data: {"dni": dni,"contact": contact,"status": status,"_token": "{{ csrf_token() }}"},
                type: 'post',
                success: function(result)
                {
                    $('#modalConfirm').modal('toggle');
                    setTimeout(function() 
                    {
                        
                        icon.removeClass('text-'+color);
                        icon.addClass('text-'+result.color);
                        // $('#content-historico').html(result);
                        // $('#content-historico').show();
                        $('.btn-contact').text('Guardar');
                        $('.btn-contact').prop( "disabled", false );
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