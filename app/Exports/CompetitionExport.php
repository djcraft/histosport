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

        $disciplines = $this->formatListe($competition->disciplines);
        $lieu = $this->formatAdresse($competition->lieu);

        return [
            'nom' => $competition->nom,
            'date' => $competition->date,
            'date_precision' => $competition->date_precision,
            'lieu' => $lieu,
            'organisateur_club' => $competition->organisateur_club ? $competition->organisateur_club->nom : '',
            'organisateur_personne' => $competition->organisateur_personne ? ($competition->organisateur_personne->prenom . ' ' . $competition->organisateur_personne->nom) : '',
            'type' => $competition->type,
            'duree' => $competition->duree,
            'niveau' => $competition->niveau,
            'clubs' => $clubs,
            'personnes' => $personnes,
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
            'organisateur_club',
            'organisateur_personne',
            'type',
            'duree',
            'niveau',
            'clubs',
            'personnes',
            'disciplines',
        ];
    }
}
