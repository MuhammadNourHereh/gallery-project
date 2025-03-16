<?php

interface UserI
{
    public static function addUser(UserModel $user): UserModel|false;
    public static function getUser(string $username, string $password): ?UserModel;
    public static function getAllUsers(): array;
    public static function updateUser(UserModel $user): bool;
    public static function deleteUser(string $username): bool;
}