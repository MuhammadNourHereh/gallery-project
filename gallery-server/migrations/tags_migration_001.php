<?php
require_once getPath("conn");


class TagsMigration
{
    public static function up()
    {
        global $conn;
        $query = "CREATE TABLE IF NOT EXISTS `tags` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `name` VARCHAR(255) NOT NULL,
            `color` INT,
            `owner` VARCHAR(255) NOT NULL,
            FOREIGN KEY (`owner`) REFERENCES `users`(`username`) ON DELETE CASCADE
        )";
        mysqli_query($conn, $query);
        echo "tags table was created succussfully\n";
    }

    public static function down()
    {
        global $conn;
        mysqli_query($conn, "DROP TABLE IF EXISTS tags;");
        echo "tags table was dropped succussfully\n";
    }
}