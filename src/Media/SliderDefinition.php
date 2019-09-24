<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace App\Media;

use Ixocreate\Media\ImageDefinition\ImageDefinitionInterface;

final class SliderDefinition implements ImageDefinitionInterface
{
    public function width(): ?int
    {
        return 1110;
    }

    public function height(): ?int
    {
        return 480;
    }

    public function directory(): string
    {
        return 'slider';
    }

    public static function serviceName(): string
    {
        return 'slider';
    }

    public function upscale(): bool
    {
        return true;
    }

    public function mode(): string
    {
        return ImageDefinitionInterface::MODE_CANVAS_FIT_CROP;
    }
}
