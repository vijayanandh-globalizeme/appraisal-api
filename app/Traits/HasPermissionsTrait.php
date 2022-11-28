<?php

namespace App\Traits;

use App\Models\Role;

trait HasPermissionsTrait {

  	public function hasRole( $roles ) {
	    foreach ($roles as $role) {
            $user_role = $this->roles->toArray();
	      	if ($user_role['slug'] == $role) {
	        	return true;
	      	}
	    }
	    return false;
  	}

    public function roles() {
        return $this->belongsTo('App\Models\Role', 'role_id', 'id');
	}

}