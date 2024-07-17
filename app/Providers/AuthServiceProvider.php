<?php

namespace App\Providers;

use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\Role;
use App\Models\Setting;
use Auth;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('access-superadmin-moderator', function() {
            return Role::isSuperadmin() || Role::isModerator() ? Response::allow() : Response::deny('Anda tidak berhak mengakses halaman ini.');
        });

        Gate::define('access-superadmin', function() {
            return Role::isSuperadmin() ? Response::allow() : Response::deny('Anda tidak berhak mengakses halaman ini.');
        });

        Gate::define('access-moderator', function() {
            return Role::isModerator() ? Response::allow() : Response::deny('Anda tidak berhak mengakses halaman ini.');
        });

        Gate::define('access-participant', function() {
            return Role::isParticipant() ? Response::allow() : Response::deny('Anda tidak berhak mengakses halaman ini.');
        });

        Gate::define('validate-project', function($user, $projectId) {
            if (Role::isParticipant()) {
                $project = ProjectUser::whereProjectId($projectId)->firstOrFail();
                if ($project->user_id != Auth::id())
                    return Response::deny('Anda tidak berhak mengakses halaman ini.');
            }

            return true;
            // return Role::isParticipant() ? Response::allow() : Response::deny('Anda tidak berhak mengakses halaman ini.');
        });

        Gate::define('cannot-update-status', function($user, $projectId) {
            return Role::isParticipant() ? Response::deny('Anda tidak berhak mengakses halaman ini.') : Response::allow();
        });

        Gate::define('access-upload', function() {
            if (Role::isParticipant())
                return Setting::key('allow_upload')->value == 1 ? Response::allow() : Response::deny('Anda tidak berhak mengakses halaman ini.');
            else
                return Response::allow();
        });
    }
}
