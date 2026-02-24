<?php

define('FAVORITES_FILE', __DIR__ . '/../data/favorites.json');

// Gère les routes liées aux favoris (stockés dans un fichier JSON)
class FavoriteController
{
    private static function readFavorites(): array
    {
        if (!file_exists(FAVORITES_FILE)) {
            return [];
        }
        return json_decode(file_get_contents(FAVORITES_FILE), true) ?? [];
    }

    private static function writeFavorites(array $favorites): void
    {
        file_put_contents(FAVORITES_FILE, json_encode($favorites, JSON_PRETTY_PRINT));
    }

    // GET /favorites
    public static function index(): void
    {
        echo json_encode(self::readFavorites());
    }

    // POST /favorites
    public static function store(): void
    {
        $movie = json_decode(file_get_contents('php://input'), true);

        if (!$movie || !isset($movie['id'], $movie['title'])) {
            http_response_code(400);
            echo json_encode(['error' => '"id" et "title" sont requis']);
            return;
        }

        $favorites = self::readFavorites();

        foreach ($favorites as $fav) {
            if ($fav['id'] === $movie['id']) {
                http_response_code(409);
                echo json_encode(['error' => 'Déjà dans les favoris']);
                return;
            }
        }

        $favorites[] = [
            'id'          => $movie['id'],
            'title'       => $movie['title'],
            'poster_path' => $movie['poster_path'] ?? null,
        ];

        self::writeFavorites($favorites);

        http_response_code(201);
        echo json_encode(['message' => 'Film ajouté', 'movie' => $movie['title']]);
    }

    // DELETE /favorites/{id}
    public static function destroy(int $id): void
    {
        $favorites = self::readFavorites();
        $updated = array_filter($favorites, fn($fav) => $fav['id'] !== $id);

        if (count($updated) === count($favorites)) {
            http_response_code(404);
            echo json_encode(['error' => 'Film non trouvé dans les favoris']);
            return;
        }

        self::writeFavorites(array_values($updated));
        echo json_encode(['message' => 'Film retiré des favoris']);
    }
}
