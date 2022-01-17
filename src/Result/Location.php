<?php

declare(strict_types=1);

namespace IshanDeepsource\PsalmAnalyzer\Result;

use IshanDeepsource\PsalmAnalyzer\Contract\LocationInterface;
use IshanDeepsource\PsalmAnalyzer\Contract\PositionInterface;

class Location implements LocationInterface
{
    protected string $path;

    protected PositionInterface $position;

    public function __construct(string $path, PositionInterface $position)
    {
        $this->path = $path;
        $this->position = $position;
    }

    public function jsonSerialize(): array
    {
        return [
            'path' => $this->path,
            'position' => $this->position,
        ];
    }
}
