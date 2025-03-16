<?php


interface PhotoI
{
    public static function addPhoto(PhotoModel $photo): PhotoModel|false;
    public static function getPhoto(int $id): ?PhotoModel;
    public static function getPhotos(string $owner): array;
    public static function updatePhoto(PhotoModel $photo): bool;
    public static function deletePhoto(int $id): bool;
}