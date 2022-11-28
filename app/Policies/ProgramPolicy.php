<?php

namespace App\Policies;

use App\Models\Program;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

use function PHPUnit\Framework\returnSelf;

class ProgramPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
        return $user->can('list programs');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Program $program)
    {
        //El usuario tiene el permiso para ver todos los detalles del programa
        if($user->can('show programs')) return true;

        //El usuario id es igual al usuario identificador que ha creado este programa
        return $user->id === $program->user_id;

        //Para estos casos significa que si yo cree mi programa solo podre ver los mios, si tengo otro role podre ver el mio mas los otros programas
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //El usuario puede crear programas?
        return $user->can('create programs');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Program $program)
    {
        //
        if($user->can('update own programs')) {
            return $user->id === $program->user_id;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Program $program)
    {
        //El usuario identificado puede eliminar sus propio programa?
        if($user->can('delete own programs')) {
            //validamos que el usuario identificado es el mismo usuario que creo este programa
            return $user->id === $program->user_id;
        }

        return $user->can('delete program');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Program $program)
    {
        //El usuario puede restaurar sus propios programas?
        if($user->can('restore own programs')){
            return $user->id === $program->user_id;
        }
        //Puede restaurar cualquier programa
        return $user->can('restore programs');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Program $program)
    {
        //
    }
}
