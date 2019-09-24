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
use Ixocreate\Schema\Element\NumberElement;
use Ixocreate\Schema\Element\TextElement;
use Ixocreate\Schema\Schema;
use Ixocreate\Schema\SchemaInterface;

class CounterBlock implements BlockInterface
{
    public function template(): string
    {
        return 'express-block::counter';
    }

    public function label(): string
    {
        return 'Counter';
    }

    public static function serviceName(): string
    {
        return 'counter';
    }

    public function receiveSchema(BuilderInterface $builder, array $options = []): SchemaInterface
    {
        return (new Schema())->withElements([
            $builder->create(CollectionElement::class, 'counters')
                ->withLabel('Counters')
                ->addCollectionElement(
                    'number',
                    'Counter',
                    (new Schema())
                        ->withElements([
                            $builder->create(ImageElement::class, 'icon')
                                ->withLabel('Icon')
                                ->withRequired(true),
                            $builder->create(NumberElement::class, 'number')
                                ->withLabel('Number')
                                ->withRequired(true),
                            $builder->create(TextElement::class, 'text')
                                ->withLabel('Text'),
                        ])
                ),
        ]);
    }
}
