<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::latest()->simplePaginate(15);

        return Inertia::render('Authors/Index', [
            'authors' => $authors
        ]);
    }

    public function show(Author $author)
    {
        $author->load('books');
        
        return Inertia::render('Authors/Show', [
            'author' => $author
        ]);
    }

    public function create(){

        if (!auth()->user()->hasRole('admin')) {
                abort(403);
            }

        return Inertia::render('Authors/Create');
    }

    public function store(Request $request)
    {

        if (!auth()->user()->hasRole('admin')) {
                abort(403);
        }

        $data = $request->validate([
            'name' => 'required|string|max:30',
            'photo'=> 'nullable|image|max:2048',
        ]);

        if($request->hasFile('photo')){
            $data['photo'] = $request->file('photo')->store('photos','public');
        }

        $author = Author::create($data);

        return redirect()->route('authors.show',$author);
    }

    public function edit(Author $author){
        
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

       return Inertia::render('Authors/Edit',[
            'author' => $author
        ]);
    }

    public function update(Request $request, Author $author){
    
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        $data = $request->validate([
            'name' => 'required|string|max:50',
            'photo' => 'nullable|image|max:2048'
        ]);

        if($request->hasFile('photo')){
            if($author->photo){
                Storage::disk('public')->delete($author->photo);
            } 
                        $data['photo'] = $request->file('photo')->store('photos', 'public');

        } else {
            unset($data['photo']);
        }

        $author->update($data);

        return redirect()->route('authors.show',$author);
    }

    public function destroy(Author $author){

        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }
        
        $author->delete();
        
        return redirect('authors');
    }
}
