<?php

use function Livewire\Volt\{rules, state};

state(['message' => '']);

rules(['message' => ['required', 'string', 'max:255']]);

$store = function () {
    $validated = $this->validate();

    auth()->user()->chirps()->create($validated);

    $this->message = '';
};

?>

<div>
    <form wire:submit="store">
        <x-textarea
            wire:model="message"
            placeholder="{{ __('What\'s on your mind?') }}"
            class="block w-full dark:!bg-gray-800"
        ></x-textarea>

        <x-input-error :messages="$errors->get('message')" class="mt-2" />
        <x-primary-button class="mt-4">{{ __('Chirp') }}</x-primary-button>
    </form>
</div>
