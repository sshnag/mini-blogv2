<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use Livewire\Attributes\Layout;
use Spatie\Permission\Models\Role;


#[Layout('layouts.app')]
class UsersManagement extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public $perPage = 10;

    #[Url(history: true)]
    public $sortBy = 'created_at';
    public $roles = [];

    #[Url(history: true)]
    public $sortDir = 'DESC';

    #[Url(history: true)]
    public $search = '';

    #[Url(history: true)]
    public $roleFilter = '';

    // add available roles
    public $availableRoles = ['user', 'author', 'admin'];

   public function mount()
{
    // Load roles for all users into the $roles array
    foreach (User::all() as $user) {
        $this->roles[$user->id] = $user->getRoleNames()->first() ?? 'user';
    }

    // Ensure every user has at least the 'user' role
    User::doesntHave('roles')->each(function ($user) {
        $user->assignRole('user');
    });
}


    //for sorting
    public function setSortBy($sortByField)
    {
        if ($this->sortBy === $sortByField) {
            $this->sortDir = ($this->sortDir == "ASC") ? 'DESC' : "ASC";
            return;
        }
        $this->sortBy = $sortByField;
        $this->sortDir = 'DESC';
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updateUserRole($userId, $role)
    {
        $user = User::findOrFail($userId);

        // verify the role exists
        if (!in_array($role, $this->availableRoles)) {
            $this->dispatch('notify',
                title: 'Error',
                message: "Invalid role selected",
                type: 'error'
            );
            return;
        }

        // remove all existing roles
        $user->roles()->detach();

        // assign the new role
        $user->assignRole($role);

        // clear the user's permission cache
        $user->forgetCachedPermissions();

        // force refresh the user model
        $user->refresh();

        $this->dispatch('notify',
            title: 'Success',
            message: "Role for {$user->name} updated to {$role}. User should log out and log back in for changes to take effect.",
            type: 'success'
        );
    }

    public function forceRefreshUserRoles($userId)
    {
        $user = User::findOrFail($userId);

        // clear all caches for this user
        $user->forgetCachedPermissions();
        $user->refresh();

        // clear global permission cache
        app()['cache']->forget('spatie.permission.cache');

        $this->dispatch('notify',
            title: 'Cache Cleared',
            message: "Permission cache cleared for {$user->name}. Role changes should now be visible.",
            type: 'success'
        );
    }
    //for user deletion
    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();

        $this->dispatch('notify',
            title: 'Deleted',
            message: "User {$user->name} has been removed.",
            type: 'success'
        );
    }

    public function render()
    {
        return view('livewire.admin.users-management', [
            'users' => User::with('roles')
                ->when($this->search, function($query) {
                    $query->where(function($q) {
                        //user searching with name, email
                        $q->where('name', 'like', '%'.$this->search.'%')
                          ->orWhere('email', 'like', '%'.$this->search.'%');
                    });
                })
                ->when($this->roleFilter, function($query) {
                    //role filtering
                    $query->whereHas('roles', function($q) {
                        $q->where('name', $this->roleFilter);
                    });
                })
                ->orderBy($this->sortBy, $this->sortDir)
                ->paginate($this->perPage)
        ]);
    }
}
