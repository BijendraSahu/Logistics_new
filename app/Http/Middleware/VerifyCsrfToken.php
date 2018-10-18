<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'login', 'getregister', 'edit_profile', 'insert_user_address', 'update_user_address', 'insert_review', 'profile_update', 'address_update', 'client_request', 'client_unload', 'manager_load','change_password','loaded_items','unloaded_items','loaded_items_delete','unloaded_items_delete'
    ];
}
