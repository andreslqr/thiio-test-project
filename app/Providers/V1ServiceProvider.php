<?php

namespace App\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class V1ServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->bootRoutes();  
    }

    protected function bootRoutes(): void
    {
        if(File::exists($this->app->config['api-v1.routes-path']))
        {
            foreach(File::allFiles($this->app->config['api-v1.routes-path']) as $file)
            {
                $this->bootRouteFile(
                    $file, 
                    $this->app->config['api-v1.name'],
                    $this->app->config['api-v1.prefix'],
                    $this->app->config['api-v1.middleware']
                );
            }
        }
    }

    /**
     * Boot the routes from a file
     * 
     * @param  \Symfony\Component\Finder\SplFileInfo $file
     * @param  string $name
     * @param  string $prefix
     * @param  array|string $middlewares
     */
    protected function bootRouteFile($file, $name = null, $prefix = null, $middlewares = [])
    {
        Route::name($name)
            ->prefix($prefix)
            ->middleware($middlewares)
            ->group(fn() => $this->loadRoutesFrom($file->getPathname()));
    }
}
