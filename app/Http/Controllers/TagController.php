<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::all();
        return view('tags.index',compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('admin_access');
        $request->validate([ 
        'nombre' => 'required'
        ]);
        
        Tag::create($request->all());
        
        return redirect()->route('tags.index')->with('success', 'Tag creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        Gate::authorize('admin_access');
        $tareas = $tag->tareas;
        return view('tags.show', compact('tag','tareas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
         return view('tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        Gate::authorize('admin_access');
        $request->validate([ 
        'nombre' => 'required'
        ]);
        
        $tag->update($request->all());
        
        return redirect()->route('tags.index')
                        ->with('success', 'Tag actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        Gate::authorize('admin_access');
        $tag->delete();
        return redirect()->route('tags.index')
            ->with('success', 'Tag eliminado correctamente');
    }
}
