<?php

namespace App\Policies;

use App\Models\OrdrLocal;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrdrLocalPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, OrdrLocal $ordrLocal): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, OrdrLocal $ordrLocal): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, OrdrLocal $ordrLocal): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, OrdrLocal $ordrLocal): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, OrdrLocal $ordrLocal): bool
    {
        return false;
    }

    public function edit(User $user, OrdrLocal $order)
    {
        if ($user->role === 'developer') {
            return true;
        }
        
        $reg = $user->oslpReg;
        if ($user->role === 'salesman' && $reg) {
            return $order->OdrSlpCode == $reg->RegSlpCode;
        }

        return false;
    }
}
