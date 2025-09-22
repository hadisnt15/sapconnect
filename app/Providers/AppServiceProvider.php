<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        DB::extend('hana', function ($config) {
            $dsn = "odbc:Driver={HDBODBC};ServerNode={$config['host']};Database={$config['database']}";
            $username = $config['username'];
            $password = $config['password'];
            $options = $config['options'] ?? [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                // \PDO::ATTR_PERSISTENT => true,   
            ];

            $pdo = new \PDO($dsn, $username, $password, $options);
             // Set default schema setelah koneksi
            $schema = $config['schema'] ?? null;
            if ($schema) {
                $pdo->exec('SET SCHEMA "' . $schema . '"');
            }
            return new \Illuminate\Database\Connection($pdo);
        });
        // DB::extend('hana', function ($config) {
        //     static $pdoCache = null; // Simpan koneksi di memory selama request

        //     if (!$pdoCache) {
        //         $dsn = "odbc:Driver={HDBODBC};ServerNode={$config['host']};Database={$config['database']}";
        //         $username = $config['username'];
        //         $password = $config['password'];

        //         $options = $config['options'] ?? [
        //             \PDO::ATTR_ERRMODE    => \PDO::ERRMODE_EXCEPTION,
        //             \PDO::ATTR_PERSISTENT => true, // Persistent connection
        //         ];

        //         $pdoCache = new \PDO($dsn, $username, $password, $options);

        //         // Set default schema setelah koneksi
        //         if (!empty($config['schema'])) {
        //             $pdoCache->exec('SET SCHEMA "' . $config['schema'] . '"');
        //         }
        //     }

        //     return new \Illuminate\Database\Connection($pdoCache);
        // });
    }
}
