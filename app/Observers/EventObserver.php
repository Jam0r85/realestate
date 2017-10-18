<?php

namespace App\Observers;

use App\Event;

class EventObserver
{
    /**
     * Listen to the event deleting event.
     * 
     * @param event $event
     */
    public function deleting(Event $event)
    {
        $event::disableSearchSyncing();
    }

    /**
     * Listen to the event deleted event.
     * 
     * @param event $event
     */
    public function deleted(Event $event)
    {
        $event::enableSearchSyncing();
        $event->searchable();
    }
}