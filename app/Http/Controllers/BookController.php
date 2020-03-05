<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Books;
use App\Models\Authors;

use Validator;
class BookController extends Controller
{
    private $path = 'images/books';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() 
    {
        $authors = Authors::get();
        $books = Books::paginate(15);
        $selected_author =[];
        return view('books.index', compact('books', 'authors', 'selected_author' ));
    }

    public function add()
    {
        $authors = Authors::get();
        return view('books.add', compact('authors'));
    }

    public function save(Request $request)
    {
        if (!empty($request->file('image')) && $request->file('image')->isValid()) {
            $fileName = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move($this->path, $fileName);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|min:5|max:255',
            'description' => 'required'
        ]);

        if (!$validator->fails())
        {
            $book = Books::create([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'image' => $fileName
            ]); 

            $book->authors()->sync($request->input('author'));
        }        

        return redirect()->route('book.index');
    }

    public function edit($id) 
    {
        $book = Books::find($id);

        if(!empty($book)) {
            $authors = Authors::get();
            $selected_author= array();

            foreach($book->authors as $author)
            {
                $selected_author[] = $author->pivot->author_id;
            }
            return view('books.edit', compact('book', 'authors', 'selected_author'));
        }

        redirect()->route('book.index');
    }

    public function update(Request $request, $id)
    {
        $author = $request->input('author');
        $book = Books::find($id);

        if (!empty($request->file('image')) && $request->file('image')->isValid()) {
            $fileName = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move($this->path, $fileName);
        }

        if (!empty($book))
        {
            if (!empty($authors))
            { 
                $book->authors()->sync($author);
            }

            $book->update([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'image' => isset($fileName)? $fileName: $book->image
            ]);
        }

        return redirect()->route('book.index');
    }

    public function delete($id) {
        $book = Books::find($id);

        if (!empty($book))
        {
            $book->authors()->detach();
            $result = $book->delete();
        }

        return redirect()->route('book.index');
    }

    public function search(Request $request) {}
}
