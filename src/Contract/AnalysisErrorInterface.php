<?php

declare(strict_types=1);

namespace IshanDeepsource\PsalmAnalyzer\Contract;

use JsonSerializable;

interface AnalysisErrorInterface extends JsonSerializable
{
    public function __construct(string $hMessage, int $level);
}
