<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\RendezVous;
use App\Models\Centre;

class RendezVousController extends Controller
{
    public function index()
    {
        $rdvs = RendezVous::with('donneur', 'centre')->get();
        if ($rdvs->isEmpty()) {
            return response()->json(['message' => 'No rendez-vous found'], 404);
        }
        return response()->json($rdvs);
    }

    public function getRendezVousByCentre($id_centre)
    {
        $rdvs = RendezVous::with('donneur')->where('id_centre', $id_centre)->get();
        return response()->json($rdvs);
    }

    public function getRendezVousByDonneur($id_donneur)
    {
        $rdvs = RendezVous::with('centre')->where('id_donneur', $id_donneur)->get();
        return response()->json($rdvs);
    }

    public function store(Request $request)
{
    $dernierRdv = RendezVous::where('id_donneur', $request->id_donneur)
        ->where('status', 'Confirmé')
        ->orderBy('dateRendezVous', 'desc')
        ->first();

    if ($dernierRdv) {
        $joursEcoules = Carbon::parse($dernierRdv->dateRendezVous)->diffInDays(now());
        if ($joursEcoules < 14) {
            return response()->json([
                'message' => "Vous devez attendre au moins 14 jours entre deux dons. Dernier don : " . $dernierRdv->dateRendezVous
            ], 403);
        }
    }

    $validatedData = $request->validate([
        'id_donneur' => 'required|exists:users,id',
        'id_centre' => 'required|exists:centres,id',
        'dateRendezVous' => 'required|date|after_or_equal:today',
    ]);

    $centre = Centre::find($request->id_centre);
    if (!$centre) {
        return response()->json(['message' => 'Centre introuvable'], 404);
    }

    $rdvCount = RendezVous::where('id_centre', $request->id_centre)
        ->whereDate('dateRendezVous', $request->dateRendezVous)
        ->count();

    if ($rdvCount >= $centre->capacite_max) {
        return response()->json([
            'message' => "Capacité maximale atteinte pour le centre à cette date."
        ], 403);
    }

    $rendezVous = RendezVous::create([
    'id_donneur' => $request->id_donneur,
    'id_centre' => $request->id_centre,
    'dateRendezVous' => $request->dateRendezVous,
    'dernierRendezVous' => $dernierRdv ? $dernierRdv->dateRendezVous : null,
    'status' => 'Confirmé',
]);

    return response()->json([
        'message' => "Rendez-vous créé avec succès.",
        'rendezVous' => $rendezVous
    ], 201);
}


    public function show(string $id)
    {
        $rendezVous = RendezVous::with('donneur', 'centre')->find($id);
        if (!$rendezVous) {
            return response()->json(['message' => 'Rendez-vous not found'], 404);
        }
        return response()->json($rendezVous);
    }

    public function update(Request $request, string $id)
    {
        $rendezVous = RendezVous::find($id);
        if (!$rendezVous) {
            return response()->json(['message' => 'Rendez-vous not found'], 404);
        }

        $validatedData = $request->validate([
            'dateRendezVous' => 'sometimes|required|date|after_or_equal:today',
            'id_donneur' => 'sometimes|required|exists:users,id',
            'id_centre' => 'sometimes|required|exists:centres,id',
        ]);

        $rendezVous->update($validatedData);
        return response()->json($rendezVous);
    }

    public function destroy(string $id)
    {
        $rendezVous = RendezVous::find($id);
        if (!$rendezVous) {
            return response()->json(['message' => 'Rendez-vous not found'], 404);
        }

        $rendezVous->delete();
        return response()->json(['message' => 'Rendez-vous supprimé avec succès.']);
    }
}
