<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ImmobilierResource;
use App\Laravue\Models\Immobilier;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

class ImmobilierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ImmobilierResource::collection(Immobilier::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title' => ['required']
            ]
        );
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {
            $params = $request->all();
            $immobilier = Immobilier::create([
                'title' => $params['title'],
                'nameOwner' => $params['nameOwner'],
                'emailOwner' => $params['emailOwner'],
                'adresse' => $params['adresse'],
                //'code' => strtolower($params['name']) . time(), // Just to make sure this value is unique
                'description' => $params['description'],
            ]);
            
            return new ImmobilierResource($immobilier);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Laravue\Models\Immobilier  $immobilier
     * @return \Illuminate\Http\Response
     */
    public function show(Immobilier $immobilier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Laravue\Models\Immobilier  $immobilier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Immobilier $immobilier)
    {
        if ($immobilier === null) {
            return response()->json(['error' => 'Immobilier not found'], 404);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'title' => ['required']
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {
            $params = $request->all();
            $immobilier->title = $params['title'];
            $immobilier->nameOwner = $params['nameOwner'];
            $immobilier->emailOwner = $params['emailOwner'];
            $immobilier->adresse = $params['adresse'];
            $immobilier->description = $params['description'];
            $immobilier->save();
        }

        return new ImmobilierResource($immobilier);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Laravue\Models\Immobilier  $immobilier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Immobilier $immobilier)
    {
        try {
            $immobilier->delete();
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }
    
        return response()->json(null, 204);
    }
}
