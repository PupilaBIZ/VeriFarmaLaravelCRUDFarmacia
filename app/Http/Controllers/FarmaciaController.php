<?php

namespace App\Http\Controllers;

use App\Models\Farmacia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FarmaciaController extends Controller
{   
    /**
     * Lista todas las farmacias creadas
     * Busca en la base de datos todos los datos
     * 
     * @method GET
     * @author Ernesto Arias
     * @since 1.0
     * @return \Illuminate\Routing\ResponseFactory
     * 
     */
    public function list()
    {
        //Busco en la base de datos
        $farmacias = Farmacia::all();

        //Devuelvo los resultados a pantalla en formato JSON
        return response()->json($farmacias, 200);
    }

    /**
     * Inserta una farmacia en la base de datos
     * 
     * @method POST
     * @author Ernesto Arias
     * @since 1.0
     * @return \Illuminate\Routing\ResponseFactory
     *      
     * @param Request[nombre, direccion, latitud, longitud]
     *  
     */
    public function insert(Request $request)
    {
        //Defino las validaciones de los datos obtenidos
        $validator = Validator::make($request->all(), [    
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'latitud' => 'required|numeric|between:-90,90',
            'longitud' => 'required|numeric|between:-180,180',
        ]);        

        //Si alguna validacion da error
        if($validator->fails()){
            //Devuelvo a pantalla los mensajes de la validacion
            return response()->json($validator->errors(), 500);
        }

        //Creo el registro en la base de datos
        $farmacia = Farmacia::create($validatedData);
        
        //Devuelvo el registro creado a pantalla en formato JSON
        return response()->json($farmacia, 200);
    }


    /**
     * Actualiza una farmacia en la base de datos
     * 
     * @method POST
     * @author Ernesto Arias
     * @since 1.0
     * @return \Illuminate\Routing\ResponseFactory
     * 
     * @param Request[nombre, direccion, latitud, longitud]
     * @param Farmacia::id
     *      
     */
    public function update(Request $request, Farmacia $farmacia)
    {
        //Defino las validaciones de los datos obtenidos
        $validator = Validator::make($request->all(), [    
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'latitud' => 'required|numeric|between:-90,90',
            'longitud' => 'required|numeric|between:-180,180',
        ]);

        //Si alguna validacion da error
        if($validator->fails()){
            //Devuelvo a pantalla los mensajes de la validacion
            return response()->json($validator->errors(), 500);
        }
        
        //Actualizo el registro en la base de datos
        $farmacia->update($validatedData);

        //Devuelvo el registro modificado a pantalla en formato JSON
        return response()->json($farmacia, 200);
    }

    /**
     * Devuelve una farmacia de la base de datos
     * 
     * 
     * @method GET
     * @author Ernesto Arias
     * @since 1.0
     * @return \Illuminate\Routing\ResponseFactory
     * 
     * @param Farmacia::id
     *      
     */
    public function get(Farmacia $farmacia)
    {
        //Devuelvo el registro solicitado a pantalla en formato JSON
        return response()->json($farmacia, 200);
    }


    /**
     * Busco una farmacia en la base de datos en funcion de una latitud y longitud dada
     * La consulta a la base de datos calcula la distancia entre las coordenadas dadas y el registro
     * y ordena los resultados por dicho calculo de manera ascendente
     * Por cuestiones de performance se limita a 20 resultados
     *      
     * @method PUT
     * @author Ernesto Arias
     * @since 1.0
     * @return \Illuminate\Routing\ResponseFactory
     * 
     * @param Request[latitud, longitud]
     *      
     */
    public function search(Request $request)
    {
        //Defino las validaciones de los datos obtenidos
        $validator = Validator::make($request->all(), [    
            'latitud' => 'required|numeric|between:-90,90',
            'longitud' => 'required|numeric|between:-180,180',
        ]);

        //Si alguna validacion da error
        if($validator->fails()){
            //Devuelvo a pantalla los mensajes de la validacion
            return response()->json($validator->errors(), 500);
        }

        //Ejecuto la consulta a la base de datos para obtener los registros ordenados por distancia
        $farmacias = Farmacia::selectRaw(" *, ROUND(earth_distance(ll_to_earth(" . $request->get("latitud") . ", " . $request->get("longitud") . "), ll_to_earth(latitud, longitud))::NUMERIC, 2) AS distancia ")
                        ->groupBy("farmacias.id")
                        ->orderBy("distancia","ASC")
                        ->limit(20)
                        ->get();
        
        //Devuelvo los resultados a pantalla en formato JSON
        return response()->json($farmacias, 200);
    }
}