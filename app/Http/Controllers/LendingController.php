<?php

namespace App\Http\Controllers;

use App\Models\Authors;
use App\Models\Books;
use App\Models\Lendings;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;

class LendingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $userid=null;
        if (Auth::check()) {
            $userid = Auth::user()->id;
        }
        $selected_books= [];
        $user = User::find($userid);
        $role= $user->role;
        if($role>0){
            $lendings = Lendings::where('user_id',$user->id)->orderBy('id', 'desc')->get();
            $lendings2 = Lendings::where('user_id','!=' ,$user->id)->orderBy('id', 'desc')->get();
            return view('lendings.index', compact('lendings', 'lendings2','role','selected_books'));
        }
        else {
            $lendings = Lendings::where('user_id',$user->id)->orderBy('id', 'desc')->get();
            return view('lendings.index', compact('lendings', 'role', 'selected_books'));
        }
    }

    public function add(Request $request)
    {
        $num = intVal($request->input('id', 0));
        if($num>0){
            if(!empty($request->input('selected_books'))){
                $selected_books=$request->input('selected_books').','.$num;
            }else {
                $selected_books=$num;
            }

        }else {
            $selected_books="";
        }
        $books = [];
        $pieces = explode(",", $selected_books);

        $booksA = Books::whereIn('id',$pieces)->get();

        $authors = Authors::get();
        $selected_aut = [];


        return view('lendings.add', compact('books','booksA', 'authors', 'selected_aut', 'selected_books'));
    }

    public function addremove(Request $request)
    {

        $num = intVal($request->input('id', 0));
        if($num>0){
            if(!empty($request->input('selected_books'))){
                $selected_books=$request->input('selected_books');
                if(strpos($selected_books,',')>0){

                    $selected_books = str_replace(",".$num,"", $selected_books);
                    $selected_books = str_replace($num.',',"", $selected_books);
                }else{
                    $selected_books = "";
                }

                $selected_books = str_replace(",".$num,"", $selected_books);
            }else {
                $selected_books="";
            }

        }else {
            $selected_books="";
        }
        $books = [];
        $pieces = explode(",", $selected_books);

        $booksA = Books::whereIn('id',$pieces)->get();

        $authors = Authors::get();
        $selected_aut = [];


        return view('lendings.add', compact('books','booksA', 'authors', 'selected_aut', 'selected_books'));
    }

    public function save(Request $request)
    {
        $userid= null;
        if (Auth::check()) {
            $userid = Auth::user()->id;
        }

        $user = User::find($userid);

        $validator = Validator::make($request->all(), [
            'selected_booksA' => 'required|min:1|max:255'
        ]);

        if (!$validator->fails()) {

            $lendings = Lendings::create([
                'user_id' => $user->id,
                'date_start' => Carbon::now(),
                'end_date' =>  Carbon::now()->addDays(7),
            ]);
            $selected_books=$request->input('selected_booksA');
            $pieces = explode(",", $selected_books);

            $lendings->books()->sync($pieces);
        }
        return redirect()->route('lendings.index');
    }

    public function edit($id)
    {
        $book = Books::find($id);

        if (!empty($book)) {
            $authors = Authors::get();

            $selected_aut = array();

            foreach ($book->authors as $author) {
                $selected_aut[] = $author->pivot->author_id;
            }
            return view('books.edit', compact(
                'book',
                'authors',
                'selected_aut'
            ));
        }

        return redirect()->route('books.index');
    }

    public function update(Request $request, $id)
    {

        $selected_books = $request->input('books');

        $book = Books::find($id);

        if (!empty($book)) {
            $fileName = null;
            if (!empty($request->file('image')) && $request->file('image')->isValid()) {
                if (!empty($request->input('deleteimage')) && file_exists($this->path . '/' . $request->input('deleteimage'))) {
                    unlink($this->path . '/' . $request->input('deleteimage'));
                }
                $fileName = time() . '.' . $request->file('image')->getClientOriginalExtension();
                $request->file('image')->move($this->path, $fileName);
            }

            if (!empty($author)) {
                $book->authors()->sync($author);
            }
            if (!$fileName) {
                $book->update([
                    'title' =>  $request->input('title'),
                    'description' =>  $request->input('description')

                ]);
            }else{
                $book->update([
                    'title' =>  $request->input('title'),
                    'description' =>  $request->input('description'),
                    'image' => $fileName

                ]);

            }
        }

        return redirect()->route('lendings.index');
    }


    public function delete($id)
    {
        $lend = Lendings::find($id);

        if (!empty($lend)) {

            $lend->books()->detach();
            $result = $lend->delete();
        }

        return redirect()->route('lendings.index');
    }

    public function giveback($id)
    {
        $lend = Lendings::find($id);

        if (!empty($lend)) {
            $lend->update([
                'date_finish' => Carbon::now()

            ]);
        }

        return redirect()->route('lendings.index');
    }

    public function search(Request $request)
    {

        $title = $request->input('title');
        $selected_aut = $request->input('author');

        $search = TRUE;

        $query = DB::table('books')->select('books.id', 'books.title', 'books.description', 'books.image')
            ->join('books_authors', 'books.id', '=', 'books_authors.book_id')
            ->join('authors', 'books_authors.author_id', '=', 'authors.id');
        //->groupBy('books.id', 'books.title', 'books.description');

        if (!empty($title) && !empty($selected_aut)) {
            $query->where('books.title', 'like', '%' . $title . '%');

            $query->whereIn('authors.id', $selected_aut);
        } else if (!empty($title)) {
            $query->where('books.title', 'like', '%' . $title . '%');
        } else if (!empty($selected_aut)) {
            $query->whereIn('authors.id', $selected_aut);
        }

        $authors = Authors::get();
        $books = $query->get();

        if (empty($selected_aut)) {
            $selected_aut = [];
        }
        return view('books.index', compact('books', 'authors', 'selected_aut', 'search'));
    }


    public function searchbook(Request $request)
    {

        $title = $request->input('title');
        $selected_aut = $request->input('author');

        $search = TRUE;

        $query = DB::table('books')->select('books.id', 'books.title', 'books.description', 'books.image')
            ->join('books_authors', 'books.id', '=', 'books_authors.book_id')
            ->join('authors', 'books_authors.author_id', '=', 'authors.id');
        //->groupBy('books.id', 'books.title', 'books.description');

        if (!empty($title) && !empty($selected_aut)) {
            $query->where('books.title', 'like', '%' . $title . '%');

            $query->whereIn('authors.id', $selected_aut);
        } else if (!empty($title)) {
            $query->where('books.title', 'like', '%' . $title . '%');
        } else if (!empty($selected_aut)) {
            $query->whereIn('authors.id', $selected_aut);
        }

        $authors = Authors::get();
        $books = $query->get();

        if (empty($selected_aut)) {
            $selected_aut = [];
        }
        $selected_books = $request->input('selected_books');

        $pieces = explode(",", $selected_books);

        $booksA = Books::whereIn('id',$pieces)->get();

        return view('lendings.add', compact('books','booksA', 'authors', 'selected_aut', 'selected_books', 'search'));
    }
}
