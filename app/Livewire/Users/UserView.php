<?php

namespace App\Livewire\Users;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class UserView extends Component
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

        $users = User::all();
        $data['users'] = $users;

        return view('livewire.users.user-view', $data);
    }
}
