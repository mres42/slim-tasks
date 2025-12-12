<?php

use DI\ContainerBuilder;

return (function () {
    $builder = new ContainerBuilder();

    // Autowire all classes automatically
    $builder->useAutowiring(true);
    $builder->addDefinitions([
        // Example: binding interfaces
        // App\Module\V1\Auth\AuthRepositoryInterface::class => DI\autowire(App\Module\V1\Auth\AuthRepository::class)
    ]);

    return $builder->build();
})();
