<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Incident;
use App\Http\Requests\Api\V1\StoreIncidentRequest;
use App\Http\Requests\Api\V1\UpdateIncidentRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\IncidentCollection;
use App\Http\Resources\Api\V1\IncidentResource;

class IncidentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new IncidentCollection(Incident::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIncidentRequest $request)
    {
        return new IncidentResource( Incident::create( $request->all() )->refresh() );
    }

    /**
     * Display the specified resource.
     */
    public function show(Incident $incident)
    {
        return new IncidentResource( $incident );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Incident $incident)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIncidentRequest $request, Incident $incident)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Incident $incident)
    {
        if ( !$incident )
        {
            return response()->json( [ 'message' => 'Incident not found' ], 404 );
        }

        $incident->is_active = false;
        $incident->save();
        return response()->json( [ 'message' => 'Incident deleted successfully' ] );
    }
}
