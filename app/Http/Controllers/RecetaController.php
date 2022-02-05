<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class RecetaController extends Controller
{
    //Constructor
    public function __construct()
    {
      $this -> middleware('auth');//verifica que se haya realizado la autentificación
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Capturar id del usuario autentificado
        $userRecetas = Auth::user()->userRecetas;
        return view('recetas.index')->with('userRecetas', $userRecetas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$categorias = DB::table('categorias')->get()->pluck('nombre','id');

        //Obtener categorias (con modelo)
        $categorias = Categoria::all(['id', 'nombre']);
        return view('recetas.create')->with('categorias', $categorias);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request['imagen']->store('upload-recetas','public'));


        //Validaciones
        $data=request()->validate([
            'nombre'=>'required|min:6',
            'categoria'=>'required',
            'ingredientes'=>'required',
            'preparacion'=>'required',
            'imagen'=>'required|image'
        ]);
        //Variable para la ruta de la imagen
        $ruta_imagen = $request['imagen']->store('upload-recetas','public');

        //REDIMENCIONAR LA IMAGEN
        //$img = Image::make(public_path("storage/{$ruta_imagen}"))->fit(1000,550);

        //GUARDAR EN EL DISCO DURO DEL SERVIDOR

        //$img->save();

        //Almacenar en la BDD
        DB::table('recetas')->insert([
            'nombre'=>$data['nombre'],
            'ingredientes'=>$data['ingredientes'],
            'preparacion'=>$data['preparacion'],
            'imagen'=>$ruta_imagen,
            'user_id' => Auth::user()->id, //capturamos el id del usuario
            'categoria_id'=>$data['categoria'],

        ]);

        //Redireccionar
        return redirect()->action([RecetaController::class, 'index']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function show(Receta $receta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function edit(Receta $receta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Receta $receta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receta $receta)
    {
        //
    }
}
