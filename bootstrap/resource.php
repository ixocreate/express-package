<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Express;

use Ixocreate\Express\Admin\Resource\NewsCategory;
use Ixocreate\Resource\ResourceConfigurator;

/** @var ResourceConfigurator $resource */
$resource->addResource(NewsCategory::class);
