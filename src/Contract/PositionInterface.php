<?php

declare(strict_types=1);

namespace IshanDeepsource\PsalmAnalyzer\Contract;

use JsonSerializable;

interface PositionInterface extends JsonSerializable
{
    public function __construct(CoordinateInterface $begin, CoordinateInterface $end);
}
