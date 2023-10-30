<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class MoviesController extends Controller
{
        public function index()
    {
        $client = new Client();

        $response = $client->request('GET', 'https://moviesdatabase.p.rapidapi.com/titles?limit=50', [
            'headers' => [
                'X-RapidAPI-Host' => 'moviesdatabase.p.rapidapi.com',
                'X-RapidAPI-Key' => 'da032df6demsh10b63f30a937906p105ecdjsn2df723e218a8',
            ],
        ]);

        $data = json_decode($response->getBody(), true);

        // Implementa la paginación
        $perPage = 10; // Cantidad de resultados por página
        $currentPage = request('page', 1);
        $items = collect($data['results']);
        $paginatedItems = $items->forPage($currentPage, $perPage);

        return view('welcome', [
            'apiResponses' => $paginatedItems,
        ]);
    }

    public function getMoviesData()
    {
        $client = new Client();
        
        try {
            $response = $client->request('GET', 'https://moviesdatabase.p.rapidapi.com/titles?limit=50', [
                'headers' => [
                    'X-RapidAPI-Host' => 'moviesdatabase.p.rapidapi.com',
                    'X-RapidAPI-Key' => 'da032df6demsh10b63f30a937906p105ecdjsn2df723e218a8',
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            $perPage = 10; 
            $offset = ($perPage * request('page', 1)) - $perPage;
            $limit = $offset + $perPage;
            $currentPage = request('page', 1);
            $items = collect($data['results']);
            $paginatedItems = $items->forPage($currentPage, $perPage);

            return response()->json([
                'data' => $paginatedItems,
                'total' => count($data['results']),
                'per_page' => $perPage,
                'current_page' => $currentPage,
                'last_page' => ceil(count($data['results']) / $perPage),
                'next_page_url' => '/movies?page=' . ($currentPage + 1),
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al realizar la solicitud a la API', 'message' => $e->getMessage()], 500);
        }
    }
}