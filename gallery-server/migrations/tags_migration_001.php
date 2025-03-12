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
            `color` INT
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