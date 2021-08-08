<?php

namespace App\Providers;



use App\Repositories\Eloquent\{ChatRepository, CommentRepository, DesginRepository, InvitationRepository, MessageRepository, UserRepository, TeamRepository};
use App\Repositories\Contracts\{IChat, IComment, IDesgin, IInvitation, IMessage, ITeam, IUser};
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(IDesgin::class, DesginRepository::class);
        $this->app->bind(IUser::class, UserRepository::class);
        $this->app->bind(IComment::class, CommentRepository::class);
        $this->app->bind(ITeam::class, TeamRepository::class);
        $this->app->bind(IInvitation::class, InvitationRepository::class);
        $this->app->bind(IChat::class, ChatRepository::class);
        $this->app->bind(IMessage::class, MessageRepository::class);
    }
}