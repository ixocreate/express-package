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
use Ixocreate\Schema\Type\UuidType;

final class Version20190131081150 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $table = $schema->createTable('express_page_news_priority');
        $table->addColumn('pageId', UuidType::serviceName());
        $table->setPrimaryKey(['pageId']);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
