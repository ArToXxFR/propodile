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
        $this->emit('openBanUserModal');
    }


    public function render()
    {
        return view('livewire.ban-user-modal', [
            'users' => $this->users
        ]);
    }
}
