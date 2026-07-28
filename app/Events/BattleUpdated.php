<?php

namespace App\Events;

use App\Models\Battle;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BattleUpdated implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $battle;

    public function __construct(Battle $battle)
    {
        $this->battle = $battle;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel(
                'battle.' . $this->battle->room_id
            ),
        ];
    }

    public function broadcastAs(): string
    {
        return 'BattleUpdated';
    }
}