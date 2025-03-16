<?php

interface PhotoTagI {
    public static function attachTag(int $photo_id, int $tag_id): bool;
    public static function detachTag(int $photo_id, int $tag_id): bool;
    public static function getAttachedTags(int $photo_id): array;
}