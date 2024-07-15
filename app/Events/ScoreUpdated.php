<?php

namespace App\Events;

use App\Models\Game;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\View;

class ScoreUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $matchId;
    public $scoreBoardHtml;

    /**
     * Create a new event instance.
     */
    public function __construct($matchId)
    {
        $this->matchId = $matchId;

        $match = Game::with(['homeTeam', 'awayTeam', 'sets' => ['setGames'], 'setGames'])->find($matchId);
        $this->scoreBoardHtml = View::make('frontend.partials.match-score-board', compact('match'))->render();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('match' . $this->matchId)
        ];
    }

    public function broadcastAs()
    {
        return 'score.updated';
    }
}
