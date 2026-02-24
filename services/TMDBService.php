<?php

// Gère tous les appels vers l'API TMDB
class TMDBService
{
    public static function getMovies(string $type): array
    {
        $url = TMDB_BASE_URL . "/movie/$type?api_key=" . TMDB_API_KEY . "&language=fr-FR";
        $response = file_get_contents($url);

        if ($response === false) {
            return ['error' => 'Impossible de contacter TMDB'];
        }

        return json_decode($response, true);
    }

    public static function getMovieById(int $id): array
    {
        $url = TMDB_BASE_URL . "/movie/$id?api_key=" . TMDB_API_KEY . "&language=fr-FR";
        $response = file_get_contents($url);

        if ($response === false) {
            return ['error' => 'Film introuvable'];
        }

        return json_decode($response, true);
    }

    public static function searchMovies(string $query): array
    {
        $url = TMDB_BASE_URL . "/search/movie?api_key=" . TMDB_API_KEY . "&language=fr-FR&query=" . urlencode($query);
        $response = file_get_contents($url);

        if ($response === false) {
            return ['error' => 'Recherche impossible'];
        }

        return json_decode($response, true);
    }
}
