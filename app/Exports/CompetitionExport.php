<?php

namespace App\Exports;

use App\Models\Competition;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CompetitionExport implements FromCollection, WithHeadings
{
    protected $ids;

    public function __construct($ids = null)
    {
        $this->ids = $ids;
    }

    public function collection()
    {
            $competitions = Competition::with(['participants.club', 'participants.personne', 'disciplines', 'lieu']);
            if ($this->ids) {
                $competitions = $competitions->whereIn('competition_id', $this->ids);
            }
            $competitions = $competitions->get();
            return $competitions->map(function ($competition) {
                // Récupérer les clubs via les participants
                $clubs = $competition->participants->map(function ($participant) {
                    return $participant->club ? $participant->club->nom : null;
                })->filter()->unique()->implode(', ');

                // Récupérer les personnes via les participants
                $personnes = $competition->participants->map(function ($participant) {
                    if ($participant->personne) {
                        return $participant->personne->prenom . ' ' . $participant->personne->nom;
                    }
                    return null;
                })->filter()->unique()->implode(', ');

                $disciplines = $competition->disciplines->pluck('nom')->implode(', ');
                return [
                    'nom' => $competition->nom,
                    'date' => $competition->date,
                    'date_precision' => $competition->date_precision,
                    'lieu' => $competition->lieu ? $competition->lieu->adresse . ', ' . $competition->lieu->code_postal . ', ' . $competition->lieu->commune : '',
                    'organisateur_club' => $competition->organisateur_club ? $competition->organisateur_club->nom : '',
                    'organisateur_personne' => $competition->organisateur_personne ? ($competition->organisateur_personne->prenom . ' ' . $competition->organisateur_personne->nom) : '',
                    'type' => $competition->type,
                    'duree' => $competition->duree,
                    'niveau' => $competition->niveau,
                    'clubs' => $clubs,
                    'personnes' => $personnes,
                    'disciplines' => $disciplines,
                ];
            });
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
