<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
class HandPlayed implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public string $player;
    public string $hand;

    public function __construct(string $player, string $hand)
    {
        $this->player = $player;
        $this->hand = $hand;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('janken'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'HandPlayed';
    }
}