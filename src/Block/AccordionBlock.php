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
use Ixocreate\Schema\Element\HtmlElement;
use Ixocreate\Schema\Element\TextElement;
use Ixocreate\Schema\Schema;
use Ixocreate\Schema\SchemaInterface;

class AccordionBlock implements BlockInterface
{
    public function template(): string
    {
        return 'express-block::accordion';
    }

    public function label(): string
    {
        return 'Accordion';
    }

    public static function serviceName(): string
    {
        return 'accordion';
    }

    public function receiveSchema(BuilderInterface $builder, array $options = []): SchemaInterface
    {
        return (new Schema())->withElements([
            $builder->create(TextElement::class, 'title')
                ->withLabel('Title'),
            $builder->create(CollectionElement::class, 'accordion')
                ->withLabel('Accordion')
                ->addCollectionElement(
                    'accordion',
                    'Accordion',
                    (new Schema())
                        ->withElements([
                            $builder->create(TextElement::class, 'title')
                                ->withLabel('Title')
                                ->withRequired(true),
                            $builder->create(HtmlElement::class, 'text')
                                ->withLabel('Text')
                                ->withRequired(true),
                        ])
                ),
        ]);
    }
}
