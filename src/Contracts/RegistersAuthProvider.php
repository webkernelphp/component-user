<?php

declare(strict_types=1);

namespace Webkernel\StdUser\Contracts;

interface RegistersAuthProvider
{
    /**
     * Return the provider name (used as key in auth.providers).
     */
    public function providerName(): string;

    /**
     * Return the provider driver (used as key in auth.providers).
     */
    public function providerDriver(): string;

    /**
     * Return the full class name of the Eloquent model for this provider.
     */
    public function modelClass(): string;

    /**
     * Optionally return a guard configuration array.
     * Return null if no new guard is needed.
     *
     * Example:
     * [
     *     'name'   => 'agent',
     *     'driver' => 'session',
     * ]
     */
    public function guard(): ?array;
}
