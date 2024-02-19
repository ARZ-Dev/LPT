<?php

namespace App\Livewire\Users;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class UserView extends Component
{
    use AuthorizesRequests, WithPagination;

    protected $listeners = [
        'deleteConfirm',
        'delete'
    ];

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
        $this->authorize('user-delete');

        if ($id == 1) {

            return to_route('users')->with('error', 'You cannot delete the user with ID 1.');
        }

        User::where('id', $id)->delete();

        return to_route('users')->with('success', 'User has been deleted successfully!');
    }

    public function render()
    {
        $data = [];

        $users = User::paginate(5);
        $data['users'] = $users;

        return view('livewire.users.user-view', $data);
    }
}
