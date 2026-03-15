<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\Incidencia;
use App\Policies\CommentPolicy;
use App\Policies\IncidenciaPolicy;
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
