# Documentation Import/Export Multi-Feuilles

Ce document accompagne le développement du nouveau système d'import/export multi-feuilles.

## Fonctionnalités principales
- Export multi-feuilles Excel
- Import multi-feuilles avec normalisation et hash
- Prévisualisation, résolution des conflits, dry-run
- Stockage temporaire avant validation
- Traitement par batch/job Laravel

## Structure technique
Voir le guide et la structure des dossiers/fichiers dans le projet.


## Workflow complet

1. **Import multi-feuilles** :
	- Sélectionner un fichier Excel multi-feuilles.
	- Les données sont normalisées, hashées et stockées temporairement.

2. **Prévisualisation** :
	- Visualiser les entités importées (clubs, personnes, etc.) avec les composants réutilisables.
	- Les conflits/doublons sont détectés et affichés.

3. **Actions** :
	- Valider l'import (synchronisation réelle en base, mise à jour des statuts, logs).
	- Rejeter l'import (suppression des données temporaires, logs).

4. **Nettoyage** :
	- Les imports temporaires et entités associées sont supprimés après validation ou rejet.

5. **Retour utilisateur** :
	- Notifications claires (succès, erreur, conflit) via les composants UI.
	- Statuts affichés avec badges.

6. **Logs** :
	- Toutes les actions importantes (validation, rejet, conflit) sont loguées pour le suivi et l’audit.

## Bonnes pratiques
- Vérifier les statuts et la suppression des imports après chaque action.
- Utiliser les logs pour diagnostiquer les problèmes ou suivre les opérations.
- Tester le workflow complet avec des jeux de données réels.


## Plan de test manuel

1. **Import d’un fichier multi-feuilles**
	- Sélectionner un fichier Excel avec plusieurs feuilles (clubs, personnes, etc.).
	- Vérifier que toutes les entités sont bien importées et affichées en prévisualisation.

2. **Détection des conflits/doublons**
	- Importer un fichier contenant des entités déjà présentes en base.
	- Vérifier que les conflits sont détectés et affichés correctement.

3. **Validation de l’import**
	- Cliquer sur « Valider l’import ».
	- Vérifier que les entités sont synchronisées en base et que le statut passe à « validé ».
	- Contrôler les logs pour s’assurer du suivi des actions.

4. **Rejet de l’import**
	- Cliquer sur « Rejeter l’import ».
	- Vérifier que les données temporaires sont supprimées et que le statut passe à « rejeté ».
	- Contrôler les logs pour s’assurer du suivi des actions.

5. **Nettoyage**
	- Vérifier qu’aucune donnée temporaire ne reste après validation ou rejet.

6. **Retour utilisateur**
	- Vérifier l’affichage des notifications, badges et statuts dans l’UI.

7. **Robustesse**
	- Tester avec des fichiers volumineux, des données mal formatées ou incomplètes.
	- Vérifier la gestion des erreurs et la stabilité du workflow.
