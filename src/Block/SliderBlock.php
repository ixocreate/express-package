<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Express\Block;

use Ixocreate\Cms\Block\BlockInterface;
use Ixocreate\Media\Schema\Element\ImageElement;
use Ixocreate\Schema\Builder\BuilderInterface;
use Ixocreate\Schema\Element\CollectionElement;
use Ixocreate\Schema\Element\LinkElement;
use Ixocreate\Schema\Element\TextareaElement;
use Ixocreate\Schema\Element\TextElement;
use Ixocreate\Schema\Schema;
use Ixocreate\Schema\SchemaInterface;

class SliderBlock implements BlockInterface
{
    public function template(): string
    {
        return 'express-block::slider';
    }

    public function label(): string
    {
        return 'Slider';
    }

    public static function serviceName(): string
    {
        return 'slider';
    }

    public function receiveSchema(BuilderInterface $builder, array $options = []): SchemaInterface
    {
        return (new Schema())->withElements([
            $builder->create(CollectionElement::class, 'content')
                ->withLabel('Content')
                ->addCollectionElement(
                    'content',
                    'Content',
                    (new Schema())
                        ->withElements([
                            $builder->create(ImageElement::class, 'image')
                                ->withLabel('Image')
                                ->withRequired(true),
                            $builder->create(LinkElement::class, 'link')
                                ->withLabel('Link'),
                            $builder->create(TextElement::class, 'title')
                                ->withLabel('title'),
                            $builder->create(TextareaElement::class, 'content')
                                ->withLabel('content'),
                        ])
                ),
        ]);
    }
}
