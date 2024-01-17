<table border="1">
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