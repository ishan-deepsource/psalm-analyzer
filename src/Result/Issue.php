<?php

declare(strict_types=1);

namespace IshanDeepsource\PsalmAnalyzer\Result;

use IshanDeepsource\PsalmAnalyzer\Contract\IssueInterface;
use IshanDeepsource\PsalmAnalyzer\Contract\LocationInterface;

/**
 * The class use to store issues raised by analyzer.
 * There's no need create an instance of the class directly, use `\IshanDeepsource\PsalmAnalyzer\Result\IssueBuilder` class to build/create this object.
 *
 * @see \IshanDeepsource\PsalmAnalyzer\Result\IssueBuilder
 */
final class Issue implements IssueInterface
{
    private string $issueCode;
    private string $issueText;
    private LocationInterface $location;

    public function __construct(string $issueCode, string $issueText, LocationInterface $location)
    {
        $this->issueCode = $issueCode;
        $this->issueText = $issueText;
        $this->location = $location;
    }

    public function getIssueText(): string
    {
        return $this->issueText;
    }

    public function jsonSerialize(): array
    {
        return [
            'issue_code' => $this->issueCode,
            'issue_text' => $this->issueText,
            'location' => $this->location,
        ];
    }
}
