<?php

namespace App\Livewire\Pcash;


use App\Models\Category;
use App\Models\Currency;
use App\Models\Receipt;
use App\Models\ReceiptAmount;
use App\Models\SubCategory;
use App\Models\Team;
use App\Models\Till;
use App\Models\TillAmount;
use App\Models\Tournament;
use App\Models\TournamentLevelCategory;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Utils\Constants;


class ReceiptForm extends Component
{
    use AuthorizesRequests;

    public $editing = false;
    public int $status;
    public $users;
    public $currencies;
    public $receipt;
    public $tills;
    public $till_id;
    public $user_id;
    public $category_id;
    public $sub_category_id;
    public $selectedSubCategory;
    public $paid_by;
    public $description;
    public $tournament_id;
    public $team_id;
    public  $receiptAmounts = [];
    public $categories = [];
    public $subCategories = [];
    public $tournaments = [];
    public $teams = [];
    public bool $submitting = false;
    public $defaultCurrency;

    protected $listeners = ['store', 'update'];

    public function mount($id = 0, $status = 0)
    {
        $this->status = $status;

        $this->currencies = Currency::all();

        $this->defaultCurrency = Currency::where('is_default', true)->first();

        $this->tills = Till::when(!auth()->user()->hasPermissionTo('till-viewAll'), function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->get();

        $this->categories = Category::when(!auth()->user()->hasPermissionTo('category-viewAll'), function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->where('type', 'receipt')
            ->get();

        $this->tournaments = Tournament::where('is_completed',false)
            ->whereDoesntHave('levelCategories', function ($query) {
                $query->where('is_group_matches_generated', true)
                    ->orWhere('is_knockout_matches_generated', true);
            })
            ->get();

        $this->teams = Team::with('levelCategory')->get();

        $this->addRow();

        if ($id) {
            if ($status && $status == Constants::VIEW_STATUS) {
                $this->authorize('receipt-view');
            } else {
                $this->authorize('receipt-edit');
            }

            $this->editing = true;
            $this->receipt = Receipt::with('receiptAmounts')->findOrFail($id);
            $this->authorize('view',$this->receipt);

            $this->till_id = $this->receipt->till_id;
            $this->category_id = $this->receipt->category_id;
            $this->subCategories = SubCategory::where('category_id', $this->category_id)->get();
            $this->sub_category_id = $this->receipt->sub_category_id;
            $this->selectedSubCategory = $this->subCategories->where('id', $this->sub_category_id)->first();
            $this->paid_by = $this->receipt->paid_by;
            $this->description = $this->receipt->description;
            $this->tournament_id = $this->receipt->tournament_id;
            $this->team_id = $this->receipt->team_id;

            $this->receiptAmounts = [];
            foreach($this->receipt->receiptAmounts as $receiptAmount) {
                $this->receiptAmounts[] = [
                    'id' => $receiptAmount->id,
                    'receipt_id' => $receiptAmount->receipt_id,
                    'currency_id' => $receiptAmount->currency_id,
                    'amount' => number_format($receiptAmount->amount),
                ];
            }
        } else {
            $this->authorize('receipt-create');

            if (count($this->tills) == 1) {
                $this->till_id = $this->tills[0]->id;
            }

            if (count($this->categories) == 1) {
                $this->category_id = $this->categories[0]->id;
                $this->subCategories = SubCategory::where('category_id', $this->category_id)->get();

                if (count($this->subCategories) == 1) {
                    $this->sub_category_id = $this->subCategories[0]->id;
                }
            }

        }

    }

    public function getSubscriptionFee()
    {
        $team = Team::with('levelCategory')->find($this->team_id);
        $tournamentCategory = TournamentLevelCategory::where('tournament_id', $this->tournament_id)->where('level_category_id', $team->level_category_id)->first();
        $subscriptionFee = $tournamentCategory?->subscription_fee;
        if ($subscriptionFee) {
            $this->receiptAmounts = [
                [
                    'amount' => number_format($subscriptionFee, 2),
                    'currency_id' => $this->defaultCurrency->id,
                ]
            ];
        }
    }

    #[On('updateSubscriptionFee')]
    public function updateSubscriptionFee($key)
    {
        $subCategory = SubCategory::with('category')->find($this->sub_category_id);
        if ($subCategory->name == "Team") {
            $currencyId = $this->receiptAmounts[$key]['currency_id'];
            $team = Team::with('levelCategory')->find($this->team_id);
            $tournamentCategory = TournamentLevelCategory::where('tournament_id', $this->tournament_id)->where('level_category_id', $team->level_category_id)->first();
            $subscriptionFee = $tournamentCategory?->subscription_fee;
            if ($subscriptionFee) {
                if ($currencyId != $this->defaultCurrency->id) {
                    $currency = $this->currencies->where('id', $currencyId)->first();
                    $amount = $subscriptionFee / $currency?->rate;
                    $this->receiptAmounts[$key]['amount'] = number_format($amount, 2);
                } else {
                    $this->receiptAmounts = [
                        [
                            'amount' => number_format($subscriptionFee, 2),
                            'currency_id' => $this->defaultCurrency->id,
                        ]
                    ];
                }
            }
        }
    }

    #[On('getSubCategories')]
    public function getSubCategories()
    {
        $this->sub_category_id = null;
        $this->subCategories = SubCategory::where('category_id', $this->category_id)->get();

        $selectedSubCategoryId = null;
        if ($this->receipt) {
            $selectedSubCategoryId = $this->receipt->sub_category_id;
        } else {
            if (count($this->subCategories) == 1) {
                $selectedSubCategoryId = $this->subCategories[0]->id;
                $this->sub_category_id = $selectedSubCategoryId;
            }
        }
        $this->dispatch('refreshSubCategories', $this->subCategories, $selectedSubCategoryId);
    }

    protected function rules()
    {
        $data = [
            'till_id' => ['required'],
            'category_id' => ['required', new Exists('categories', 'id')],
            'sub_category_id' => ['required', new Exists('sub_categories', 'id')],
            'paid_by' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'receiptAmounts' => ['array', 'min:1'],
            'receiptAmounts.*.currency_id' => ['required', 'distinct'],
            'receiptAmounts.*.amount' => ['required'],
        ];

        $subCategory = SubCategory::find($this->sub_category_id);
        if ($subCategory?->name == "Team") {
            $data['tournament_id'] = ['required'];
            $data['team_id'] = ['required'];
        }

        return $data;
    }

    public function addRow()
    {
        $this->receiptAmounts[] = [
            'currency_id' => '',
            'amount' => ''
        ];
    }

    public function removeRow($key)
    {
        unset($this->receiptAmounts[$key]);
    }

    public function store()
    {
        $this->authorize('receipt-create');
        $this->validate();

        if($this->submitting) {
            return;
        }
        $this->submitting = true;

        DB::beginTransaction();
        try {

            checkMonthlyOpening($this->till_id);

            $subCategory = SubCategory::find($this->sub_category_id);

            $receipt = Receipt::create([
                'till_id' => $this->till_id,
                'user_id' => auth()->id(),
                'category_id' => $this->category_id,
                'sub_category_id' => $this->sub_category_id,
                'paid_by' => $this->paid_by,
                'description' => $this->description,
                'tournament_id' => $subCategory->name == "Team" ? $this->tournament_id : NULL,
                'team_id' => $subCategory->name == "Team" ? $this->team_id : NULL,
            ]);

            $receiptId = $receipt->id;
            foreach ($this->receiptAmounts as $receiptAmount) {
                ReceiptAmount::create([
                    'receipt_id' => $receiptId,
                    'currency_id' => $receiptAmount['currency_id'],
                    'amount' => sanitizeNumber($receiptAmount['amount']),
                ]);

                $this->updateTillsAmounts($receiptAmount);
            }

            DB::commit();

        } catch (\Exception $exception) {
            DB::rollBack();
            $this->submitting = false;

            return $this->dispatch('swal:error', [
                'title' => 'Error!',
                'text'  => $exception->getMessage(),
            ]);
        }

        return to_route('receipt')->with('success', 'receipt has been created successfully!');
    }


    public function update()
    {
        $this->authorize('receipt-edit');
        $this->validate();

        if($this->submitting) {
            return;
        }
        $this->submitting = true;

        DB::beginTransaction();
        try {

            $existingReceiptAmounts = ReceiptAmount::where('receipt_id', $this->receipt->id)->get();
            foreach ($existingReceiptAmounts as $existingReceiptAmount) {
                $tillAmount = TillAmount::where('till_id', $this->receipt->till_id)
                    ->where('currency_id', $existingReceiptAmount->currency_id)
                    ->first();

                if ($tillAmount) {
                    $updatedAmount = $tillAmount->amount - $existingReceiptAmount->amount;

                    $tillAmount->update([
                        'amount' => $updatedAmount,
                    ]);
                }
            }

            $this->receipt->update([
                'till_id' => $this->till_id,
                'category_id' => $this->category_id,
                'sub_category_id' => $this->sub_category_id,
                'paid_by' => $this->paid_by,
                'description' => $this->description,
                'tournament_id' => $this->tournament_id,
                'team_id' => $this->team_id,

            ]);

            $receiptAmountsIds = [];
            foreach ($this->receiptAmounts as $receiptAmount) {

                $receipt = ReceiptAmount::updateOrCreate([
                    'id' => $receiptAmount['id'] ?? 0,
                ],[
                    'receipt_id' => $this->receipt->id,
                    'currency_id' => $receiptAmount['currency_id'],
                    'amount' => sanitizeNumber($receiptAmount['amount']),
                ]);
                $receiptAmountsIds[] = $receipt->id;

                $this->updateTillsAmounts($receiptAmount);
            }
            ReceiptAmount::where('receipt_id', $this->receipt->id)->whereNotIn('id', $receiptAmountsIds)->delete();

            DB::commit();

            return to_route('receipt')->with('success', 'Receipt has been updated successfully!');

        } catch (\Exception $exception) {
            DB::rollBack();
            $this->submitting = false;

            return $this->dispatch('swal:error', [
                'title' => 'Error!',
                'text' => $exception->getMessage(),
            ]);
        }
    }


    public function updateTillsAmounts(mixed $receiptAmount): void
    {
        $tillAmount = TillAmount::where('till_id', $this->till_id)
            ->where('currency_id', $receiptAmount['currency_id'])
            ->first();

        if ($tillAmount) {
            $tillAmount->update([
                'amount' => $tillAmount->amount + sanitizeNumber($receiptAmount['amount']),
            ]);
        } else {
            TillAmount::create([
                'till_id' => $this->till_id,
                'currency_id' => $receiptAmount['currency_id'],
                'amount' => sanitizeNumber($receiptAmount['amount'])
            ]);
        }
    }

    public function render()
    {
        if ($this->status == Constants::VIEW_STATUS) {
            return view('livewire.pcash.receipt.receipt-view');
        }
            return view('livewire.pcash.receipt.receipt-form');
        }
    }

