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
use Ixocreate\Schema\Type\UuidType;

final class PageNewsPriority implements EntityInterface, DatabaseEntityInterface
{
    use EntityTrait;

    private $pageId;

    public function pageId(): UuidType
    {
        return $this->pageId;
    }

    public static function createDefinitions(): DefinitionCollection
    {
        return new DefinitionCollection([
            new Definition('pageId', UuidType::class, false, true),
        ]);
    }

    public static function loadMetadata(ClassMetadataBuilder $builder)
    {
        $builder->setTable('express_page_news_priority');

        $builder->createField('pageId', UuidType::serviceName())->makePrimaryKey()->build();
    }
}
