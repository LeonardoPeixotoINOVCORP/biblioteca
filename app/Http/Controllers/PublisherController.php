<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class PublisherController extends Controller
{
    public function index(){
        return Inertia::render('Publishers/Index', [
            
        ]);
    }
}
