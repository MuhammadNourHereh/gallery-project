# gallery-project

## ER-Diagram
https://drawsql.app/teams/mnhs-team/diagrams/gallery-project

## Configurations

1. put this line in `php.ini` file
```sh
    auto_prepend_file = "/absolute/path/to/gallery-server/utils/getPath.php"
```
2. run `pathsBuilder.php`, you have to run it every time file structure changes
3. For mysql, create `root` user with empty password. note DB config can changed in `connetion/conn.php`
4. for migrations, run `migrations/migrations.php`. note that you don't have to create database
5. for seeding, run `seeds.php`

