<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;

class CampaignController extends Controller
{
    /**
     * Método para buscar todas as campanhas.
     */
    public function index()
    {
        $campaigns = Campaign::all();
        return response()->json([
            'message' => 'Campaigns retrieved successfully.',
            'campaigns' => $campaigns
        ], 200);
    }

    /**
     * Método para buscar uma campanha específica por ID.
     */
    public function show($id)
    {
        $campaign = Campaign::find($id);
        if (!$campaign) {
            return response()->json([
                'message' => 'Campaign not found.'
            ], 404);
        }

        return response()->json([
            'message' => 'Campaign retrieved successfully.',
            'campaign' => $campaign
        ], 200);
    }

    /**
     * Método para criar uma nova campaign.
     */
    public function store(Request $request)
    {
        // Valida os dados da requisição
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'date|after_or_equal:start_date',
        ]);

        // Cria a campanha no banco de dados
        $campaign = Campaign::create([
            'name' => $validated['name'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
        ]);

        return response()->json([
            'message' => 'Campaign created successfully.',
            'campaign' => $campaign
        ], 201);
    }

    /**
     * Método para atualizar uma campanha existente.
     */
    public function update(Request $request, $id)
    {
        // Busca a campanha pelo ID
        $campaign = Campaign::find($id);

        // Verifica se a campanha foi encontrada
        if (!$campaign) {
            return response()->json([
                'message' => 'Campaign not found.'
            ], 404);
        }

        // Valida os dados da requisição
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|date|after_or_equal:start_date',
        ]);

        // Atualiza os campos com os dados validados
        $campaign->update($validated);

        return response()->json([
            'message' => 'Campaign updated successfully.',
            'campaign' => $campaign
        ], 200);
    }    
}
