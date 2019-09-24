<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Express\PageType;

use Ixocreate\Cms\PageType\HandlePageTypeInterface;
use Ixocreate\Cms\PageType\RootPageTypeInterface;
use Ixocreate\Cms\PageType\RoutingAwareInterface;
use Ixocreate\Cms\Schema\Element\BlockContainerElement;
use Ixocreate\Media\Schema\Element\ImageElement;
use Ixocreate\Schema\Builder\BuilderInterface;
use Ixocreate\Schema\Element\GroupElement;
use Ixocreate\Schema\Element\TabbedGroupElement;
use Ixocreate\Schema\Element\TextareaElement;
use Ixocreate\Schema\Schema;
use Ixocreate\Schema\SchemaInterface;

class HomePageType implements RootPageTypeInterface, HandlePageTypeInterface, RoutingAwareInterface
{
    public static function serviceName(): string
    {
        return 'home';
    }

    public function label(): string
    {
        return 'Home';
    }

    public function allowedChildren(): ?array
    {
        return ['page', 'redirect', 'news-overview'];
    }

    public function routing(): string
    {
        return '${URI:mainUri}/${LANG:no-root-default}';
    }

    public function template(): string
    {
        return 'express-page::home';
    }

    public function provideSchema($name, BuilderInterface $builder, $options = []): SchemaInterface
    {
        return (new Schema())->withElements([
            $builder->create(TabbedGroupElement::class, 'tabs')
                ->withElements([
                    $builder->create(GroupElement::class, 'content')
                        ->withLabel("Content")
                        ->withElements(
                            [
                                $builder->create(BlockContainerElement::class, 'content')
                                    ->withLabel("Content")
                                    ->withBlocks([
                                        'accordion',
                                        'contactForm',
                                        'cookieInfo',
                                        'counter',
                                        'download',
                                        'gallery',
                                        'image',
                                        'news',
                                        'slider',
                                        'text',
                                        'textImage',
                                        'video',
                                    ]),
                            ]
                        ),
                    $builder->create(GroupElement::class, 'seo')
                        ->withLabel("SEO")
                        ->withElements([
                            $builder->create(TextareaElement::class, 'metaDescription')
                                ->withLabel("Meta Description"),
                            $builder->create(ImageElement::class, 'metaImage')
                                ->withLabel("Meta Image"),
                        ]),
                ]),
        ]);
    }
}
