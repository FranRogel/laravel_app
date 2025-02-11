<?php

namespace App\Http\Controllers;


use App\Models\Tarea;
use App\Models\Tag;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tareas = Tarea::all();
        $tags = Tag::with('tareas')->get();
        return view('tareas.index',compact('tags'), compact('tareas'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = Tag::all(); // Obtener todas las etiquetas disponibles
        return view('tareas.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([ 
        'nombre' => 'required',
        'descripcion' => 'required',
        'fecha_comienzo'=> 'required',
        'fecha_final'=> 'required',
        'tag_id'=> 'required',
        'creador_id' => 'required'
        ]);
        
        Tarea::create($request->all());
        
        return redirect()->route('tareas.index')->with('success', 'Tarea creada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tarea $tarea)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tarea $tarea)
    {
        $tag_original = $tarea->tag;
        $tags = Tag::all();
         return view('tareas.edit', compact('tag_original', 'tags', 'tarea'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tarea $tarea)
    {
        $request->validate([ 
        'nombre' => 'required',
        'descripcion' => 'required',
        'fecha_comienzo'=> 'required',
        'fecha_final'=> 'required',
        'tag_id'=> 'required'
        ]);
        
        $tarea->update($request->all());
        
        return redirect()->route('tareas.index')
                        ->with('success', 'Tarea actualizada correctamente');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tarea $tarea)
    {
        $tarea->delete();
        
        return redirect()->route('tareas.index')
            ->with('success', 'Tarea Eliminada correctamente');
        
    }
}
