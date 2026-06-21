<?php declare(strict_types=1);
namespace Webkernel;
use Filament\Models\Contracts\{FilamentUser, HasAvatar};
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Webkernel\Component\AccessControl\Concerns\{HasBusinessAccess, HasPrivilegeLevel};

abstract class StdUser extends Authenticatable implements FilamentUser, HasAvatar
{
    use Notifiable, HasPrivilegeLevel, HasBusinessAccess;

    /** Override to change the table name */ protected $table = 'users';
    /** Custom DB connection (null for default). */ protected $connection;

    protected $hidden = [
        'password',
        'remember_token',
    ];

    #[\Override]
    protected function casts(): array
    {
        return [
        'email_verified_at' => 'datetime',
        'password'      => 'hashed',
        ];
    }

    /** Override in a child model or panel policy to restrict access. */
    final public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    /** Gravatar fallback. Override to use a stored avatar column. */
    public function getFilamentAvatarUrl(): ?string
    {
        if (!empty($this->avatar_url)) { return $this->avatar_url; }
        return webkernel_branding_url('webkernel-no-avatar');
    }
}
