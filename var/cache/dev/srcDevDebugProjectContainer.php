<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerZupnbg9\srcDevDebugProjectContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerZupnbg9/srcDevDebugProjectContainer.php') {
    touch(__DIR__.'/ContainerZupnbg9.legacy');

    return;
}

if (!\class_exists(srcDevDebugProjectContainer::class, false)) {
    \class_alias(\ContainerZupnbg9\srcDevDebugProjectContainer::class, srcDevDebugProjectContainer::class, false);
}

return new \ContainerZupnbg9\srcDevDebugProjectContainer(array(
    'container.build_hash' => 'Zupnbg9',
    'container.build_id' => 'feddaeca',
    'container.build_time' => 1525266811,
), __DIR__.\DIRECTORY_SEPARATOR.'ContainerZupnbg9');
