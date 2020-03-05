@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
            	<ol class="breadcrumb panel-heading">
                	<li><a href="{{route('book.index')}}">Livros</a></li>
                	<li class="active">Adicionar</li>
                </ol>
                <div class="panel-body">
	                <form action="{{ route('book.save') }}" method="POST" enctype="multipart/form-data">
	                	{{ csrf_field() }}
						          <div class="form-group">
						            	<label for="name">Titulo</label>
						              <input type="text" class="form-control" name="title" id="title" placeholder="Titulo">
                      </div>
                      <div class="form-group">
                        <label for="author">Autores</label>
                        <select name="author[]" class="form-control selectpicker" multiple data-live-search="true" id="author" title="Autores">
                          @foreach($authors as $author)
                            <option value="{{$author->id}}">{{$author->name}}</option>
                          @endforeach()
                        </select>

                        <p class="help-block">Use Crtl para selecionar.</p>
                      </div>
                      <div class="form-group">
                        <label for="name">Descrição</label>
                        <textarea type="text" class="form-control" name="description" id="description" placeholder="Descrição" rows="10" cols="50" resize="off"></textarea>                      
                      </div>
                      <div class="control-group">
                        <div class="controls">
                          <input name="image" type="file">
                        </div>
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