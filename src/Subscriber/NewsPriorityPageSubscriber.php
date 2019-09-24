<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Express\Subscriber;

use Ixocreate\Cms\Event\PageEvent;
use Ixocreate\Entity\EntityInterface;
use Ixocreate\Event\EventInterface;
use Ixocreate\Event\Subscriber\SubscriberInterface;
use Ixocreate\Express\Entity\PageNewsPriority;
use Ixocreate\Express\PageType\NewsPageType;
use Ixocreate\Express\Repository\PageNewsPriorityRepository;

final class NewsPriorityPageSubscriber implements SubscriberInterface
{
    /**
     * @var PageNewsPriorityRepository
     */
    private $pageNewsPriorityRepository;

    /**
     * PriorityPageSubscriber constructor.
     *
     * @param PageNewsPriorityRepository $pageNewsPriorityRepository
     */
    public function __construct(PageNewsPriorityRepository $pageNewsPriorityRepository)
    {
        $this->pageNewsPriorityRepository = $pageNewsPriorityRepository;
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

        /** @var EntityInterface $pagePriority */
        $pagePriority = $this->pageNewsPriorityRepository->find((string)$event->page()->id());
        if ($pagePriority !== null) {
            $this->pageNewsPriorityRepository->remove($pagePriority);
        }

        $priority = $schema->newsPriority;
        if ($priority === true) {
            $pagePriority = new PageNewsPriority([
                'pageId' => $event->page()->id(),
            ]);
            $this->pageNewsPriorityRepository->save($pagePriority);
        }
    }
}
