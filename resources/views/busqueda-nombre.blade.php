@extends('layouts.main')

@section('css')


@endsection

@section('content')

<section class="section dashboard">
    <div class="card">
        <div class="card-body">
            <table class="table table-hover mt-3">
                <tr>
                    <th>DNI</th>
                    <th>Nombre</th>
                    <th>Genero</th>
                    <th>Estado civil</th>
                    <th>Fecha Nacimiento</th>
                </tr>
                @foreach ($data as $d)
                    <tr>
                        <td>
                            {{$d->dni}}
                            <form action="{{route('buscar')}}" method="POST" class="form-company" target="_blank">
                                @csrf
                                <input type="hidden" name="tipo" value="{{isset($d->tipo) ? $d->tipo : 'dni'}}">
                                <input type="hidden" name="nombre" value="{{$d->dni}}">
                                <button type="submit" class="btn btn-primary ">
                                    <i class="bi bi-search"></i>
                                </button>
                            </form>
                        </td>
                        <td>{{$d->fullname}}</td>
                        <td>{{isset($d->gender) ? $d->gender : ''}}</td>
                        <td>{{isset($d->civilStatus) ? $d->civilStatus : ''}}</td>
                        <td>{{isset($d->dateOfBirth)? Carbon\Carbon::createFromFormat('d/m/Y',$d->dateOfBirth)->format('d/m/Y') : '' }}</td>
                    </tr>
                @endforeach
                

            </table>
        </div>
    </div>
</section>
@endsection

@section('script')

@endsection

