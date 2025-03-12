<?php
require_once "users_migration_001.php";
require_once "photos_migration_001.php";
require_once "tags_migration_001.php";
require_once "photo_tags_migration_001.php";


if ($argc > 1 && $argv[1] == "--down") {
    echo "Rolling back migrations...\n";
    PhotoTagMigration::down();
    TagsMigration::down();
    PhotosMigration::down();
    UsersMigration::down();
    echo "Migrations rolled back successfully!\n";
} else {
    echo "Running migrations...\n";
    UsersMigration::up();
    PhotosMigration::up();
    TagsMigration::up();
    PhotoTagMigration::up();
    echo "Migrations applied successfully!\n";
}




