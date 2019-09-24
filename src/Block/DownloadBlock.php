<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Express\Block;

use Ixocreate\Cms\Block\BlockInterface;
use Ixocreate\Media\Schema\Element\MediaElement;
use Ixocreate\Schema\Builder\BuilderInterface;
use Ixocreate\Schema\Element\CollectionElement;
use Ixocreate\Schema\Element\TextElement;
use Ixocreate\Schema\Schema;
use Ixocreate\Schema\SchemaInterface;

class DownloadBlock implements BlockInterface
{
    public function template(): string
    {
        return 'express-block::download';
    }

    public function label(): string
    {
        return 'Download';
    }

    public static function serviceName(): string
    {
        return 'download';
    }

    public function receiveSchema(BuilderInterface $builder, array $options = []): SchemaInterface
    {
        return (new Schema())->withElements([
            $builder->create(TextElement::class, 'title')
                ->withLabel('Title'),
            $builder->create(CollectionElement::class, 'downloads')
                ->withLabel('Downloads')
                ->addCollectionElement(
                    'download',
                    'Download',
                    (new Schema())
                        ->withElements([
                            $builder->create(TextElement::class, 'title')
                                ->withLabel('Title')
                                ->withRequired(true),
                            $builder->create(TextElement::class, 'text')
                                ->withLabel('Text'),
                            $builder->create(MediaElement::class, 'media')
                                ->withLabel('Media')
                                ->withRequired(true),
                        ])
                ),
        ]);
    }
}
