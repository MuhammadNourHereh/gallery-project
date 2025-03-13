<?php


interface PhotoI
{
    public static function addPhoto(PhotoSkeleton $photo): PhotoSkeleton|false;
    public static function getPhoto(int $id): ?PhotoSkeleton;
    public static function getPhotos(string $owner): array;
    public static function updatePhoto(PhotoSkeleton $photo): bool;
    public static function deletePhoto(int $id): bool;
}