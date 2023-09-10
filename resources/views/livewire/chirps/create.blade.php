<?php

use function Livewire\Volt\{rules, state};

state(['message' => '']);

rules(['message' => ['required', 'string', 'max:255']]);

$store = function () {
    $validated = $this->validate();

    auth()->user()->chirps()->create($validated);

    $this->message = '';

    $this->dispatch('chirp-created');
};

?>

<div x-data="data" x-init="start">
    <form wire:submit="store">
        <x-textarea
            wire:model="message"
            placeholder="{{ __('What\'s on your mind?') }}"
            class="block w-full dark:!bg-gray-800"
            x-on:keydown="typingChirp"
        ></x-textarea>

        <x-input-error :messages="$errors->get('message')" class="mt-2" />
            <div class="mt-2 text-gray-500 text-sm italic" x-show="userTyping">
            <span class="font-bold not-italic" x-text="userTyping"></span> {{ __('is writing a chirp') }}
        </div>
        <x-primary-button class="mt-4">{{ __('Chirp') }}</x-primary-button>
    </form>

    <script>
        const data = () => ({
            user: null,
            userTyping: false,
            typingChirp() {
                Echo.join('chirps')
                    .whisper('typing', this.user)
            },
            start() {
                this.user = '{{ auth()->user()->name }}'
                Echo.join('chirps')
                    .listenForWhisper('typing', (user) => {
                        this.userTyping = user
                        setTimeout(() => this.userTyping = false, 2000)
                    })
            },
        })
    </script>
</div>
