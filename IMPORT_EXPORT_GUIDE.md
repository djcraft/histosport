# Analyse du projet pour la refonte Import/Export multi-feuilles

## 1. Structure actuelle

### Exports
- `app/Exports/BaseExport.php` : Classe abstraite, logique commune d'export, transformation, headings, helpers.
- `app/Exports/ClubExport.php`, `CompetitionExport.php`, etc. : Export spécifique par entité, relations incluses, formatage personnalisé.

### Imports
- `app/Imports/BaseImport.php` : Classe abstraite, logique commune d'import, gestion des erreurs, suivi des entités créées/mises à jour.
- `app/Imports/ClubImport.php`, `CompetitionImport.php`, etc. : Import spécifique par entité, normalisation, déduplication, gestion des pivots, création/recherche des entités liées.

### Modèles
- `app/Models/Club.php`, `Lieu.php`, `Personne.php`, etc. : Modèles Eloquent, relations, méthodes de normalisation et recherche canonique (findNormalized, normalizeFields).

### Vues
- `resources/views/livewire/` : Vues Livewire pour la gestion CRUD, modals, etc. Pas de vue de prévisualisation d'import/export actuellement.

### Migrations
- `database/migrations/` : Tables principales, pivots, jobs, etc.

### Jobs/Batches
- Utilisation possible du système de jobs Laravel (à intégrer pour le batch import/export).

## 2. Points d'évolution pour le nouveau système

### Extraction multi-feuilles
- Générer un fichier Excel avec une feuille principale (entité) et des feuilles secondaires (entités liées).
- Chaque feuille doit contenir les données normalisées et des identifiants pour les correspondances.

### Import multi-feuilles
- Lire chaque feuille, normaliser les données, créer/retrouver les entités.
- Utiliser un hash canonique pour chaque ligne (aggrégation des champs, valeurs null/vides identiques).
- Gérer les liens entre feuilles via des identifiants ou des clés de correspondance.

### Prévisualisation et Dry-Run
- Créer une vue Livewire pour prévisualiser les données importées, détecter les conflits, afficher une synthèse avant validation.
- Permettre un "Dry-Run" (simulation sans enregistrement) pour visualiser les impacts.

### Stockage temporaire (transaction)
- Stocker les données importées en attente de validation (table temporaire ou cache, type transaction).
- Synchronisation effective après validation utilisateur.

### Batch/Job Laravel
- Utiliser les jobs/batches Laravel pour traiter l'import/export en arrière-plan, gérer les gros volumes.

## 3. Marche à suivre

1. **Créer une branche dédiée** :
   - Nom : `feature/import-export-multisheet`
   - Convention : standard Laravel, PR draft dès le début.

2. **Définir les modèles de données temporaires** (pour stockage en attente).

3. **Créer les services d'export multi-feuilles** :
   - Génération Excel avec plusieurs feuilles.
   - Mapping des liens entre entités.

4. **Créer les services d'import multi-feuilles** :
   - Lecture, normalisation, hash, correspondance entre feuilles.
   - Stockage temporaire, gestion des conflits.

5. **Développer la vue de prévisualisation Livewire** :
   - Synthèse, détection des conflits, validation.
   - Dry-Run.

6. **Intégrer le système de batch/job** pour l'import/export.

7. **Tests unitaires et fonctionnels**.

8. **Documentation et guide utilisateur**.

---

Ce fichier servira de guide pour l'ensemble du processus de création du nouveau système d'import/export multi-feuilles.
