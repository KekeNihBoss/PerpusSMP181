<?php

namespace App\Http\Controllers;

use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $categories = Event::select('category')->distinct()->pluck('category');

        $events = Event::when(request('category'), function ($query) {
                $query->where('category', request('category'));
            })
            ->where('is_active', true)
            ->orderBy('event_date', 'desc')
            ->paginate(9);

        return view('blog.index', compact('events', 'categories'));
    }

public function show($slug)
{
    $event = Event::where('slug', $slug)->firstOrFail();

    $sessionKey = 'viewed_event_' . $event->id;

    if (!session()->has($sessionKey)) {
        $event->increment('views');
        session()->put($sessionKey, true);
    }

    $relatedEvents = Event::where('category', $event->category)
        ->where('id', '!=', $event->id)
        ->take(3)
        ->get();

    return view('blog.show', compact('event', 'relatedEvents'));
}

}
