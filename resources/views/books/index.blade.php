@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <ol class="breadcrumb panel-heading">
          <li class="active">Livros</li>
        </ol>
        <div class="panel-body">
          <form class="form-inline" action="{{ route('book.search') }}" method="POST">
             {{ csrf_field() }}
                <input type="hidden" name="_method" value="put">
                <div class="form-group" style="float: right;">
                    <p><a href="{{route('book.add')}}" class="btn btn-info btn-sm"><i class="glyphicon glyphicon-plus"></i> Adicionar</a></p>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Autor">
                </div>
                <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i> Buscar</button>
           </form>
           <br />
           <table class="table table-bordered table-striped">
               <thead>
                   <tr>
                       <th>Cod</th>
                       <th width="20">Imagem</th>
                       <th>Nome</th>
                       <th>Descrição</th>
                       <th>Ação</th>
                   </tr>
               </thead>
               <tbody>
                   @foreach($books as $book)
                       <tr>
                           <th scope="row" class="text-center">{{ $book->id }}</th>
                           <td class="center">
                              <img src="/images/books/{{ $book->image }}"  width="90px" height="150px"/>
                           </td>
                           <td>{{ $book->title }}</td>
                           <td  style="max-width: 100px; text-overflow: ellipsis; white-space: nowrap; overflow: hidden;">{{$book->description }}</td>              
                           <td width="155" class="text-center">
                               <a href="{{route('book.edit', $book->id)}}" class="btn btn-default">Editar</a>
                               <a href="{{route('book.delete', $book->id)}}" class="btn btn-danger">Excluir</a>
                           </td>
                       </tr>
                   @endforeach
               </tbody>
           </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection