<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for database operations. This is
    | the connection which will be utilized unless another connection
    | is explicitly specified when you execute a query / statement.
    |
    */

    'default' => env('DB_CONNECTION', 'pgsql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Below are all of the database connections defined for your application.
    | An example configuration is provided for each database system which
    | is supported by Laravel. You're free to add / remove connections.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DB_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        'mysql_reader' => [
            'driver' => 'mysql',
            'url' => env('DB_URL'),
            'host' => env('DB_MYSQL_READER_HOST', '127.0.0.1'),
            'port' => env('DB_MYSQL_READER_PORT', '3306'),
            'database' => env('DB_MYSQL_READER_DATABASE', 'laravel'),
            'username' => env('DB_MYSQL_READER_USERNAME', 'root'),
            'password' => env('DB_MYSQL_READER_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'mysql_llavorsi' => [
            'driver' => 'mysql',
            'url' => env('DB_URL'),
            'host' => env('DB_MYSQL_LLAVORSI_HOST', '127.0.0.1'),
            'port' => env('DB_MYSQL_LLAVORSI_PORT', '3306'),
            'database' => env('DB_MYSQL_LLAVORSI_DATABASE', 'laravel'),
            'username' => env('DB_MYSQL_LLAVORSI_USERNAME', 'root'),
            'password' => env('DB_MYSQL_LLAVORSI_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'mysql_acsi' => [
            'driver' => 'mysql',
            'url' => env('DB_URL'),
            'host' => env('DB_MYSQL_ACSI_HOST', '127.0.0.1'),
            'port' => env('DB_MYSQL_ACSI_PORT', '3306'),
            'database' => env('DB_MYSQL_ACSI_DATABASE', 'laravel'),
            'username' => env('DB_MYSQL_ACSI_USERNAME', 'root'),
            'password' => env('DB_MYSQL_ACSI_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'mysql_lijar' => [
            'driver' => 'mysql',
            'url' => env('DB_URL'),
            'host' => env('DB_MYSQL_LIJAR_HOST', '127.0.0.1'),
            'port' => env('DB_MYSQL_LIJAR_PORT', '3306'),
            'database' => env('DB_MYSQL_LIJAR_DATABASE', 'laravel'),
            'username' => env('DB_MYSQL_LIJAR_USERNAME', 'root'),
            'password' => env('DB_MYSQL_LIJAR_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'mysql_dielec' => [
            'driver' => 'mysql',
            'url' => env('DB_URL'),
            'host' => env('DB_MYSQL_DIELEC_HOST', '127.0.0.1'),
            'port' => env('DB_MYSQL_DIELEC_PORT', '3306'),
            'database' => env('DB_MYSQL_DIELEC_DATABASE', 'laravel'),
            'username' => env('DB_MYSQL_DIELEC_USERNAME', 'root'),
            'password' => env('DB_MYSQL_DIELEC_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'mysql_biosca' => [
            'driver' => 'mysql',
            'url' => env('DB_URL'),
            'host' => env('DB_MYSQL_BIOSCA_HOST', '127.0.0.1'),
            'port' => env('DB_MYSQL_BIOSCA_PORT', '3306'),
            'database' => env('DB_MYSQL_BIOSCA_DATABASE', 'laravel'),
            'username' => env('DB_MYSQL_BIOSCA_USERNAME', 'root'),
            'password' => env('DB_MYSQL_BIOSCA_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'mysql_ibereco' => [
            'driver' => 'mysql',
            'url' => env('DB_URL'),
            'host' => env('DB_MYSQL_IBERECO_HOST', '127.0.0.1'),
            'port' => env('DB_MYSQL_IBERECO_PORT', '3306'),
            'database' => env('DB_MYSQL_IBERECO_DATABASE', 'laravel'),
            'username' => env('DB_MYSQL_IBERECO_USERNAME', 'root'),
            'password' => env('DB_MYSQL_IBERECO_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'mysql_ronquillo' => [
            'driver' => 'mysql',
            'url' => env('DB_URL'),
            'host' => env('DB_MYSQL_RONQUILLO_HOST', '127.0.0.1'),
            'port' => env('DB_MYSQL_RONQUILLO_PORT', '3306'),
            'database' => env('DB_MYSQL_RONQUILLO_DATABASE', 'laravel'),
            'username' => env('DB_MYSQL_RONQUILLO_USERNAME', 'root'),
            'password' => env('DB_MYSQL_RONQUILLO_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'mysql_fcoagudo' => [
            'driver' => 'mysql',
            'url' => env('DB_URL'),
            'host' => env('DB_MYSQL_FCOAGUDO_HOST', '127.0.0.1'),
            'port' => env('DB_MYSQL_FCOAGUDO_PORT', '3306'),
            'database' => env('DB_MYSQL_FCOAGUDO_DATABASE', 'laravel'),
            'username' => env('DB_MYSQL_FCOAGUDO_USERNAME', 'root'),
            'password' => env('DB_MYSQL_FCOAGUDO_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'mysql_talayuelas' => [
            'driver' => 'mysql',
            'url' => env('DB_URL'),
            'host' => env('DB_MYSQL_TALAYUELAS_HOST', '127.0.0.1'),
            'port' => env('DB_MYSQL_TALAYUELAS_PORT', '3306'),
            'database' => env('DB_MYSQL_TALAYUELAS_DATABASE', 'laravel'),
            'username' => env('DB_MYSQL_TALAYUELAS_USERNAME', 'root'),
            'password' => env('DB_MYSQL_TALAYUELAS_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'mysql_mercedes' => [
            'driver' => 'mysql',
            'url' => env('DB_URL'),
            'host' => env('DB_MYSQL_MERCEDES_HOST', '127.0.0.1'),
            'port' => env('DB_MYSQL_MERCEDES_PORT', '3306'),
            'database' => env('DB_MYSQL_MERCEDES_DATABASE', 'laravel'),
            'username' => env('DB_MYSQL_MERCEDES_USERNAME', 'root'),
            'password' => env('DB_MYSQL_MERCEDES_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'mysql_pastor' => [
            'driver' => 'mysql',
            'url' => env('DB_URL'),
            'host' => env('DB_MYSQL_PASTOR_HOST', '127.0.0.1'),
            'port' => env('DB_MYSQL_PASTOR_PORT', '3306'),
            'database' => env('DB_MYSQL_PASTOR_DATABASE', 'laravel'),
            'username' => env('DB_MYSQL_PASTOR_USERNAME', 'root'),
            'password' => env('DB_MYSQL_PASTOR_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'mysql_cortijodelora' => [
            'driver' => 'mysql',
            'url' => env('DB_URL'),
            'host' => env('DB_MYSQL_CORTIJODELORA_HOST', '127.0.0.1'),
            'port' => env('DB_MYSQL_CORTIJODELORA_PORT', '3306'),
            'database' => env('DB_MYSQL_CORTIJODELORA_DATABASE', 'laravel'),
            'username' => env('DB_MYSQL_CORTIJODELORA_USERNAME', 'root'),
            'password' => env('DB_MYSQL_CORTIJODELORA_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'mysql_aspro' => [
            'driver' => 'mysql',
            'url' => env('DB_URL'),
            'host' => env('DB_MYSQL_ASPRO_HOST', '127.0.0.1'),
            'port' => env('DB_MYSQL_ASPRO_PORT', '3306'),
            'database' => env('DB_MYSQL_ASPRO_DATABASE', 'laravel'),
            'username' => env('DB_MYSQL_ASPRO_USERNAME', 'root'),
            'password' => env('DB_MYSQL_ASPRO_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'mysql_leandro' => [
            'driver' => 'mysql',
            'url' => env('DB_URL'),
            'host' => env('DB_MYSQL_LEANDRO_HOST', '127.0.0.1'),
            'port' => env('DB_MYSQL_LEANDRO_PORT', '3306'),
            'database' => env('DB_MYSQL_LEANDRO_DATABASE', 'laravel'),
            'username' => env('DB_MYSQL_LEANDRO_USERNAME', 'root'),
            'password' => env('DB_MYSQL_LEANDRO_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'mysql_cerrajon' => [
            'driver' => 'mysql',
            'url' => env('DB_URL'),
            'host' => env('DB_MYSQL_CERRAJON_HOST', '127.0.0.1'),
            'port' => env('DB_MYSQL_CERRAJON_PORT', '3306'),
            'database' => env('DB_MYSQL_CERRAJON_DATABASE', 'laravel'),
            'username' => env('DB_MYSQL_CERRAJON_USERNAME', 'root'),
            'password' => env('DB_MYSQL_CERRAJON_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'mysql_cela' => [
            'driver' => 'mysql',
            'url' => env('DB_URL'),
            'host' => env('DB_MYSQL_CELA_HOST', '127.0.0.1'),
            'port' => env('DB_MYSQL_CELA_PORT', '3306'),
            'database' => env('DB_MYSQL_CELA_DATABASE', 'laravel'),
            'username' => env('DB_MYSQL_CELA_USERNAME', 'root'),
            'password' => env('DB_MYSQL_CELA_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'mysql_queralt' => [
            'driver' => 'mysql',
            'url' => env('DB_URL'),
            'host' => env('DB_MYSQL_QUERALT_HOST', '127.0.0.1'),
            'port' => env('DB_MYSQL_QUERALT_PORT', '3306'),
            'database' => env('DB_MYSQL_QUERALT_DATABASE', 'laravel'),
            'username' => env('DB_MYSQL_QUERALT_USERNAME', 'root'),
            'password' => env('DB_MYSQL_QUERALT_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'mysql_alconera' => [
            'driver' => 'mysql',
            'url' => env('DB_URL'),
            'host' => env('DB_MYSQL_ALCONERA_HOST', '127.0.0.1'),
            'port' => env('DB_MYSQL_ALCONERA_PORT', '3306'),
            'database' => env('DB_MYSQL_ALCONERA_DATABASE', 'laravel'),
            'username' => env('DB_MYSQL_ALCONERA_USERNAME', 'root'),
            'password' => env('DB_MYSQL_ALCONERA_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'mysql_chera' => [
            'driver' => 'mysql',
            'url' => env('DB_URL'),
            'host' => env('DB_MYSQL_CHERA_HOST', '127.0.0.1'),
            'port' => env('DB_MYSQL_CHERA_PORT', '3306'),
            'database' => env('DB_MYSQL_CHERA_DATABASE', 'laravel'),
            'username' => env('DB_MYSQL_CHERA_USERNAME', 'root'),
            'password' => env('DB_MYSQL_CHERA_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'mysql_chulilla' => [
            'driver' => 'mysql',
            'url' => env('DB_URL'),
            'host' => env('DB_MYSQL_CHULILLA_HOST', '127.0.0.1'),
            'port' => env('DB_MYSQL_CHULILLA_PORT', '3306'),
            'database' => env('DB_MYSQL_CHULILLA_DATABASE', 'laravel'),
            'username' => env('DB_MYSQL_CHULILLA_USERNAME', 'root'),
            'password' => env('DB_MYSQL_CHULILLA_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'mysql_sotdechera' => [
            'driver' => 'mysql',
            'url' => env('DB_URL'),
            'host' => env('DB_MYSQL_SOTDECHERA_HOST', '127.0.0.1'),
            'port' => env('DB_MYSQL_SOTDECHERA_PORT', '3306'),
            'database' => env('DB_MYSQL_SOTDECHERA_DATABASE', 'laravel'),
            'username' => env('DB_MYSQL_SOTDECHERA_USERNAME', 'root'),
            'password' => env('DB_MYSQL_SOTDECHERA_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'mysql_hidroelcarmen' => [
            'driver' => 'mysql',
            'url' => env('DB_URL'),
            'host' => env('DB_MYSQL_HIDROELCARMEN_HOST', '127.0.0.1'),
            'port' => env('DB_MYSQL_HIDROELCARMEN_PORT', '3306'),
            'database' => env('DB_MYSQL_HIDROELCARMEN_DATABASE', 'laravel'),
            'username' => env('DB_MYSQL_HIDROELCARMEN_USERNAME', 'root'),
            'password' => env('DB_MYSQL_HIDROELCARMEN_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'mariadb' => [
            'driver' => 'mariadb',
            'url' => env('DB_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'url' => env('DB_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'Usuarios'),
            'username' => env('DB_USERNAME', 'postgres'),
            'password' => env('DB_PASSWORD', 'Vosnos2013*'),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'public',
            'sslmode' => 'prefer',
        ],


        //conexion para cela
        'pgsql-cela' => [
            'driver' => 'pgsql',
            'url' => env('DB_URL'),
            'host' => env('DB_CELA_HOST', '127.0.0.1'),
            'port' => env('DB_CELA_PORT', '5432'),
            'database' => env('DB_CELA_DATABASE', 'Cela'),
            'username' => env('DB_CELA_USERNAME', 'postgres'),
            'password' => env('DB_CELA_PASSWORD', 'Vosnos2013*'),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'core', //AÑADIMOS AQUÍ EL ESQUEMA CORE, POR DEFECTO COGE EL PUBLIC
            'sslmode' => 'prefer',
        ],

        //conexion para chera
        'pgsql-chera' => [
            'driver' => 'pgsql',
            'url' => env('DB_URL'),
            'host' => env('DB_CHERA_HOST', '127.0.0.1'),
            'port' => env('DB_CHERA_PORT', '5432'),
            'database' => env('DB_CHERA_DATABASE', 'Chera'),
            'username' => env('DB_CHERA_USERNAME', 'postgres'),
            'password' => env('DB_CHERA_PASSWORD', 'Vosnos2013*'),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'core', //AÑADIMOS AQUÍ EL ESQUEMA CORE, POR DEFECTO COGE EL PUBLIC
            'sslmode' => 'prefer',
        ],

        //conexion para sotdechera
        'pgsql-sotdechera' => [
            'driver' => 'pgsql',
            'url' => env('DB_URL'),
            'host' => env('DB_SOTDECHERA_HOST', '127.0.0.1'),
            'port' => env('DB_SOTDECHERA_PORT', '5432'),
            'database' => env('DB_SOTDECHERA_DATABASE', 'Sotdechera'),
            'username' => env('DB_SOTDECHERA_USERNAME', 'postgres'),
            'password' => env('DB_SOTDECHERA_PASSWORD', 'Vosnos2013*'),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'core', //AÑADIMOS AQUÍ EL ESQUEMA CORE, POR DEFECTO COGE EL PUBLIC
            'sslmode' => 'prefer',
        ],

        //conexion para biosca BIOSCA
        'pgsql-biosca' => [
            'driver' => 'pgsql',
            'url' => env('DB_URL'),
            'host' => env('DB_BIOSCA_HOST', '127.0.0.1'),
            'port' => env('DB_BIOSCA_PORT', '5432'),
            'database' => env('DB_BIOSCA_DATABASE', 'Biosca'),
            'username' => env('DB_BIOSCA_USERNAME', 'postgres'),
            'password' => env('DB_BIOSCA_PASSWORD', 'Vosnos2013*'),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'core', //AÑADIMOS AQUÍ EL ESQUEMA CORE, POR DEFECTO COGE EL PUBLIC
            'sslmode' => 'prefer',
        ],

        //conexion para Santaclara SANTACLARA
        'pgsql-santaclara' => [
            'driver' => 'pgsql',
            'url' => env('DB_URL'),
            'host' => env('DB_SANTACLARA_HOST', '127.0.0.1'),
            'port' => env('DB_SANTACLARA_PORT', '5432'),
            'database' => env('DB_SANTACLARA_DATABASE', 'Santaclara'),
            'username' => env('DB_SANTACLARA_USERNAME', 'postgres'),
            'password' => env('DB_SANTACLARA_PASSWORD', 'Vosnos2013*'),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'core', //AÑADIMOS AQUÍ EL ESQUEMA CORE, POR DEFECTO COGE EL PUBLIC
            'sslmode' => 'prefer',
        ],

        //conexion para Alvarobenito ALVAROBENITO
        'pgsql-alvarobenito' => [
            'driver' => 'pgsql',
            'url' => env('DB_URL'),
            'host' => env('DB_ALVAROBENITO_HOST', '127.0.0.1'),
            'port' => env('DB_ALVAROBENITO_PORT', '5432'),
            'database' => env('DB_ALVAROBENITO_DATABASE', 'Alvarobenito'),
            'username' => env('DB_ALVAROBENITO_USERNAME', 'postgres'),
            'password' => env('DB_ALVAROBENITO_PASSWORD', 'Vosnos2013*'),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'core', //AÑADIMOS AQUÍ EL ESQUEMA CORE, POR DEFECTO COGE EL PUBLIC
            'sslmode' => 'prefer',
        ],

        //conexion para Vilaller VILALLER
        'pgsql-vilaller' => [
            'driver' => 'pgsql',
            'url' => env('DB_URL'),
            'host' => env('DB_VILALLER_HOST', '127.0.0.1'),
            'port' => env('DB_VILALLER_PORT', '5432'),
            'database' => env('DB_VILALLER_DATABASE', 'Vilaller'),
            'username' => env('DB_VILALLER_USERNAME', 'postgres'),
            'password' => env('DB_VILALLER_PASSWORD', 'Vosnos2013*'),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'core', //AÑADIMOS AQUÍ EL ESQUEMA CORE, POR DEFECTO COGE EL PUBLIC
            'sslmode' => 'prefer',
        ],


        //conexion para Sampol SAMPOL
        'pgsql-sampol' => [
            'driver' => 'pgsql',
            'url' => env('DB_URL'),
            'host' => env('DB_SAMPOL_HOST', '127.0.0.1'),
            'port' => env('DB_SAMPOL_PORT', '5432'),
            'database' => env('DB_SAMPOL_DATABASE', 'Sampol'),
            'username' => env('DB_SAMPOL_USERNAME', 'postgres'),
            'password' => env('DB_SAMPOL_PASSWORD', 'Vosnos2013*'),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'core', //AÑADIMOS AQUÍ EL ESQUEMA CORE, POR DEFECTO COGE EL PUBLIC
            'sslmode' => 'prefer',
        ],

        //conexion para Pastor PASTOR
        'pgsql-pastor' => [
            'driver' => 'pgsql',
            'url' => env('DB_URL'),
            'host' => env('DB_PASTOR_HOST', '127.0.0.1'),
            'port' => env('DB_PASTOR_PORT', '5432'),
            'database' => env('DB_PASTOR_DATABASE', 'Pastor'),
            'username' => env('DB_PASTOR_USERNAME', 'postgres'),
            'password' => env('DB_PASTOR_PASSWORD', 'Vosnos2013*'),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'core', //AÑADIMOS AQUÍ EL ESQUEMA CORE, POR DEFECTO COGE EL PUBLIC
            'sslmode' => 'prefer',
        ],

        //conexion para Mercedes MERCEDES
        'pgsql-mercedes' => [
            'driver' => 'pgsql',
            'url' => env('DB_URL'),
            'host' => env('DB_MERCEDES_HOST', '127.0.0.1'),
            'port' => env('DB_MERCEDES_PORT', '5432'),
            'database' => env('DB_MERCEDES_DATABASE', 'Mercedes'),
            'username' => env('DB_MERCEDES_USERNAME', 'postgres'),
            'password' => env('DB_MERCEDES_PASSWORD', 'Vosnos2013*'),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'core', //AÑADIMOS AQUÍ EL ESQUEMA CORE, POR DEFECTO COGE EL PUBLIC
            'sslmode' => 'prefer',
        ],

        //conexion para Hnoscastro HNOSCASTRO
        'pgsql-hnoscastro' => [
            'driver' => 'pgsql',
            'url' => env('DB_URL'),
            'host' => env('DB_HNOSCASTRO_HOST', '127.0.0.1'),
            'port' => env('DB_HNOSCASTRO_PORT', '5432'),
            'database' => env('DB_HNOSCASTRO_DATABASE', 'Hnoscastro'),
            'username' => env('DB_HNOSCASTRO_USERNAME', 'postgres'),
            'password' => env('DB_HNOSCASTRO_PASSWORD', 'Vosnos2013*'),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'core', //AÑADIMOS AQUÍ EL ESQUEMA CORE, POR DEFECTO COGE EL PUBLIC
            'sslmode' => 'prefer',
        ],

        //conexion para Alconera ALCONERA
        'pgsql-alconera' => [
            'driver' => 'pgsql',
            'url' => env('DB_URL'),
            'host' => env('DB_ALCONERA_HOST', '127.0.0.1'),
            'port' => env('DB_ALCONERA_PORT', '5432'),
            'database' => env('DB_ALCONERA_DATABASE', 'Alconera'),
            'username' => env('DB_ALCONERA_USERNAME', 'postgres'),
            'password' => env('DB_ALCONERA_PASSWORD', 'Vosnos2013*'),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'core', //AÑADIMOS AQUÍ EL ESQUEMA CORE, POR DEFECTO COGE EL PUBLIC
            'sslmode' => 'prefer',
        ],

        //conexion para Meliana MELIANA
        'pgsql-meliana' => [
            'driver' => 'pgsql',
            'url' => env('DB_URL'),
            'host' => env('DB_MELIANA_HOST', '127.0.0.1'),
            'port' => env('DB_MELIANA_PORT', '5432'),
            'database' => env('DB_MELIANA_DATABASE', 'Meliana'),
            'username' => env('DB_MELIANA_USERNAME', 'postgres'),
            'password' => env('DB_MELIANA_PASSWORD', 'Vosnos2013*'),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'core', //AÑADIMOS AQUÍ EL ESQUEMA CORE, POR DEFECTO COGE EL PUBLIC
            'sslmode' => 'prefer',
        ],

        //conexion para Cerrajon CERRAJON
        'pgsql-cerrajon' => [
            'driver' => 'pgsql',
            'url' => env('DB_URL'),
            'host' => env('DB_CERRAJON_HOST', '127.0.0.1'),
            'port' => env('DB_CERRAJON_PORT', '5432'),
            'database' => env('DB_CERRAJON_DATABASE', 'Cerrajon'),
            'username' => env('DB_CERRAJON_USERNAME', 'postgres'),
            'password' => env('DB_CERRAJON_PASSWORD', 'Vosnos2013*'),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'core', //AÑADIMOS AQUÍ EL ESQUEMA CORE, POR DEFECTO COGE EL PUBLIC
            'sslmode' => 'prefer',
        ],

        //conexion para Dielec DIELEC
        'pgsql-dielec' => [
            'driver' => 'pgsql',
            'url' => env('DB_URL'),
            'host' => env('DB_DIELEC_HOST', '127.0.0.1'),
            'port' => env('DB_DIELEC_PORT', '5432'),
            'database' => env('DB_DIELEC_DATABASE', 'Dielec'),
            'username' => env('DB_DIELEC_USERNAME', 'postgres'),
            'password' => env('DB_DIELEC_PASSWORD', 'Vosnos2013*'),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'core', //AÑADIMOS AQUÍ EL ESQUEMA CORE, POR DEFECTO COGE EL PUBLIC
            'sslmode' => 'prefer',
        ],


        //conexion para Chulilla CHULILLA
        'pgsql-chulilla' => [
            'driver' => 'pgsql',
            'url' => env('DB_URL'),
            'host' => env('DB_CHULILLA_HOST', '127.0.0.1'),
            'port' => env('DB_CHULILLA_PORT', '5432'),
            'database' => env('DB_CHULILLA_DATABASE', 'Chulilla'),
            'username' => env('DB_CHULILLA_USERNAME', 'postgres'),
            'password' => env('DB_CHULILLA_PASSWORD', 'Vosnos2013*'),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'core', //AÑADIMOS AQUÍ EL ESQUEMA CORE, POR DEFECTO COGE EL PUBLIC
            'sslmode' => 'prefer',
        ],

        //conexion para Coelca COELCA
        'pgsql-coelca' => [
            'driver' => 'pgsql',
            'url' => env('DB_URL'),
            'host' => env('DB_COELCA_HOST', '127.0.0.1'),
            'port' => env('DB_COELCA_PORT', '5432'),
            'database' => env('DB_COELCA_DATABASE', 'Coelca'),
            'username' => env('DB_COELCA_USERNAME', 'postgres'),
            'password' => env('DB_COELCA_PASSWORD', 'Vosnos2013*'),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'core', //AÑADIMOS AQUÍ EL ESQUEMA CORE, POR DEFECTO COGE EL PUBLIC
            'sslmode' => 'prefer',
        ],


        //conexion para Hidroelcarmen HIDROELCARMEN
        'pgsql-hidroelcarmen' => [
            'driver' => 'pgsql',
            'url' => env('DB_URL'),
            'host' => env('DB_HIDROELCARMEN_HOST', '127.0.0.1'),
            'port' => env('DB_HIDROELCARMEN_PORT', '5432'),
            'database' => env('DB_HIDROELCARMEN_DATABASE', 'Hidroelcarmen'),
            'username' => env('DB_HIDROELCARMEN_USERNAME', 'postgres'),
            'password' => env('DB_HIDROELCARMEN_PASSWORD', 'Vosnos2013*'),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'core', //AÑADIMOS AQUÍ EL ESQUEMA CORE, POR DEFECTO COGE EL PUBLIC
            'sslmode' => 'prefer',
        ],

        //conexion para Lijar LIJAR
        'pgsql-lijar' => [
            'driver' => 'pgsql',
            'url' => env('DB_URL'),
            'host' => env('DB_LIJAR_HOST', '127.0.0.1'),
            'port' => env('DB_LIJAR_PORT', '5432'),
            'database' => env('DB_LIJAR_DATABASE', 'Lijar'),
            'username' => env('DB_LIJAR_USERNAME', 'postgres'),
            'password' => env('DB_LIJAR_PASSWORD', 'Vosnos2013*'),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'core', //AÑADIMOS AQUÍ EL ESQUEMA CORE, POR DEFECTO COGE EL PUBLIC
            'sslmode' => 'prefer',
        ],

        //conexion para Talayuelas TALAYUELAS
        'pgsql-talayuelas' => [
            'driver' => 'pgsql',
            'url' => env('DB_URL'),
            'host' => env('DB_TALAYUELAS_HOST', '127.0.0.1'),
            'port' => env('DB_TALAYUELAS_PORT', '5432'),
            'database' => env('DB_TALAYUELAS_DATABASE', 'Talayuelas'),
            'username' => env('DB_TALAYUELAS_USERNAME', 'postgres'),
            'password' => env('DB_TALAYUELAS_PASSWORD', 'Vosnos2013*'),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'core', //AÑADIMOS AQUÍ EL ESQUEMA CORE, POR DEFECTO COGE EL PUBLIC
            'sslmode' => 'prefer',
        ],

        //conexion para Laprohida LAPROHIDA
        'pgsql-laprohida' => [
            'driver' => 'pgsql',
            'url' => env('DB_URL'),
            'host' => env('DB_LAPROHIDA_HOST', '127.0.0.1'),
            'port' => env('DB_LAPROHIDA_PORT', '5432'),
            'database' => env('DB_LAPROHIDA_DATABASE', 'Laprohida'),
            'username' => env('DB_LAPROHIDA_USERNAME', 'postgres'),
            'password' => env('DB_LAPROHIDA_PASSWORD', 'Vosnos2013*'),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'core', //AÑADIMOS AQUÍ EL ESQUEMA CORE, POR DEFECTO COGE EL PUBLIC
            'sslmode' => 'prefer',
        ],
		
		 //conexion para MartinSilva
        'pgsql-martinsilva' => [
            'driver' => 'pgsql',
            'url' => env('DB_URL'),
            'host' => env('DB_MARTINSILVA_HOST', '127.0.0.1'),
            'port' => env('DB_MARTINSILVA_PORT', '5432'),
            'database' => env('DB_MARTINSILVA_DATABASE', 'Martinsilva'),
            'username' => env('DB_MARTINSILVA_USERNAME', 'postgres'),
            'password' => env('DB_MARTINSILVA_PASSWORD', 'Vosnos2013*'),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'core', //AÑADIMOS AQUÍ EL ESQUEMA CORE, POR DEFECTO COGE EL PUBLIC
            'sslmode' => 'prefer',
        ],
		//conexion para Leandro
        'pgsql-leandro' => [
            'driver' => 'pgsql',
            'url' => env('DB_URL'),
            'host' => env('DB_LEANDRO_HOST', '127.0.0.1'),
            'port' => env('DB_LEANDRO_PORT', '5432'),
            'database' => env('DB_LEANDRO_DATABASE', 'Leandro'),
            'username' => env('DB_LEANDRO_USERNAME', 'postgres'),
            'password' => env('DB_LEANDRO_PASSWORD', 'Vosnos2013*'),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'core', //AÑADIMOS AQUÍ EL ESQUEMA CORE, POR DEFECTO COGE EL PUBLIC
            'sslmode' => 'prefer',
        ],
		//conexion para Ebrofanas
        'pgsql-ebrofanas' => [
            'driver' => 'pgsql',
            'url' => env('DB_URL'),
            'host' => env('DB_EBROFANAS_HOST', '127.0.0.1'),
            'port' => env('DB_EBROFANAS_PORT', '5432'),
            'database' => env('DB_EBROFANAS_DATABASE', 'Ebrofanas'),
            'username' => env('DB_EBROFANAS_USERNAME', 'postgres'),
            'password' => env('DB_EBROFANAS_PASSWORD', 'Vosnos2013*'),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'core', //AÑADIMOS AQUÍ EL ESQUEMA CORE, POR DEFECTO COGE EL PUBLIC
            'sslmode' => 'prefer',
        ],
		//conexion para Sierramagina
        'pgsql-sierramagina' => [
            'driver' => 'pgsql',
            'url' => env('DB_URL'),
            'host' => env('DB_SIERRAMAGINA_HOST', '127.0.0.1'),
            'port' => env('DB_SIERRAMAGINA_PORT', '5432'),
            'database' => env('DB_SIERRAMAGINA_DATABASE', 'Sierramagina'),
            'username' => env('DB_SIERRAMAGINA_USERNAME', 'postgres'),
            'password' => env('DB_SIERRAMAGINA_PASSWORD', 'Vosnos2013*'),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'core', //AÑADIMOS AQUÍ EL ESQUEMA CORE, POR DEFECTO COGE EL PUBLIC
            'sslmode' => 'prefer',
        ],
		//conexion para Ferez
        'pgsql-ferez' => [
            'driver' => 'pgsql',
            'url' => env('DB_URL'),
            'host' => env('DB_FEREZ_HOST', '127.0.0.1'),
            'port' => env('DB_FEREZ_PORT', '5432'),
            'database' => env('DB_FEREZ_DATABASE', 'Ferez'),
            'username' => env('DB_FEREZ_USERNAME', 'postgres'),
            'password' => env('DB_FEREZ_PASSWORD', 'Vosnos2013*'),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'core', //AÑADIMOS AQUÍ EL ESQUEMA CORE, POR DEFECTO COGE EL PUBLIC
            'sslmode' => 'prefer',
        ],
        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'url' => env('DB_URL'),
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            // 'encrypt' => env('DB_ENCRYPT', 'yes'),
            // 'trust_server_certificate' => env('DB_TRUST_SERVER_CERTIFICATE', 'false'),
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run on the database.
    |
    */

    'migrations' => [
        'table' => 'migrations',
        'update_date_on_publish' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as Memcached. You may define your connection settings here.
    |
    */

    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_') . '_database_'),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],

    ],

];
