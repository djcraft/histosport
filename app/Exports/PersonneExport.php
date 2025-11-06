<?php


namespace App\Exports;

use App\Models\Personne;

class PersonneExport extends BaseExport
{
    protected function getEntities()
    {
        $query = Personne::with(['clubs', 'adresse', 'lieu_naissance', 'lieu_deces']);
        if ($this->ids) {
            $query = $query->whereIn('personne_id', $this->ids);
        }
        return $query->get();
    }

    protected function getModelClass()
    {
        return Personne::class;
    }

    protected function getPrimaryKey()
    {
        return 'personne_id';
    }

    protected function formatLieu($lieu)
    {
        if (!$lieu) return ', , , , , ';
        $fields = [
            $lieu->nom ?? '',
            $lieu->adresse ?? '',
            $lieu->commune ?? '',
            $lieu->code_postal ?? '',
            $lieu->departement ?? '',
            $lieu->pays ?? ''
        ];
        return implode(', ', $fields);
    }

    protected function transform($personne)
    {
        $clubs = $this->formatListe($personne->clubs);
        $adresse = $this->formatLieu($personne->adresse);
        $lieu_naissance = $this->formatLieu($personne->lieu_naissance);
        $lieu_deces = $this->formatLieu($personne->lieu_deces);
        return [
            'nom' => $personne->nom,
            'prenom' => $personne->prenom,
            'date_naissance' => $personne->date_naissance,
            'lieu_naissance' => $lieu_naissance,
            'date_deces' => $personne->date_deces,
            'lieu_deces' => $lieu_deces,
            'sexe' => $personne->sexe,
            'titre' => $personne->titre,
            'adresse' => $adresse,
            'clubs' => $clubs,
        ];
    }

    public function headings(): array
    {
        return [
            'nom',
            'prenom',
            'date_naissance',
            'lieu_naissance',
            'date_deces',
            'lieu_deces',
            'sexe',
            'titre',
            'adresse',
            'clubs',
        ];
    }
}
