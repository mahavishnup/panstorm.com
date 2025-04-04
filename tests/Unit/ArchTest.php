<?php

declare(strict_types=1);

use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Database\Eloquent\Factories\Factory;

arch()->preset()->php();
arch()->preset()->laravel();
arch()->preset()->security();

arch('controllers')
    ->expect('App\Http\Controllers')
    ->not->toBeUsed();

arch('avoid mutation')
    ->expect('App')
    ->classes()
    ->toBeReadonly()
    ->ignoring([
        'App\Exceptions',
        'App\Jobs',
        'App\Http\Requests',
        'App\Models',
        'App\Providers',
        'App\Services',
        HandleInertiaRequests::class,
    ]);

arch('avoid inheritance')
    ->expect('App')
    ->classes()
    ->toExtendNothing()
    ->ignoring([
        'App\Models',
        'App\Exceptions',
        'App\Jobs',
        'App\Http\Requests',
        'App\Providers',
        'App\Services',
        HandleInertiaRequests::class,
    ]);

arch('annotations')
    ->expect('App')
    ->toHavePropertiesDocumented()
    ->toHaveMethodsDocumented();

arch('avoid open for extension')
    ->expect('App')
    ->classes()
    ->toBeFinal();

arch('avoid abstraction')
    ->expect('App')
    ->not->toBeAbstract();

arch('factories')
    ->expect('Database\Factories')
    ->toExtend(Factory::class)
    ->toHaveMethod('definition')
    ->toOnlyBeUsedIn([
        'App\Models',
    ]);

arch('models')
    ->expect('App\Models')
    ->toHaveMethod('casts')
    ->toOnlyBeUsedIn([
        'App\Http',
        'App\Jobs',
        'App\Models',
        'App\Providers',
        'App\Actions',
        'App\Services',
        'Database\Factories',
        'Database\Seeders', // will be removed in the next PR as removing it gets outside of this PR scope
    ]);

arch('actions')
    ->expect('App\Actions')
    ->toHaveMethod('handle');
