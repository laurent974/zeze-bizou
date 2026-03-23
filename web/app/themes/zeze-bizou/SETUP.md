# Configuration du Thème Sage 11

## Technologies Configurées

✅ **TypeScript** - Configuration stricte avec vérification complète des types
✅ **SCSS** - Avec Bootstrap Grid uniquement (léger, 12KB)
✅ **Storybook** - Pour développer et tester les composants en isolation
✅ **Playwright** - Tests E2E multi-navigateurs

## Commandes NPM

```bash
# Développement
npm run dev          # Lancer Vite dev server
npm run build        # Build pour production

# Storybook
npm run storybook    # Lancer Storybook sur http://localhost:6006
npm run build-storybook # Build Storybook pour déploiement

# Playwright
npm test             # Lancer les tests Playwright
npm run test:ui      # Lancer Playwright avec interface UI
npm run playwright:install # Installer les navigateurs pour Playwright
```

## Structure des Composants

```
resources/
├── css/
│   ├── app.scss              # Styles principaux avec Bootstrap Grid
│   ├── editor.scss           # Styles pour l'éditeur Gutenberg
│   └── _bootstrap-grid.scss  # Import Bootstrap Grid uniquement
├── js/
│   ├── app.ts                # Point d'entrée TypeScript principal
│   ├── editor.ts             # Scripts pour l'éditeur Gutenberg
│   └── components/
│       ├── Button.ts         # Composant Button TypeScript
│       ├── Button.stories.ts # Stories Storybook pour Button
│       └── Grid.stories.ts   # Stories Storybook pour Grid
```

## Utilisation des Composants

### Composant Button

```typescript
import { createButton } from '@scripts/components/Button';

const button = createButton({
  text: 'Click Me',
  variant: 'primary',
  onClick: (event) => {
    console.log('Button clicked!', event);
  }
});

document.body.appendChild(button);
```

### Système de Grid Bootstrap

Le thème utilise uniquement le système de grid de Bootstrap (12 colonnes), sans le CSS complet.

```html
<div class="container">
  <div class="row">
    <div class="col-md-6">Contenu à gauche</div>
    <div class="col-md-6">Contenu à droite</div>
  </div>
</div>
```

Points d'arrêt disponibles :
- `col-sm` (≥576px)
- `col-md` (≥768px)
- `col-lg` (≥992px)
- `col-xl` (≥1200px)
- `col-xxl` (≥1400px)

## Storybook

Storybook est configuré avec des exemples pour :
- **Button** : Différents variants (primary, secondary)
- **Grid** : Démonstrations de grille responsive (2, 3, 4 colonnes)

Pour ajouter de nouvelles stories, créez des fichiers `.stories.ts` dans `resources/js/components/`.

## Playwright

Les tests Playwright sont dans `tests/`. Exemples inclus :
- Vérification du titre de la page
- Vérification de la visibilité du header/footer

Pour exécuter les tests dans différents navigateurs :
```bash
npm test  # Exécute sur tous les navigateurs configurés
```

## Développement

1. **Démarrer WordPress** avec DDEV
2. **Lancer Vite** : `npm run dev`
3. **Voir les changements** en temps réel
4. **Tester les composants** avec Storybook : `npm run storybook`
5. **Exécuter les tests** : `npm test`

## Licence

Ce thème utilise des variables CSS personnalisées pour les couleurs :
- `--primary-color`: #007cba
- `--secondary-color`: #6c757d

Le CSS compilé est dans `public/build/` (généré automatiquement par Vite).
