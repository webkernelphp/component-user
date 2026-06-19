<?php declare(strict_types=1);

namespace Webkernel\StdUser\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

abstract class User extends Authenticatable implements FilamentUser, HasAvatar
{
    use Notifiable;

    /**
     * Override this in the child model to point to a different table.
     */
    protected $table = 'users';

    /**
     * Override this in the child model to use a specific DB connection.
     * Null means the default connection is used.
     */
    protected $connection = null;

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    /**
     * Override in a child model or panel policy to restrict access.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    /**
     * Gravatar fallback. Override to use a stored avatar column.
     */
    public function getFilamentAvatarUrl(): ?string
    {
        if (!empty($this->avatar_url)) {
            return $this->avatar_url;
        }

        $hash = md5(strtolower(trim((string) $this->email)));

        return 'https://www.gravatar.com/avatar/' . $hash . '?d=mp';
    }
}
