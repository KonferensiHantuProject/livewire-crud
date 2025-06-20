<?php

namespace App\Livewire\Page;

use App\Livewire\Forms\UserCreateForm;
use App\Livewire\Forms\UserEditForm;
use App\Models\User as ModelsUser;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.front')]
class User extends Component
{
    use WithPagination;

    /**
     * A computed properties for geting a users data
     * to be loaded on to the table.
     */
    #[Computed()]
    public function users()
    {
        return ModelsUser::orderBy('created_at', 'desc')->paginate();
    }

    // -------------------------------------------------------------------------------------
    // Create User 
    // -------------------------------------------------------------------------------------

    /**
     * livewire form to handle edit form.
     */
    public UserCreateForm $createForm;

    /**
     * Create user main handler. triggered
     * by a form submission.
     */
    public function createUser()
    {
        sleep(1);
        try {
            // validation 
            $this->createForm->validate();

            // business logic
            ModelsUser::create([
                'name' => $this->createForm->name,
                'email' => $this->createForm->email,
                'password' => Hash::make('password'),
                'remember_token' => now()->toString(),
            ]);
            $this->dispatch('user_create_submitted');

            // cleanup
            $this->createForm->reset();
            $this->createForm->resetErrorBag();
        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            $this->addError('error', $e->getMessage());
        } finally {
            $this->dispatch('user_create_progressed');
        }
    }

    // -------------------------------------------------------------------------------------
    // Edit User 
    // -------------------------------------------------------------------------------------

    /**
     * livewire form to handle edit form.
     */
    public UserEditForm $editForm;


    /**
     * Main method to be called by trigger
     * like an edit button ar something.
     */
    public function populateUser($id)
    {
        sleep(1);
        $user = ModelsUser::find($id);
        $this->editForm->id = $user->id;
        $this->editForm->name = $user->name;
        $this->editForm->email = $user->email;
        $this->dispatch('user_edit_populated');
    }

    /**
     * Edit user main handler. triggered
     * by a form submission.
     */
    public function editUser()
    {
        sleep(1);
        try {
            // get user to be edited
            $user = ModelsUser::find($this->editForm->id);

            // validation 
            $this->editForm->validateOnly('name');
            if ($user->email != $this->editForm->email) {
                $this->editForm->validateOnly('email');
            }

            // business logic
            $user->name = $this->editForm->name;
            $user->email = $this->editForm->email;
            $user->password = Hash::make('password');
            $user->save();
            $this->dispatch('user_edit_submitted');

            // cleanup
            $this->editForm->reset();
            $this->editForm->resetErrorBag();
        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            $this->addError('error', $e->getMessage());
        } finally {
            $this->dispatch('user_edit_progressed');
        }
    }

    // -------------------------------------------------------------------------------------
    // Delete User 
    // -------------------------------------------------------------------------------------
    public function deleteUser($id)
    {
        $user = ModelsUser::find($id);
        $user->delete();
    }


    /**
     * Renders the whole livewire component
     */
    public function render()
    {
        return view('livewire.page.user');
    }
}
