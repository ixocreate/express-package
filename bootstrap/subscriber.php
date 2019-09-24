<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Express;

use Ixocreate\Event\Subscriber\SubscriberConfigurator;
use Ixocreate\Express\Subscriber\NewsCategoryPageSubscriber;
use Ixocreate\Express\Subscriber\NewsPriorityPageSubscriber;

/** @var SubscriberConfigurator $subscriber */
$subscriber->addSubscriber(NewsCategoryPageSubscriber::class);
$subscriber->addSubscriber(NewsPriorityPageSubscriber::class);
