<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\CampaignRepositoryInterface;

class CampaignController extends Controller
{
    protected $campaignRepository;

    public function __construct(CampaignRepositoryInterface $campaignRepository)
    {
        $this->campaignRepository = $campaignRepository;
    }

    /**
     * Retorna a view de criação de campanha
     */
    public function new()
    {
        return view('new-campaign');
    }

    /**
     * Método para buscar todas as campanhas.
     */
    public function index()
    {
        $campaigns = $this->campaignRepository->getAllCampaigns();
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
        $campaign = $this->campaignRepository->getCampaignById($id);
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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $campaign = $this->campaignRepository->createCampaign($validated);

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
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|date|after_or_equal:start_date',
        ]);

        $campaign = $this->campaignRepository->updateCampaign($id, $validated);

        if (!$campaign) {
            return response()->json([
                'message' => 'Campaign not found.'
            ], 404);
        }

        return response()->json([
            'message' => 'Campaign updated successfully.',
            'campaign' => $campaign
        ], 200);
    }

    /**
     * Exibe os jogadores de uma campanha
     */
    public function viewPlayersOfCampaign($campaign_id)
    {
        $players = $this->campaignRepository->getPlayersByCampaign($campaign_id);
        if (!$players) {
            return response()->json([
                'message' => 'Campaign not found for the specified id.'
            ], 404);
        }

        return view('players-campaign', [
            'campaign' => $this->campaignRepository->getCampaignById($campaign_id),
            'players' => $players
        ]);
    }

    /**
     * Exibe os personagens disponíveis de uma campanha
     */
    public function viewCharactersAvailableOfCampaign($campaign_id)
    {
        $availableCharacters = $this->campaignRepository->getAvailableCharacters($campaign_id);

        if ($availableCharacters === null) {
            return response()->json([
                'message' => 'Campaign not found for the specified id.'
            ], 404);
        }

        return view('characters', ['characters' => $availableCharacters]);
    }
}
