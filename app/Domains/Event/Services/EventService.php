<?php

namespace App\Domains\Event\Services;

use App\Domains\Event\Models\Event;
use Illuminate\Support\Facades\DB;

class EventService
{
    public function create(array $data): Event
    {
        return DB::transaction(fn () => Event::create($data));
    }

    public function update(Event $event, array $data): Event
    {
        return DB::transaction(function () use ($event, $data) {
            $event->fill($data)->save();

            return $event->fresh();
        });
    }

    public function delete(Event $event): bool
    {
        return DB::transaction(function () use ($event) {
            $event->delete();

            return true;
        });
    }
}