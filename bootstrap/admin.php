<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Express;

use Ixocreate\Admin\AdminConfigurator;

/** @var AdminConfigurator $admin */
$admin->getNavigationGroup('Content')
    ->add("News", ["admin.api.news.index"], "fa fa-newspaper-o", "/page-flat/news-overview", 600);

$admin->getNavigationGroup("Content")
    ->add("News Category", ["admin.api.news-category.index"], "fa fa-newspaper-o", "/resource/news-category", 590);
