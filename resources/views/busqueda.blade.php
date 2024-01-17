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
</style>
    
@endsection

@section('content')

    <section class="section dashboard">
      <div class="row">
        <div class="col-12">
            @include('message.index')
        </div>
        <div class="col-12">
            <div class="card" style="height: 80vh;">
                <div class="card-body">
                    <form action="{{route('buscar')}}" onkeydown="return event.key != 'Enter';" style="padding: 120px" method="POST" autocomplete="off" id="form-buscar">
                        @csrf
                        <h2 class="text-center">Busqueda</h2>
                        <input type="text" name="nombre" class="form-control input-nombre" style="padding: 20px;font-size: 20px;" required>
                        <div class="invalid-feedback"></div>
                        <fieldset class="row mb-3" style="margin-top: 10px">
                            <legend class="col-form-label col-sm-2 pt-0">Buscar por:</legend>
                            <div class="col-sm-10">
                                <div class="form-check"> 
                                    <input class="form-check-input" type="radio" name="tipo" id="tipo1" value="dni" checked=""> 
                                    <label class="form-check-label" for="tipo1"> Cedula </label>
                                </div>
                                <div class="form-check"> 
                                    <input class="form-check-input" type="radio" name="tipo" id="tipo2" value="nombre"> 
                                    <label class="form-check-label" for="tipo2"> Nombre </label>
                                </div>
                                <div class="form-check"> 
                                    <input class="form-check-input" type="radio" name="tipo" id="tipo3" value="telefono"> 
                                    <label class="form-check-label" for="tipo3"> Teléfono </label>
                                </div>
                                <div class="form-check"> 
                                    <input class="form-check-input" type="radio" name="tipo" id="tipo4" value="placa"> 
                                    <label class="form-check-label" for="tipo4"> Placa </label>
                                </div>
                                <div class="form-check"> 
                                    <input class="form-check-input" type="radio" name="tipo" id="tipo5" value="ruc"> 
                                    <label class="form-check-label" for="tipo5"> RUC </label>
                                </div>
                            </div>
                        </fieldset>
                        <div class="text-center">
                            <button type="button" class="btn btn-primary btn-buscar btn-lg"> <i class="bi bi-search"></i> Buscar</button>
                        </div>

                        
                    </form>
                </div>
            </div>
        </div>
      </div>
    </section>

@endsection

@section('script')

<script>
    // $(document).ready(function () {

    //     $("#form-buscar").submit(function (e) {

    //         //stop submitting the form to see the disabled button effect
            

    //         //disable the submit button
            
    //         $(this).children('button[type=submit]').attr("disabled", 'disabled');
    //         e.preventDefault();
    //         return false;

    //     });
    // });

    $(".btn-buscar").click(function(e){
        e.preventDefault();

        let valida = false;
        let tipo = $("input[type=radio]:checked").val();
        let nombre = $(".input-nombre").val();
         
        console.log(tipo);
        
        if(tipo == 'dni'){
            valida = validarCI(nombre);
            $(".invalid-feedback").text('Ingrese un número de cédula valido');
        } else if(tipo == 'nombre'){
            valida = validateName(nombre);
            $(".invalid-feedback").text('Ingrese un nombre valido');
        } else if (tipo == 'telefono'){
            valida = validarLargo(nombre,5);
            $(".invalid-feedback").text('Ingrese un teléfono mayor a 5 digitos');
        } else if (tipo == 'ruc'){
            valida = validarLargo(nombre,12);
            $(".invalid-feedback").text('debe ser de 13 digitos');
        } else if (tipo == 'placa'){
            valida = validarLargo(nombre,5);
            $(".invalid-feedback").text('Ingrese una Placa mayor a 5 digitos');
        }

        if(valida){
            $(".input-nombre").removeClass('is-invalid');
            $(".input-nombre").addClass('is-valid');
            $(this).attr("disabled", true);
            $(this).append(' <div class="spinner-border" role="status" style="width: 20px;height: 20px;"> <span class="visually-hidden">Loading...</span></div>');

            $('#form-buscar').submit();
        } else{
            $(".input-nombre").removeClass('is-valid');
            $(".input-nombre").addClass('is-invalid');
        }
        
    });

    function validarCI(cedula)
    {
        if (cedula.length == 10) {

            let digito_region = parseInt(cedula.substring(0, 2));

            if (digito_region >= 1 && digito_region <= 24) {

                let ultimo_digito = parseInt(cedula.substring(9, 10));

                let pares = parseInt(cedula.substring(1, 2)) + parseInt(cedula.substring(3, 4)) + parseInt(cedula.substring(5, 6)) + parseInt(cedula.substring(7, 8));

                let numero1 = parseInt(cedula.substring(0, 1));
                numero1 = (numero1 * 2);
                if (numero1 > 9) { numero1 = (numero1 - 9); }

                let numero3 = parseInt(cedula.substring(2, 3));
                numero3 = (numero3 * 2);
                if (numero3 > 9) { numero3 = (numero3 - 9); }

                let numero5 = parseInt(cedula.substring(4, 5));
                numero5 = (numero5 * 2);
                if (numero5 > 9) { numero5 = (numero5 - 9); }

                let numero7 = parseInt(cedula.substring(6, 7));
                numero7 = (numero7 * 2);
                if (numero7 > 9) { numero7 = (numero7 - 9); }

                let numero9 = parseInt(cedula.substring(8, 9));
                numero9 = (numero9 * 2);
                if (numero9 > 9) { numero9 = (numero9 - 9); }

                let impares = numero1 + numero3 + numero5 + numero7 + numero9;

                let suma_total = (pares + impares);

                let primer_digito_suma = String(suma_total).substring(0, 1);

                let decena = (parseInt(primer_digito_suma) + 1) * 10;

                let digito_validador = decena - suma_total;

                if (digito_validador == 10)
                    digito_validador = 0;

                if (digito_validador == ultimo_digito) {
                    return true;
                } else {
                    return false;
                }

            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    function validateName(name) {
        const re = /^[A-Za-zñÑ ]+$/;
        if (re.test(name))
        return true;
        else
        return false;
    }
    function validarLargo(data, leng) {
        if (data.length < leng) {
        // this.alertType = 'light';
        // this.successMessage = msj;
        // this.focusSearch();
            return false;
        }
        return true;
    }
</script>
    
@endsection
