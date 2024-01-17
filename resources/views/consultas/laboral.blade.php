<div class="row mb-3">

    <ul class="nav nav-tabs nav-tabs-bordered" id="borderedTab" role="tablist">
        <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#bordered-home" type="button" role="tab" aria-controls="home" aria-selected="true">Información Laboral</button>
        </li>
        <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#bordered-profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Mis Empresas</button>
        </li>
        <li class="nav-item" role="presentation">
        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#bordered-contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Sociedades</button>
        </li>
        <li class="nav-item" role="presentation">
        <button class="nav-link" id="historico-tab" data-bs-toggle="tab" data-bs-target="#tab-historico" type="button" role="tab" aria-controls="historico" aria-selected="false">Historico</button>
        </li>
    </ul>
    <div class="tab-content pt-2" id="borderedTabContent">
        <div class="tab-pane fade show active" id="bordered-home" role="tabpanel" aria-labelledby="home-tab">
            <div class="row mt-3">
                @foreach ($laboral['jobInfoCompany'] as $item)
                    <div class="col-6 mb-3">
                        <label class="form-label">Cargo</label>
                        <input type="text" class="form-control" disabled value="{{$item['position']}}"/>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">Compañia</label>
                        
                            <form action="{{route('buscar')}}" method="POST" class="form-company" target="_blank">
                                @csrf
                                <input type="hidden" name="tipo" value="ruc">
                                <div class="input-group">
                                    <input type="text" name="nombre" class="form-control" readonly value="{{$item['ruc']}}"/>
                                    
                                    <button type="button" class="btn btn-primary btn-company">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </form>
                        
                    </div>
                    
                    {{-- <div class="col-6 mb-3">
                        <label class="form-label" >Salario</label>
                        <input type="text"  class="form-control" disabled value="{{$item['salary']}}"/>  
                    </div> --}}
                    <div class="col-6 mb-3">
                        <label class="form-label">Fecha de ingreso</label>
                        <input type="text" class="form-control" disabled value="{{$item['admissionDate']}}"/>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label" >Razon social</label>
                        <input type="text"  class="form-control" disabled value="{{$item['legalName']}}"/>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label" >Fecha de salida</label>
                        <input type="text"  class="form-control" disabled value="{{$item['fireDate']}}"/>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label" >Teléfono</label>
                        <input type="text"  class="form-control" disabled value="{{$item['phone']}}"/>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label" >Correo</label>
                        <input type="text"  class="form-control" disabled value="{{$item['email']}}"/>  
                    </div>
                    <div class="col-8 offset-md-2 mb-3">
                        <label class="form-label" >Dirección</label>
                        <input type="text"  class="form-control" disabled value="{{$item['address']}}"/>
                            
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="tab-pane fade" id="bordered-profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="row mt-3">
                @if ($laboral['ownInfoCompany'])
                    @foreach ($laboral['ownInfoCompany'] as $item)
                        <div class="col-6 mb-3">
                            <label class="form-label" >Ruc de la Compañia</label>
                            <div class="input-group">
                                <input type="text"  class="form-control" disabled value="{{$item['ruc']}}"/>
                                
                                <button type="button" class="btn btn-primary">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label" >Fecha de inicio de actividades de la compañia</label>
                            <input type="text"  class="form-control" disabled value="{{$item['activitiesStartDate']}}"/>  
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label" >Dirección de la compañia</label>
                            <input type="text"  class="form-control" disabled value="{{$item['address']}}"/>  
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label" >Fecha suspención de actividades de la compañia</label>
                            <input type="text"  class="form-control" disabled value="{{$item['suspensionRequestDate']}}"/>  
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label" >Razon social de la compañia</label>
                            <input type="text"  class="form-control" disabled value="{{$item['legalName']}}"/>  
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label" >Fecha de reinicio de actividades de la compañia</label>
                            <input type="text"  class="form-control" disabled value="{{$item['activitiesRestartDate']}}"/>  
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label" >Razon social de la compañia 2</label>
                            <input type="text"  class="form-control" disabled value="{{$item['businessName']}}"/>  
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label" >Telefono de la compañia</label>
                            <input type="text"  class="form-control" disabled value="{{$item['phone']}}"/>  
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label" >Correo de la compañia</label>
                            <input type="text"  class="form-control" disabled value="{{$item['email']}}"/>  
                        </div>
                            
                    @endforeach
                @endif
                </div>
        </div>
        <div class="tab-pane fade" id="bordered-contact" role="tabpanel" aria-labelledby="contact-tab">
            <div class="row mt-3">
                    @foreach ($laboral['societyInfoCompany'] as $item)
                    <div class="col-6 mb-3">
                        <label class="form-label" >Ruc de la Compañia</label>
                        <div class="input-group">
                            <input type="text"  class="form-control" disabled value="{{$item['ruc']}}"/>
                            
                            <button type="button" class="btn btn-primary">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label" >Fecha de inicio de actividades de la compañia</label>
                        <input type="text"  class="form-control" disabled value="{{$item['activitiesStartDate']}}"/>  
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label" >Dirección de la compañia</label>
                        <input type="text"  class="form-control" disabled value="{{$item['address']}}"/>  
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label" >Fecha suspención de actividades de la compañia</label>
                        <input type="text"  class="form-control" disabled value="{{$item['suspensionRequestDate']}}"/>  
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label" >Razon social de la compañia</label>
                        <input type="text"  class="form-control" disabled value="{{$item['legalName']}}"/>  
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label" >Fecha de reinicio de actividades de la compañia</label>
                        <input type="text"  class="form-control" disabled value="{{$item['activitiesRestartDate']}}"/>  
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label" >Razon social de la compañia 2</label>
                        <input type="text"  class="form-control" disabled value="{{$item['businessName']}}"/>  
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label" >Cargo</label>
                        <input type="text"  class="form-control" disabled value="{{$item['position']}}"/>  
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label" >Telefono de la compañia</label>
                        <input type="text"  class="form-control" disabled value="{{$item['phone']}}"/>  
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label" >Correo de la compañia</label>
                        <input type="text"  class="form-control" disabled value="{{$item['email']}}"/>  
                    </div>
                    <hr>
                @endforeach
            </div>
        </div>
        <div class="tab-pane fade" id="tab-historico" role="tabpanel" aria-labelledby="historico-tab">
            <button type="button" class="btn btn-primary btn-historico">Consultar Historico</button>
            <div id="content-historico" style="display:none;">
                
            </div>
        </div>
        
    </div>
</div>