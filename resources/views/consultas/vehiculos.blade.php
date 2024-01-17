<ul class="nav nav-tabs nav-tabs-bordered" id="borderedTab" role="tablist">
    @if(!Auth::user()->isDemo())
    <li class="nav-item" role="presentation">
    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#vehiculo-tab" type="button" role="tab" aria-controls="home" aria-selected="true">Vehículos</button>
    </li>
    @endif
    <li class="nav-item" role="presentation">
    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#propiedad-tab" type="button" role="tab" aria-controls="profile" aria-selected="false">Propiedades</button>
    </li>
</ul>
<div class="tab-content pt-2" id="borderedTabContent">
    @if(!Auth::user()->isDemo())
    <div class="tab-pane fade show active" id="vehiculo-tab" role="tabpanel" aria-labelledby="vehiculo-tab">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Vehículo</th>
                    <th>Detalles</th>
                    <th>Matriculación</th>
                    <th>Tasación</th>
                </tr>
            </thead>
            <tbody>
                @if(count($vehiculos))
                    @if(isset($vehiculos['vehicle']))
                        @foreach ($vehiculos['vehicle'] as $vehiculo)
                            @empty(!$vehiculo)
                                <tr>
                                    <td>
                                        <img alt="" class="img-fluid" src="{{asset($vehiculo['image'])}}" style="width: 70px">
                                        <a  class="">{{$vehiculo['model']}} - {{$vehiculo['year']}}</a><br>
                                        <span class="text-secondary">Motocicleta Marca: {{$vehiculo['brand']}} </span><br>
                                        <span class="text-secondary">PLACA: {{$vehiculo['carRegistration']}}</span>
                                    </td>
                                    <td></td>
                                    <td>
                                        <span class="text-secondary">Lugar: <b>{{$vehiculo['city']}}</b></span><br>
                                        <span class="text-secondary">Ult. Pago: <b>{{$vehiculo['dateOfLastCarRegistration']}}</b></span>
                                        {{-- <span class="text-secondary">Lugar: {{$vehiculo['city']}}</span> --}}
                                    </td>
                                    <td class="text-center"><b>${{$vehiculo['appraisalValue']}}</b></td>
                                </tr>
                            @endempty
                        @endforeach
                    @endif
                    @if(isset($vehiculos['ant']))
                        @foreach ($vehiculos['ant'] as $ant)
                            @empty(!$ant)
                                <tr>
                                    <td>
                                        <img alt="" class="img-fluid" src="{{asset($ant['image'])}}" style="width: 70px">
                                        <a  class="">{{$ant['model']}} - {{$ant['year']}}</a><br>
                                        <span class="text-secondary">Motocicleta Marca: {{$ant['brand']}} </span><br>
                                        <span class="text-secondary">PLACA: {{$ant['carRegistration']}}</span>
                                    </td>
                                    <td></td>
                                    <td>
                                        <span class="text-secondary">Lugar: <b>{{$ant['city']}}</b></span><br>
                                        <span class="text-secondary">Ult. Pago: <b>{{$ant['dateOfLastCarRegistration']}}</b></span>
                                        {{-- <span class="text-secondary">Lugar: {{$vehiculo['city']}}</span> --}}
                                    </td>
                                    <td class="text-center"><b>${{$ant['appraisalValue']}}</b></td>
                                </tr>
                            @endempty
                        @endforeach
                    @endif
                @endif
            </tbody>
        </table>
    </div>
    @endif
    <div class="tab-pane fade" id="propiedad-tab" role="tabpanel" aria-labelledby="propiedad-tab">
            <table class="table table-hover">
            <thead>
                <tr>
                    <th>N° de Predio</th>
                    <th>Parroquia</th>
                    <th>Area del terreno</th>
                    <th>Area de construcción</th>
                    <th>Dirección</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($propiedades as $propiedad)
                    <tr>
                        <td>{{$propiedad['PREDIO']}}</td>
                        <td>{{$propiedad['PARROQUIA']}}</td>
                        <td>{{$propiedad['AREA_TERRENO']}}</td>
                        <td>{{$propiedad['AREA_CONSTRUCCION']}}</td>
                        <td>{{$propiedad['CALLE'] . ' - ' . $propiedad['NUMERO']}}</td>
                    </tr>
                    {{-- <tr id="prop-{{$propiedad['estateNumber']}}" style="display: none;">
                        <td colspan="4">
                            <div class="row">
                                <div class="col-6">
                                    <span>Nombre: <b>{{$propiedad['name']}}</b></span><br>
                                    <span>Telefono: <b>{{$propiedad['phone']}}</b></span><br>
                                    <span>Zona: <b>{{$propiedad['zone']}}</b></span><br>
                                    <span>Barrio / Sector: <b>{{$propiedad['neighborhoodSector']}}</b></span><br>
                                </div>
                                <div class="col-6">
                                    <span>Tipo de zona: <b>{{$propiedad['zoneType']}}</b></span><br>
                                    <span>Calle principal: <b>{{$propiedad['mainStreet']}}</b></span><br>
                                    <span>Numero: <b>{{$propiedad['number']}}</b></span><br>
                                </div>
                            </div>
                        </td>
                    </tr> --}}
                @endforeach
            </tbody>
        </table>
    </div>
</div>