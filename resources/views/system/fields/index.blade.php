@extends('layouts.adminlte')

@section('content_adminlte')

<div class='row'>
    <div class="col-12 p-1">
        <a href="{{route('system.fields.create')}}" class='btn btn-success'> Cadastrar campo </a>
    </div>

    <div class="col-12 p-1">
        <form action="#" method="GET">
            <div class="card">
                <div class="card-header">
                    Filtrar campos
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="fieldName">Nome do campo</label>
                                <input type="text" class="form-control" id="fieldName" name="fieldName" placeholder="Nome do campo" value="{{ Request::get('teamName') ?? '' }}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="teamCity">Estado do campo</label>
                            <select class="form-control select2bs4" id="teamState" name="stateId">
                                
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="teamCity">Cidade do campo</label>
                            <select class="form-control select2bs4" id="teamCity" name="cityId">
                                
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <input type="submit" class="btn btn-primary" value="Filtrar times">
                </div>
            </div>
        </form>
    </div>
    
    @if($fields->count() > 0)
        <div class="col-md-12 d-flex flex-column align-items-center">
        <table class="table ">
            <thead class="thead-light">
                <tr>
                <th scope="col">ID do Campo</th>
                <th scope="col">City ID</th>
                <th scope="col">Nome</th>
                <th scope="col">Apelido</th>
                <th scope="col">Endereco</th>
                <th scope="col">Como chegar</th>
                </tr>
            </thead>
            <tbody>
                @foreach($fields as $field)
                <tr>
                <td>{{$field->id}}</td>
                <td>{{$field->city_id}}</td>
                <td>{{$field->name}}</td>
                <td>{{$field->nickname != ''? $field->nickname : '---'}}</td>
                <td>{{$field->address}}</td>
                <td><a href="{{$field->google_location}}">{{$field->google_location}}</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>

            <nav>
                <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="{{ $fields->previousPageUrl() }}">Voltar</a></li>
                    {{--Link de retorno para o paginate--}}

                    @for($i = 1; $i <= $fields->lastPage(); $i++) 
                    <li class="page-item {{ $fields->currentPage() == $i ? 'active' : ''}}" >
                        <a class="page-link" href="{{ $fields->url($i) }}">{{ $i }}</a>
                    </li>
                    @endfor

                    <li class="page-item"><a class="page-link" href="{{ $fields->nextPageUrl() }}">Proximo</a></li>
                    {{--Link de avancar para o paginate--}}
                </ul>
            </nav>
        </div>
</div>

    @else
        <div class="col-12 mt-3">
            <div class='alert alert-danger'> Nenhum Time cadastrado </div>
        </div>
    @endif
@endsection