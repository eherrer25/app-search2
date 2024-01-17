 
<table class="table table-hover mt-3">
    <thead>
        <tr>
            <th>Cedula</th>
            <th>Nombre</th>
            <th>Estado Civil</th>
            <th>Fecha de Nacimiento</th>
            <th>Genero</th>
            <th>Parentesco</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($json["family"] as $f)
            <tr>
                <td>{{$f['dni']}} 
                    <form action="{{route('buscar')}}" method="POST" target="_blank">
                        @csrf
                        <input type="hidden" name="nombre" value="{{$f['dni']}}">
                        <input type="hidden" name="tipo" value="dni">
                        <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                    </form>
                </td>
                <td>{{$f['fullname']}}</td>
                <td>{{$f['civilStatus']}}</td>
                <td>{{$f['dateOfBirth']}} ({{$f['age']}}) </td>
                <td>{{$f['gender']}}</td>
                <td>{{$f['relationship']}}</td>
            </tr>
        @endforeach
    </tbody>

</table>