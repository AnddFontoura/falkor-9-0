@extends('layouts.adminlte')

@section('content_adminlte')
    <div class='row'>
        <div class="col-12">
            <div class="row">
                <div class="col-lg-2 col-md-4 col-sm-6 mt-3">
                    <a
                        href="{{ route('system.player.index') }}"
                        class='btn btn-success w-100'
                    >
                        Listar Jogadores
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Aplicações em times</h3>
                </div>

                <div class="card-body">
                    @if(count($teamApplications) == 0)
                        <div class="col-12 mt-3">
                            <div class='alert alert-success'> Você não aplicou em nenhum time </div>
                        </div>
                    @else
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th> TIME </th>
                                <th class="w-10">POSIÇÃO</th>
                                <th class="w-10">STATUS</th>
                                <th class="w-50"> OPÇÕES </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($teamApplications as $application)
                                <tr>
                                    <td>
                                        {{ $application->teamInfo->name }}
                                    </td>
                                    <td class="text-center">
                                        {!! $application->gamePositionInfo->icon !!}
                                    </td>

                                    <td class="text-center">
                                        @switch($application->approved)
                                            @case(0)
                                                <div class="btn btn-danger w-100">
                                                    Reprovado
                                                </div>
                                                @break
                                            @case(1)
                                                <div class="btn btn-success w-100">
                                                    Aprovado
                                                </div>
                                                @break
                                            @case(null)
                                                <div class="btn btn-warning w-100">
                                                    Não avaliado
                                                </div>
                                                @break
                                        @endswitch
                                    </td>

                                    <td>
                                        {{ $application->rejection_reason }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif

                </div>

                @if($teamApplications->links())
                    <div class="card-footer clearfix">
                        {{ $teamApplications->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
