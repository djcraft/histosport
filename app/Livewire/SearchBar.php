<?php


namespace App\Livewire;

use Livewire\Component;

class SearchBar extends Component
{

    public $search = '';
    public $results = [];
    #[\Livewire\Attributes\Modelable]
    public $modelValue = [];
    public $multi = true;

    // Paramètres dynamiques
    public $entityClass = '';
    public $displayField = '';
    public $searchFields = [];
    public $idField = 'id';
    // ...existing code...
    public function mount()
    {
        if ($this->multi) {
            if (!is_array($this->modelValue)) {
                $this->modelValue = $this->modelValue ? [$this->modelValue] : [];
            }
        } else {
            if (is_array($this->modelValue)) {
                $this->modelValue = count($this->modelValue) ? $this->modelValue[0] : null;
            }
        }
    }

    public function searchUpdated()
    {
        $this->results = [];
        if (trim($this->search) === '') {
            return;
        }
        $model = app($this->entityClass);
        $query = $model::query();
        $query->where(function($q) {
            foreach ($this->searchFields as $field) {
                $q->orWhere($field, 'like', '%' . $this->search . '%');
            }
        });
        $query->limit(10);
        $this->results = $query->get()->toArray();
    }

    public function select($id)
    {
        if ($this->multi) {
            if (!is_array($this->modelValue)) {
                $this->modelValue = [];
            }
            if (!in_array($id, $this->modelValue)) {
                $this->modelValue[] = $id;
            }
            $this->dispatch('update:modelValue', $this->modelValue);
        } else {
            $this->modelValue = $id;
            $this->dispatch('update:modelValue', $id);
        }
        $this->search = '';
        $this->results = [];
    }

    public function remove($id)
    {
        if ($this->multi) {
            $this->modelValue = array_filter((array)$this->modelValue, fn($itemId) => $itemId != $id);
            $this->dispatch('update:modelValue', $this->modelValue);
        } else {
            $this->modelValue = null;
            $this->dispatch('update:modelValue', null);
        }
    }

    public function render()
    {
        $model = app($this->entityClass);
        $ids = [];
        if (is_array($this->modelValue)) {
            $ids = $this->modelValue;
        } elseif (is_null($this->modelValue)) {
            $ids = [];
        } else {
            $ids = [$this->modelValue];
        }
        $selectedItems = $model::whereIn($this->idField, $ids)->get();
        return view('livewire.search-bar', [
            'selectedItems' => $selectedItems,
            'displayField' => $this->displayField,
            'idField' => $this->idField,
            'results' => $this->results,
            'search' => $this->search,
            'multi' => $this->multi,
        ]);
    }
}
