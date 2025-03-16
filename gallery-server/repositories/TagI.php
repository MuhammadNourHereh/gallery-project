<?php
interface TagI
{
    public static function addTag(TagModel $tag): TagModel|false;
    public static function getTag(int $id): ?TagModel;
    public static function getTags(string $owner): array;
    public static function updateTag(TagModel $tag): bool;
    public static function deleteTag(int $id): bool;
}