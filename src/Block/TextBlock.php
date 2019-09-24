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
use Ixocreate\Schema\Element\HtmlElement;
use Ixocreate\Schema\Element\TextElement;
use Ixocreate\Schema\Schema;
use Ixocreate\Schema\SchemaInterface;

class TextBlock implements BlockInterface
{
    public function template(): string
    {
        return 'express-block::text';
    }

    public function label(): string
    {
        return 'Text';
    }

    public static function serviceName(): string
    {
        return 'text';
    }

    public function receiveSchema(BuilderInterface $builder, array $options = []): SchemaInterface
    {
        return (new Schema())->withElements([
            $builder->create(TextElement::class, 'title')
                ->withLabel('title'),
            $builder->create(HtmlElement::class, 'text')
                ->withLabel('Text')
                ->withRequired(true),
        ]);
    }
}
