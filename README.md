# Système de Gestion de Scolarité et de Notes

## Présentation

Ce projet est une application web développée avec Laravel dans le cadre du module **Programmation Web et Framework** de l'Université Joseph Ki-Zerbo.

L'application permet la gestion administrative, financière et pédagogique d'un établissement d'enseignement primaire (CP1 à CM2).

---

## Membres du groupe N°5

- Sawadogo Wendwaoga Kevin Marie
- Sam Ibrahim

---

## Encadrement

**Enseignant :**
Docteur Lionel Marcus G. KABORET

**Université :**
Université Joseph Ki-Zerbo
UFR / SEA

---

## Objectifs du projet

L'application permet :

### Gestion administrative et financière

- Authentification sécurisée
- Gestion des utilisateurs
- Gestion des classes
- Gestion des élèves
- Ajout de photos des élèves
- Définition des frais de scolarité par classe
- Enregistrement des paiements
- Calcul automatique du reste à payer
- Génération des reçus PDF

### Gestion pédagogique

- Gestion des matières
- Saisie des notes
- Modification des notes
- Calcul des moyennes
- Classement des élèves

### Bulletins

- Génération des bulletins par classe
- Export PDF des bulletins

### Tableau de bord

- Nombre total d'élèves
- Nombre total de classes
- Montant total des frais collectés
- Montant restant à recouvrer
- Élèves en retard de paiement

---

## Technologies utilisées

- PHP 
- Laravel
- MySQL
- Tailwind CSS
- JavaScript
- DomPDF

---

## Installation

### 1. Cloner le projet

```bash
git clone https://github.com/VOTRE_COMPTE/projet-gestion-scolaire.git
```

### 2. Entrer dans le dossier

```bash
cd projet-gestion-scolaire
```

### 3. Installer les dépendances

```bash
composer install
```

### 4. Copier le fichier d'environnement

```bash
cp .env.example .env
```


```bash
copy .env.example .env
```

### 5. Générer la clé Laravel

```bash
php artisan key:generate
```

### 6. Configurer la base de données

Modifier le fichier `.env`

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=app_gestion
DB_USERNAME=root
DB_PASSWORD=
```

### 7. Exécuter les migrations

```bash
php artisan migrate
```

```bash
php artisan migrate:fresh --seed

### 8. Installer les dépendances

Installer Node.js (si pas déjà fait)

npm install

### 10. Lancer le compilateur 
juste Lancer (dans un terminal)
    npm run dev

Installer
    npm run build

### 9. Lancer le serveur

```bash
php artisan serve
```

---

## Structure de la base de données

### Tables principales

- users
- classes
- eleves
- matieres
- notes
- paiements

---

## Rôles utilisateurs

### Gestionnaire

Le gestionnaire peut :

- Gérer les classes
- Gérer les élèves
- Gérer les matières
- Enregistrer les paiements
- Générer les reçus PDF
- Consulter le tableau de bord

### Enseignant

L'enseignant peut :

- Consulter les classes
- Saisir les notes
- Modifier les notes
- Générer les relevés
- Générer les bulletins

---

## Fonctionnalités réalisées

### Authentification

- Connexion
- Déconnexion
- Gestion des rôles

### Gestion des classes

- Ajout
- Modification
- Suppression

### Gestion des élèves

- Ajout
- Modification
- Suppression
- Photo

### Gestion des matières

- Ajout
- Modification
- Suppression

### Gestion des paiements

- Enregistrement des versements
- Calcul du reste à payer
- Reçu PDF

### Gestion des notes

- Saisie des notes
- Modification groupée
- Relevés de notes

### Bulletins

- Génération des bulletins
- Export PDF

---


