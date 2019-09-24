<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace App\Media;

use Ixocreate\Media\ImageDefinition\ImageDefinitionInterface;

final class ImageDefinition implements ImageDefinitionInterface
{
    public function width(): ?int
    {
        return 1110;
    }

    public function height(): ?int
    {
        return null;
    }

    public function directory(): string
    {
        return 'image';
    }

    public static function serviceName(): string
    {
        return 'image';
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
