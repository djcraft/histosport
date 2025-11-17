# Configuration des Secrets GitHub / GitHub Secrets Configuration

Ce document liste tous les secrets qui doivent être configurés dans GitHub pour que les workflows CI/CD fonctionnent correctement.

This document lists all secrets that need to be configured in GitHub for CI/CD workflows to work properly.

## 🔐 Secrets Requis / Required Secrets

### Pour le déploiement / For Deployment

Ces secrets sont utilisés par `.github/workflows/deploy.yml` :

#### SSH_HOST
- **Description:** Adresse IP ou nom de domaine du serveur de production
- **Exemple:** `203.0.113.42` ou `server.example.com`
- **Utilisé pour:** Connexion SSH au serveur pour le déploiement

#### SSH_USER
- **Description:** Nom d'utilisateur SSH pour la connexion au serveur
- **Exemple:** `deployer` ou `ubuntu`
- **Utilisé pour:** Authentification SSH

#### SSH_PRIVATE_KEY
- **Description:** Clé SSH privée (format PEM) pour l'authentification
- **Génération:**
  ```bash
  # Sur votre machine locale
  ssh-keygen -t ed25519 -C "github-actions-deploy" -f ~/.ssh/histosport_deploy
  
  # La clé privée est dans ~/.ssh/histosport_deploy (à mettre dans GitHub)
  # La clé publique est dans ~/.ssh/histosport_deploy.pub (à mettre sur le serveur)
  
  # Sur le serveur
  cat ~/.ssh/histosport_deploy.pub >> ~/.ssh/authorized_keys
  chmod 600 ~/.ssh/authorized_keys
  ```
- **Format:** Commencer par `-----BEGIN OPENSSH PRIVATE KEY-----`
- **⚠️ IMPORTANT:** Ne jamais partager cette clé et la garder uniquement dans GitHub Secrets

### Pour les tests / For Testing

Ces secrets sont utilisés par `.github/workflows/tests.yml` :

#### FLUX_USERNAME
- **Description:** Nom d'utilisateur pour accéder à Flux UI (composants Livewire)
- **Fourni par:** Licence Flux UI
- **Format:** Généralement une adresse email

#### FLUX_LICENSE_KEY
- **Description:** Clé de licence pour Flux UI
- **Fourni par:** Licence Flux UI
- **Format:** Chaîne alphanumérique

## 📝 Comment Ajouter les Secrets / How to Add Secrets

### Sur GitHub.com

1. Aller sur votre repository : `https://github.com/djcraft/histosport`
2. Cliquer sur **Settings** (Paramètres)
3. Dans le menu de gauche, cliquer sur **Secrets and variables** > **Actions**
4. Cliquer sur **New repository secret**
5. Entrer le nom du secret (ex: `SSH_HOST`)
6. Entrer la valeur du secret
7. Cliquer sur **Add secret**
8. Répéter pour chaque secret

### Via GitHub CLI

```bash
# Installer GitHub CLI si nécessaire
# https://cli.github.com/

# Authentification
gh auth login

# Ajouter un secret
gh secret set SSH_HOST --body "votre-serveur.example.com" --repo djcraft/histosport
gh secret set SSH_USER --body "deployer" --repo djcraft/histosport

# Pour SSH_PRIVATE_KEY (depuis un fichier)
gh secret set SSH_PRIVATE_KEY < ~/.ssh/histosport_deploy --repo djcraft/histosport

# Pour FLUX_USERNAME
gh secret set FLUX_USERNAME --body "votre@email.com" --repo djcraft/histosport

# Pour FLUX_LICENSE_KEY
gh secret set FLUX_LICENSE_KEY --body "votre-cle-license" --repo djcraft/histosport
```

## ✅ Vérification / Verification

Une fois les secrets configurés, vous pouvez vérifier qu'ils sont bien présents :

1. **Sur GitHub.com:**
   - Settings > Secrets and variables > Actions
   - Vous devriez voir la liste des secrets (les valeurs sont masquées)

2. **Via GitHub CLI:**
   ```bash
   gh secret list --repo djcraft/histosport
   ```

