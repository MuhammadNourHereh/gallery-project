<?php

interface PhotoTagI {
    public static function attachTag(PhotoTagModel $photoTag): bool;
    public static function detachTag(PhotoTagModel $photoTag): bool;
    public static function getAttachedTags(int $photo_id): array;
}