<?php
function getPath($file){
    $jsonPath = __DIR__ . '/paths.json';

    if (!file_exists($jsonPath)) {
        die("Error: paths.json not found. Run pathsBuilder.php script.");
    }

    $paths = json_decode(file_get_contents($jsonPath), true);

    if (!isset($paths[$file])) {
        die("Error: Path '$file' not found.");
    }

    return $paths[$file];
}

