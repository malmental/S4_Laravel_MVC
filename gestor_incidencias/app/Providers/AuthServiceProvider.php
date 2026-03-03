<?php

namespace App\Providers;

use App\Models\Incidencia;
use App\Models\Comment;
use App\Policies\IncidenciaPolicy;
use App\Policies\CommentPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Incidencia::class => IncidenciaPolicy::class,
        Comment::class => CommentPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}