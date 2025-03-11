<?php

function buildPaths($dir, $base)
{
    $paths = [];
    $files = scandir($dir);

    foreach ($files as $file) {
        if ($file === '.' || $file === '..') {
            continue;
        }

        $fullPath = realpath("$dir/$file");

        if (is_dir($fullPath)) {
            $paths = array_merge($paths, buildPaths($fullPath, $base));
        } else {
            $key = pathinfo($file, PATHINFO_FILENAME);
            $paths[$key] = $fullPath;
        }
    }

    return $paths;
}

$baseDir = realpath(__DIR__ . "/..");
$paths = buildPaths($baseDir, $baseDir);

// Save paths.json
file_put_contents(__DIR__ . '/paths.json', json_encode($paths, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

echo "paths.json generated successfully!\n";
