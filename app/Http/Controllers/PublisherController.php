<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class PublisherController extends Controller
{
    public function index()
    {
        $publishers = Publisher::latest()->simplePaginate(15);

        return Inertia::render('Publishers/Index', [
            'publishers' => $publishers
        ]);
    }

    public function show($id){

        $publisher = Publisher::with('books')->findOrFail($id);

        return Inertia::render('Publishers/Show', [
            'publisher' => $publisher
        ]);
    }

    public function create(){

        if (!auth()->user()->hasRole('admin')) {
                abort(403);
        }

        return Inertia::render('Publishers/Create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        $data = $request->validate([
            'name' => 'required|string|max:50',
            'logo'=> 'nullable|image|max:2048',
        ]);

        if($request->hasFile('logo')){
            $data['logo'] = $request->file('logo')->store('logos','public');
        }

        $publisher = Publisher::create($data);

        return redirect()->route('publishers.show',$publisher);
    }

    public function edit(Publisher $publisher){

        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        return Inertia::render('Publishers/Edit', [
            'publisher' => $publisher
        ]);
    }

    public function update(Request $request, Publisher $publisher){
    
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        $data = $request->validate([
            'name' => 'required|string|max:50',
            'logo' => 'nullable|image|max:2048'
        ]);

        if($request->hasFile('logo')){
            if($publisher->logo){
                Storage::disk('public')->delete($publisher->logo);
            } 
                        $data['logo'] = $request->file('logo')->store('logos', 'public');

        } else {
            unset($data['logo']);
        }

        $publisher->update($data);

        return redirect()->route('publishers.show',$publisher);
    }

    public function destroy(Publisher $publisher){

        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        $publisher->delete();
        
        return redirect('publishers');
    }
}
