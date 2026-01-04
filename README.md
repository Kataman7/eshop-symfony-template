# Picokeebs - Boutique en ligne

Une boutique en ligne minimaliste avec paiement Stripe, sans inscription utilisateur.

## Fonctionnalités

- Liste de produits
- Détails produit
- Paiement via Stripe Checkout (pas de compte requis)
- Design minimaliste et responsive

## Prérequis

- Docker et Docker Compose
- Pour prod : Base de données PostgreSQL externe

## Installation et lancement pour la première fois

1. Clonez le projet :
   ```bash
   git clone <url-du-repo>
   cd picokeebs
   ```

2. Copiez le fichier d'environnement :
   ```bash
   cp .env.example .env
   ```

3. Éditez `.env` et configurez :
   - `APP_SECRET` : une clé secrète aléatoire
   - `STRIPE_SECRET_KEY` : votre clé secrète Stripe (test ou live)

4. Pour le développement (DB dans Docker) :
   ```bash
   docker compose up --build
   ```

   La migration de la DB et l'ajout des produits d'exemple se feront automatiquement.

5. Accédez à http://localhost:8000

## Lancement après la première fois

```bash
docker compose up
```

## Production

Pour la production :

1. Configurez une base de données PostgreSQL externe.

2. Dans `.env`, changez `DATABASE_URL` pour pointer vers votre DB externe.

3. Changez `APP_ENV=prod`

4. Construisez et déployez avec Docker :
   ```bash
   docker compose -f compose.yaml up --build -d
   ```

## Structure

- `src/Entity/Product.php` : Entité produit
- `src/Entity/Order.php` : Entité commande
- `src/Controller/StoreController.php` : Contrôleur boutique
- `src/Controller/CheckoutController.php` : Contrôleur paiement
- `templates/` : Templates Twig
- `migrations/` : Migrations Doctrine

## Commandes utiles

- Ajouter des produits d'exemple : `php bin/console app:add-sample-products`
- Créer une migration : `php bin/console doctrine:migrations:diff`
- Appliquer migrations : `php bin/console doctrine:migrations:migrate`