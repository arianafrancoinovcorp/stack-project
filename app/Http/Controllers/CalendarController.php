<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Entity;
use App\Models\User;
use App\Models\CalendarType;
use App\Models\CalendarAction;
use App\Models\CalendarKnowledge;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::with(['type', 'user', 'entity']);

        // Filtro por utilizador
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filtro por entidade
        if ($request->filled('entity_id')) {
            $query->where('entity_id', $request->entity_id);
        }

        $activities = $query->get();

        // Para os filtros
        $users = User::all();
        $entities = Entity::all();

        return view('calendar.index', compact('activities', 'users', 'entities'));
    }

    public function events(Request $request)
{
    $query = Activity::with(['type', 'user', 'entity']);

    // Filtros
    if ($request->filled('user_id')) {
        $query->where('user_id', $request->user_id);
    }

    if ($request->filled('entity_id')) {
        $query->where('entity_id', $request->entity_id);
    }

    $activities = $query->get();

    $events = $activities->map(function($activity) {
        // Formatar a data corretamente
        $date = \Carbon\Carbon::parse($activity->date)->format('Y-m-d');
        $time = $activity->time ?? '00:00:00';
        
        $startDateTime = $date . 'T' . $time;
        $endDateTime = \Carbon\Carbon::parse($date . ' ' . $time)
            ->addMinutes($activity->duration ?? 60)
            ->format('Y-m-d\TH:i:s');
        
        return [
            'id' => $activity->id,
            'title' => $activity->description ?: ($activity->type->name ?? 'Activity'),
            'start' => $startDateTime,
            'end' => $endDateTime,
            'color' => $activity->status === 'done' ? '#34D399' : '#3B82F6',
            'url' => route('calendar.edit', $activity->id)
        ];
    });

    return response()->json($events);
}

    public function create()
    {
        $users = User::all();
        $entities = Entity::all();
        $types = CalendarType::all();
        $actions = CalendarAction::all();
        $knowledges = CalendarKnowledge::all();

        return view('calendar.form', compact('users', 'entities', 'types', 'actions', 'knowledges'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'duration' => 'required|integer',
            'user_id' => 'required|exists:users,id',
            'knowledge_id' => 'nullable|exists:calendar_knowledges,id',
            'entity_id' => 'nullable|exists:entities,id',
            'type_id' => 'nullable|exists:calendar_types,id',
            'action_id' => 'nullable|exists:calendar_actions,id',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,done',
            'shared' => 'nullable|boolean'
        ]);

        Activity::create($data);

        return redirect()->route('calendar.index')->with('success', 'Activity created successfully.');
    }

    public function edit(Activity $activity)
    {
        $users = User::all();
        $entities = Entity::all();
        $types = CalendarType::all();
        $actions = CalendarAction::all();
        $knowledges = CalendarKnowledge::all();

        return view('calendar.form', compact('activity', 'users', 'entities', 'types', 'actions', 'knowledges'));
    }

    public function update(Request $request, Activity $activity)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'duration' => 'required|integer',
            'user_id' => 'required|exists:users,id',
            'knowledge_id' => 'nullable|exists:calendar_knowledges,id',
            'entity_id' => 'nullable|exists:entities,id',
            'type_id' => 'nullable|exists:calendar_types,id',
            'action_id' => 'nullable|exists:calendar_actions,id',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,done',
            'shared' => 'nullable|boolean'
        ]);

        $activity->update($data);

        return redirect()->route('calendar.index')->with('success', 'Activity updated successfully.');
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();
        return redirect()->route('calendar.index')->with('success', 'Activity deleted successfully.');
    }
}