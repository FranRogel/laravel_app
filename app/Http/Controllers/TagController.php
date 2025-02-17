<?php

namespace App\Http\Controllers;

use App\Providers\AppServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use App\Models\Tarea;
use App\Models\Tag;
use Illuminate\Http\Request;


class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::orderBy('prioridad', 'asc')->get();
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
        'nombre' => 'required|unique:tags,nombre',
        'prioridad' => 'required'
        ]);
        
        $tag = Tag::create($request->all());

        Log::info('Tag creado', [
                'usuario' => auth()->user() ? auth()->user()->name : 'Desconocido',
                'tag' => $tag->toArray()
                   ]);
        
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
        'nombre' => 'required|unique:tags,nombre',
        'prioridad' => 'required'
        ]);
        
        $tag->update($request->all());

        Log::info('Tag Actualizado', [
            'usuario' => auth()->user() ? auth()->user()->name : 'Desconocido',
            'tag' => $tag->toArray()
               ]);
        
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
