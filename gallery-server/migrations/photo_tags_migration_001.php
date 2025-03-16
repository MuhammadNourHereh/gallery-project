<?php
require_once getPath("conn");


class PhotoTagMigration
{
    public static function up()
    {
        global $conn;
        $query = "CREATE TABLE IF NOT EXISTS `photo_tag` (
            `photo_id` INT NOT NULL,
            `tag_id` INT NOT NULL,
            PRIMARY KEY (`photo_id`, `tag_id`),
            FOREIGN KEY (`photo_id`) REFERENCES `photos`(`id`),
            FOREIGN KEY (`tag_id`) REFERENCES `tags`(`id`)
        )";
        mysqli_query($conn, $query);
        echo "photo_tag table was created succussfully\n";
    }

    public static function down()
    {
        global $conn;
        mysqli_query($conn, "DROP TABLE IF EXISTS photo_tag;");
        echo "photo_tag table was dropped succussfully\n";
    }
}