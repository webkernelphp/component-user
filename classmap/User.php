<?php declare(strict_types=1);
namespace App\Models;

/**
* App\Models\User
*
* This is the host application's user model.
* Override $table, $connection, $fillable, or any method here.
*
* Inheritance chain:
*   App\Models\User  ->  Webkernel\StdUser
*/
final class User extends \Webkernel\StdUser
{

        /**
        * Uncomment to point to a different table.
        * The migration must create this table with the correct schema.
        */
        // protected $table = 'app_users';

        /**
        * Uncomment to use a specific DB connection for this model.
        */
        // protected $connection = 'webkernel_primary';

        protected $fillable = [
            'name',
            'email',
            'password',
            'avatar_url',
        ];
    }
