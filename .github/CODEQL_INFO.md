# Note sur CodeQL / CodeQL Information

## 🔍 Qu'est-ce que CodeQL ? / What is CodeQL?

CodeQL est un outil d'analyse de code statique développé par GitHub qui détecte automatiquement les vulnérabilités de sécurité dans votre code.

CodeQL is a static code analysis tool developed by GitHub that automatically detects security vulnerabilities in your code.

## 💰 Disponibilité / Availability

### ✅ GRATUIT / FREE pour :

- **Dépôts publics** (tous, sans limitation)
- **Public repositories** (all, without limitation)

### 💼 Nécessite GitHub Advanced Security pour :

- Dépôts privés dans une organisation
- Private repositories in an organization
- Nécessite un abonnement GitHub Advanced Security

## 🚀 Activation pour ce dépôt / Activation for this Repository

### Situation actuelle / Current Situation

Ce dépôt est actuellement **privé** et **n'est pas dans une organisation**. Par conséquent :

This repository is currently **private** and **not in an organization**. Therefore:

❌ CodeQL ne peut pas être activé maintenant
❌ CodeQL cannot be activated now

✅ Le workflow CodeQL est déjà configuré et prêt
✅ The CodeQL workflow is already configured and ready

### Après le passage en public / After Going Public

Une fois le dépôt rendu **public** :

Once the repository is made **public**:

1. **CodeQL s'activera automatiquement** - Aucune action requise !
2. **CodeQL will activate automatically** - No action required!

Le workflow `.github/workflows/codeql.yml` commencera à s'exécuter :
- À chaque push sur `main` et `develop`
- À chaque pull request
- Chaque lundi à 6h00 UTC (scan hebdomadaire)

## 🔧 Comment vérifier l'activation / How to Verify Activation

Une fois le dépôt public :

Once the repository is public:

1. Allez dans **Settings** > **Security** > **Code security and analysis**
2. Vérifiez que "CodeQL analysis" est **activé**
3. Consultez l'onglet **Security** > **Code scanning** pour voir les résultats

## 🛡️ En attendant / In the Meantime

Pendant que le dépôt est privé, nous avons mis en place :

While the repository is private, we have set up:

✅ **Security Audit Workflow** - Analyse les dépendances (fonctionne maintenant)
- Composer audit pour les dépendances PHP
- NPM audit pour les dépendances JavaScript
- S'exécute quotidiennement

✅ **Vérifications manuelles effectuées** :
- Scan manuel des secrets (aucun trouvé)
- Vérification de l'historique Git (propre)
- Audit de configuration (sécurisé)

## 📋 Alternative temporaire / Temporary Alternative

Si vous souhaitez une analyse de sécurité avant le passage en public, vous pouvez :

If you want security analysis before going public, you can:

### Option 1 : Analyse locale avec PHP_CodeSniffer

```bash
composer require --dev squizlabs/php_codesniffer
./vendor/bin/phpcs --standard=PSR12 app/
```

### Option 2 : PHPStan pour l'analyse statique

```bash
composer require --dev phpstan/phpstan
./vendor/bin/phpstan analyse app/
```

### Option 3 : Psalm

```bash
composer require --dev vimeo/psalm
./vendor/bin/psalm --init
./vendor/bin/psalm
```

## 🎯 Recommandation / Recommendation

**La meilleure option est de rendre le dépôt public dès que possible.**

**The best option is to make the repository public as soon as possible.**

Pourquoi / Why:
- ✅ CodeQL gratuit et automatique
- ✅ Dependabot gratuit et automatique  
- ✅ Meilleure visibilité et contributions
- ✅ Pas besoin d'organisation ou d'abonnement

## 📚 Ressources / Resources

- [CodeQL Documentation](https://codeql.github.com/)
- [GitHub Advanced Security Pricing](https://docs.github.com/en/get-started/learning-about-github/about-github-advanced-security)
- [Code Scanning for Public Repos](https://docs.github.com/en/code-security/code-scanning/automatically-scanning-your-code-for-vulnerabilities-and-errors/about-code-scanning)

## ❓ FAQ

**Q: Puis-je tester CodeQL avant de rendre le dépôt public ?**  
R: Non, pas sans créer une organisation avec GitHub Advanced Security. Mais le workflow est déjà configuré et testé.

**Q: Can I test CodeQL before making the repository public?**  
A: No, not without creating an organization with GitHub Advanced Security. But the workflow is already configured and tested.

**Q: Le workflow CodeQL va-t-il causer des erreurs maintenant ?**  
R: Non, le workflow est configuré mais ne s'exécutera pas tant que CodeQL n'est pas disponible. Une fois le dépôt public, il s'activera automatiquement.

**Q: Will the CodeQL workflow cause errors now?**  
A: No, the workflow is configured but won't run until CodeQL is available. Once the repository is public, it will activate automatically.

**Q: Dois-je supprimer le workflow CodeQL ?**  
R: **NON !** Gardez-le. Il s'activera automatiquement dès que le dépôt sera public.

**Q: Should I delete the CodeQL workflow?**  
A: **NO!** Keep it. It will activate automatically as soon as the repository is public.

---

**Conclusion:** Le workflow CodeQL est prêt. Il attendra simplement que le dépôt soit public pour s'activer. C'est normal et attendu.

**Conclusion:** The CodeQL workflow is ready. It will simply wait for the repository to be public to activate. This is normal and expected.
