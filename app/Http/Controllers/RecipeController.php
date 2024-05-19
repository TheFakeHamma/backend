<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class RecipeController extends Controller
{
    public function getRecipes(Request $request)
    {
        $query = $request->query('q');

        if ($query) {
            return $this->getApiRecipes($query);
        } else {
            return $this->getRandomRecipes();
        }
    }

    private function getApiRecipes($query)
    {
        $client = new Client();
        $options = [
            'query' => [
                'type' => 'public',
                'q' => $query,
                'app_id' => env('EDAMAM_APP_ID'),
                'app_key' => env('EDAMAM_APP_KEY'),
            ],
        ];

        // SSL disabled for local development
        if (env('DISABLE_SSL_VERIFICATION', false)) {
            $options['verify'] = false;
        }

        try {
            $response = $client->get('https://api.edamam.com/api/recipes/v2', $options);

            return response()->json(json_decode($response->getBody(), true));
        } catch (RequestException $e) {
            $statusCode = $e->hasResponse() ? $e->getResponse()->getStatusCode() : 500;
            $errorDetails = [];

            if ($e->hasResponse()) {
                $responseBody = $e->getResponse()->getBody()->getContents();
                $errorDetails = json_decode($responseBody, true);
            }

            Log::error('RequestException: ' . $e->getMessage(), ['details' => $errorDetails]);

            return response()->json([
                'error' => 'Unable to fetch recipes',
                'message' => $e->getMessage(),
                'details' => $errorDetails
            ], $statusCode);
        } catch (\Exception $e) {
            Log::error('Exception: ' . $e->getMessage());

            return response()->json([
                'error' => 'Unexpected error occurred',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    private function getRandomRecipes()
    {
        $queries = ['chicken', 'beef', 'pasta', 'salad', 'soup', 'dessert', 'fish', 'vegetarian'];
        $randomQuery = $queries[array_rand($queries)];
        
        return $this->getApiRecipes($randomQuery);
    }
}
