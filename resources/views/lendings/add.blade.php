@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <ol class="breadcrumb panel-heading">
                        <li><a href="{{route('lendings.index')}}">Lendings</a></li>
                        <li class="active">Adicionar</li>
                    </ol>
                    <div class="panel-body">

                        <div>
                            <div class="panel-body">
                                <form class="form-inline" action="{{ route('lendings.searchbook') }}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="put">
                                    <input type="hidden" name="selected_books" value="{{$selected_books}}">

                                    <div class="form-group">
                                        <input type="text" class="form-control" id="name" name="title" placeholder="Livro">
                                    </div>
                                    <div class="form-group" style="width: 200px; max-width: 200px;">
                                        <select name="author[]" class="form-control selectpicker" multiple=""
                                                data-live-search="true" title="Autores">
                                            <?php
                                            if(!empty($authors)){
                                            foreach($authors as $author){ ?>
                                            <option value="<?= $author->id ?>"
                                            <?= in_array($author->id, $selected_aut) ? "selected" : NULL ; ?>>
                                                <?= $author->fullName() ?></option>
                                            <?php }
                                            } ?>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i>
                                        Buscar</button>
                                </form>
                                <br>
                                <h3>Resultados </h3>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Cod</th>
                                        <th width="20">Imagem</th>
                                        <th>Titulo</th>
                                        <th>Descrição</th>
                                        <th>Autores</th>
                                        <th>Ação</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($books as $book)
                                        <tr>
                                            <th scope="row" class="text-center">{{ $book->id }}</th>
                                            <td class="center">
                                                <img src="/images/books/{{ $book->image }}" width="50%" />
                                            </td>
                                            <td>{{ $book->title }}</td>
                                            <td class="text-justify">{{ $book->description }}</td>
                                            <td class="text-justify">
                                                @foreach(App\Models\Books::Find($book->id)->authors as $author)
                                                    <ul>{{$author->id}} - {{ $author->fullname() }}</ul>
                                                @endforeach </td>
                                            <td width="155" class="text-center">
                                                <a href="{{route('lendings.add', ['id'=>$book->id,'selected_books'=>$selected_books])}}" class="btn btn-default btn-sm"><i
                                                        class="glyphicon glyphicon-plus"></i></a>

                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            </div>

                        </div>

                        <form action="{{ route('lendings.save') }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <input type="hidden" name="selected_booksA" value="{{$selected_books}}">
                                <label for="title">Data de Devolução Prevista</label>
                                <input type="text"  class="form-control" name="date_end" id="date_end" placeholder="" value="{{Carbon\Carbon::now()->addDay(7)->format('d/m/Y')}}">
                            </div>
                            <div class="form-group">
                                <h3>Alocados </h3>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Cod</th>
                                        <th width="20">Imagem</th>
                                        <th>Titulo</th>
                                        <th>Descrição</th>
                                        <th>Autores</th>
                                        <th>Ação</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($booksA as $book)
                                        <tr>
                                            <th scope="row" class="text-center">{{ $book->id }}</th>
                                            <td class="center">
                                                <img src="/images/books/{{ $book->image }}" width="100%" />
                                            </td>
                                            <td>{{ $book->title }}</td>
                                            <td class="text-justify">{{ $book->description }}</td>
                                            <td class="text-justify">
                                                @foreach(App\Models\Books::Find($book->id)->authors as $author)
                                                    <ul>{{$author->id}} - {{ $author->fullname() }}</ul>
                                                @endforeach </td>
                                            <td width="155" class="text-center">
                                                <a href="{{route('lendings.addremove', ['id'=>$book->id,'selected_books'=>$selected_books])}}" class="btn btn-default btn-sm"><i
                                                        class="glyphicon glyphicon-minus"></i></a>

                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <br />
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
