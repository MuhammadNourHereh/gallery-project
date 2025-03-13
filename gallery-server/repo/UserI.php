<?php

interface UserI
{
    public static function addUser(UserSkeleton $user): UserSkeleton|false;
    public static function getUser(string $username, string $password): ?UserSkeleton;
    public static function getAllUsers(): array;
    public static function updateUser(UserSkeleton $user): bool;
    public static function deleteUser(string $username): bool;
}