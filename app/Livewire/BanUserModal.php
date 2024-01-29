<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class BanUserModal extends Component
{
    use WithPagination;
    public $userId;
    public $confirmingBanUser = false;
    public $users;

    public function mount($users)
    {
        $this->users = $users;
    }

    public function confirmBanUser($userId)
    {
        $this->userId = $userId;
        $this->confirmingBanUser = true;
    }

    public function openBanUserModal()
    {
        return view('livewire.ban-user-modal');
    }

    public function render()
    {
        $users = User::paginate(10);

        return view('livewire.ban-user-modal', compact('users'));
    }
}
