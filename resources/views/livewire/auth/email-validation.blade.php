<x-card title="Code" class="w-[450px]">

    @error('dateResendNotAllowed')
        <x-alert icon="o-exclamation-triangle" class="alert-error my-4">
            {{ $message }}
        </x-alert>
    @enderror

    <x-form class="space-y-6 px-2" wire:submit="handle" no-separator>
        <div class="flex flex-col">
            <x-pin wire:model="code" size="6" numeric/>
            @error('code')
                <p class="text-xs text-red-500">
                    {{ $message }}
                </p>
            @enderror
        </div>
        <x-slot:actions>
            <x-button label="Validate" class="btn-primary w-full" type="submit" spinner="handle"/>
        </x-slot:actions>
    </x-form>

    <p wire:click="sendNewCode"
       class="mt-5 text-center text-sm font-semibold
       {{ $dateResendAllowed && now()->isBefore($dateResendAllowed) ? 'text-gray-400' : 'cursor-pointer text-indigo-400 hover:text-indigo-300' }} "
    >
        Send a new code
    </p>

    <p @click="$dispatch('logout')" class="mt-10 text-center text-sm text-gray-400 hover:text-indigo-300 cursor-pointer">
        Logout
    </p>
</x-card>