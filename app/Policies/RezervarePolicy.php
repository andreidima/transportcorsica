<?php

namespace App\Policies;

use App\Models\Rezervare;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RezervarePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Rezervare  $rezervare
     * @return mixed
     */
    public function view(User $user, Rezervare $rezervare)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Rezervare  $rezervare
     * @return mixed
     */
    public function update(User $user, Rezervare $rezervare)
    {
        if (auth()->user()->role === 'sofer') {
            if (!$rezervare->retur) {
                return
                    (
                        ($rezervare->data_cursa > \Carbon\Carbon::now()->startOfWeek())
                        &&
                        ($rezervare->data_cursa < \Carbon\Carbon::now()->endOfWeek())
                    );
            }elseif($rezervare->retur) {
                $rezervare_retur = Rezervare::find($rezervare->retur);
                return 
                    (
                        (
                            ($rezervare->data_cursa > \Carbon\Carbon::now()->startOfWeek())
                            && 
                            ($rezervare->data_cursa < \Carbon\Carbon::now()->endOfWeek())
                        )
                        ||
                        (
                            ($rezervare_retur->data_cursa > \Carbon\Carbon::now()->startOfWeek())
                            && 
                            ($rezervare_retur->data_cursa < \Carbon\Carbon::now()->endOfWeek())
                        )
                    );               
            }
        } else{
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Rezervare  $rezervare
     * @return mixed
     */
    public function delete(User $user, Rezervare $rezervare)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Rezervare  $rezervare
     * @return mixed
     */
    public function restore(User $user, Rezervare $rezervare)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Rezervare  $rezervare
     * @return mixed
     */
    public function forceDelete(User $user, Rezervare $rezervare)
    {
        //
    }
}