3. **Test du workflow:**
   - Créer un tag pour déclencher le déploiement :
     ```bash
     git tag v1.0.0
     git push origin v1.0.0
     ```
   - Vérifier les logs du workflow dans l'onglet Actions

## 🔒 Bonnes Pratiques de Sécurité / Security Best Practices

### ✅ À FAIRE / DO

- ✅ Utiliser des secrets différents pour staging et production
- ✅ Régénérer les clés SSH périodiquement (tous les 6-12 mois)
- ✅ Limiter les permissions des clés SSH au minimum nécessaire
- ✅ Utiliser des clés ED25519 plutôt que RSA (plus sécurisé)
- ✅ Auditer régulièrement qui a accès aux secrets
- ✅ Activer l'authentification 2FA sur GitHub

### ❌ À NE JAMAIS FAIRE / NEVER DO

- ❌ Ne jamais commiter des secrets dans le code
- ❌ Ne jamais partager des secrets par email ou chat
- ❌ Ne jamais réutiliser les mêmes secrets entre projets
- ❌ Ne jamais logger ou afficher les secrets dans les workflows
- ❌ Ne jamais utiliser la même clé SSH pour plusieurs serveurs

## 🔄 Rotation des Secrets / Secret Rotation

Il est recommandé de changer les secrets régulièrement :

### Rotation de la clé SSH (tous les 6 mois)

```bash
# 1. Générer une nouvelle paire de clés
ssh-keygen -t ed25519 -C "github-actions-deploy-$(date +%Y%m)" -f ~/.ssh/histosport_deploy_new

# 2. Ajouter la nouvelle clé publique sur le serveur
cat ~/.ssh/histosport_deploy_new.pub | ssh user@server 'cat >> ~/.ssh/authorized_keys'

# 3. Tester la nouvelle clé
ssh -i ~/.ssh/histosport_deploy_new user@server 'echo "Connexion OK"'

# 4. Mettre à jour le secret GitHub
gh secret set SSH_PRIVATE_KEY < ~/.ssh/histosport_deploy_new --repo djcraft/histosport

# 5. Tester le déploiement

# 6. Supprimer l'ancienne clé du serveur
ssh user@server
# Éditer ~/.ssh/authorized_keys et supprimer l'ancienne clé

# 7. Supprimer l'ancienne clé locale
rm ~/.ssh/histosport_deploy ~/.ssh/histosport_deploy.pub
mv ~/.ssh/histosport_deploy_new ~/.ssh/histosport_deploy
mv ~/.ssh/histosport_deploy_new.pub ~/.ssh/histosport_deploy.pub
```

## 📊 Environnements GitHub / GitHub Environments

Pour une meilleure organisation, vous pouvez créer des environnements :

1. **Settings** > **Environments** > **New environment**
2. Créer : `Testing`, `Staging`, `Production`
3. Configurer les secrets spécifiques à chaque environnement
4. Ajouter des règles de protection (approvals, timers, etc.)

## 🆘 Dépannage / Troubleshooting

### Le workflow échoue avec "Permission denied"

- Vérifier que `SSH_PRIVATE_KEY` contient bien la clé complète avec les lignes de début/fin
- Vérifier que la clé publique est dans `~/.ssh/authorized_keys` sur le serveur
- Vérifier les permissions du dossier `.ssh` sur le serveur : `chmod 700 ~/.ssh`

### Le workflow échoue avec "Host key verification failed"

Le workflow est configuré pour accepter automatiquement les clés d'hôte. Si le problème persiste :
- Vérifier que `SSH_HOST` est correct
- Vérifier que le serveur SSH est accessible depuis GitHub Actions

### Impossible d'installer les dépendances Flux

- Vérifier que `FLUX_USERNAME` et `FLUX_LICENSE_KEY` sont corrects
- Vérifier que la licence est active
- Contacter le support Flux UI si nécessaire

## 📚 Ressources / Resources

- [GitHub Secrets Documentation](https://docs.github.com/en/actions/security-guides/encrypted-secrets)
- [SSH Key Best Practices](https://www.ssh.com/academy/ssh/keygen)
- [GitHub Actions Security](https://docs.github.com/en/actions/security-guides/security-hardening-for-github-actions)
