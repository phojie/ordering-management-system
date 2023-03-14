<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\User;
use App\Traits\Generate;

class UserObserver
{
    use Generate;

    public function creating(User $user): void
    {
        //set fullname
        $user->full_name = $this->generateFullname($user);
    }

  public function created(User $user): void
  {
      // set default role
      try {
          // if user has no role, assign customer role
          if ($user->roles->count() == 0) {
              $user->assignRole('Customer');
          }
      } catch (\Throwable $th) {
          // throw $th;
      }
  }

    public function updating(User $user): void
    {
        //set fullname
        $user->full_name = $this->generateFullname($user);
    }

    public function deleted(User $user): void
    {
        $user->status = 'deleted';
        $user->save();
    }

    public function restored(User $user): void
    {
        $user->status = 'active';
        $user->save();
    }

    public function forceDeleted(User $user): void
    {
        //
    }
}
