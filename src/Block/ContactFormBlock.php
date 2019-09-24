<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Express\Block;

use Ixocreate\Cms\Block\BlockInterface;
use Ixocreate\Schema\Builder\BuilderInterface;
use Ixocreate\Schema\Schema;
use Ixocreate\Schema\SchemaInterface;

class ContactFormBlock implements BlockInterface
{
    public function label(): string
    {
        return 'Contact Form';
    }

    public static function serviceName(): string
    {
        return 'contactForm';
    }

    public function receiveSchema(BuilderInterface $builder, array $options = []): SchemaInterface
    {
        $schema = new Schema();
        return $schema;
    }

    public function template(): string
    {
        return 'express-block::contact-form';
    }
}
