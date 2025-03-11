<?php

function getPath($file)
{
    // considering /gallery-server as the base dirctory
    $base = __DIR__ . "/..";
    $paths = [

    ];

    if (!isset($paths[$file])) {
        die("Error: Path '$file' not found.");
    }

    return $paths[$file];
}
