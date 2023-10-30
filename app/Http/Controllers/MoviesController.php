<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MoviesController extends Controller
{
    public function index(Request $request)
    {
        try {
            $response = Http::withHeaders([
                'X-RapidAPI-Host' => 'moviesdatabase.p.rapidapi.com',
                'X-RapidAPI-Key' => env('RAPID_API_KEY'),
            ])->get('https://moviesdatabase.p.rapidapi.com/titles', [
                'limit' => 50,
            ]);

            $data = $response->json();

            $filteredResults = collect($data['results'])->filter(function ($item) {
                return $item['primaryImage'] !== null;
            });

            $perPage = 10;
            $currentPage = max(1, (int) request('page', 1));

            $totalItems = count($filteredResults);
            $lastPage = ceil($totalItems / $perPage);

            $offset = ($perPage * $currentPage) - $perPage;
            $paginatedItems = $filteredResults->slice($offset, $perPage);

            $prevPage = $currentPage > 1 ? $currentPage - 1 : null;
            $nextPage = $currentPage < $lastPage ? $currentPage + 1 : null;

            return view('welcome', [
                'paginatedItems' => $paginatedItems,
                'total' => $totalItems,
                'per_page' => $perPage,
                'current_page' => $currentPage,
                'last_page' => $lastPage,
                'next_page_url' => $nextPage ? '/?page=' . $nextPage : null,
                'prev_page_url' => $prevPage ? '/?page=' . $prevPage : null,
            ]);
        } catch (\Exception $e) {
            return view('error', [
                'error' => 'Erro ao realizar a solicitação da API',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function getMoviesData()
    {
        try {
            $response = Http::withHeaders([
                'X-RapidAPI-Host' => 'moviesdatabase.p.rapidapi.com',
                'X-RapidAPI-Key' => 'da032df6demsh10b63f30a937906p105ecdjsn2df723e218a8',
            ])->get('https://moviesdatabase.p.rapidapi.com/titles', [
                'limit' => 50,
            ]);

            $data = $response->json();

            $filteredResults = collect($data['results'])->filter(function ($item) {
                return $item['primaryImage'] !== null;
            });

            $perPage = 10;
            $offset = ($perPage * request('page', 1)) - $perPage;
            $limit = $offset + $perPage;
            $currentPage = request('page', 1);
            $paginatedItems = $filteredResults->forPage($currentPage, $perPage);

            return response()->json([
                'data' => $paginatedItems->values(),
                'total' => count($filteredResults),
                'per_page' => $perPage,
                'current_page' => $currentPage,
                'last_page' => ceil(count($filteredResults) / $perPage),
                'next_page_url' => '/api/movies?page=' . ($currentPage + 1),
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao realizar a solicitação da API', 'message' => $e->getMessage()], 500);
        }
    }

}