<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\RoomType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoomTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($hotelId)
    {
        $roomTypes = RoomType::where('hotel_id', $hotelId)->get();
        return response()->json($roomTypes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:Estándar,Junior,Suite',
            'accommodation' => 'required|in:Sencilla,Doble,Triple,Cuádruple',
            'quantity' => 'required|integer|min:1',
            'hotel_id' => 'required|exists:hotels,id',
        ]);

        $roomType = $validated['type'];
        $accommodation = $validated['accommodation'];

        $validAccommodation = $this->validateAccommodation($roomType, $accommodation);

        if (!$validAccommodation) {
            return response()->json(['error' => 'La acomodación no es válida para el tipo de habitación seleccionado'], 400);
        }

        $hotel = Hotel::find($validated['hotel_id']);

        // Verificar si el tipo de habitación y acomodación ya existe para el hotel
        $existingRoomType = RoomType::where('hotel_id', $hotel->id)
            ->where('type', $validated['type'])
            ->where('accommodation', $validated['accommodation'])
            ->first();

        if ($existingRoomType) {
            return response()->json(['error' => 'El tipo de habitación y acomodación ya existe para este hotel'], 400);
        }

        // Verificar el límite de habitaciones
        $totalRoomTypesQuantity = RoomType::where('hotel_id', $hotel->id)->sum('quantity');
        if (($totalRoomTypesQuantity + $validated['quantity']) > $hotel->number_of_rooms) {
            return response()->json(['error' => 'La cantidad total de tipos de habitación no debe exceder el número total de habitaciones del hotel'], 400);
        }

        $roomType = RoomType::create($validated);
        return response()->json($roomType, 201);
    }

    /**
     * Validation Accommodation
     */
    private function validateAccommodation($roomType, $accommodation)
    {
        $validOptions = [
            'Estándar' => ['Sencilla', 'Doble'],
            'Junior' => ['Triple', 'Cuádruple'],
            'Suite' => ['Sencilla', 'Doble', 'Triple']
        ];

        return in_array($accommodation, $validOptions[$roomType] ?? []);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $roomType = RoomType::find($id);

        if (!$roomType) {
            return response()->json(['error' => 'Tipo de habitación no encontrado'], 404);
        }

        return response()->json($roomType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        /* ToDo: Update Room Types */
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        /* ToDo: Delete Room Types */
    }
}
