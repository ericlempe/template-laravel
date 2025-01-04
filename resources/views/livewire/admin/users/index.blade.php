<div>
    <x-header title="Users" separator/>

    <div class="mb-4 flex space-x-4">
        <div class="w-1/3">
            <x-input
                label="Search by email or name"
                icon="o-magnifying-glass"
                wire:model.live="search"
            />
        </div>
        <div class="w-1/3">
            <x-choices
                Label="Search by permissions"
                wire:model.live="search_permissions"
                :options="$permissions_to_search"
                option-label="key"
                search-function="filterPermissions"
                searchable
                multiple
                no-result-text="Nothing here"
            />
        </div>
    </div>

    <x-table :headers="$this->headers" :rows="$this->users" with-pagination>
        @scope('cell_permissions', $user)
        @foreach($user->permissions as $permission)
            <x-badge :value="\Illuminate\Support\Str::ucfirst($permission->key)" class="badge-info"/>
        @endforeach
        @endscope

        @scope('actions', $user)
        <x-button icon="o-trash" wire:click="delete({{ $user->id }})" spinner class="btn-sm"/>
        @endscope
    </x-table>
</div>
