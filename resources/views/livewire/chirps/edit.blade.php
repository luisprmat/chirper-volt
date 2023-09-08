<?php

use function Livewire\Volt\{mount, rules, state};

state(['chirp', 'message']);

rules(['message' => ['required', 'string', 'max:255']]);

mount(fn () => $this->message = $this->chirp->message);

$update = function () {
    $this->authorize('update', $this->chirp);

    $validated = $this->validate();

    $this->chirp->update($validated);

    $this->dispatch('chirp-updated');
};

$cancel = fn () => $this->dispatch('chirp-edit-canceled');

?>

<div>
    <form wire:submit="update">
        <x-textarea
            wire:model="message"
            class="block w-full dark:!bg-gray-800"
        ></x-textarea>

        <x-input-error :messages="$errors->get('message')" class="mt-2" />
        <div class="mt-4 flex items-baseline gap-2">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
            <button class="dark:text-gray-300" wire:click.prevent="cancel">{{ __('Cancel') }}</button>
        </div>
    </form>
</div>
