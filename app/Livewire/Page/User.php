<?php

namespace App\Livewire\Page;

use App\Models\User as ModelsUser;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.front')]
class User extends Component
{
    use WithPagination;

    #[Computed()]
    public function users()
    {
        return ModelsUser::orderBy('created_at', 'desc')->paginate();
    }

    public function render()
    {
        return view('livewire.page.user');
    }
}
