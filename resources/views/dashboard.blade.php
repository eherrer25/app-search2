@extends('layouts.main')

@section('css')
<style>
    .links-center nav ul{
        justify-content: center!important;
    }
</style>
    
@endsection

@section('content')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        {{-- <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Prueba</a></li>
                <li class="breadcrumb-item active">prueba</li>
            </ol>
        </nav> --}}
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">

                    <!-- Sales Card -->
                    {{-- @role('Administrador|Empresa')
                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card sales-card">

                                <div class="card-body">
                                    <h5 class="card-title">Total <span>| usuarios</span></h5>

                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-people"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{ $users }}</h6>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endrole --}}
                        <!-- End Sales Card -->
                        <div class="col-12">
                            <div class="card infocard">
                                <div class="card-header">
                                    Últimas busquedas
                                </div>
                                <div class="card-body mt-3">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Cedula/RUC</th>
                                            <th>Nombre</th>
                                            <th>Fecha</th>
                                        </tr>
                                        @foreach ($reportes as $r)
                                            <tr>
                                                <td>{{ $r->dni }}</td>
                                                <td>{{ $r->description }}</td>
                                                <td>{{ $r->created_at->format('d/m/Y H:i') }}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                    {{-- <div class="links-center">
                                        {{ $reportes->links() }}
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    
                    

                </div>
            </div><!-- End Left side columns -->

        </div>
    </section>
@endsection

@section('script')
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
@endsection
