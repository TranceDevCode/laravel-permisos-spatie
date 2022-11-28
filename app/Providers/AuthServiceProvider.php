<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Program;
use App\Policies\ProgramPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Program::class => ProgramPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //Con esta funcion controlamos todas las habilidades o permisos para un usuario especifico, para este caso sucede con el Super Admin del sistema
        Gate::before(function($user, $ability){
            //Si el usuario tiene el role Super-Admin retornamos true, en otro caso retornamos null
            return $user->hasRole('Super-Admin') ? true : null;
        });
    }
}
