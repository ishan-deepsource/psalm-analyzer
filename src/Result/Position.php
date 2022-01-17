<?php

declare(strict_types=1);

namespace IshanDeepsource\PsalmAnalyzer\Result;

use IshanDeepsource\PsalmAnalyzer\Contract\PositionInterface;
use IshanDeepsource\PsalmAnalyzer\Contract\CoordinateInterface;

class Position implements PositionInterface
{
    protected CoordinateInterface $begin;

    protected CoordinateInterface $end;

    public function __construct(CoordinateInterface $begin, CoordinateInterface $end)
    {
        $this->begin = $begin;
        $this->end = $end;
    }

    public function jsonSerialize(): array
    {
        return [
            'begin' => $this->begin,
            'end' => $this->end,
        ];
    }
}
