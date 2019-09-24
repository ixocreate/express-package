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
use Ixocreate\Schema\Schema;
use Ixocreate\Schema\SchemaInterface;

class GalleryBlock implements BlockInterface
{
    public function template(): string
    {
        return 'express-block::gallery';
    }

    public function label(): string
    {
        return 'Gallery';
    }

    public static function serviceName(): string
    {
        return 'gallery';
    }

    public function receiveSchema(BuilderInterface $builder, array $options = []): SchemaInterface
    {
        return (new Schema())->withElements([
            $builder->create(CollectionElement::class, 'images')
                ->withLabel('Images')
                ->addCollectionElement(
                    'image',
                    'Image',
                    (new Schema())
                        ->withElements([
                            $builder->create(ImageElement::class, 'image')
                                ->withLabel('Image')
                                ->withRequired(true),
                        ])
                ),
        ]);
    }
}
