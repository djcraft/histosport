# Guide de Contribution / Contributing Guide

Merci de votre intérêt pour contribuer à HistoSport ! / Thank you for your interest in contributing to HistoSport!

## 🔒 Règles de sécurité / Security Rules

**CRITIQUE / CRITICAL:** Avant de contribuer, lisez attentivement :

### ❌ À NE JAMAIS FAIRE / NEVER DO

1. **Ne jamais commiter de secrets** / **Never commit secrets**
   - Fichiers `.env`
   - Clés API, tokens, mots de passe
   - Clés privées (`.pem`, `.key`, etc.)
   - Certificats SSL
   - Identifiants de base de données

2. **Ne jamais désactiver les protections de sécurité** / **Never disable security protections**
   - CSRF protection
   - XSS filtering
   - SQL injection protection
   - Rate limiting

3. **Ne jamais exposer des données sensibles** / **Never expose sensitive data**
   - Informations utilisateur
   - Logs contenant des secrets
   - Détails internes de l'application

### ✅ Bonnes pratiques / Best Practices

1. **Toujours utiliser des variables d'environnement** / **Always use environment variables**
   ```php
   // ✅ Bon / Good
   $apiKey = env('API_KEY');
   
   // ❌ Mauvais / Bad
   $apiKey = 'sk_live_abc123xyz';
   ```

2. **Valider toutes les entrées utilisateur** / **Validate all user inputs**
   ```php
   // ✅ Bon / Good
   $validated = $request->validate([
       'email' => 'required|email',
       'name' => 'required|string|max:255',
   ]);
   ```

3. **Utiliser les fonctionnalités de sécurité de Laravel** / **Use Laravel's security features**
   - Eloquent ORM (prévient SQL injection)
   - Blade templating (prévient XSS)
   - Middleware CSRF
   - Hash::make() pour les mots de passe

4. **Tester votre code** / **Test your code**
   ```bash
   ./vendor/bin/pest
   composer audit
   npm audit
   ```

## 🔍 Avant de soumettre une Pull Request / Before Submitting a PR

### 1. Vérifier les secrets / Check for secrets

```bash
# Vérifier qu'aucun secret n'est présent
git diff --cached

# Vérifier les fichiers ignorés
git status --ignored
```

### 2. Exécuter les tests / Run tests

```bash
# Tests PHP
./vendor/bin/pest

# Linting PHP
./vendor/bin/pint

# Audit de sécurité
composer audit
npm audit
```

### 3. Vérifier les vulnérabilités / Check for vulnerabilities

```bash
# Dépendances PHP
composer audit

# Dépendances JavaScript
npm audit

# Corriger les vulnérabilités automatiquement (avec précaution)
npm audit fix
```

### 4. Checklist avant commit / Pre-commit checklist

- [ ] Aucun secret dans le code
- [ ] Aucun fichier `.env` ou `.key` ajouté
- [ ] Validation des entrées utilisateur
- [ ] Tests ajoutés/mis à jour
- [ ] Pas de `console.log()` ou `dd()` oubliés
- [ ] Code linté (./vendor/bin/pint)
- [ ] Documentation mise à jour si nécessaire
- [ ] Commits descriptifs et clairs

## 🐛 Signaler un bug / Report a Bug

### Bug de sécurité / Security Bug

**NE PAS créer d'issue publique!** / **DO NOT create a public issue!**

Consultez [SECURITY.md](SECURITY.md) pour le processus de signalement sécurisé.

### Bug normal / Regular Bug

Pour les bugs non liés à la sécurité, créez une issue avec :

1. Description claire du problème
2. Étapes pour reproduire
3. Comportement attendu vs observé
4. Version PHP, Laravel, navigateur
5. Logs d'erreur (sans données sensibles)

## 💡 Proposer une fonctionnalité / Propose a Feature

1. Vérifier qu'une issue similaire n'existe pas déjà
2. Créer une issue décrivant :
   - Le problème que cela résout
   - La solution proposée
   - Les alternatives considérées
   - Impact sur la sécurité (si applicable)

## 🔄 Processus de contribution / Contribution Process

### 1. Fork & Clone

```bash
# Fork le projet sur GitHub
# Puis clone votre fork
git clone https://github.com/votre-username/histosport.git
cd histosport

# Ajouter l'upstream
git remote add upstream https://github.com/djcraft/histosport.git
```

### 2. Créer une branche / Create a branch

```bash
# Partir de develop
git checkout develop
git pull upstream develop

# Créer une branche descriptive
git checkout -b feature/ma-fonctionnalite
# ou
git checkout -b fix/correction-du-bug
```

### 3. Développer / Develop

```bash
# Copier .env.example
cp .env.example .env

# Installer les dépendances
composer install
npm install

# Générer la clé
php artisan key:generate

# Créer la DB et migrer
touch database/database.sqlite
php artisan migrate

# Développer votre fonctionnalité
# ...

# Tester régulièrement
./vendor/bin/pest
./vendor/bin/pint
```

### 4. Commit

```bash
# Commits atomiques et descriptifs
git add .
git commit -m "feat: ajout de la fonctionnalité X"

# Convention de commits (recommandé)
# feat: nouvelle fonctionnalité
# fix: correction de bug
# docs: documentation
# style: formatage (sans changement de code)
# refactor: refactoring
# test: ajout de tests
# chore: tâches de maintenance
```

### 5. Push & Pull Request

```bash
# Push vers votre fork
git push origin feature/ma-fonctionnalite
```

Puis sur GitHub :
1. Créer une Pull Request vers `develop`
2. Décrire clairement les changements
3. Référencer les issues liées
4. Cocher les cases de la checklist
5. Attendre la review

## 📋 Standards de code / Code Standards

### PHP

- Suivre PSR-12
- Utiliser les conventions Laravel
- Commenter les parties complexes
- Types stricts quand possible

```php
<?php

declare(strict_types=1);

namespace App\Actions;

class MonAction
{
    /**
     * Description claire de la fonction
     */
    public function execute(string $param): bool
    {
        // Code clair et lisible
        return true;
    }
}
```

### JavaScript

- Code ES6+
- Utiliser const/let (pas var)
- Nommer clairement les variables
- Commenter les parties complexes

### Blade

- Toujours échapper les variables : `{{ $variable }}`
- Utiliser `{!! !!}` uniquement si absolument nécessaire
- Components plutôt que includes quand possible

## 🧪 Tests

Tous les nouveaux features doivent avoir des tests :

```php
<?php

use App\Models\User;

test('user can register', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertRedirect('/dashboard');
    expect(User::where('email', 'test@example.com')->exists())->toBeTrue();
});
```

## 📝 Documentation

- README.md : Vue d'ensemble et installation
- SECURITY.md : Politiques de sécurité
- DEPLOYMENT.md : Guide de déploiement
- Code comments : Logique complexe
- DocBlocks : Fonctions publiques

## ❓ Questions ?

- Ouvrir une discussion sur GitHub
- Consulter la documentation Laravel
- Lire les issues existantes

## 🙏 Merci / Thank You

Votre contribution améliore le projet pour tous !
Your contribution makes the project better for everyone!

---

**Important:** En contribuant, vous acceptez que votre code soit sous licence MIT.
**Important:** By contributing, you agree that your code will be under the MIT license.
