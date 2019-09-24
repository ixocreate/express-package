<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace App\Media;

use Ixocreate\Media\ImageDefinition\ImageDefinitionInterface;

final class VideoDefinition implements ImageDefinitionInterface
{
    public function width(): ?int
    {
        return 780;
    }

    public function height(): ?int
    {
        return 440;
    }

    public function directory(): string
    {
        return 'video';
    }

    public static function serviceName(): string
    {
        return 'video';
    }

    public function upscale(): bool
    {
        return false;
    }

    public function mode(): string
    {
        return ImageDefinitionInterface::MODE_FIT_CROP;
    }
}
