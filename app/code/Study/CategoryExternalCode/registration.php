<?php
declare(strict_types=1);

use Magento\Framework\Component\ComponentRegistrar as ComponentRegistrarAlias;

ComponentRegistrarAlias::register(
    ComponentRegistrarAlias::MODULE,
    'Study_CategoryExternalCode',
    __DIR__
);
