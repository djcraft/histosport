# Politique de Sécurité / Security Policy

## Signalement de vulnérabilités / Reporting Security Vulnerabilities

🇫🇷 **Français:**

Si vous découvrez une vulnérabilité de sécurité dans ce projet, veuillez **NE PAS** créer d'issue publique. À la place, envoyez un email à l'équipe de maintenance avec les détails suivants :

- Description de la vulnérabilité
- Étapes pour reproduire le problème
- Impact potentiel
- Suggestions de correction (si disponibles)

Nous nous engageons à répondre dans les 48 heures et à travailler avec vous pour résoudre le problème rapidement.

---

🇬🇧 **English:**

If you discover a security vulnerability in this project, please **DO NOT** create a public issue. Instead, send an email to the maintenance team with the following details:

- Description of the vulnerability
- Steps to reproduce the issue
- Potential impact
- Suggested fix (if available)

We commit to responding within 48 hours and working with you to resolve the issue quickly.

## Bonnes pratiques de sécurité / Security Best Practices

### Configuration de production / Production Configuration

#### Variables d'environnement critiques / Critical Environment Variables

**⚠️ IMPORTANT:** Les valeurs suivantes doivent TOUJOURS être configurées correctement en production :

```bash
# Environnement - DOIT être "production"
APP_ENV=production

# Debug - DOIT être "false" en production
APP_DEBUG=false

# Clé d'application - DOIT être unique et générée aléatoirement
APP_KEY=base64:VotreClefGenereeAleatoirement...

# URL de l'application - Configurez votre domaine réel
APP_URL=https://votre-domaine.fr

# Base de données - Utilisez des mots de passe forts
DB_PASSWORD=un_mot_de_passe_tres_fort_et_unique

# Mail - Ne jamais utiliser les valeurs par défaut
MAIL_PASSWORD=votre_mot_de_passe_smtp_securise
```

#### Telescope - Sécurisation de l'accès

Telescope est un outil de débogage puissant qui **NE DOIT PAS** être accessible publiquement en production :

```bash
# Désactiver complètement Telescope en production (recommandé)
TELESCOPE_ENABLED=false

# OU restreindre l'accès par IP
TELESCOPE_ALLOWED_IP=votre.ip.publique.autorisee
```

**Note:** L'accès à Telescope est également restreint à l'utilisateur avec l'ID 1 dans le code. Assurez-vous que seuls les administrateurs de confiance ont cet ID.

#### Inscription utilisateur

Contrôlez si les nouveaux utilisateurs peuvent s'inscrire :

```bash
# Désactiver en production si vous ne voulez pas d'inscriptions publiques
ALLOW_REGISTRATION=false
```

### Fichiers sensibles / Sensitive Files

Les fichiers suivants ne doivent **JAMAIS** être commis dans Git :

- `.env` - Contient toutes vos configurations sensibles
- `storage/*.key` - Clés de chiffrement
- `auth.json` - Identifiants Composer
- Fichiers de base de données (`.sqlite`, `.db`)
- Logs contenant des données sensibles

**Vérification:** Le fichier `.gitignore` est déjà configuré pour ignorer ces fichiers.

### Dépendances / Dependencies

```bash
# Vérifier les vulnérabilités connues
composer audit

# Mettre à jour les dépendances (avec précaution)
composer update
npm audit
npm audit fix
```

### Permissions fichiers / File Permissions

Sur le serveur de production :

```bash
# Le code de l'application doit être en lecture seule
chmod -R 755 /chemin/vers/laravel

# Storage et cache doivent être inscriptibles
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Base de données / Database

- Utilisez toujours des mots de passe forts et uniques
- Ne jamais utiliser le compte `root` en production
- Limitez les privilèges au strict nécessaire
- Activez le chiffrement des connexions (SSL/TLS) si possible
- Effectuez des sauvegardes régulières

### HTTPS / SSL/TLS

**OBLIGATOIRE en production:**

- Utilisez toujours HTTPS
- Configurez `APP_URL` avec `https://`
- Utilisez un certificat SSL valide (Let's Encrypt recommandé)
- Configurez le fichier `config/session.php` : `'secure' => true`
- Activez HSTS (HTTP Strict Transport Security)

### Mises à jour de sécurité / Security Updates

- Surveillez les mises à jour de Laravel et ses dépendances
- Appliquez les correctifs de sécurité rapidement
- Testez dans un environnement de staging avant la production

## Configuration Docker

Si vous utilisez Docker en production :

```bash
# Ne jamais exposer directement les ports de base de données
# Utilisez un reverse proxy (nginx, traefik)
# Ne montez pas de volumes sensibles en lecture-écriture depuis l'hôte
# Utilisez des secrets Docker pour les données sensibles
```

## Checklist de déploiement sécurisé / Secure Deployment Checklist

Avant de déployer en production :

- [ ] `APP_ENV=production`
- [ ] `APP_DEBUG=false`
- [ ] `APP_KEY` généré avec `php artisan key:generate`
- [ ] Tous les mots de passe dans `.env` sont forts et uniques
- [ ] `TELESCOPE_ENABLED=false` ou `TELESCOPE_ALLOWED_IP` configuré
- [ ] `ALLOW_REGISTRATION` configuré selon vos besoins
- [ ] HTTPS activé avec certificat valide
- [ ] Permissions fichiers correctement configurées
- [ ] Sauvegardes de base de données configurées
- [ ] Logs d'erreurs configurés (pas affichés aux utilisateurs)
- [ ] Rate limiting activé sur les routes sensibles
- [ ] CSRF protection activé (par défaut dans Laravel)
- [ ] Validation des entrées utilisateur partout
- [ ] Headers de sécurité configurés (CSP, X-Frame-Options, etc.)

## Support des versions / Version Support

| Version | Supportée          |
| ------- | ------------------ |
| Latest  | :white_check_mark: |
| < Latest| :x:                |

Nous recommandons de toujours utiliser la dernière version stable.

## Ressources supplémentaires / Additional Resources

- [Laravel Security Documentation](https://laravel.com/docs/security)
- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [PHP Security Best Practices](https://www.php.net/manual/en/security.php)
