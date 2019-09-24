<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Express\Template;

use Ixocreate\Entity\EntityCollection;
use Ixocreate\Express\Entity\PageNewsCategory;
use Ixocreate\Express\Repository\NewsCategoryRepository;
use Ixocreate\Express\Repository\PageNewsCategoryRepository;
use Ixocreate\Template\Extension\ExtensionInterface;

class NewsCategoryExtension implements ExtensionInterface
{
    /**
     * @var NewsCategoryRepository
     */
    private $newsCategoryRepository;

    /**
     * @var PageNewsCategoryRepository
     */
    private $pageNewsCategoryRepository;

    public static function getName(): string
    {
        return 'newsCategory';
    }

    public function __construct(
        NewsCategoryRepository $newsCategoryRepository,
        PageNewsCategoryRepository $pageNewsCategoryRepository
    ) {
        $this->newsCategoryRepository = $newsCategoryRepository;
        $this->pageNewsCategoryRepository = $pageNewsCategoryRepository;
    }

    public function __invoke()
    {
        return $this;
    }

    public function findByPageId($pageId)
    {
        $result = $this->pageNewsCategoryRepository->findBy(['pageId' => $pageId]);

        $categories = [];
        /** @var PageNewsCategory $pageNewsCategory */
        foreach ($result as $pageNewsCategory) {
            $categories[] = $pageNewsCategory->newsCategoryId();
        }

        return $this->byIds($categories);
    }

    public function findAll()
    {
        return new EntityCollection($this->newsCategoryRepository->findAll());
    }

    public function byIds($ids)
    {
        return new EntityCollection($this->newsCategoryRepository->findBy(['id' => $ids]));
    }
}
