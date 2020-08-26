<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ListingResource;
use App\Laravue\Models\Listing;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ListingResource::collection(Listing::all());
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
        $listing = Listing::create([
            'title' => $params['title'],
            // 'code' => strtolower($params['name']) . time(), // Just to make sure this value is unique
            'nameOwner' => $params['nameOwner'],
            'emailOwner' => $params['emailOwner'],
            'description' => $params['description'],
        ]);
        
        return new ListingResource($listing);
    }
}


    /**
     * Display the specified resource.
     *
     * @param  \App\Laravue\Models\Listing  $listing
     * @return \Illuminate\Http\Response
     */
    public function show(Listing $listing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Laravue\Models\Listing  $listing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Listing $listing)
    {
        if ($listing === null) {
            return response()->json(['error' => 'Category not found'], 404);
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
            $listing->title = $params['title'];
            $listing->nameOwner = $params['nameOwner'];
            $listing->emailOwner = $params['emailOwner'];
            $listing->description = $params['description'];
            $listing->save();
        }

        return new ListingResource($listing);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Laravue\Models\Listing  $listing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Listing $listing)
    {
        try {
            $listing->delete();
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }
    
        return response()->json(null, 204);
    }
}
