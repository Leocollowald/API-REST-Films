<?php

require_once __DIR__ . '/../services/TMDBService.php';

// Gère les routes liées aux films
class MovieController
{
    // GET /movies?type=...
    public static function list(string $type): void
    {
        if (!in_array($type, ALLOWED_TYPES)) {
            http_response_code(400);
            echo json_encode(['error' => 'Type invalide. Types acceptés : ' . implode(', ', ALLOWED_TYPES)]);
            return;
        }

        $data = TMDBService::getMovies($type);

        if (isset($data['error'])) {
            http_response_code(500);
        }

        echo json_encode($data);
    }

    // GET /movies/{id}
    public static function show(int $id): void
    {
        $data = TMDBService::getMovieById($id);

        if (isset($data['error'])) {
            http_response_code(404);
        }

        echo json_encode($data);
    }

    // GET /movies/search?query=...
    public static function search(string $query): void
    {
        if (empty($query)) {
            http_response_code(400);
            echo json_encode(['error' => 'Paramètre "query" manquant']);
            return;
        }

        $data = TMDBService::searchMovies($query);

        if (isset($data['error'])) {
            http_response_code(500);
        }

        echo json_encode($data);
    }
}
