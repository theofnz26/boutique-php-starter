# 📚 Glossaire des Commandes Git

Ce fichier récapitule les commandes essentielles pour gérer les versions de mon projet.

| Commande | À quoi ça sert ? (Explication simple) | Exemple concret |
| :--- | :--- | :--- |
| **1. LES BASES QUOTIDIENNES** | | |
| `git status` | **La boussole.** Me dit où j'en suis : quels fichiers sont modifiés, nouveaux (rouge) ou prêts à être validés (vert). | `git status` |
| `git add .` | **Le carton.** Met TOUS les fichiers modifiés/nouveaux dans la zone de préparation ("stage"). | `git add .` |
| `git commit -m "..."` | **Le scotch.** Ferme le carton et colle une étiquette dessus. Sauvegarde une version locale. | `git commit -m "Ajout de la page contact"` |
| `git push` | **L'envoi.** Expédie mes cartons (commits) vers le serveur (GitHub). | `git push` |
| **2. TRAVAIL EN ÉQUIPE / MISES À JOUR** | | |
| `git pull` | **La réception.** Télécharge les modifs qui sont sur GitHub et les fusionne avec mon code. À faire si `git push` est bloqué. | `git pull` |
| `git clone [url]` | **Le téléchargement.** Récupère un projet complet depuis GitHub pour la première fois. | `git clone https://github.com/...` |
| **3. CORRECTIONS & NETTOYAGE** | | |
| `git rm [fichier]` | **La suppression propre.** Supprime un fichier de mon ordi ET dit à Git de l'oublier. | `git rm assets/images/mauvaise.jpg` |
| `git restore [fichier]` | **L'annulation.** "Oups, j'ai cassé ce fichier, remets-le comme au dernier commit". | `git restore public/index.php` |
| `git log` | **L'historique.** Affiche la liste de tous les commits précédents (Tape `q` pour quitter). | `git log` |
| **4. CONFIGURATION (Rarement utilisé)** | | |
| `git config --global user.name` | Définit mon nom pour les signatures de commits. | `git config --global user.name "Theo"` |
| `git config --global pull.rebase false` | Configure Git pour qu'il fusionne (merge) automatiquement lors d'un pull (évite les blocages). | `git config --global pull.rebase false` |