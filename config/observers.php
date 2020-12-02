<?php

return [
    \CleaniqueCoders\LaravelObservers\Observers\ReferenceObserver::class => [],
    \CleaniqueCoders\LaravelObservers\Observers\HashidsObserver::class => [],
    \CleaniqueCoders\LaravelUuid\Observers\UuidObserver::class => [
        \App\Models\Base::class,
        \App\Models\Team::class,
        \App\Models\User::class,
    ],
];
