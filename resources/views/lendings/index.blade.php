@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <ol class="breadcrumb panel-heading">
                    <li class="active">Empréstimos</li>
                </ol>
                <div class="panel-body">
                    <form class="form-inline" action="{{ route('lendings.search') }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="put">
                        <div class="form-group" style="float: right;">
                            <p><a href="{{route('lendings.add')}}" class="btn btn-info btn-sm"><i
                                        class="glyphicon glyphicon-plus"></i> Adicionar</a></p>
                        </div>

                    </form>
                    <br>
                    <label>Meus Emprestimos</label>
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Cod</th>
                            <th>Data do Aluguel</th>
                            <th>Dia de Devolução</th>
                            <th>Livros</th>
                            <th>Dia de Devolvida</th>
                            @if(Auth::user()->role == 100)
                            <th>Ação</th>
                                @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $lendings as $lend)
                            <tr>
                                <th scope="row" class="text-center">{{ $lend->id }}</th>
                                <td class="text-justify">{{ Carbon\Carbon::parse($lend->date_start)->locale('pt_BR')->format('dd/MM/Y') }}</td>
                                <td class="text-justify">{{Carbon\Carbon::parse($lend->date_end)->locale('pt_BR')->format('d/MM/Y')  }}</td>
                                <td class="text-justify">Livros</td>
                                <td class="text-justify">{{ !empty($lend->date_finish)? Carbon\Carbon::parse($lend->date_finish)->format('d/m/Y'): null}}</td>
                                @if(Auth::user()->role == 1000)
                                <td width="155" class="text-center">

                                    <a href="{{route('lendings.edit', $lend->id)}}" class="btn btn-default btn-sm"><i
                                            class="glyphicon glyphicon-pencil"></i></a>
                                    <a href="{{route('lendings.delete', $lend->id)}}" class="btn btn-danger btn-sm"><i
                                            class="glyphicon glyphicon-trash"></i></a>
                                    <a href="{{route('lendings.giveback', $lend->id)}}" class="btn btn-success btn-sm"><i
                                            class="glyphicon glyphicon-ok"></i></a>
                                </td>
                                @endif

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @if($role>0)
                    <label>Emprestimos</label>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Cod</th>
                                <th>Usuario</th>
                                <th>Data do Aluguel</th>
                                <th>Dia de Devolução</th>
                                <th>Livros</th>
                                <th>Dia de Devolvida</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $lendings2 as $lend)
                            <tr>
                                <th scope="row" class="text-center">{{ $lend->id }}</th>
                                <th scope="row" class="text-center">{{ $lend->user->name }}</th>
                                <td class="text-justify">{{ Carbon\Carbon::parse($lend->date_start)->locale('pt_BR')->format('d/m/Y') }}</td>
                                <td class="text-justify">{{Carbon\Carbon::parse($lend->date_end)->locale('pt_BR')->format('d/m/Y')  }}</td>
                                <td class="text-justify">Livros</td>
                                <td class="text-justify">{{ !empty($lend->date_finish)? Carbon\Carbon::parse($lend->date_finish)->format('d/m/Y'): null}}</td>
                                <td width="155" class="text-center">
                                    <a href="{{route('lendings.edit', $lend->id)}}" class="btn btn-default btn-sm"><i
                                            class="glyphicon glyphicon-pencil"></i></a>
                                    <a href="{{route('lendings.delete', $lend->id)}}" class="btn btn-danger btn-sm"><i
                                            class="glyphicon glyphicon-trash"></i></a>
                                    <a href="{{route('lendings.giveback', $lend->id)}}" class="btn btn-success btn-sm"><i
                                            class="glyphicon glyphicon-ok"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
 @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection