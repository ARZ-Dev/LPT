<div>

    <form wire:submit.prevent="submit">

        <div wire:ignore class="card">
            <div class="card-header border-bottom d-flex justify-content-between">
                <h4 class="card-title mb-3">{{ $category->tournament->name }} - {{ $category->levelCategory?->name }} - Groups</h4>
                <a class="btn btn-primary h-50" href="{{ route('tournaments-categories.edit', [$category->tournament_id, $category->id]) }}">{{ $category->levelCategory?->name }} Category</a>
            </div>
            <div class="table-responsive">
                <table class="dt-row-grouping table border-top">
                    <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Team</th>
                        <th class="text-center">Matches Played</th>
                        <th class="text-center">Rank</th>
                        <th class="text-center">Wins</th>
                        <th class="text-center">Losses</th>
                        <th class="text-center">Score</th>
                        <th class="text-center">Qualified</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($category->groups as $group)
                        <tr class="group bg-light text-center">
                            <td colspan="9">
                                {{ $group->name }}
                            </td>
                        </tr>
                        @foreach($group->groupTeams as $groupTeam)
                            <tr>
                                <td class="text-center">
                                    {{ $groupTeam->id }}
                                </td>
                                <td class="text-center">
                                    {{ $groupTeam->team?->nickname }}
                                </td>
                                <td class="text-center">
                                    {{ $groupTeam->matches_played }}
                                </td>
                                <td class="text-center">
                                    {{ $groupTeam->rank }}
                                </td>
                                <td class="text-center">
                                    {{ $groupTeam->wins }}
                                </td>
                                <td class="text-center">
                                    {{ $groupTeam->losses }}
                                </td>
                                <td class="text-center">
                                    {{ $groupTeam->score }}
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-label-{{ $groupTeam->has_qualified ? "info" : "warning" }}">
                                        {{ $groupTeam->has_qualified ? "Qualified" : "Not Qualified" }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($group->qualification_status == "draw" && in_array($groupTeam->team_id, json_decode($group->drawn_teams_ids ?? [])))
                                        <input wire:click="toggleQualifyTeam({{ $group->id }}, {{ $groupTeam->team_id }})" type="radio" name="qualified-team-{{ $group->id }}" class="form-check-input">
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-12 text-end mt-4">
            <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
        </div>
    </form>

    @script
    @include('livewire.deleteConfirm')
    @endscript

    @script
    <script>

    </script>
    @endscript

</div>
