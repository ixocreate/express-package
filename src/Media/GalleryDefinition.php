<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace App\Media;

use Ixocreate\Media\ImageDefinition\ImageDefinitionInterface;

final class GalleryDefinition implements ImageDefinitionInterface
{
    public function width(): ?int
    {
        return 1500;
    }

    public function height(): ?int
    {
        return 1000;
    }

    public function directory(): string
    {
        return 'gallery';
    }

    public static function serviceName(): string
    {
        return 'gallery';
    }

    public function upscale(): bool
    {
        return false;
    }

    public function mode(): string
    {
        return ImageDefinitionInterface::MODE_FIT;
    }
}
