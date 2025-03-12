<?php
require_once getPath("conn");


class UsersMigration
{
    public static function up()
    {
        global $conn;
        $query = "CREATE TABLE IF NOT EXISTS `users` (
            `username` VARCHAR(255) PRIMARY KEY,
            `firstname` VARCHAR(255) NOT NULL,
            `lastname` VARCHAR(255) NOT NULL,
            `password` VARCHAR(255) NOT NULL
        )";
        mysqli_query($conn, $query);
        echo "users table was created succussfully\n";
    }

    public static function down()
    {
        global $conn;
        mysqli_query($conn, "DROP TABLE IF EXISTS users;");
        echo "users table was dropped succussfully\n";
    }
}