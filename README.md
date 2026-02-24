# API REST Films

API en PHP qui récupère des films depuis TMDB et permet de sauvegarder des favoris.

## Installation

1. Créer un fichier `.env` à la racine du projet :
```
TMDB_API_KEY=ta_clé_api_tmdb
```
2. Lancer : `php -S localhost:8000`
3. Aller sur `http://localhost:8000`

## Routes

```
GET    /movies                      films populaires
GET    /movies?type=top_rated       films par type (popular, top_rated, upcoming, now_playing)
GET    /movies/{id}                 détails d'un film
GET    /movies/search?query=...     recherche par titre
GET    /favorites                   liste des favoris
POST   /favorites                   ajouter un favori
DELETE /favorites/{id}              supprimer un favori
```

## Exemples

```
GET http://localhost:8000/movies
GET http://localhost:8000/movies?type=top_rated
GET http://localhost:8000/movies/550
GET http://localhost:8000/movies/search?query=inception
```

POST /favorites avec Postman, body JSON :
```json
{ "id": 550, "title": "Fight Club", "poster_path": "/abc.jpg" }
```

DELETE /favorites/{id} :
```
DELETE http://localhost:8000/favorites/550
```

## Screenshots

![Accueil API](screen/get-accueil.png)
`GET /` — API en marche

![Détail film](screen/get-movie-550.png)
`GET /movies/550` — Détail Fight Club

![Recherche batman](screen/get-search-batman.png)
`GET /movies/search?query=batman` — Résultats recherche

![Ajout favori](screen/post-favorites.png)
`POST /favorites` — Film ajouté

![Route inconnue](screen/post-movies-404.png)
`POST /movies` — Route introuvable
