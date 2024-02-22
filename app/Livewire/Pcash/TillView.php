<?php

namespace App\Livewire\Pcash;

use App\Models\Till;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Livewire\Component;

class TillView extends Component
{
    use AuthorizesRequests;

    protected $listeners = ['deleteConfirm','delete'];

    public function deleteConfirm($method, $id = null): void
    {
        $this->dispatch('swal:confirm', [
            'type'  => 'warning',
            'title' => 'Are you sure?',
            'text'  => 'You won\'t be able to revert this!',
            'id'    => $id,
            'method' => $method,
        ]);
    }

    public function delete($id)
    {
        $this->authorize('till-delete');

        $till = Till::findOrFail($id);
        $till->delete();

        return to_route('till')->with('success', 'till has been deleted successfully!');
    }


    public function render()
    {
        $data = [];

        $till = Till::with(['user'])->get();
        $data['till'] = $till;

        return view('livewire.pcash.till-view', $data);
    }
}
