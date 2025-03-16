<?php
define("UPLOADS_DIR", realpath(__DIR__ . "/../uploads") . "/");
define("URL_Base", "/gallery-server/uploads/");
function verifyAndSave($base64): bool|string
{
    echo UPLOADS_DIR;
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
    $timestamp = microtime(true);
    $fileName = UPLOADS_DIR . "file_" . $timestamp . "." . $extension;
    $url = URL_Base . "file_" . $timestamp . "." . $extension;
    if (!file_put_contents($fileName, $decoded))
        return false;

    // return file url
    return $url;
}

