<?php

namespace App\Providers;

use App\Models\BlogPost;
use App\Policies\BlogPostPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
         BlogPost::class => BlogPostPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('secret-link', function ($user) {
           return $user->is_admin;
        });

//        Gate::define('update-post', function ($user, $post) {
//           return $user->id == $post->user_id;
//        });
//
//        Gate::define('delete-post', function ($user, $post) {
//            return $user->id == $post->user_id;
//        });
//
        Gate::before(function ($user, $ability) {
            if ($user->is_admin) {
                return true;
            }
        });

//        Gate::after(function ($user, $ability, $result) {
//            if ($user->is_admin && in_array($ability, ['update-post', 'delete-post'])) {
//                return true;
//            }
//        });
    }
}
