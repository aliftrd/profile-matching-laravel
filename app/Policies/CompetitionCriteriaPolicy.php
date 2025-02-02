<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CompetitionCriteria;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompetitionCriteriaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_competition::criteria');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CompetitionCriteria $competitionCriteria): bool
    {
        return $user->can('view_competition::criteria');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_competition::criteria');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CompetitionCriteria $competitionCriteria): bool
    {
        return $user->can('update_competition::criteria');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CompetitionCriteria $competitionCriteria): bool
    {
        return $user->can('delete_competition::criteria');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_competition::criteria');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, CompetitionCriteria $competitionCriteria): bool
    {
        return $user->can('force_delete_competition::criteria');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_competition::criteria');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, CompetitionCriteria $competitionCriteria): bool
    {
        return $user->can('restore_competition::criteria');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_competition::criteria');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, CompetitionCriteria $competitionCriteria): bool
    {
        return $user->can('replicate_competition::criteria');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_competition::criteria');
    }
}
