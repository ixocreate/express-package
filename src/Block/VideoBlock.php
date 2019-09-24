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
use Ixocreate\Schema\Element\YouTubeElement;
use Ixocreate\Schema\Schema;
use Ixocreate\Schema\SchemaInterface;

class VideoBlock implements BlockInterface
{
    public function template(): string
    {
        return 'express-block::video';
    }

    public function label(): string
    {
        return 'Video';
    }

    public static function serviceName(): string
    {
        return 'video';
    }

    public function receiveSchema(BuilderInterface $builder, array $options = []): SchemaInterface
    {
        return (new Schema())->withElements([
            $builder->create(TextElement::class, 'title')
                ->withLabel('Title'),
            $builder->create(TextElement::class, 'subTitle')
                ->withLabel('Sub Title'),
            $builder->create(YouTubeElement::class, 'video')
                ->withLabel('Video')
                ->withRequired(true),
            $builder->create(ImageElement::class, 'image')
                ->withLabel('Image'),
        ]);
    }
}
