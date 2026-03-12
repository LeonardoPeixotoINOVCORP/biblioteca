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

    public function show(Publisher $publisher){
        return Inertia::render('Publishers/Show', [
            'publisher' => $publisher
        ]);
    }

    public function create(){
        return Inertia::render('Publishers/Create');
    }

    public function store(Request $request)
    {
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
        return Inertia::render('Publishers/Edit', [
            'publisher' => $publisher
        ]);
    }

    public function update(Request $request, Publisher $publisher){
    
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
        $publisher->delete();
        
        return redirect('publishers');
    }
}
