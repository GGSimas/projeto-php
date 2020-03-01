@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
            	<ol class="breadcrumb panel-heading">
                	<li><a href="{{route('author.index')}}">Autor</a></li>
                	<li class="active">Editar</li>
                </ol>
                <div class="panel-body">
	                <form action="{{ route('author.update', $author->id) }}" method="POST" enctype="multipart/form-data">
	                	{{ csrf_field() }}
                    <div class="form-group">
                        <label for="name">Nome</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Nome" value="{{ $author->name }}">
                    </div>

                    <div class="form-group">
                        <label for="name">Sobrenome</label>
                        <input type="text" class="form-control" name="surname" id="surname" placeholder="Sobrenome" value="{{ $author->surname }}">
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