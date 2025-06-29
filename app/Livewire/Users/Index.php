<?php

namespace App\Livewire\Users;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Role;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $roleFilter = '';
    public $showCreateModal = false;
    public $showEditModal = false;
    public $selectedUser = null;
    public $roles = [];

    // Form properties
    public $name = '';
    public $email = '';
    public $password = '';
    public $role_id = '';

    protected $listeners = [
        'userCreated' => 'handleUserCreated',
        'userUpdated' => 'handleUserUpdated',
        'closeModal' => 'closeModal'
    ];

    protected $queryString = ['search', 'roleFilter', 'page'];

    public function mount()
    {
        $this->roles = Role::all();
    }

    public function handleUserCreated()
    {
        $this->closeModal();
        session()->flash('message', 'User created successfully!');
    }

    public function handleUserUpdated()
    {
        $this->closeModal();
        session()->flash('message', 'User updated successfully!');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingRoleFilter()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->resetForm();
        $this->showCreateModal = true;
    }

    public function edit($userId)
    {
        $user = User::findOrFail($userId);
        $this->selectedUser = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role_id = $user->role_id;
        $this->password = '';
        $this->showEditModal = true;
    }

    public function save()
    {
        if ($this->selectedUser) {
            $this->update();
        } else {
            $this->store();
        }
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role_id' => 'required|exists:roles,id',
        ]);

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'role_id' => $this->role_id,
        ]);

        $this->closeModal();
        session()->flash('message', 'User created successfully!');
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->selectedUser->id,
            'password' => 'nullable|min:6',
            'role_id' => 'required|exists:roles,id',
        ]);

        $this->selectedUser->update([
            'name' => $this->name,
            'email' => $this->email,
            'role_id' => $this->role_id,
        ]);

        if ($this->password) {
            $this->selectedUser->update([
                'password' => bcrypt($this->password),
            ]);
        }

        $this->closeModal();
        session()->flash('message', 'User updated successfully!');
    }

    public function delete($userId)
    {
        $user = User::findOrFail($userId);
        
        // Prevent deleting the current user
        if ($user->id === auth()->id()) {
            session()->flash('error', 'You cannot delete your own account!');
            return;
        }

        $user->delete();
        session()->flash('message', 'User deleted successfully!');
    }

    public function resetForm()
    {
        $this->selectedUser = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role_id = '';
        $this->resetValidation();
    }

    public function closeModal()
    {
        $this->showCreateModal = false;
        $this->showEditModal = false;
        $this->resetForm();
    }

    public function render()
    {
        $query = User::with('role')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                        ->orWhere('email', 'like', "%{$this->search}%");
                });
            })
            ->when($this->roleFilter, function ($query) {
                $query->where('role_id', $this->roleFilter);
            })
            ->orderBy('created_at', 'desc');

        return view('livewire.users.index', [
            'users' => $query->paginate(10),
        ]);
    }
} 