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

## À compléter au fil du développement
