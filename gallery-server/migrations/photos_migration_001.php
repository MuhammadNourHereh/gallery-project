<?php
require_once getPath("conn");

class PhotosMigration
{
    public static function up()
    {
        global $conn;
        $query = "CREATE TABLE IF NOT EXISTS `photos` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `title` VARCHAR(255) NOT NULL,
            `desc` VARCHAR(255),
            `url` VARCHAR(255) NOT NULL,
            `owner` VARCHAR(255) NOT NULL,
            FOREIGN KEY (`owner`) REFERENCES `users`(`username`) ON DELETE CASCADE
        )";
        mysqli_query($conn, $query);
        echo "photos table was created succussfully\n";
    }

    public static function down()
    {
        global $conn;
        mysqli_query($conn, "DROP TABLE IF EXISTS photos;");
        echo "photos table was dropped succussfully\n";
    }
}