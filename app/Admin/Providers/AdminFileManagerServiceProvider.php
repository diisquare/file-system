<?php
namespace App\Admin\Providers;

use Illuminate\Support\ServiceProvider;
use App\Admin\Services\AdminFileManager;

class FileManagerServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot(AdminFileManager $extension)
    {
        if (!AdminFileManager::boot()) {
            return;
        }

        if ($views = $extension->views()) {
            $this->loadViewsFrom($views, 'laravel-admin-file-manager');
        }

        $this->app->booted(function () {
            AdminFileManager::routes(__DIR__ . '/../routes/web.php');
        });
    }
}
