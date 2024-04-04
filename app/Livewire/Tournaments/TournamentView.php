<?php

namespace App\Livewire\Tournaments;

use App\Models\Game;
use App\Models\Group;
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
            $tournament = Tournament::with(['levelCategories' => ['teams']])->findOrFail($tournamentId);

            foreach ($tournament->levelCategories as $category) {
                if ($category->has_group_stage) {
                    $nbOfTeams = $category->number_of_teams;
                    $numberOfGroups = $category->number_of_groups;
                    $teamsPerGroup = ceil($nbOfTeams / $numberOfGroups);

                    $teamsIds = $category->teams->pluck('team_id')->toArray();
                    $teams = Team::find($teamsIds);
                    $shuffledTeams = $teams->shuffle();

                    for ($i = 1; $i <= $numberOfGroups; $i++) {
                        $group = Group::create([
                            'tournament_level_category_id' => $category->id,
                            'name' => 'Group ' . $i,
                        ]);

                        $groupTeams = $shuffledTeams->splice(0, $teamsPerGroup);
                        $group->teams()->attach($groupTeams);

                        // Generate matches for each group
                        $teamIds = $group->teams()->pluck('teams.id');
                        $teamCount = count($teamIds);

                        for ($j = 0; $j < $teamCount - 1; $j++) {
                            for ($k = $j + 1; $k < $teamCount; $k++) {
                                Game::create([
                                    'type' => 'group_stage',
                                    'group_id' => $group->id,
                                    'home_team_id' => $teamIds[$j],
                                    'away_team_id' => $teamIds[$k],
                                ]);
                            }
                        }
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

        return to_route('tournaments')->with('success', 'Matches has been generated successfully!');
    }

    public function render()
    {
        return view('livewire.tournaments.tournament-index');
    }
}
