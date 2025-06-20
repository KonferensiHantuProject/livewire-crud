<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class UserEditForm extends Form
{
    #[Validate('required')]
    public $id;

    #[Validate('required')]
    public $name;

    #[Validate('required|unique:users,email')]
    public $email;
}
