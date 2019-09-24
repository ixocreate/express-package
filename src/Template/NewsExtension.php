<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Express\Template;

use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\CompositeExpression;
use Ixocreate\Cms\Entity\PageVersion;
use Ixocreate\Cms\Repository\PageRepository;
use Ixocreate\Cms\Repository\PageVersionRepository;
use Ixocreate\Cms\Repository\SitemapRepository;
use Ixocreate\Collection\ArrayCollection;
use Ixocreate\Entity\EntityCollection;
use Ixocreate\Express\Entity\PageNewsCategory;
use Ixocreate\Express\Repository\NewsCategoryRepository;
use Ixocreate\Express\Repository\PageNewsCategoryRepository;
use Ixocreate\Express\Repository\PageNewsPriorityRepository;
use Ixocreate\Template\Extension\ExtensionInterface;

final class NewsExtension implements ExtensionInterface
{
    /**
     * @var string
     */
    private $locale;

    /**
     * @var SitemapRepository
     */
    private $sitemapRepository;

    /**
     * @var PageRepository
     */
    private $pageRepository;

    /**
     * @var PageVersionRepository
     */
    private $pageVersionRepository;

    /**
     * @var PageNewsCategoryRepository
     */
    private $pageNewsCategoryRepository;

    /**
     * @var PageNewsCategoryRepository
     */
    private $newsCategoryRepository;

    /**
     * @var PageNewsCategoryRepository
     */
    private $pageNewsPriorityRepository;

    /**
     * @return string
     */
    public static function getName(): string
    {
        return "news";
    }

    public function __construct(
        SitemapRepository $sitemapRepository,
        PageRepository $pageRepository,
        PageVersionRepository $pageVersionRepository,
        PageNewsCategoryRepository $pageNewsCategoryRepository,
        PageNewsPriorityRepository $pageNewsPriorityRepository,
        NewsCategoryRepository $newsCategoryRepository
    ) {
        $this->sitemapRepository = $sitemapRepository;
        $this->pageRepository = $pageRepository;
        $this->pageVersionRepository = $pageVersionRepository;
        $this->pageNewsCategoryRepository = $pageNewsCategoryRepository;
        $this->newsCategoryRepository = $newsCategoryRepository;
        $this->pageNewsPriorityRepository = $pageNewsPriorityRepository;
    }

    public function __invoke()
    {
        return $this;
    }

    public function locale(string $locale)
    {
        $this->locale = $locale;
        return $this;
    }

    public function take(int $amount)
    {
        return $this->paginate($amount);
    }

    public function findAll()
    {
        return $this->paginate(null);
    }

    public function paginate(int $limit = null, ?array $filters = null): ArrayCollection
    {
        $newsCategories = new EntityCollection($this->newsCategoryRepository->findAll());

        $filteredPageIds = null;
        $priorityPageIds = null;
        $withoutPageIds = null;
        if (!empty($filters['categoryIds'])) {
            $pageNewsCategoryResult = $this->pageNewsCategoryRepository->findBy(['newsCategoryId' => $filters['categoryIds']]);
            $filteredPageIds = [];

            if (empty($pageNewsCategoryResult)) {
                return new ArrayCollection();
            }

            /** @var PageNewsCategory $pageNewsCategory */
            foreach ($pageNewsCategoryResult as $pageNewsCategory) {
                $filteredPageIds[] = $pageNewsCategory->pageId();
            }
        }
        if (!empty($filters['priority']) && $filters['priority'] === true) {
            $priorityPageIds = [];
            $pageNewsPriorityResult = $this->pageNewsPriorityRepository->findAll();
            foreach ($pageNewsPriorityResult as $pageNewsPriority) {
                $priorityPageIds[] = $pageNewsPriority->pageId();
            }
        }
        if (!empty($filters['withoutPriority']) && $filters['withoutPriority'] === true) {
            $pageNewsPriorityResult = $this->pageNewsPriorityRepository->findAll();
            $withoutPageIds = [];
            foreach ($pageNewsPriorityResult as $pageNewsPriority) {
                $withoutPageIds[] = $pageNewsPriority->pageId();
            }
        }

        $newsList = [];
        $sitemap = $this->sitemapRepository->findOneBy(['handle' => 'news-overview']);
        if (empty($sitemap)) {
            return new ArrayCollection();
        }

        $result = $this->sitemapRepository->findBy(['parentId' => $sitemap->id()]);
        $sitemapIds = [];
        foreach ($result as $sitemap) {
            $sitemapIds[] = $sitemap->id();
        }

        $criteria = Criteria::create();

        $criteria->where(Criteria::expr()->eq('status', 'online'));
        if ($this->locale) {
            $criteria->andWhere(Criteria::expr()->eq('locale', $this->locale));
        }
        $criteria->andWhere(Criteria::expr()->in('sitemapId', $sitemapIds));

        if (!empty($filteredPageIds)) {
            $criteria->andWhere(Criteria::expr()->in('id', $filteredPageIds));
        }
        if (!empty($priorityPageIds)) {
            $criteria->andWhere(Criteria::expr()->in('id', $priorityPageIds));
        }
        if (!empty($withoutPageIds)) {
            $criteria->andWhere(Criteria::expr()->notIn('id', $withoutPageIds));
        }

        $criteria->andWhere(new CompositeExpression(
            CompositeExpression::TYPE_OR,
            [
                Criteria::expr()->isNull("publishedFrom"),
                Criteria::expr()->lte("publishedFrom", new \DateTime()),
            ]
        ));
        $criteria->andWhere(new CompositeExpression(
            CompositeExpression::TYPE_OR,
            [
                Criteria::expr()->isNull("publishedUntil"),
                Criteria::expr()->gte("publishedUntil", new \DateTime()),
            ]
        ));

        if (!empty($filters['year'])) {
            $criteria->andWhere(Criteria::expr()->gte(
                'releasedAt',
                new \DateTime($filters['year'] . '-01-01 00:00:00')
            ));
            $criteria->andWhere(Criteria::expr()->lt(
                'releasedAt',
                new \DateTime($filters['year'] . '-12-31 00:00:00')
            ));
        }

        $criteria->orderBy(['releasedAt' => 'DESC']);
        $criteria->setMaxResults($limit);
        $pages = $this->pageRepository->matching($criteria);

        foreach ($pages as $page) {
            $criteria = Criteria::create();
            $criteria->where(Criteria::expr()->eq('pageId', $page->id()));
            $criteria->andWhere(Criteria::expr()->neq('approvedAt', null));

            $criteria->orderBy(['approvedAt' => 'DESC']);
            $criteria->setMaxResults(1);

            $pageVersion = $this->pageVersionRepository->matching($criteria);
            /** @var PageVersion $pageVersion */
            $pageVersion = $pageVersion->current();

            $newsCategoryIds = (new EntityCollection($this->pageNewsCategoryRepository->findBy(['pageId' => $page->id])))
                ->extract(function ($category) {
                    return $category->newsCategoryId();
                });

            $newsList[] = [
                'page' => $page,
                'pageContent' => $pageVersion->content(),
                'pageNewsCategories' => $newsCategories->filter(function ($newsCategory) use ($newsCategoryIds) {
                    return $newsCategoryIds->get($newsCategory->id);
                }),
            ];
        }
        return new ArrayCollection($newsList);
    }
}
