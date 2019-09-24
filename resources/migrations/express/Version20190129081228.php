<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Ixocreate\Schema\Type\DateTimeType;
use Ixocreate\Schema\Type\TypeInterface;
use Ixocreate\Schema\Type\UuidType;

final class Version20190129081228 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $table = $schema->createTable('express_news_category');
        $table->addColumn('id', UuidType::serviceName());
        $table->addColumn('name', TypeInterface::TYPE_STRING);
        $table->addColumn('createdAt', DateTimeType::serviceName());
        $table->addColumn('updatedAt', DateTimeType::serviceName());
        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
