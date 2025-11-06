<?php


namespace App\Exports;

use App\Models\Competition;

class CompetitionExport extends BaseExport
{
    protected function getEntities()
    {
        $query = Competition::with([
            'participants.club',
            'participants.personne',
            'disciplines',
            'lieu',
            'organisateur_club',
            'organisateur_personne'
        ]);
        if ($this->ids) {
            $query = $query->whereIn('competition_id', $this->ids);
        }
        return $query->get();
    }

    protected function getModelClass()
    {
        return Competition::class;
    }

    protected function getPrimaryKey()
    {
        return 'competition_id';
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

    protected function transform($competition)
    {
        $clubs = $competition->participants->map(function ($participant) {
            return $participant->club ? $participant->club->nom : null;
        })->filter()->unique()->implode(', ');

        $personnes = $competition->participants->map(function ($participant) {
            if ($participant->personne) {
                return $participant->personne->prenom . ' ' . $participant->personne->nom;
            }
            return null;
        })->filter()->unique()->implode(', ');

        $resultatsPersonnes = $competition->participants->map(function ($participant) {
            if ($participant->personne && $participant->resultat) {
                return $participant->personne->prenom . ' ' . $participant->personne->nom . ' : ' . $participant->resultat;
            }
            return null;
        })->filter()->implode(' | ');

        $resultatsClubs = $competition->participants->map(function ($participant) {
            if ($participant->club && $participant->resultat) {
                return $participant->club->nom . ' : ' . $participant->resultat;
            }
            return null;
        })->filter()->implode(' | ');

        $disciplines = $this->formatListe($competition->disciplines);
        $lieu = $this->formatLieu($competition->lieu);

        $sites = $competition->sites->map(function ($site) {
            return $this->formatLieu($site);
        })->filter()->unique()->implode('; ');

        return [
            'nom' => $competition->nom,
            'date' => $competition->date,
            'date_precision' => $competition->date_precision,
            'lieu' => $lieu,
            'sites' => $sites,
            'organisateur_club' => $competition->organisateur_club ? $competition->organisateur_club->nom : '',
            'organisateur_personne' => $competition->organisateur_personne ? ($competition->organisateur_personne->prenom . ' ' . $competition->organisateur_personne->nom) : '',
            'type' => $competition->type,
            'duree' => $competition->duree,
            'niveau' => $competition->niveau,
            'clubs' => $clubs,
            'personnes' => $personnes,
            'resultats_personnes' => $resultatsPersonnes,
            'resultats_clubs' => $resultatsClubs,
            'disciplines' => $disciplines,
        ];
    }

    public function headings(): array
    {
        return [
            'nom',
            'date',
            'date_precision',
            'lieu',
            'sites',
            'organisateur_club',
            'organisateur_personne',
            'type',
            'duree',
            'niveau',
            'clubs',
            'personnes',
            'resultats_personnes',
            'resultats_clubs',
            'disciplines',
        ];
    }
}
