<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entity;
use App\Models\Country;
use App\Models\Type;

class EntityController extends Controller
{
    // Index
    public function index(Request $request)
    {
        $type = $request->get('type', 'client');
        $search = $request->get('search', '');

        $query = Entity::with('country', 'types')
            ->whereHas('types', fn ($q) => $q->where('name', $type));

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('nif', 'like', "%$search%")
                    ->orWhere('phone', 'like', "%$search%")
                    ->orWhere('mobile', 'like', "%$search%");
            });
        }

        $entities = $query
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('entities.index', compact('entities', 'type', 'search'));
    }

    // Create
    public function create(Request $request)
    {
        $countries = Country::orderBy('name')->get();
        $types = Type::orderBy('name')->get();

        return view('entities.create', [
            'entity' => new Entity(),
            'countries' => $countries,
            'types' => $types,
            'mode' => 'create',
        ]);
    }

    // Store
    public function store(Request $request)
    {
        $validated = $request->validate([
            'types' => 'required|array|min:1',
            'types.*' => 'exists:types,id',

            'nif' => 'required|unique:entities,nif',
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:10',
            'city' => 'nullable|string|max:255',
            'country_id' => 'nullable|exists:countries,id',
            'phone' => 'nullable|string|max:20',
            'mobile' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'email' => 'nullable|email|max:255',
            'rgpd_consent' => 'boolean',
            'notes' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        // separar types (pivot)
        $types = $validated['types'];
        unset($validated['types']);

        // criar entity
        $entity = Entity::create($validated);

        // sync pivot
        $entity->types()->sync($types);

        $firstType = Type::find($types[0])->name ?? 'client';

        return redirect()
            ->route('entities.index', ['type' => $firstType])
            ->with('success', 'Entity created successfully.');
    }

    // Edit
    public function edit(Entity $entity)
    {
        $countries = Country::orderBy('name')->get();
        $types = Type::orderBy('name')->get();
        $entity->load('types');
        $mode = 'edit';

        return view('entities.edit', compact('entity', 'countries', 'types', 'mode'));
    }

    // Update
    public function update(Request $request, Entity $entity)
    {
        $validated = $request->validate([
            'types' => 'required|array|min:1',
            'types.*' => 'exists:types,id',

            'nif' => 'required|unique:entities,nif,' . $entity->id,
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:10',
            'city' => 'nullable|string|max:255',
            'country_id' => 'nullable|exists:countries,id',
            'phone' => 'nullable|string|max:20',
            'mobile' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'email' => 'nullable|email|max:255',
            'rgpd_consent' => 'boolean',
            'notes' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        // separar types (pivot)
        $types = $validated['types'];
        unset($validated['types']);

        // update entity
        $entity->update($validated);

        // sync pivot
        $entity->types()->sync($types);

        $redirectType = $entity->types->first()->name ?? 'client';

        return redirect()
            ->route('entities.index', ['type' => $redirectType])
            ->with('success', 'Entity updated successfully.');
    }

    // Delete
    public function destroy(Entity $entity)
    {
        $entity->delete();

        return redirect()
            ->route('entities.index')
            ->with('success', 'Entity deleted successfully.');
    }
}
