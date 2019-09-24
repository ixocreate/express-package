<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace App\Media;

use Ixocreate\Media\ImageDefinition\ImageDefinitionInterface;

final class IconDefinition implements ImageDefinitionInterface
{
    public function width(): ?int
    {
        return 150;
    }

    public function height(): ?int
    {
        return 150;
    }

    public function directory(): string
    {
        return 'icon';
    }

    public static function serviceName(): string
    {
        return 'icon';
    }

    public function upscale(): bool
    {
        return false;
    }

    public function mode(): string
    {
        return ImageDefinitionInterface::MODE_CANVAS;
    }
}
