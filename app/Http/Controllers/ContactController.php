<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Entity;
use App\Models\ContactFunction;

class ContactController extends Controller
{
    // Index list
    public function index(Request $request)
    {
        $contacts = Contact::with(['entity','function'])
            ->when($request->entity_id, fn($q) => $q->where('entity_id', $request->entity_id))
            ->when($request->function_id, fn($q) => $q->where('function_id', $request->function_id))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->orderBy('id','desc')
            ->paginate(20);

        $entities = Entity::orderBy('name')->get();
        $functions = ContactFunction::orderBy('name')->get();

        return view('contacts.index', compact('contacts','entities','functions'));
    }

    // Create
    public function create()
    {
        $entities = Entity::orderBy('name')->get();
        $functions = ContactFunction::orderBy('name')->get();
        return view('contacts.create', compact('entities','functions'));
    }

    // Store new
    public function store(Request $request)
    {
        $validated = $request->validate([
            'entity_id' => 'required|exists:entities,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'function_id' => 'nullable|exists:contact_functions,id',
            'phone' => 'nullable|string|max:20',
            'mobile' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'rgpd_consent' => 'boolean',
            'notes' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        Contact::create($validated);

        return redirect()->route('contacts.index')
            ->with('success','Contact created successfully.');
    }

    // Edit
    public function edit(Contact $contact)
    {
        $entities = Entity::orderBy('name')->get();
        $functions = ContactFunction::orderBy('name')->get();
        return view('contacts.edit', compact('contact','entities','functions'));
    }

    // Update
    public function update(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'entity_id' => 'required|exists:entities,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'function_id' => 'nullable|exists:contact_functions,id',
            'phone' => 'nullable|string|max:20',
            'mobile' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'rgpd_consent' => 'boolean',
            'notes' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $contact->update($validated);

        return redirect()->route('contacts.index')
            ->with('success','Contact updated successfully.');
    }

    // Remove contact
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('contacts.index')
            ->with('success','Contact deleted successfully.');
    }
}
