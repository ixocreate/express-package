<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Express\Entity;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Ixocreate\Database\DatabaseEntityInterface;
use Ixocreate\Entity\Definition;
use Ixocreate\Entity\DefinitionCollection;
use Ixocreate\Entity\EntityInterface;
use Ixocreate\Entity\EntityTrait;
use Ixocreate\Schema\Type\DateTimeType;
use Ixocreate\Schema\Type\TypeInterface;
use Ixocreate\Schema\Type\UuidType;

final class NewsCategory implements EntityInterface, DatabaseEntityInterface
{
    use EntityTrait;

    private $id;

    private $name;

    private $createdAt;

    private $updatedAt;

    public function id(): UuidType
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function createdAt(): DateTimeType
    {
        return $this->createdAt;
    }

    public function updatedAt(): DateTimeType
    {
        return $this->updatedAt;
    }

    public static function createDefinitions(): DefinitionCollection
    {
        return new DefinitionCollection([
            new Definition('id', UuidType::class, false, true),
            new Definition('name', TypeInterface::TYPE_STRING, false, true),
            new Definition('createdAt', DateTimeType::class, false, true),
            new Definition('updatedAt', DateTimeType::class, false, true),
        ]);
    }

    public static function loadMetadata(ClassMetadataBuilder $builder)
    {
        $builder->setTable('express_news_category');

        $builder->createField('id', UuidType::serviceName())->makePrimaryKey()->build();
        $builder->createField('name', 'string')->nullable(false)->build();
        $builder->createField('createdAt', DateTimeType::serviceName())->nullable(false)->build();
        $builder->createField('updatedAt', DateTimeType::serviceName())->nullable(false)->build();
    }
}
