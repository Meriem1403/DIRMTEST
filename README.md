# DIRM — prototype formulaires

Prototype Symfony des **formulaires administratifs** de la Direction interrégionale de la mer Méditerranée.

Le dépôt de travail suivi est [Dirm](https://github.com/Meriem1403/Dirm) (branche `final`). Celui-ci sert de variante de développement : squelette Symfony, Docker et premiers écrans, sans le périmètre complet des demandes.

<p align="center">
  <img src="https://img.shields.io/badge/php-8.2-777BB4?logo=php&logoColor=white" alt="PHP 8.2" />
  <img src="https://img.shields.io/badge/symfony-7.3-000000?logo=symfony&logoColor=white" alt="Symfony 7.3" />
  <img src="https://img.shields.io/badge/docker-ready-2496ED?logo=docker&logoColor=white" alt="Docker" />
</p>

<p align="center">
  <strong>Dépôt :</strong> <a href="https://github.com/Meriem1403/DIRMTEST">github.com/Meriem1403/DIRMTEST</a>
</p>

---

## Sommaire

- [Présentation](#présentation)
- [Stack technique](#stack-technique)
- [Prérequis](#prérequis)
- [Installation](#installation)
- [Qualité](#qualité)
- [Sécurité](#sécurité)
- [Structure du projet](#structure-du-projet)

---

## Présentation

DIRMTEST reprend le socle Symfony 7.3 (Twig, Doctrine, Stimulus, Turbo) pour itérer sur les formulaires avant de les porter dans Dirm. Il n'est pas la référence fonctionnelle : les demandes de mobilité, d'habilitation et de chantier sont dans l'autre dépôt.

---

## Stack technique

| Couche | Technologies |
|--------|----------------|
| Backend | PHP 8.2, Symfony 7.3 |
| Données | Doctrine ORM |
| Frontend | Twig, Stimulus, Turbo |
| Qualité | PHPUnit, CodeQL |
| Conteneurisation | Docker Compose (`compose.yaml`) |

---

## Prérequis

- **Docker** et Docker Compose
- **Git**

---

## Installation

```bash
git clone https://github.com/Meriem1403/DIRMTEST.git
cd DIRMTEST
docker compose up --build
```

Le compose démarre MySQL, phpMyAdmin (port **8081**) et Mailpit (port **8026**). Il ne lance pas le serveur PHP : créer un `.env.local` non versionné avec `APP_SECRET` et `DATABASE_URL`, puis démarrer Symfony (`symfony serve` ou le serveur PHP du projet).

Le mot de passe de cette base locale est celui du compose. Le changer avant tout usage autre que le poste de développement.

---

## Qualité

GitHub Actions exécute les tests (`.github/workflows/tests.yml`) et l'analyse CodeQL (`.github/workflows/codeql.yml`) sur ce dépôt.

```bash
php bin/phpunit
```

---

## Sécurité

Même règle que sur Dirm : pas de secret dans Git. Ce prototype ne doit pas recevoir de copie d'une base réelle.

---

## Structure du projet

```
DIRMTEST/
├── src/                 # Noyau Symfony
├── templates/
├── migrations/
├── compose.yaml
└── .github/workflows/   # tests, CodeQL
```

---

<p align="center">
  <sub>Prototype. Le produit suivi est <a href="https://github.com/Meriem1403/Dirm">Dirm</a>.</sub>
</p>
