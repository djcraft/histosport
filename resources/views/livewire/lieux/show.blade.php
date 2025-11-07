<div>
    <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">Détail du lieu</h2>
        <x-field label="Nom" :value="$lieu->nom" />
        <x-field label="Adresse" :value="$lieu->adresse" />
        <x-fields-group :fields="[
            ['label' => 'Code postal', 'value' => $lieu->code_postal],
            ['label' => 'Commune', 'value' => $lieu->commune],
            ['label' => 'Département', 'value' => $lieu->departement],
            ['label' => 'Pays', 'value' => $lieu->pays]
        ]" />
        <div class="flex justify-end">
            <x-button as="a" href="{{ route('lieux.edit', $lieu) }}" variant="link-orange">Modifier</x-button>
        </div>
    </div>
</div>
