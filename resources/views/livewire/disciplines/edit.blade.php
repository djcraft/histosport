
<div class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">Modifier une discipline</h2>
    <form wire:submit.prevent="update">
        <x-form-input name="nom" label="Nom" wire:model="nom" required />
        @error('nom') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        <x-form-group class="mb-4">
            <x-form-textarea name="description" label="Description" wire:model="description" rows="3" />
            @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </x-form-group>
        <div class="flex justify-end">
            <x-button type="submit" variant="primary">Mettre à jour</x-button>
        </div>
    </form>
</div>
