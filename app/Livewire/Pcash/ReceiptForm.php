<?php

namespace App\Livewire\Pcash;


use App\Models\Category;
use App\Models\Currency;
use App\Models\Receipt;
use App\Models\ReceiptAmount;
use App\Models\SubCategory;
use App\Models\Till;
use App\Models\TillAmount;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Exception;
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
    public $paid_by;
    public $description;
    public  $receiptAmounts = [];
    public $categories = [];
    public $subCategories = [];

    protected $listeners = ['store', 'update'];

    public function mount($id = 0, $status = 0)
    {
        $this->authorize('receipt-list');

        $this->status = $status;

        $this->currencies = Currency::all();

        $this->tills = Till::when(!auth()->user()->hasPermissionTo('till-viewAll'), function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->get();

        $this->categories = Category::when(!auth()->user()->hasPermissionTo('category-viewAll'), function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->where('type', 'receipt')
            ->get();

        $this->addRow();

        if ($id) {
            $this->editing = true;
            $this->receipt = Receipt::with('receiptAmounts')->findOrFail($id);

            $this->till_id = $this->receipt->till_id;
            $this->category_id = $this->receipt->category_id;
            $this->subCategories = SubCategory::where('category_id', $this->category_id)->get();
            $this->sub_category_id = $this->receipt->sub_category_id;
            $this->paid_by = $this->receipt->paid_by;
            $this->description = $this->receipt->description;
            $this->receiptAmounts = [];
            foreach($this->receipt->receiptAmounts as $receiptAmount) {
                $this->receiptAmounts[] = [
                    'id' => $receiptAmount->id,
                    'receipt_id' => $receiptAmount->receipt_id,
                    'currency_id' => $receiptAmount->currency_id,
                    'amount' => number_format($receiptAmount->amount),
                ];
            }
        }

    }

    #[On('getSubCategories')]
    public function getSubCategories()
    {
        $this->sub_category_id = null;
        $selectedSubCategoryId = $this->receipt?->sub_category_id;
        $this->subCategories = SubCategory::where('category_id', $this->category_id)->get();
        $this->dispatch('refreshSubCategories', $this->subCategories, $selectedSubCategoryId);
    }

    protected function rules()
    {
        return [
            'till_id' => ['required'],
            'category_id' => ['required', new Exists('categories', 'id')],
            'sub_category_id' => ['required', new Exists('sub_categories', 'id')],
            'paid_by' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'receiptAmounts' => ['array', 'min:1'],
            'receiptAmounts.*.currency_id' => ['required'],
            'receiptAmounts.*.amount' => ['required'],
        ];
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

        DB::beginTransaction();
        try {

            $receipt = Receipt::create([
                'till_id' => $this->till_id,
                'user_id' => auth()->id(),
                'category_id' => $this->category_id,
                'sub_category_id' => $this->sub_category_id,
                'paid_by' => $this->paid_by,
                'description' => $this->description,
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
            return $this->dispatch('swal:error', [
                'title' => 'Error!',
                'text' => $exception->getMessage(),
            ]);
        }
    }

    /**
     * @param mixed $receiptAmount
     * @return void
     */
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
        return view('livewire.pcash.receipt-form');
    }
}
