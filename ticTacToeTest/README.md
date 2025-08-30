🏆 Auteur :Projet développé par Aymen Zaabar ✨
# 🎮 Morpion (Tic-Tac-Toe) - Laravel

Une application web simple de **Morpion (Tic-Tac-Toe)** réalisée avec **Laravel 11**.  
Elle permet de jouer en local, sauvegarder les parties, et afficher un **leaderboard** avec l’historique des résultats.

---

## 🚀 Fonctionnalités

- Plateau 3x3 interactif (Frontend en **Blade + JavaScript**).
- Détection automatique du gagnant ou du match nul.
- Sauvegarde des parties en base de données (via API Laravel).
- Leaderboard affichant la date et le résultat de chaque partie.

---

## 🛠️ Installation

### 1. Cloner le projet
```bash
git clone https://github.com/aymenzaabar/ticTacToe/tree/developer
cd morpion-laravel

### 2. Installer les dépendances PHP

```bash
composer install

###3. Lancer le serveur de développement
```bash
php artisan serve


Le projet sera disponible sur :
http://127.0.0.1:8000

app/
 ├── Http/
 │   ├── Controllers/
 │   │   └── GameController.php   # Gère l'API et l'affichage
 │   └── Services/
 │       └── GameService.php      # Contient la logique métier
 └── Models/
     └── Game.php                 # Modèle Eloquent

resources/
 └── views/
     └── game.blade.php           # Vue principale avec plateau + leaderboard
