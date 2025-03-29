<x-filament-panels::page>
    <x-filament-panels::form wire:submit="updateProfile" class="pl-[50px]">
        {{ $this->editProfileForm }}
        <x-filament-panels::form.actions :actions="$this->getUpdateProfileFormActions()" />
    </x-filament-panels::form>

    <x-filament-panels::form wire:submit="updatePassword" class="pl-[50px]">
        {{ $this->editPasswordForm }}
        <x-filament-panels::form.actions :actions="$this->getUpdatePasswordFormActions()" />
    </x-filament-panels::form>
</x-filament-panels::page>
