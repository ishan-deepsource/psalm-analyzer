<?php

declare(strict_types=1);

namespace IshanDeepsource\PsalmAnalyzer\Result;

use IshanDeepsource\PsalmAnalyzer\Contract\CoordinateInterface;

class Coordinate implements CoordinateInterface
{
    protected int $line;

    protected int $column;

    public function __construct(int $line, int $column)
    {
        $this->line = $line;
        $this->column = $column;
    }

    public function jsonSerialize(): array
    {
        return [
            'line' => $this->line,
            'column' => $this->column,
        ];
    }
}
