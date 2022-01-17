<?php

declare(strict_types=1);

namespace IshanDeepsource\PsalmAnalyzer\Contract;

use JsonSerializable;

interface LocationInterface extends JsonSerializable
{
    public function __construct(string $path, PositionInterface $position);
}
