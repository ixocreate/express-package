<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Express\Block;

use Ixocreate\Cms\Block\BlockInterface;
use Ixocreate\Express\Admin\Resource\NewsCategory;
use Ixocreate\Schema\Builder\BuilderInterface;
use Ixocreate\Schema\Element\MultiSelectElement;
use Ixocreate\Schema\Element\TextElement;
use Ixocreate\Schema\Schema;
use Ixocreate\Schema\SchemaInterface;

class NewsBlock implements BlockInterface
{
    public function label(): string
    {
        return 'News';
    }

    public static function serviceName(): string
    {
        return 'news';
    }

    public function receiveSchema(BuilderInterface $builder, array $options = []): SchemaInterface
    {
        return (new Schema())->withElements([
            $builder->create(TextElement::class, 'title')
                ->withLabel('title'),
            $builder->create(MultiSelectElement::class, 'newsCategory')
                ->withLabel('Category')
                ->withResource(NewsCategory::serviceName(), 'id', 'name'),
        ]);
    }

    public function template(): string
    {
        return 'express-block::news';
    }
}
