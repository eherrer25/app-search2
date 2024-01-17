 
@if ($json['jobInfoCompany'])
<div class="row mt-3">
    <h2>Información laboral</h2>
    @foreach ($json['jobInfoCompany'] as $item)
        <div class="col-6 mb-3">
            <label class="form-label" for="form12">Cargo</label>
            <input type="text" id="form12" class="form-control" disabled value="{{$item['position']}}"/>
        </div>
        <div class="col-6 mb-3">
            <label class="form-label" for="form12">Compañia</label>
            <div class="input-group">
                <input type="text" id="form12" class="form-control" disabled value="{{$item['ruc']}}"/>
                
                <button type="button" class="btn btn-primary">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </div>
        
        <div class="col-6 mb-3">
            <label class="form-label" for="form12">Salario</label>
            <input type="text" id="form12" class="form-control" disabled value="{{$item['salary']}}"/>  
        </div>
        <div class="col-6 mb-3">
            <label class="form-label" for="form12">Fecha de ingreso</label>
            <input type="text" id="form12" class="form-control" disabled value="{{$item['admissionDate']}}"/>
        </div>
        <div class="col-6 mb-3">
            <label class="form-label" for="form12">Razon social</label>
            <input type="text" id="form12" class="form-control" disabled value="{{$item['legalName']}}"/>
        </div>
        <div class="col-6 mb-3">
            <label class="form-label" for="form12">Fecha de salida</label>
            <input type="text" id="form12" class="form-control" disabled value="{{$item['fireDate']}}"/>
        </div>
        <div class="col-6 mb-3">
            <label class="form-label" for="form12">Teléfono</label>
            <input type="text" id="form12" class="form-control" disabled value="{{$item['phone']}}"/>
        </div>
        <div class="col-6 mb-3">
            <label class="form-label" for="form12">Correo</label>
            <input type="text" id="form12" class="form-control" disabled value="{{$item['email']}}"/>  
        </div>
        <div class="col-8 offset-md-2 mb-3">
            <label class="form-label" for="form12">Dirección</label>
            <input type="text" id="form12" class="form-control" disabled value="{{$item['address']}}"/>
                
        </div>
    @endforeach
    <div class="col-12">
        <hr>
    </div>
</div>
@endif
@if ($json['ownInfoCompany'])
<div class="row mt-3">
    <h2>Mis empresas</h2>
    @foreach ($json['ownInfoCompany'] as $item)
        <div class="col-6 mb-3">
            <label class="form-label" for="form12">Ruc de la Compañia</label>
            <div class="input-group">
                <input type="text" id="form12" class="form-control" disabled value="{{$item['ruc']}}"/>
                
                <button type="button" class="btn btn-primary">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </div>
        <div class="col-6 mb-3">
            <label class="form-label" for="form12">Fecha de inicio de actividades de la compañia</label>
            <input type="text" id="form12" class="form-control" disabled value="{{$item['activitiesStartDate']}}"/>  
        </div>
        <div class="col-6 mb-3">
            <label class="form-label" for="form12">Dirección de la compañia</label>
            <input type="text" id="form12" class="form-control" disabled value="{{$item['address']}}"/>  
        </div>
        <div class="col-6 mb-3">
            <label class="form-label" for="form12">Fecha suspención de actividades de la compañia</label>
            <input type="text" id="form12" class="form-control" disabled value="{{$item['suspensionRequestDate']}}"/>  
        </div>
        <div class="col-6 mb-3">
            <label class="form-label" for="form12">Razon social de la compañia</label>
            <input type="text" id="form12" class="form-control" disabled value="{{$item['legalName']}}"/>  
        </div>
        <div class="col-6 mb-3">
            <label class="form-label" for="form12">Fecha de reinicio de actividades de la compañia</label>
            <input type="text" id="form12" class="form-control" disabled value="{{$item['activitiesRestartDate']}}"/>  
        </div>
        <div class="col-6 mb-3">
            <label class="form-label" for="form12">Razon social de la compañia 2</label>
            <input type="text" id="form12" class="form-control" disabled value="{{$item['businessName']}}"/>  
        </div>
        <div class="col-6 mb-3">
            <label class="form-label" for="form12">Telefono de la compañia</label>
            <input type="text" id="form12" class="form-control" disabled value="{{$item['phone']}}"/>  
        </div>
        <div class="col-6 mb-3">
            <label class="form-label" for="form12">Correo de la compañia</label>
            <input type="text" id="form12" class="form-control" disabled value="{{$item['email']}}"/>  
        </div>
            
    @endforeach
    <div class="col-12">
        <hr>
    </div>
</div>
@endif
 @if ($json['societyInfoCompany'])
 <div class="row mt-3">
    <h2>Sociedades</h2>
    @foreach ($json['societyInfoCompany'] as $item)
        <div class="col-6 mb-3">
            <label class="form-label" for="form12">Ruc de la Compañia</label>
            <div class="input-group">
                <input type="text" id="form12" class="form-control" disabled value="{{$item['ruc']}}"/>
                
                <button type="button" class="btn btn-primary">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </div>
        <div class="col-6 mb-3">
            <label class="form-label" for="form12">Fecha de inicio de actividades de la compañia</label>
            <input type="text" id="form12" class="form-control" disabled value="{{$item['activitiesStartDate']}}"/>  
        </div>
        <div class="col-6 mb-3">
            <label class="form-label" for="form12">Dirección de la compañia</label>
            <input type="text" id="form12" class="form-control" disabled value="{{$item['address']}}"/>  
        </div>
        <div class="col-6 mb-3">
            <label class="form-label" for="form12">Fecha suspención de actividades de la compañia</label>
            <input type="text" id="form12" class="form-control" disabled value="{{$item['suspensionRequestDate']}}"/>  
        </div>
        <div class="col-6 mb-3">
            <label class="form-label" for="form12">Razon social de la compañia</label>
            <input type="text" id="form12" class="form-control" disabled value="{{$item['legalName']}}"/>  
        </div>
        <div class="col-6 mb-3">
            <label class="form-label" for="form12">Fecha de reinicio de actividades de la compañia</label>
            <input type="text" id="form12" class="form-control" disabled value="{{$item['activitiesRestartDate']}}"/>  
        </div>
        <div class="col-6 mb-3">
            <label class="form-label" for="form12">Razon social de la compañia 2</label>
            <input type="text" id="form12" class="form-control" disabled value="{{$item['businessName']}}"/>  
        </div>
        <div class="col-6 mb-3">
            <label class="form-label" for="form12">Cargo</label>
            <input type="text" id="form12" class="form-control" disabled value="{{$item['position']}}"/>  
        </div>
        <div class="col-6 mb-3">
            <label class="form-label" for="form12">Telefono de la compañia</label>
            <input type="text" id="form12" class="form-control" disabled value="{{$item['phone']}}"/>  
        </div>
        <div class="col-6 mb-3">
            <label class="form-label" for="form12">Correo de la compañia</label>
            <input type="text" id="form12" class="form-control" disabled value="{{$item['email']}}"/>  
        </div>
    @endforeach
</div>
@endif