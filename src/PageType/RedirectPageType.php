<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Express\PageType;

use Ixocreate\Cms\PageType\MiddlewarePageTypeInterface;
use Ixocreate\Cms\PageType\PageTypeInterface;
use Ixocreate\Express\Middleware\RedirectMiddleware;
use Ixocreate\Schema\Builder\BuilderInterface;
use Ixocreate\Schema\Element\GroupElement;
use Ixocreate\Schema\Element\LinkElement;
use Ixocreate\Schema\Element\TabbedGroupElement;
use Ixocreate\Schema\Schema;
use Ixocreate\Schema\SchemaInterface;

class RedirectPageType implements PageTypeInterface, MiddlewarePageTypeInterface
{
    public static function serviceName(): string
    {
        return 'redirect';
    }

    public function label(): string
    {
        return 'Redirect';
    }

    public function allowedChildren(): ?array
    {
        return ['page', 'redirect'];
    }

    public function middleware(): array
    {
        return [
            RedirectMiddleware::class,
        ];
    }

    public function template(): string
    {
        return 'express-page::page';
    }

    public function provideSchema($name, BuilderInterface $builder, $options = []): SchemaInterface
    {
        return (new Schema())->withElements([
            $builder->create(TabbedGroupElement::class, 'tabs')
                ->withElements([
                    $builder->create(GroupElement::class, 'settings')
                        ->withLabel("Settings")
                        ->withElements([
                            $builder->create(LinkElement::class, 'redirect')
                                ->withLabel("Redirect")
                                ->withRequired(true),
                        ]),
                ]),
        ]);
    }
}
