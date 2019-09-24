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
use Ixocreate\Schema\Element\TextElement;
use Ixocreate\Schema\Schema;
use Ixocreate\Schema\SchemaInterface;

class ImageBlock implements BlockInterface
{
    public function template(): string
    {
        return 'express-block::image';
    }

    public function label(): string
    {
        return 'Image';
    }

    public static function serviceName(): string
    {
        return 'image';
    }

    public function receiveSchema(BuilderInterface $builder, array $options = []): SchemaInterface
    {
        return (new Schema())->withElements([
            $builder->create(ImageElement::class, 'image')
                ->withLabel('Image')
                ->withRequired(true),
            $builder->create(TextElement::class, 'caption')->withLabel('Caption'),
        ]);
    }
}
