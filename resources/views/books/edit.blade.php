@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
            	<ol class="breadcrumb panel-heading">
                	<li><a href="{{route('book.index')}}">Livros</a></li>
                	<li class="active">Editar</li>
                </ol>
                <div class="panel-body">
	                <form action="{{ route('book.update', $book->id) }}" method="POST" enctype="multipart/form-data">
	                	{{ csrf_field() }}
						<div class="form-group">
						  	<label for="name">Nome</label>
						    <input type="text" class="form-control" name="title" id="title" placeholder="Titulo" value="{{ $book->title }}">
						</div>
                        <div class="form-group">
                            <label for="name">Autores</label>
                            <select name="author[]" class="form-control selectpicker" multiple="" data-live-search="true" title="Autores">
                                <?php foreach($authors as $author){ ?>
                                    <option value="<?= $author->id ?>" <?= in_array($author->id, $selected_author) ? "selected" : NULL ; ?>><?= $author->name ?></option>
                                <?php } ?>
                            </select>
                            <p class="help-block">Use Crtl para selecionar.</p>
                        </div>
                        <div class="form-group">
                            <label for="name">Capa</label>
                            <img src="/images/books/{{ $book->image }}"  width="10%" />

                            <input name="image" type="file">
                        </div>
                        <div class="form-group">
                            <label for="description">Descrição</label>
                            <textarea class="form-control" rows="3" name="description" id="description">{{ $book->description }}</textarea>
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