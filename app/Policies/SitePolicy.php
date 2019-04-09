<?php

namespace App\Policies;

use App\Site;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SitePolicy
{
    use HandlesAuthorization;

    public function manage(User $user, Site $site)
    {
        return $user->is($site->owner);
    }
}
