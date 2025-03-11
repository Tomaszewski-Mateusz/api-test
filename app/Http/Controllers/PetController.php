<?php

namespace App\Http\Controllers;

use App\Services\PetService;
use Illuminate\Http\Request;

class PetController extends Controller
{
    protected $petService;

    public function __construct(PetService $petService)
    {
        $this->petService = $petService;
    }

    public function index()
    {
        $pets = $this->petService->getPets();
        return view('pet.index', compact('pets'));
    }

    public function create()
    {
        return view('pet.create');
    }

    public function store(Request $request)
    {
        $petData = $this->preparePetData($request);
        $pet = $this->petService->createPet($petData);

        return $pet
            ? redirect()->route('pet.index')->with('success', 'Pet created successfully.')
            : redirect()->back()->with('error', 'Failed to create pet.');
    }

    public function show($id)
    {
        $pet = $this->petService->getPet($id);

        if ($pet) {
            return view('pet.show', compact('pet'));
        } else {
            return redirect()->route('pet.index')->with('error', 'Pet not found.');
        }
    }

    public function edit($id)
    {
        $pet = $this->petService->getPet($id);

        if ($pet) {
            return view('pet.edit', compact('pet'));
        } else {
            return redirect()->route('pet.index')->with('error', 'Pet not found.');
        }
    }

    public function update(Request $request, $id)
    {
        $petData = $this->preparePetData($request);
        $petData['id'] = $id;
        $updatedPet = $this->petService->updatePet($petData);

        return $updatedPet
            ? redirect()->route('pet.index')->with('success', 'Pet updated successfully.')
            : redirect()->back()->with('error', 'Failed to update pet.');
    }

    public function destroy($id)
    {
        if ($this->petService->deletePet($id)) {
            return redirect()->route('pet.index')->with('success', 'Pet deleted successfully.');
        } else {
            return redirect()->route('pet.index')->with('error', 'Failed to delete pet.');
        }
    }
    private function preparePetData(Request $request): array
    {
        $data = $request->validate([
            'name' => 'required|string',
            'photoUrls' => 'nullable|string',
            'tags' => 'nullable|string',
            'status' => 'required|in:available,pending,sold',
            'category' => 'nullable|string',
        ]);

        $photoUrls = !empty($data['photoUrls']) ? explode(',', $data['photoUrls']) : [];

        $tags = [];
        if (!empty($data['tags'])) {
            $tagNames = explode(',', $data['tags']);
            foreach ($tagNames as $tagName) {
                $tags[] = ['id' => 0, 'name' => trim($tagName)];
            }
        }

        $category = !empty($data['category'])
            ? ['id' => 0, 'name' => trim($data['category'])]
            : null;

        return [
            'name' => $data['name'],
            'photoUrls' => $photoUrls,
            'tags' => $tags,
            'category' => $category,
            'status' => $data['status'],
        ];
    }
}
