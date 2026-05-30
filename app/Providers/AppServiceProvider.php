<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\FilesystemAdapter;
use League\Flysystem\Filesystem as Flysystem;
use League\Flysystem\Local\LocalFilesystemAdapter;

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
        Storage::extend('local-dynamic', function ($app, $config) {
            $adapter = new LocalFilesystemAdapter(
                $config['root'],
                null,
                $config['lock'] ?? LOCK_EX
            );

            $filesystem = new Flysystem($adapter, $config);

            return new class($filesystem, $adapter, $config) extends FilesystemAdapter {
                public function url($path): string
                {
                    return storage_url($path);
                }
            };
        });
    }
}
