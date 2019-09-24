<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Express\Admin\Resource;

use Ixocreate\Admin\Resource\DefaultAdminTrait;
use Ixocreate\Admin\Resource\Schema\ListSchemaAwareInterface;
use Ixocreate\Admin\UserInterface;
use Ixocreate\Express\Repository\NewsCategoryRepository;
use Ixocreate\Resource\ResourceInterface;
use Ixocreate\Schema\Builder\Builder;
use Ixocreate\Schema\Builder\BuilderInterface;
use Ixocreate\Schema\ListElement\DateTimeListElement;
use Ixocreate\Schema\ListElement\TextListElement;
use Ixocreate\Schema\ListSchema\ListSchema;
use Ixocreate\Schema\ListSchema\ListSchemaInterface;
use Ixocreate\Schema\SchemaAwareInterface;
use Ixocreate\Schema\SchemaInterface;

class NewsCategory implements
    ResourceInterface,
    SchemaAwareInterface,
    ListSchemaAwareInterface
{
    use DefaultAdminTrait;

    public static function serviceName(): string
    {
        return 'news-category';
    }

    public function repository(): string
    {
        return NewsCategoryRepository::class;
    }

    public function label(): string
    {
        return 'News Category';
    }

    public function schema(BuilderInterface $builder): SchemaInterface
    {
        /** @var Builder $builder */
        $schema = $builder->fromEntity(\Ixocreate\Express\Entity\NewsCategory::class);

        $schema = $schema->withAddedElement($schema->get('name')->withRequired(true));

        return $schema;
    }

    public function listSchema(UserInterface $user): ListSchemaInterface
    {
        return (new ListSchema())
            ->withAddedElement(new TextListElement("name", "Name"))
            ->withAddedElement(new DateTimeListElement("createdAt", "Created"))
            ->withAddedElement(new DateTimeListElement("updatedAt", "Updated"));
    }
}
