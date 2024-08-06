<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hotels = Hotel::with('roomTypes')->get();
        return response()->json($hotels);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:hotels,name',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'nit' => 'required|string|unique:hotels,nit',
            'number_of_rooms' => 'required|integer|min:1',
        ]);

        $hotel = Hotel::create($validated);
        return response()->json($hotel, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $hotel = Hotel::with('roomTypes')->find($id);

        if (!$hotel) {
            return response()->json(['error' => 'Hotel no encontrado'], 404);
        }

        return response()->json($hotel);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        /* ToDo: Update Hoteles */
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        /* ToDo: Delete Hoteles */
    }
}
