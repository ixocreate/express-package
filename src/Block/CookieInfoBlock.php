<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Express\Block;

use Ixocreate\Cms\Block\BlockInterface;
use Ixocreate\Schema\Builder\BuilderInterface;
use Ixocreate\Schema\Element\CollectionElement;
use Ixocreate\Schema\Element\TextareaElement;
use Ixocreate\Schema\Element\TextElement;
use Ixocreate\Schema\Schema;
use Ixocreate\Schema\SchemaInterface;

class CookieInfoBlock implements BlockInterface
{
    public function template(): string
    {
        return 'express-block::cookie-info';
    }

    public function label(): string
    {
        return 'Cookie Info';
    }

    public static function serviceName(): string
    {
        return 'cookieInfo';
    }

    public function receiveSchema(BuilderInterface $builder, array $options = []): SchemaInterface
    {
        return (new Schema())->withElements([
            $builder->create(CollectionElement::class, 'table')
                ->withLabel('Table')
                ->addCollectionElement(
                    'row',
                    'Row',
                    (new Schema())
                        ->withElements([
                            $builder->create(TextElement::class, 'name')
                                ->withLabel('Name')
                                ->withRequired(true),
                            $builder->create(TextElement::class, 'time')
                                ->withLabel('Time')
                                ->withRequired(true),
                            $builder->create(TextareaElement::class, 'description')
                                ->withLabel('Description')
                                ->withRequired(true),
                            $builder->create(TextElement::class, 'source')
                                ->withLabel('Source')
                                ->withRequired(true),
                        ])
                ),
        ]);
    }
}
