<?php

declare(strict_types=1);

namespace IshanDeepsource\PsalmAnalyzer\Contract;

use JsonSerializable;

interface CoordinateInterface extends JsonSerializable
{
    public function __construct(int $line, int $column);
}
