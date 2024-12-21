<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Repository\contracts\AccountRepositoryInterface::class,
            \App\Repository\Domain\AccountRepository::class
        );

        $this->app->bind(
            \App\Repository\contracts\TransactionRepositoryInterface::class,
            \App\Repository\Domain\TransactionRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Outros métodos podem ser implementados aqui, se necessário
    }
}
