<?php
interface TagI
{
    public static function addTag(TagSkeleton $tag): TagSkeleton|false;
    public static function getTag(int $id): ?TagSkeleton;
    public static function getAllTags(): array;
    public static function updateTag(TagSkeleton $tag): bool;
    public static function deleteTag(int $id): bool;
}