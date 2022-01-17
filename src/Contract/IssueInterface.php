<?php

declare(strict_types=1);

namespace IshanDeepsource\PsalmAnalyzer\Contract;

use JsonSerializable;

interface IssueInterface extends JsonSerializable
{
    public function __construct(string $issueCode, string $issueText, LocationInterface $location);
}
