<?php

    app()->register('Telenok\Shop\ShopServiceProvider');

    $this->line('Examine app.php');

    $this->call('telenok:package', [
        'action' => 'add-provider', 
        '--provider' => 'Telenok\Shop\ShopServiceProvider',
    ]);   

    $this->line('Package new classes copy');

    $this->call('vendor:publish', [
        '--tag' => ['resourcesapp'], 
        '--provider' => 'Telenok\Shop\ShopServiceProvider',
    ]);
    
    $this->line('Package migrating', true);

    $this->call('migrate', [
        '--path' => 'vendor/telenok/shop/src/migrations', 
        '--force' => true
    ]);