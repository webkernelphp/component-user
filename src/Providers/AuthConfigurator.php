<?php

declare(strict_types=1);

namespace Webkernel\StdUser\Providers;

use Webkernel\WebApp;
use Webkernel\StdUser\Contracts\RegistersAuthProvider;

final class AuthConfigurator
{
    public function __construct(private readonly WebApp $app) {}

    /**
     * Set the default user model for the primary auth provider.
     * Called once by StdUserServiceProvider during boot.
     */
    public function applyDefaults(string $modelClass): void
    {
        $this->app['config']->set('auth.providers.users.driver', 'eloquent');
        $this->app['config']->set('auth.providers.users.model', $modelClass);
    }

    /**
     * Register an additional provider and optional guard from a module.
     * Modules call this via the webkernel.auth.register_provider event.
     */
    public function registerProvider(RegistersAuthProvider $registration): void
    {
        $config = $this->app['config'];

        $config->set(
            'auth.providers.' . $registration->providerName(),
            [
                'driver' => $registration->providerDriver() ?? 'eloquent',
                'model'  => $registration->modelClass(),
            ]
        );

        $guard = $registration->guard();

        if ($guard !== null) {
            $guardName = $guard['name'];

            $config->set(
                'auth.guards.' . $guardName,
                [
                    'driver'   => $guard['driver'] ?? 'session',
                    'provider' => $registration->providerName(),
                ]
            );
        }
    }
}
