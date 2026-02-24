<?php

// Charge les variables du fichier .env
$env = parse_ini_file(__DIR__ . '/../.env');

// Configuration TMDB
define('TMDB_API_KEY', $env['TMDB_API_KEY']);
define('TMDB_BASE_URL', 'https://api.themoviedb.org/3');
define('ALLOWED_TYPES', ['popular', 'top_rated', 'upcoming', 'now_playing']);
