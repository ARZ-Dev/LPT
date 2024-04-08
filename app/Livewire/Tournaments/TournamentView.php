<?php

namespace App\Livewire\Tournaments;

use App\Models\Game;
use App\Models\Group;
use App\Models\KnockoutRound;
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
                $nbOfTeams = $category->number_of_teams;
                $teamsIds = $category->teams->pluck('team_id')->toArray();
                $teams = Team::find($teamsIds);

                if ($category->has_group_stage) {
                    $numberOfGroups = $category->number_of_groups;
                    $teamsPerGroup = ceil($nbOfTeams / $numberOfGroups);

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
                                    'type' => 'group_stages',
                                    'group_id' => $group->id,
                                    'home_team_id' => $teamIds[$j],
                                    'away_team_id' => $teamIds[$k],
                                ]);
                            }
                        }
                    }
                } else {
                    $rounds = ceil(log($nbOfTeams, 2));

                    for ($i = 1; $i <= $rounds; $i++) {
                        $roundName = match ($nbOfTeams) {
                            2 => 'Final',
                            4 => 'Semi Final',
                            8 => 'Quarter Final',
                            default => 'Round of ' . $nbOfTeams,
                        };

                        $knockoutRound = KnockoutRound::updateOrCreate([
                            'tournament_level_category_id' => $category->id,
                            'name' => $roundName,
                        ]);

                        // Generate matches for the current knockout round
                        while ($teams->count() >= 2) {
                            // Take two teams from the top of the teams list
                            $homeTeam = $teams->shift();
                            $awayTeam = $teams->shift();

                            // Create a match for the current knockout round
                            Game::create([
                                'type' => 'knockouts',
                                'knockout_round_id' => $knockoutRound->id,
                                'home_team_id' => $homeTeam->id,
                                'away_team_id' => $awayTeam->id,
                            ]);
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

    
    #[On('knockoutRound')]
    public function knockoutRound($id)
    {
        $winnerTeamsIds = Game::with(['knockoutRound.tournamentLevelCategory' => function ($query) use ($id) {
            $query->where('tournament_id', $id);
        }])->where('is_completed', 1)->pluck('winner_team_id')->ToArray();
        
        $winnerTeamsCount = count($winnerTeamsIds) /2;

        $game = Game::with(['knockoutRound.tournamentLevelCategory' => function ($query) use ($id) {
            $query->where('tournament_id', $id);
        }])->where('is_completed', 1)->first();

        
        $knockout_round_id = $game->knockout_round_id;
        
        for($i=0; $i <= $winnerTeamsCount; $i = $i +2) {
            $team1_id = $winnerTeamsIds[$i];
            $team2_id = $winnerTeamsIds[$i + 1];

            Game::create([
                'type'=>"knockouts",
                'knockout_round_id'=>$knockout_round_id + 1,
                'home_team_id'=>$team1_id,
                'away_team_id'=>$team2_id,
            ]);
        }
    

    }

    public function render()
    {
        return view('livewire.tournaments.tournament-index');
    }
}
