<div>
@if($show)
    <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow max-w-xl w-full">
            <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">Créer une discipline</h2>
            <form wire:submit.prevent="save">
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Nom</label>
                    <input type="text" wire:model.defer="nom" placeholder="Nom de la discipline" autofocus
                        class="w-full px-3 py-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                    @error('nom') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Description</label>
                    <textarea wire:model.defer="description" rows="3"
                        class="w-full px-3 py-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100"></textarea>
                    @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="flex justify-end gap-2 mt-4">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Créer</button>
                    <button type="button" wire:click="$set('show', false)" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Annuler</button>
                </div>
            </form>
        </div>
    </div>
@endif
</div>
