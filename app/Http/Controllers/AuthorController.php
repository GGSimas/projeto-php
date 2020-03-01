<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Authors;

use Validator;

class AuthorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() 
    {
        $authors = Authors::paginate(15);
        return view('author.index', compact('authors'));
    }

    public function add() 
    {
        return view('author.add');
    }

    public function save(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
        ]);

        if (!$validator->fails())
        {
            $author = Authors::create([
                'name' => $request->input('name'),
                'surname' => $request->input('surname')
            ]);
        }
        return redirect()->route('author.index');
    }

    public function edit($id) 
    {
        $author = Authors::find($id);

        if (!$author)
        {
            return redirect()->route('author.index');
        }

        return view('author.edit', compact('author'));
    }

    public function update(Request $request, $id) {
        Authors::find($id)->update($request->all());
        return redirect()->route('author.index');
    }

    public function delete($id) {
        Authors::find($id)->delete();
        return redirect()->route('author.index');
    }
    

    public function search(Request $request) {
        $name = $request->input('name');
        $search = true;
        if ($name)
        {
            $authors = Authors::where('name', 'like', '%'. $name . '%' )->get();
        }
        return view('author.index', compact('authors', 'search'));

    }
}
