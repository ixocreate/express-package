<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace App\Media;

use Ixocreate\Media\ImageDefinition\ImageDefinitionInterface;

final class GalleryThumbDefinition implements ImageDefinitionInterface
{
    public function width(): ?int
    {
        return 350;
    }

    public function height(): ?int
    {
        return 240;
    }

    public function directory(): string
    {
        return 'gallery-thumb';
    }

    public static function serviceName(): string
    {
        return 'gallery-thumb';
    }

    public function upscale(): bool
    {
        return false;
    }

    public function mode(): string
    {
        return ImageDefinitionInterface::MODE_CANVAS_FIT_CROP;
    }
}
