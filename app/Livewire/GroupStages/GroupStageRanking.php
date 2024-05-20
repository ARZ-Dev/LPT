<?php

namespace App\Livewire\GroupStages;

use App\Models\Group;
use App\Models\GroupTeam;
use App\Models\TournamentLevelCategory;
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
        $this->qualifiedTeams[$groupId] = $teamId;
    }

    public function rules()
    {
        return [
            'qualifiedTeams' => ['required', 'min:1'],
        ];
    }

    public function submit()
    {
        foreach ($this->qualifiedTeams as $groupId => $teamId) {
            GroupTeam::where('group_id', $groupId)->where('team_id', $teamId)->update([
                'has_qualified' => true,
            ]);

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

        return to_route('group-stages.rankings', $this->category->id)->with('success', 'Teams has been qualified successfully!');
    }

    public function render()
    {
        return view('livewire.group-stages.group-stage-ranking');
    }
}
