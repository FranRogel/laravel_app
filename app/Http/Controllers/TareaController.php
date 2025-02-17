<?php

namespace App\Http\Controllers;

use App\Providers\AppServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Log;
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
        $tags = Tag::with('tareas')->orderBy('prioridad', 'asc')->get();
        return view('tareas.index',compact('tags'), compact('tareas'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = Tag::orderBy('prioridad', 'asc')->get(); // Obtener todas las etiquetas disponibles
        return view('tareas.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:tareas,nombre',
            'descripcion' => 'required',
            'fecha_comienzo' => 'required',
            'fecha_final' => 'required',
            'tag_id' => 'required',
            'creador_id' => 'required'
        ]);
    
            // Crear la tarea
        $tarea = Tarea::create($request->all());
    
            // Registrar en el log
        Log::info('Tarea creada', [
                'usuario' => auth()->user() ? auth()->user()->name : 'Desconocido',
                'tarea' => $tarea->toArray()
            ]);
    
        return redirect()->route('tareas.index')->with('success', 'Tarea creada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tarea $tarea)
    {
        $creador = $tarea->creador;
        $tag = $tarea->tag;
        
        return view('tareas.show', compact('tarea','creador','tag'));
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tarea $tarea)
    {
       try {
        Gate::Authorize('manage', $tarea);
 
        $tag_original = $tarea->tag;
        $tags = Tag::orderBy('prioridad', 'asc')->get();

        return view('tareas.edit', compact('tag_original', 'tags', 'tarea'));

       } catch (AuthorizationException  $e) {
        Log::warning('Intento de acceso no autorizado a store', [
            'user_id' => auth()->id(),
            'email' => auth()->user()->email ?? 'guest',
            'route' => request()->url(),
            'ip' => request()->ip(),
            'message' => $e->getMessage(),
        ]);
        abort(403, 'No autorizado');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tarea $tarea)
    {
        try {
            Gate::Authorize('manage', $tarea);

            $request->validate([ 
                'nombre' => 'required|unique:tareas,nombre',
                'descripcion' => 'required',
                'fecha_comienzo'=> 'required',
                'fecha_final'=> 'required',
                'tag_id'=> 'required'
                ]);
                
            $tarea->update($request->all());
        
            Log::info('Tarea Editada', [
                    'usuario' => auth()->user() ? auth()->user()->name : 'Desconocido',
                    'tarea' => $tarea->toArray()
                ]);
            return redirect()->route('tareas.index')
                            ->with('success', 'Tarea actualizada correctamente');
        
        } catch (AuthorizationException  $e) {


        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tarea $tarea)
    {
        Gate::authorize('manage', $tarea);
        Log::info('Tarea Eliminada', [
            'usuario' => auth()->user() ? auth()->user()->name : 'Desconocido',
            'tarea' => $tarea->toArray()
        ]);
        $tarea->delete();
        
        return redirect()->route('tareas.index')
            ->with('success', 'Tarea Eliminada correctamente');
        
    }

    public function cambiarTag(Request $request, $id)
    {
        try {
            $tarea = Tarea::findOrFail($id);
            Gate::authorize('manage', $tarea);
            $tarea->tag_id = $request->tag_id;
            $tarea->save();
    
            return redirect()->route('tareas.index')
            ->with('success', 'Tarea Modificada Correctamente');
        } catch (AuthorizationException  $e){
            return redirect()->route('tareas.index');
        }

    }
}
