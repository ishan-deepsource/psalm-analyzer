<?php

declare(strict_types=1);

namespace IshanDeepsource\PsalmAnalyzer\Contract;

use JsonSerializable;

interface AnalysisResultInterface extends JsonSerializable
{
    public function pushIssue(IssueInterface $issue): void;

    public function pushError(AnalysisErrorInterface $analysisError): void;

    public function isPassed(): bool;

    public function getIssues(): array;

    public function getAnalysisErrors(): array;

    public function getResult(): array;

    public function write(string $analysisResultPath): bool;
}
