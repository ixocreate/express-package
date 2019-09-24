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
use Ixocreate\Schema\Element\HtmlElement;
use Ixocreate\Schema\Element\SelectElement;
use Ixocreate\Schema\Element\TextElement;
use Ixocreate\Schema\Schema;
use Ixocreate\Schema\SchemaInterface;

class TextImageBlock implements BlockInterface
{
    public function template(): string
    {
        return 'express-block::text-image';
    }

    public function label(): string
    {
        return 'Text with Image';
    }

    public static function serviceName(): string
    {
        return 'textImage';
    }

    public function receiveSchema(BuilderInterface $builder, array $options = []): SchemaInterface
    {
        return (new Schema())->withElements([
            $builder->create(SelectElement::class, 'imagePosition')
                ->withLabel('Image Position')
                ->withOptions([
                    'left' => 'Left',
                    'right' => 'Right',
                ])
                ->withRequired(true),
            $builder->create(ImageElement::class, 'image')
                ->withLabel('Image')
                ->withRequired(true),
            $builder->create(TextElement::class, 'caption')->withLabel('Caption'),
            $builder->create(TextElement::class, 'title')
                ->withLabel('title'),
            $builder->create(HtmlElement::class, 'text')
                ->withLabel('Text')
                ->withRequired(true),
        ]);
    }
}
