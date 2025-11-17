# Liste de contrôle de sécurité / Security Checklist

Ce document fournit une liste de vérification complète pour s'assurer que le dépôt est sécurisé avant de le rendre public.

This document provides a comprehensive checklist to ensure the repository is secure before making it public.

## ✅ Contrôles effectués / Checks Completed

### 🔐 Secrets et données sensibles / Secrets and Sensitive Data

- [x] Aucun fichier `.env` n'est commis dans le dépôt
- [x] Aucun fichier `.env` n'existe dans l'historique Git
- [x] `.gitignore` est configuré pour exclure tous les fichiers sensibles
- [x] `.dockerignore` est configuré pour exclure les secrets des images Docker
- [x] Aucune clé API ou token hardcodé trouvé dans le code
- [x] Aucune clé privée (`.pem`, `.key`, etc.) dans le dépôt
- [x] Aucun mot de passe hardcodé dans le code
- [x] Aucun fichier de base de données (dumps, backups) commis
- [x] Les workflows GitHub utilisent des secrets pour les données sensibles

### 📝 Documentation

- [x] `README.md` avec instructions d'installation et avertissements de sécurité
- [x] `SECURITY.md` avec politique de sécurité et bonnes pratiques
- [x] `DEPLOYMENT.md` avec guide de déploiement sécurisé
- [x] `CONTRIBUTING.md` avec directives de sécurité pour les contributeurs
- [x] `.github/SECRETS.md` documentant les secrets GitHub Actions requis
- [x] `.env.example` avec commentaires de sécurité

### 🔧 Configuration

- [x] `APP_DEBUG` par défaut à `false` en production (config/app.php)
- [x] `APP_ENV` par défaut à `production` (config/app.php)
- [x] Telescope configuré avec restrictions d'accès (IP + Gate)
- [x] Sessions configurées correctement
- [x] CSRF protection activée (par défaut Laravel)
- [x] Configuration mail sans secrets hardcodés
- [x] Configuration base de données utilise `env()`
- [x] Tous les services utilisent des variables d'environnement

### 🤖 CI/CD et Workflows

- [x] Workflow CodeQL configuré pour l'analyse de sécurité
- [x] Workflow d'audit de dépendances configuré
- [x] Workflow de déploiement utilise des secrets GitHub
- [x] Workflow de tests configuré correctement
- [x] Workflow de linting configuré
- [x] Permissions GITHUB_TOKEN limitées dans tous les workflows
- [x] Aucun secret exposé dans les logs des workflows

### 🔒 Code et Dépendances

- [x] Aucune vulnérabilité détectée par CodeQL
- [x] Utilisation de Eloquent ORM (protection SQL injection)
- [x] Utilisation de Blade (protection XSS)
- [x] Validation des entrées utilisateur présente
- [x] Hachage des mots de passe avec Hash::make()
- [x] Dépendances Laravel à jour
- [x] Pas de dépendances avec vulnérabilités critiques connues

### 🐳 Docker

- [x] `.dockerignore` configuré pour exclure les secrets
- [x] Dockerfile ne copie pas de fichiers sensibles
- [x] `docker-compose.yml` utilise des variables d'environnement
- [x] Pas de ports sensibles exposés publiquement

### 📊 Monitoring et Logs

- [x] Logs configurés pour ne pas exposer de données sensibles
- [x] Telescope masque les paramètres sensibles en production
- [x] Headers de requêtes sensibles masqués dans Telescope
- [x] Configuration pour désactiver Telescope en production

## 🎯 Recommandations avant publication / Recommendations Before Going Public

### Actions immédiates / Immediate Actions

1. **Activer CodeQL sur le dépôt GitHub**
   - Settings > Security > Code security and analysis
   - Enable "CodeQL analysis"

2. **Activer Dependabot**
   - Settings > Security > Code security and analysis
   - Enable "Dependabot alerts"
   - Enable "Dependabot security updates"

3. **Configurer les secrets GitHub**
   - Suivre le guide dans `.github/SECRETS.md`
   - Ajouter tous les secrets requis

4. **Activer les protections de branches**
   - Settings > Branches > Add branch protection rule
   - Pour `main` :
     - Require pull request reviews
     - Require status checks to pass
     - Include administrators

5. **Vérifier les permissions du dépôt**
   - Settings > Manage access
   - Limiter l'accès en écriture aux administrateurs de confiance

### Actions recommandées / Recommended Actions

1. **Ajouter un fichier LICENSE**
   - Choisir une licence appropriée (MIT, GPL, etc.)
   - Ajouter le fichier à la racine du projet

