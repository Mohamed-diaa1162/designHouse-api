<?php

namespace App\Providers;

use App\Models\{Design, comment, Message, Team};
use App\Policies\{CommentPolicy, DesignPolicy, InvitationPolicy, MessagePolicy, TeamPolicy};
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Design::class => DesignPolicy::class,
        comment::class => CommentPolicy::class,
        Team::class => TeamPolicy::class,
        Invitation::class => InvitationPolicy::class,
        Message::class => MessagePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}