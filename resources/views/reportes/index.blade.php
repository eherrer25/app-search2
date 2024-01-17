@extends('layouts.main')

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link rel="stylesheet" href="{{asset('css/loading.css')}}">
<style>
    .links-center nav ul{
        justify-content: center!important;
    }
    .text-right{
        text-align: right;
    }
</style>
    
@endsection
@section('content')
    <div class="loading">Loading&#8230;</div>
    <div class="content">
        <div class="pagetitle">
            <h1>Reportes</h1>
            {{-- <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Prueba</a></li>
                    <li class="breadcrumb-item active">prueba</li>
                </ol>
            </nav> --}}
        </div>

        <?php
            $date = Carbon\Carbon::now()->startOfMonth()->format('d/m/Y') .' - '.Carbon\Carbon::now()->format('d/m/Y');
        // dd($date);
        ?>

        <div class="row">
            <div class="col-3 contact">
                <div class="info-box card">
                    <span><h3>Total:</h3>{{$reportes->total()}}</span>
                </div>
            </div>
        </div>

        <section class="section dashboard">
            <div class="card">
                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-10">
                            <form action="{{request()->is('admin/reportes') ? route('reporte.index') : route('reporte.api')}}" method="GET" id="form-filter" class="row mt-3">
                                @role('Administrador')
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="">Usuarios</label>
                                            <select name="user" id="" class="form-control select-user">
                                                <option value="todos" {{$data['user'] == null ? 'selected' : ''}}>Todos</option>
                                                @foreach ($usuarios as $item)
                                                    <option value="{{$item->id}}" {{$data['user'] == $item->id ? 'selected' : ''}}>{{$item->name}}</option>
                                                @endforeach
                                                
                                            </select>
                                        </div>
                                    </div>
                                @endrole
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="">Rango de fechas</label>
                                            <input type="text" name="fecha" class="form-control daterange" value="{{$fecha ? $fecha : $date}}" >
                                        </div>
                                    </div>
                                
                            </form>

                        </div>
                        
                        <div class="col-2 text-right">
                            @if(count($data) == 0)
                                <a href="{{request()->is('admin/reportes') ? route('reporte.index').'?export=excel' : route('reporte.api').'?export=excel'}}" class="btn btn-success btn-excel"><i class="bi bi-file-earmark-excel"></i></a>
                            @else
                                <a href="{{request()->fullUrlWithQuery(['export' => 'excel'])}}" class="btn btn-success btn-excel"><i class="bi bi-file-earmark-excel"></i></a>
                            @endif
                            
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-12">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Usuario</th>
                                        <th>DNI</th>
                                        <th>Descripción</th>
                                        <th>Fecha</th>
                                    </tr>
                                    
                                </thead>
                                <tbody>
                                    @foreach ($reportes as $item)
                                        <tr>
                                            <td>{{$item->user->name}}</td>
                                            <td>{{$item->dni}}</td>
                                            <td>{{$item->description}}</td>
                                            <td>{{$item->created_at->format('d-m-Y H:i')}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 link-pag links-center">
                            {{ $reportes->appends($data)->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')

    {{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> --}}
    
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
        $(window).on('load', function() {
            setTimeout(function() {
                $(".loading").css("display", "none").fadeOut();
            }, 300);
        });
        $('.daterange').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        });

        $('.daterange').on('apply.daterangepicker', function(ev, picker) {
            $(".loading").css("display", "block").fadeIn();
            $('#form-filter').submit();
        });

        $('.select-user').on('change', function(ev, picker) {
            $(".loading").css("display", "block").fadeIn();
            $('#form-filter').submit();
        });

        $(document).on('click','.btn-excel',function(e){
            $(".loading").css("display", "block").fadeIn();

            setTimeout(function() {
                $(".loading").css("display", "none").fadeOut();
            }, 3000);
        });


    </script>
@endsection