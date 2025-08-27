<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NuSmartCard;
use Illuminate\Http\JsonResponse;

class NuSmartCardController extends Controller
{
    /**
     * Return all Nu Smart Card records with related data.
     */
    public function index(): JsonResponse
    {
        $cards = NuSmartCard::with(['blood', 'department', 'designation'])
            ->orderBy('order_position', 'asc')
            ->get();

        return response()->json($cards);
    }
}
