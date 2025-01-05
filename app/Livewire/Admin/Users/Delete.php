<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use App\Notifications\UserDeletedNotification;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\{On, Rule};
use Livewire\Component;

class Delete extends Component
{
    #[Rule(['accepted'])]
    public bool $confirmedDeletion = false;

    public ?User $user = null;

    public bool $modal = false;

    public function render(): view
    {
        return view('livewire.admin.users.delete');
    }

    public function destroy(): void
    {
        $this->validate();
        $this->user->delete();
        $this->user->notify(new UserDeletedNotification());
        $this->dispatch('user::deleted');
        $this->reset('confirmedDeletion', 'modal');
    }

    #[On('user::deletion')]
    public function openConfimation(int $userId): void
    {
        $this->user  = User::select('id', 'name')->find($userId);
        $this->modal = true;
    }

    public function confirmDeletion()
    {
        $this->confirmedDeletion = true;
        $this->destroy();
    }
}
