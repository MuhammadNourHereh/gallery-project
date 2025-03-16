<?php
define("UPLOADS_DIR", realpath(__DIR__ . "/../uploads") . "/");

function varifyAndSave($base64): bool|string
{

    if (preg_match('/data:image\/(\w+);base64,/', $base64, $matches)) {
        $extension = $matches[1];  // e.g., 'png', 'jpeg'
    } else {
        return false;  // Invalid base64 string
    }

    // remove meta data
    $base64 = preg_replace('/^data:image\/\w+;base64,/', '', $base64);

    // decode base64
    $decoded = base64_decode($base64, true);

    // validate base64
    if ($decoded === false || base64_encode($decoded) !== $base64)
        return false;

    // create a name based on timestamp to avoid conflicts
    $fileName = UPLOADS_DIR . "file_" . microtime(true) . "." . $extension;
    file_put_contents($fileName, $decoded);

    // return file url
    return $fileName;
}