2. **Configurer les GitHub Environments**
   - Créer des environnements : Testing, Staging, Production
   - Configurer les secrets spécifiques à chaque environnement
   - Ajouter des règles d'approbation pour Production

3. **Activer les GitHub Security Advisories**
   - Settings > Security > Security advisories
   - Permet de gérer les vulnérabilités privément

4. **Configurer les notifications de sécurité**
   - Settings > Notifications
   - Activer les notifications pour les alertes de sécurité

5. **Mettre en place un processus de revue de code**
   - Exiger au moins 1 approbation pour les PR
   - Utiliser CODEOWNERS pour les fichiers sensibles

## 🚨 Points d'attention en production / Production Attention Points

### Variables d'environnement critiques / Critical Environment Variables

Assurez-vous que ces variables sont correctement configurées sur le serveur de production :

```bash
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:votre_cle_unique_generee
APP_URL=https://votre-domaine-reel.fr

DB_PASSWORD=mot_de_passe_tres_fort_unique
MAIL_PASSWORD=mot_de_passe_mail_securise

TELESCOPE_ENABLED=false
# OU si vous devez l'utiliser
TELESCOPE_ALLOWED_IP=votre.ip.publique.specifique

ALLOW_REGISTRATION=false  # ou true selon vos besoins
```

### Sécurité du serveur / Server Security

- [ ] Pare-feu configuré (UFW, iptables)
- [ ] Fail2ban installé et configuré
- [ ] Certificat SSL/TLS valide installé
- [ ] HTTPS forcé (redirection HTTP → HTTPS)
- [ ] Headers de sécurité configurés (CSP, HSTS, etc.)
- [ ] Sauvegardes automatiques configurées
- [ ] Monitoring en place (logs, uptime, etc.)
- [ ] Mises à jour de sécurité automatiques activées

### Accès et permissions / Access and Permissions

- [ ] Accès SSH limité par clé (pas de mot de passe)
- [ ] Utilisateur non-root pour l'application
- [ ] Permissions fichiers correctement configurées (755/644)
- [ ] Storage et cache inscriptibles par www-data
- [ ] Base de données accessible uniquement en local
- [ ] Compte base de données dédié (pas root)

## 📈 Maintenance continue / Ongoing Maintenance

### Hebdomadaire / Weekly

- [ ] Vérifier les logs d'erreur
- [ ] Vérifier les alertes de sécurité GitHub
- [ ] Surveiller les performances

### Mensuelle / Monthly

- [ ] Mettre à jour les dépendances (après tests)
- [ ] Vérifier les sauvegardes
- [ ] Auditer les accès utilisateur
- [ ] Réviser les logs de sécurité

### Trimestrielle / Quarterly

- [ ] Audit de sécurité complet
- [ ] Rotation des secrets (clés SSH, etc.)
- [ ] Révision de la documentation
- [ ] Test du plan de reprise après sinistre

### Annuelle / Yearly

- [ ] Revue complète de la sécurité
- [ ] Mise à jour de Laravel vers la dernière LTS
- [ ] Audit de conformité (RGPD si applicable)
- [ ] Formation sécurité pour les contributeurs

## 🔗 Ressources / Resources

### Documentation

- [SECURITY.md](../SECURITY.md) - Politique de sécurité
- [DEPLOYMENT.md](../DEPLOYMENT.md) - Guide de déploiement
- [CONTRIBUTING.md](../CONTRIBUTING.md) - Guide de contribution
- [.github/SECRETS.md](SECRETS.md) - Configuration des secrets

### Outils de sécurité / Security Tools

- [GitHub CodeQL](https://codeql.github.com/)
- [GitHub Dependabot](https://github.com/dependabot)
- [Laravel Security](https://laravel.com/docs/security)
- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [Composer Audit](https://getcomposer.org/doc/03-cli.md#audit)
- [NPM Audit](https://docs.npmjs.com/cli/v8/commands/npm-audit)

### Support

En cas de problème de sécurité :
1. Consulter [SECURITY.md](../SECURITY.md)
2. Ne PAS créer d'issue publique
3. Contacter l'équipe de maintenance directement

## ✅ Validation finale / Final Validation

Avant de rendre le dépôt public, confirmer que :

- [ ] Tous les points de cette checklist sont verts
- [ ] La documentation est complète et à jour
- [ ] Les secrets GitHub sont configurés
- [ ] CodeQL et Dependabot sont activés
- [ ] Les protections de branches sont en place
- [ ] L'équipe est informée et formée
- [ ] Un plan de réponse aux incidents est en place

---

**Date de dernière vérification :** 2025-11-17

**Vérifié par :** GitHub Copilot Agent

**Statut :** ✅ Prêt pour publication publique
