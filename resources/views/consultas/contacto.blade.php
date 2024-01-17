@if(isset($contacto['address']))
<table class="table table-hover table-primary">
    <tr>
        <th>Direcciones</th>
        <th>Provincia</th>
        <th>Ciudad</th>
    </tr>
    @foreach ($contacto['address'] as $item)
        <?php
            $color = 'secondary';
            $status = App\Models\Contacto::validarContacto($item['address'],$dni);
            if($status == '0'){
                $color = 'success';
            }elseif($status == '1'){
                $color = 'warning';
            }elseif($status == '2'){
                $color = 'danger';
            }
        ?>
        <tr>
            <td>{{$item['address']}} <a href="" class="btn-contact-data" data-bs-toggle="modal" data-bs-target="#modalConfirm" data-contact="{{$item['address']}}" data-dni="{{$dni}}" data-color="{{$color}}"  data-id="a-{{$loop->index}}"><i id="a-{{$loop->index}}" class="bi bi-check-all text-{{$color}}"></i></a></td>
            <td>{{$item['province']}}</td>
            <td>{{$item['city']}}</td>
        </tr>
    @endforeach
    
</table>
@endif
@if(isset($contacto['emails']))
<table class="table table-hover table-success">
    <tr>
        <th>Correos</th>
    </tr>
    @foreach ($contacto['emails'] as $item)
        <?php
            $color = 'secondary';
            $status = App\Models\Contacto::validarContacto($item['email'],$dni);
            if($status == '0'){
                $color = 'success';
            }elseif($status == '1'){
                $color = 'warning';
            }elseif($status == '2'){
                $color = 'danger';
            }
        ?>
        <tr>
            <td>{{$item['email']}} <a href="" class="btn-contact-data" data-bs-toggle="modal" data-bs-target="#modalConfirm" data-contact="{{$item['email']}}" data-dni="{{$dni}}" data-color="{{$color}}" data-id="c-{{$loop->index}}"><i id="c-{{$loop->index}}" class="bi bi-check-all text-{{$color}}"></i></a></td>
        </tr>
    @endforeach
    
</table>
@endif
@if(isset($contacto['phones']))
<table class="table table-hover table-secondary">
    <tr>
        <th>Teléfonos</th>
    </tr>
    @foreach ($contacto['phones'] as $item)
        <?php
            $color = 'secondary';
            $status = App\Models\Contacto::validarContacto($item['phone'],$dni);
            if($status == '0'){
                $color = 'success';
            }elseif($status == '1'){
                $color = 'warning';
            }elseif($status == '2'){
                $color = 'danger';
            }
        ?>
        <tr>
            <td>{{$item['phone']}} <a href="" class="btn-contact-data" data-bs-toggle="modal" data-bs-target="#modalConfirm" data-contact="{{$item['phone']}}" data-dni="{{$dni}}" data-color="{{$color}}" data-id="p-{{$loop->index}}"><i id="p-{{$loop->index}}" class="bi bi-check-all text-{{$color}}"></i></a></td>
        </tr>
    @endforeach
    
</table>
@endif
@if(isset($contacto['company']))
<table class="table table-hover table-secondary">
    <tr>
        <th>Contacto</th>
    </tr>
    @foreach ($contacto['company'] as $item)
        <?php
            $color = 'secondary';
            $status = App\Models\Contacto::validarContacto($item->contacto,$dni);
            if($status == '0'){
                $color = 'success';
            }elseif($status == '1'){
                $color = 'warning';
            }elseif($status == '2'){
                $color = 'danger';
            }
        ?>
        <tr>
            <td>{{$item->contacto}} <a href="" class="btn-contact-data" data-bs-toggle="modal" data-bs-target="#modalConfirm" data-contact="{{$item->contacto}}" data-dni="{{$dni}}" data-color="{{$color}}" data-id="p-{{$loop->index}}"><i id="p-{{$loop->index}}" class="bi bi-check-all text-{{$color}}"></i></a></td>
        </tr>
    @endforeach
    
</table>
@endif