<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Express\Repository;

use Ixocreate\Database\Repository\AbstractRepository;
use Ixocreate\Express\Entity\PageNewsCategory;

final class PageNewsCategoryRepository extends AbstractRepository
{
    /**
     * @return string
     */
    public function getEntityName(): string
    {
        return PageNewsCategory::class;
    }
}
