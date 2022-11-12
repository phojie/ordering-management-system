<?php

namespace App\Observers;

use App\Models\User;
use App\Traits\Generate;

class UserObserver
{
	use Generate;

	public function creating(User $user): void
	{
		// set default image
		if ($user->image_url === '' || $user->image_url === null) {
			$user->image_url = 'https://robohash.org/'.$user->id.'?set=set1&bgset=bg2&size=400x400';
		}
		//set fullname
		$user->full_name = $this->generateFullname($user);
	}

	public function updating(User $user): void
	{
		// set default image
		if ($user->image_url === '' || $user->image_url === null) {
			$user->image_url = 'https://robohash.org/'.$user->id.'?set=set1&bgset=bg2&size=400x400';
		}

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
