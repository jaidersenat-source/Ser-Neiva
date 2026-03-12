<?php

namespace App\Policies;

use App\Models\Iglesia;
use App\Models\User;

class IglesiaPolicy
{
    /**
     * Admin puede todo. Editor Huila solo iglesias fuera de Neiva.
     */
    private function canManage(User $user, Iglesia $iglesia): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isEditorHuila()) {
            $mun = strtolower(trim($iglesia->municipality ?? ''));
            return $mun !== 'neiva';
        }

        return false;
    }

    public function viewAny(User $user): bool  { return true; }
    public function view(User $user, Iglesia $iglesia): bool { return true; }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isEditorHuila();
    }

    public function update(User $user, Iglesia $iglesia): bool
    {
        return $this->canManage($user, $iglesia);
    }

    public function delete(User $user, Iglesia $iglesia): bool
    {
        return $this->canManage($user, $iglesia);
    }
}
