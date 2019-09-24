<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Express\Subscriber;

use Ixocreate\Cms\Event\PageEvent;
use Ixocreate\Event\EventInterface;
use Ixocreate\Event\Subscriber\SubscriberInterface;
use Ixocreate\Express\Entity\PageNewsCategory;
use Ixocreate\Express\PageType\NewsPageType;
use Ixocreate\Express\Repository\PageNewsCategoryRepository;

final class NewsCategoryPageSubscriber implements SubscriberInterface
{
    /**
     * @var PageNewsCategoryRepository
     */
    private $pageNewsCategoryRepository;

    /**
     * CategoryPageSubscriber constructor.
     *
     * @param PageNewsCategoryRepository $pageNewsCategoryRepository
     */
    public function __construct(PageNewsCategoryRepository $pageNewsCategoryRepository)
    {
        $this->pageNewsCategoryRepository = $pageNewsCategoryRepository;
    }

    public static function register(): array
    {
        return ['page-version.publish'];
    }

    public function handle(EventInterface $event, string $eventName)
    {
        /** @var PageEvent $event */
        if (!($event->pageType() instanceof NewsPageType)) {
            return;
        }

        $schema = $event->pageVersion()->content();

        $result = $this->pageNewsCategoryRepository->findBy(['pageId' => $event->page()->id()]);
        foreach ($result as $pageCategory) {
            $this->pageNewsCategoryRepository->remove($pageCategory);
        }

        $category = $schema->newsCategory;
        if (empty($category) || !\is_array($category)) {
            return;
        }

        foreach ($category as $id) {
            $pageCategory = new PageNewsCategory([
                'newsCategoryId' => $id,
                'pageId' => $event->page()->id(),
            ]);

            $this->pageNewsCategoryRepository->save($pageCategory);
        }
    }
}
