<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Express\Repository;

use Ixocreate\Database\Repository\AbstractRepository;
use Ixocreate\Express\Entity\NewsCategory;

class NewsCategoryRepository extends AbstractRepository
{
    /**
     * @return string
     */
    public function getEntityName(): string
    {
        return NewsCategory::class;
    }
}
