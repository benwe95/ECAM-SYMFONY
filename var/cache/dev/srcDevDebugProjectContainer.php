<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerWsl62ww\srcDevDebugProjectContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerWsl62ww/srcDevDebugProjectContainer.php') {
    touch(__DIR__.'/ContainerWsl62ww.legacy');

    return;
}

if (!\class_exists(srcDevDebugProjectContainer::class, false)) {
    \class_alias(\ContainerWsl62ww\srcDevDebugProjectContainer::class, srcDevDebugProjectContainer::class, false);
}

return new \ContainerWsl62ww\srcDevDebugProjectContainer(array(
    'container.build_hash' => 'Wsl62ww',
    'container.build_id' => 'f345229e',
    'container.build_time' => 1523445441,
), __DIR__.\DIRECTORY_SEPARATOR.'ContainerWsl62ww');