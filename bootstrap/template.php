<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Express;

use Ixocreate\Express\Template\NewsCategoryExtension;
use Ixocreate\Express\Template\NewsExtension;
use Ixocreate\Template\TemplateConfigurator;

/** @var TemplateConfigurator $template */
$template->addDirectory('express-error', __DIR__ . '/../templates/error');
$template->addDirectory('express-page', __DIR__ . '/../templates/page');
$template->addDirectory('express-block', __DIR__ . '/../templates/block');
$template->addDirectory('express-layout', __DIR__ . '/../templates/layout');
$template->addDirectory('express-partials', __DIR__ . '/../templates/partials');

$template->addExtension(NewsCategoryExtension::class);
$template->addExtension(NewsExtension::class);
