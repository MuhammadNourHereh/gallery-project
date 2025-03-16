<?php

interface PhotoTagI {
    public static function attachTag(PhotoTagSkeleton $photoTag): bool;
    public static function detachTag(PhotoTagSkeleton $photoTag): bool;
    public static function getAttachedTags(int $photo_id): array;
}