
<div>
    <form wire:submit.prevent="update" class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">Modifier la discipline</h2>
        <div class="mb-4">
            <label for="nom" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nom</label>
            <input type="text" id="nom" wire:model.defer="nom" class="mt-1 block w-full rounded border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100" required>
            @error('nom') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
            <textarea id="description" wire:model.defer="description" rows="3" class="mt-1 block w-full rounded border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100"></textarea>
            @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        
        <div class="flex justify-between items-center mt-6">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Mettre à jour</button>
            <!-- Bouton supprimer retiré -->
        </div>
        <!-- Modal de confirmation suppression retiré -->
    </form>
</div>
