<?php

namespace App\Livewire\GroupStages;

use App\Models\Group;
use App\Models\GroupTeam;
use App\Models\TournamentLevelCategory;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class GroupStageRanking extends Component
{
    public $category;
    public $groupStage;
    public $qualifiedTeams = [];

    public function mount($categoryId)
    {
        $this->category = TournamentLevelCategory::with(['groups' => ['groupTeams' => function ($query) {
            $query->orderBy('rank');
        }]])->findOrFail($categoryId);
    }

    public function toggleQualifyTeam($groupId, $teamId)
    {
        if (in_array($teamId, $this->qualifiedTeams[$groupId] ?? [])) {
            $index = array_search($teamId, $this->qualifiedTeams[$groupId]);
            unset($this->qualifiedTeams[$groupId][$index]);
        } else {
            $this->qualifiedTeams[$groupId][] = $teamId;
        }
    }

    public function rules()
    {
        return [
            'qualifiedTeams.*' => ['required', 'array', 'min:1', 'max:' . $this->category->number_of_winners_per_group],
        ];
    }

    public function submit()
    {
        $this->validate();

        DB::beginTransaction();
        try {

            foreach ($this->qualifiedTeams as $groupId => $teamsIds) {
                GroupTeam::where('group_id', $groupId)->whereIn('team_id', $teamsIds)->update([
                    'has_qualified' => true,
                ]);

                $qualifiedTeamsCount = GroupTeam::where('group_id', $groupId)->where('has_qualified', true)->count();
                throw_if($qualifiedTeamsCount > $this->category->number_of_winners_per_group, new \Exception("Only " . $this->category->number_of_winners_per_group . " must qualify from each group!"));

                Group::where('id', $groupId)->update([
                    'is_completed' => true,
                    'qualification_status' => 'completed',
                ]);
            }

            $groupsCount = Group::where('tournament_level_category_id', $this->category->id)->count();
            $completedGroupsCount = Group::where('tournament_level_category_id', $this->category->id)->where('is_completed', true)->count();

            if ($completedGroupsCount == $groupsCount) {
                $this->category->update(['is_group_stages_completed' => true]);

                $this->category->groupStage->update([
                    'is_completed' => true,
                ]);
            }


            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            $this->dispatch('swal:error', [
                'title' => 'Error!',
                'text'  => $exception->getMessage(),
            ]);
        }

        return to_route('group-stages.rankings', $this->category->id)->with('success', 'Teams has been qualified successfully!');
    }

    public function render()
    {
        return view('livewire.group-stages.group-stage-ranking');
    }
}
