<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use Inertia\Inertia;

class AuthorController extends Controller
{
    public function index()
    {

        $authors = Author::all();

        return Inertia::render('Authors/Index', [
            'authors' => $authors
        ]);
    }

    public function show(Author $author)
    {
        return Inertia::render('Authors/Show', [
            'author' => $author
        ]);
    }

    public function create(){
        return Inertia::render('Authors/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:30',
            'photo'=> 'nullable|image|max:2048',
        ]);

        if($request->hasFile('photo')){
            $data['photo'] = $request->file('photo')->store('photos','public');
        }

        $author = Author::create($data);

        // Relaciona os autores
        $author = Author::create($data);

        return redirect()->route('authors.show',$author);
    }
}
