<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Express\PageType;

use Ixocreate\Cms\PageType\HandlePageTypeInterface;
use Ixocreate\Cms\PageType\PageTypeInterface;
use Ixocreate\Cms\PageType\TerminalPageTypeInterface;
use Ixocreate\Media\Schema\Element\ImageElement;
use Ixocreate\Schema\Builder\BuilderInterface;
use Ixocreate\Schema\Element\GroupElement;
use Ixocreate\Schema\Element\TabbedGroupElement;
use Ixocreate\Schema\Element\TextareaElement;
use Ixocreate\Schema\Schema;
use Ixocreate\Schema\SchemaInterface;

class NewsOverviewPageType implements PageTypeInterface, TerminalPageTypeInterface, HandlePageTypeInterface
{
    public static function serviceName(): string
    {
        return 'news-overview';
    }

    public function label(): string
    {
        return 'News Overview';
    }

    public function allowedChildren(): ?array
    {
        return ['news'];
    }

    public function template(): string
    {
        return 'express-page::news-overview';
    }

    public function provideSchema($name, BuilderInterface $builder, $options = []): SchemaInterface
    {
        return (new Schema())->withElements([
            $builder->create(TabbedGroupElement::class, 'tabs')
                ->withElements([
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
