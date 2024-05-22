<?php

namespace App\Livewire\Tournaments;

use App\Models\Currency;
use App\Models\LevelCategory;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\TournamentLevelCategory;
use App\Models\TournamentLevelCategoryTeam;
use App\Models\TournamentType;
use App\Rules\EvenNumber;
use App\Utils\Constants;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\RequiredIf;
use Livewire\Component;

class TournamentForm extends Component
{
    public bool $editing = false;
    public $levelCategories = [];
    public $status;

    public $tournament = null;
    public $teams;

    // form data
    public $name;
    public array $selectedCategoriesIds = [];
    public $startDate;
    public $endDate;
    public bool $is_free = true;

    public array $categoriesInfo = [];
    public array $subscriptionFees = [];
    public $defaultCurrency;

    public $currencies = [];
    public $submitting = false;

    public function mount($id = 0, $status = 0)
    {
        $this->levelCategories = LevelCategory::has('teams')->get();
        $this->teams = Team::with('players')->get();
        $this->status = $status;
        $this->currencies = Currency::all();
        $this->defaultCurrency = Currency::where('is_default', true)->first();

        if ($id) {

            if ($id == Constants::VIEW_STATUS) {
                $this->authorize('tournament-view');
            } else {
                $this->authorize('tournament-edit');
            }

            $this->tournament = Tournament::with(['createdBy',
                    'levelCategories.levelCategory' => ['teams']
                ])->findOrFail($id);
            $this->editing = true;
            $this->name = $this->tournament->name;
            $this->startDate = $this->tournament->start_date;
            $this->endDate = $this->tournament->end_date;
            $this->is_free = $this->tournament->is_free;
            $levelCategories = $this->tournament->levelCategories;
            $this->selectedCategoriesIds = $levelCategories->pluck('level_category_id')->toArray();

            foreach ($levelCategories as $levelCategory) {
                $this->subscriptionFees[$levelCategory->level_category_id][$this->defaultCurrency->id] = $levelCategory->subscription_fee;
                $this->getExchangedFees($levelCategory->level_category_id);
            }

        } else {
            $this->authorize('tournament-create');
        }
    }

    public function getExchangedFees($categoryId)
    {
        foreach ($this->currencies as $currency) {
            $fee = empty($this->subscriptionFees[$categoryId][$this->defaultCurrency->id]) ? 0 : $this->subscriptionFees[$categoryId][$this->defaultCurrency->id];
            $fee = sanitizeNumber($fee);

            if (!$currency->is_default) {
                $exchangedFee = $fee / $currency->rate;
                $this->subscriptionFees[$categoryId][$currency->id] = number_format($exchangedFee, 2);
            }
        }
    }

    public function rules()
    {
        $data = [
            'name' => ['required', 'max:255', Rule::unique('tournaments', 'id')->ignore($this->tournament?->id)],
            'selectedCategoriesIds' => ['required', 'array', 'min:1'],
            'startDate' => ['required', 'date'],
            'endDate' => ['required', 'date', 'after_or_equal:startDate'],
        ];

        if (!$this->is_free && auth()->user()->hasPermissionTo('tournament-setSubscriptionFees')) {
            $data['subscriptionFees'] = ['required', 'array', 'min:1'];
            foreach ($this->selectedCategoriesIds ?? [] as $categoryId) {
                $data['subscriptionFees.'. $categoryId . '.' . $this->defaultCurrency->id] = ['required', 'numeric'];
            }
        }

        return $data;
    }

    public function store()
    {
        $this->validate();

        if ($this->submitting) {
            return false;
        }
        $this->submitting = true;

        $tournament = Tournament::create([
            'created_by' => auth()->id(),
            'name' => $this->name,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'is_free' => $this->is_free,
        ]);

        foreach ($this->selectedCategoriesIds as $categoryId) {
            $tournament->levelCategories()->create([
                'level_category_id' => $categoryId,
                'subscription_fee' => $this->is_free ? 0 : ($this->subscriptionFees[$categoryId][$this->defaultCurrency->id] ?? 0),
                'start_date' => $this->startDate,
                'end_date' => $this->endDate,
            ]);
        }

        return to_route('tournaments-categories', $tournament->id)->with('success', 'Tournament has been created successfully!');
    }

    public function update()
    {
        $this->validate();

        DB::beginTransaction();
        try {

            $this->tournament->update([
                'name' => $this->name,
                'start_date' => $this->startDate,
                'end_date' => $this->endDate,
                'is_free' => $this->is_free,
            ]);

            $categoriesIds = [];
            foreach ($this->selectedCategoriesIds as $categoryId) {
                $levelCategory = TournamentLevelCategory::updateOrCreate([
                    'tournament_id' => $this->tournament->id,
                    'level_category_id' => $categoryId,
                ],[
                    'subscription_fee' => $this->is_free ? 0 : ($this->subscriptionFees[$categoryId][$this->defaultCurrency->id] ?? 0),
                    'start_date' => $this->startDate,
                    'end_date' => $this->endDate,
                ]);

                $categoriesIds[] = $levelCategory->id;
            }
            $removedCategories = TournamentLevelCategory::where('tournament_id', $this->tournament->id)->whereNotIn('id', $categoriesIds)->get();
            throw_if($removedCategories->firstWhere('is_group_matches_generated', true) || $removedCategories->firstWhere('is_knockout_matches_generated', true), new \Exception("You cannot delete a category that have pending matches!"));

            $removedCategories->each->delete();

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->dispatch('swal:error', [
                'title' => 'Error!',
                'text'  => $exception->getMessage(),
            ]);
        }

        return to_route('tournaments-categories', $this->tournament->id)->with('success', 'Tournament has been updated successfully!');
    }

    public function render()
    {
        if ($this->status == Constants::VIEW_STATUS) {
            return view('livewire.tournaments.tournament-view');
        }
        return view('livewire.tournaments.tournament-form');
    }
}
