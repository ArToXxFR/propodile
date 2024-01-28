<?php

namespace App\Livewire;

use Livewire\Component;

class BanUserModal extends Component
{
    public $userId;
    public $confirmingBanUser = false;

    public function confirmBanUser($userId)
    {
        $this->userId = $userId;
        $this->confirmingBanUser = true;
    }

    public function render()
    {
        return view('livewire.ban-user');
    }
}
