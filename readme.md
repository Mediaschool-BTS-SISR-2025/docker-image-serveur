Got it 😎
Voici ton README **prêt à copier-coller directement** — aucun code HTML, aucun markup inutile, juste du pur Markdown propre.
Tu peux coller ça **tel quel dans ton README.md**, ça s’affichera nickel sur GitHub 👇

---

# 🧱 MediaSchool Dev Environment

🚀 Environnement complet Dockerisé pour MediaSchool — un seul `docker-compose up` et c’est parti !

---

## 🏁 Démarrage Rapide

### 1️⃣ Cloner le projet

```bash
git clone <url_du_projet>
cd mediaschool
```

---

### 2️⃣ Ajouter votre code

Placez vos fichiers dans la bonne structure :

```
.
├── backend/
│   └── src/        ← votre code backend (PHP, Node.js, etc.)
│
└── frontend/
    └── src/        ← votre code frontend (React, Vue, HTML/CSS, etc.)
```

---

### 3️⃣ Lancer l’environnement

Depuis la racine du projet :

```bash
docker-compose up -d --build
```

🕐 Le premier lancement peut prendre quelques minutes pendant la construction des images.

---

## ✨ Workflow Dev

Une fois lancé :

1. Codez dans `backend/src` ou `frontend/src`
2. Sauvegardez vos fichiers
3. Rafraîchissez le navigateur

💡 Les changements s’appliquent instantanément — zéro redémarrage requis.

---

## 🌐 Accès aux Services

| Service                      | URL Locale                                     | Notes / Identifiants          |
| ---------------------------- | ---------------------------------------------- | ----------------------------- |
| 🖥️ Frontend (Site Web)      | [http://localhost:3000](http://localhost:3000) | Résultat de votre code        |
| 🧮 phpMyAdmin                | [http://localhost:8080](http://localhost:8080) | Interface de gestion MySQL    |
| 🗄️ Base de Données (direct) | `localhost:3306`                               | Pour DBeaver, TablePlus, etc. |

**Identifiants MySQL :**

```
Utilisateur : mediaschooluser
Mot de passe : mediaschoolpass
Base : mediaschooldb
```

---

## 🛠️ Commandes Docker Utiles

| Action                             | Commande                         |
| ---------------------------------- | -------------------------------- |
| 🚫 Stopper tous les services       | `docker-compose down`            |
| 🧩 Voir l’état des services        | `docker-compose ps`              |
| 🧾 Logs d’un service (ex: backend) | `docker-compose logs -f backend` |

---

## 🧩 Stack Technique

| Composant           | Technologie              |
| ------------------- | ------------------------ |
| 🐳 Conteneurisation | Docker & Docker Compose  |
| ⚙️ Backend          | PHP / Node.js            |
| 🎨 Frontend         | React / Vue / HTML / CSS |
| 💾 Base de données  | MySQL                    |
| 🧮 Admin DB         | phpMyAdmin               |

---

## 💡 Tips & Tricks

* 🔁 Si tu modifies la config Docker :

  ```bash
  docker-compose up -d --build
  ```
* 🧹 Nettoyer ton environnement :

  ```bash
  docker system prune -a
  ```
* 🕵️‍♂️ Debug rapide :

  ```bash
  docker-compose logs -f backend
  ```

---

## 👨‍💻 Auteur

**Tiago Q**
Environnement de développement prêt à coder — sans prise de tête 🧠💻

Made with ❤️ & ☕ by the MediaSchool SISR Team

---
