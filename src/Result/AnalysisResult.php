<?php

declare(strict_types=1);

namespace IshanDeepsource\PsalmAnalyzer\Result;

use Throwable;
use IshanDeepsource\PsalmAnalyzer\Contract\IssueInterface;
use IshanDeepsource\PsalmAnalyzer\Contract\AnalysisErrorInterface;
use IshanDeepsource\PsalmAnalyzer\Contract\AnalysisResultInterface;

final class AnalysisResult implements AnalysisResultInterface
{
    /**
     * @var string
     */
    public const ISSUES = 'issues';

    /**
     * @var string
     */
    public const IS_PASSED = 'is_passed';

    /**
     * @var string
     */
    public const ERRORS = 'errors';

    /**
     * @var string
     */
    public const FILE_NAME = 'analysis_results.json';

    /**
     * @var array<IssueInterface>
     */
    private array $issues = [];

    /**
     * @var array<AnalysisErrorInterface>
     */
    private array $errors = [];

    /**
     * Push issue raised by checkers to analysis result.
     */
    public function pushIssue(IssueInterface $issue): void
    {
        $this->issues[] = $issue;
    }

    /**
     * Push unexpected internal errors to analysis result.
     */
    public function pushError(AnalysisErrorInterface $analysisError): void
    {
        $this->errors[] = $analysisError;
    }

    public function isPassed(): bool
    {
        if (empty($this->issues)) {
            return true;
        }

        return false;
    }

    public function getIssues(): array
    {
        return $this->issues;
    }

    public function getAnalysisErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return array{
     *     issues: array{issue_code: string, issue_text: string, location: \IshanDeepsource\PsalmAnalyzer\Analysis\Result\Location},
     *     is_passed: bool,
     *     errors: array<string>
     * }
     */
    public function getResult(): array
    {
        return [
            self::ISSUES => $this->getIssues(),
            self::IS_PASSED => $this->isPassed(),
            self::ERRORS => $this->getAnalysisErrors(),
        ];
    }

    /**
     * @return array{
     *     issues: array{issue_code: string, issue_text: string, location: \IshanDeepsource\PsalmAnalyzer\Analysis\Result\Location},
     *     is_passed: bool,
     *     errors: array<string>
     * }
     */
    public function jsonSerialize(): array
    {
        return $this->getResult();
    }

    /**
     * Writes analysis result to given file path.
     *
     * @param string $analysisResultPath Absolute file path to write analysis into.
     */
    public function write(string $analysisResultPath): bool
    {
        $result = file_put_contents($analysisResultPath, json_encode($this, JSON_UNESCAPED_SLASHES));

        if ($result !== false) { // If file successfully written
            return true;
        }

        return false;
    }
}
