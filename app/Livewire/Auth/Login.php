<?php

namespace App\Livewire\Auth;

<<<<<<< HEAD
=======
use App\Models\User;

>>>>>>> 9154491a58cbe5c3e5c8224a1b7d7230e479e1e5
use Livewire\Component;

class Login extends Component
{
    public $username = '';
    public $password = '';
    public $rememberMe = false;

<<<<<<< HEAD
=======
    public $headerStyle;


>>>>>>> 9154491a58cbe5c3e5c8224a1b7d7230e479e1e5
    protected $rules = [
        'username' => ['required', 'string', 'username'],
        'password' => ['required', 'string'],
    ];

<<<<<<< HEAD
=======
    public function mount()
    {
        if(auth()->user())
        {
            return to_route('dashboard');
        }
    }

>>>>>>> 9154491a58cbe5c3e5c8224a1b7d7230e479e1e5
    public function login()
    {
        $validatedData = $this->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);
    
        if (auth()->attempt(['username' => $validatedData['username'], 'password' => $validatedData['password']], $this->rememberMe))
        {
            return redirect()->route('dashboard');
        }
        else
        {
            return $this->addError('username', trans('auth.failed'));
        }
    }
    

    public function render()
    {
        return view('livewire.auth.login');
    }
}
