<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class PetService
{
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://petstore.swagger.io/v2/',
            'retries' => 3,
            'delay' => 100,
        ]);
    }


    public function getPets(array $status = ['available', 'pending', 'sold'])
    {
        try {
            $response = $this->client->get('pet/findByStatus', [
                'query' => ['status' => implode(',', $status)],
            ]);

            return json_decode($response->getBody(), true);
        } catch (ClientException $e) {
            Log::error('Error fetching pets: ' . $e->getMessage());
            return null;
        }
    }

    public function getPet(int $id)
    {
        try {
            $response = $this->client->get("pet/{$id}");

            return json_decode($response->getBody(), true);
        } catch (ClientException $e) {
            Log::error('Error fetching pet: ' . $e->getMessage());
            return null;
        }
    }

    public function createPet(array $data)
    {
        try {
            $response = $this->client->post('pet', ['json' => $data]);

            return json_decode($response->getBody(), true);
        } catch (ClientException $e) {
            Log::error('Error creating pet: ' . $e->getMessage());
            return null;
        }
    }

    public function updatePet(array $data)
    {
        try {
            $response = $this->client->put('pet', ['json' => $data]);

            return json_decode($response->getBody(), true);
        } catch (ClientException $e) {
            Log::error('Error updating pet: ' . $e->getMessage());
            return null;
        }
    }

    public function deletePet(int $id): bool
    {
        try {
            $response = $this->client->delete("pet/{$id}");

            return $response->getStatusCode() === 200;
        } catch (RequestException $e) {
            Log::error('Error deleting pet: ' . $e->getMessage());
            return false;
        }
    }

}
