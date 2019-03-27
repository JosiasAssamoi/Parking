<?php

namespace App\Policies;

use App\User;
use Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    public function only_admin(User $user)
    {   
    
       return $user->isAdmin();

    }

    public function request_booking(User $user){
        $user->refresh();

        if ($user->isInQueue() || !empty($user->getCurrrentPlace())){
            return false;
        }
        return true;
    }

    public function seeHisRank (User $user){
        $user->refresh();

         
        return $user->isInQueue() ;
    }

}
