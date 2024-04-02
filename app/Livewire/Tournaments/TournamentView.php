<?php

namespace App\Livewire\Tournaments;

use App\Models\Group;
use App\Models\GroupTeam;
use App\Models\Team;
use App\Models\Tournament;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class TournamentView extends Component
{
    public $tournaments = [];

    public function mount()
    {
        $this->authorize('tournament-list');
        $this->tournaments = Tournament::all();
    }

    #[On('delete')]
    public function delete($id)
    {
        $this->authorize('tournament-delete');

        $tournament = Tournament::with('levelCategories')->findOrFail($id);

        $tournament->levelCategories->each->delete();

        $tournament->delete();

        return to_route('tournaments')->with('success', 'Tournament has been deleted successfully!');
    }

    #[On('generateMatches')]
    public function generateMatches($tournamentId)
    {
        DB::beginTransaction();
        try {
            $tournament = Tournament::with([
                'levelCategories' => ['teams']
            ])->findOrFail($tournamentId);

            foreach ($tournament->levelCategories as $category) {
                if ($category->has_group_stage) {
                    $nbOfTeams = $category->number_of_teams;
                    $teamsPerGroup = 3; // Adjust this according to your preference
                    $numberOfGroups = ceil($nbOfTeams / $teamsPerGroup);

                    $teamsIds = $category->teams->pluck('team_id')->toArray();
                    $teams = Team::find($teamsIds);
                    $shuffledTeams = $teams->shuffle();

                    $groups = [];
                    for ($i = 1; $i <= $numberOfGroups; $i++) {
                        $groups[$i] = Group::create([
                            'tournament_level_category_id' => $category->id,
                            'name' => 'Group ' . $i,
                        ]);
                        $groupTeams = $shuffledTeams->splice(0, $teamsPerGroup);
                        $groups[$i]->teams()->attach($groupTeams);
                    }
                }
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->dispatch('swal:error', [
                'title' => 'Error!',
                'text'  => $exception->getMessage(),
            ]);
        }
    }

    public function render()
    {
        return view('livewire.tournaments.tournament-index');
    }
}
