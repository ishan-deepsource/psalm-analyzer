<?php

declare(strict_types=1);

namespace IshanDeepsource\PsalmAnalyzer\Result\Builder;

use IshanDeepsource\PsalmAnalyzer\Result\Issue;
use IshanDeepsource\PsalmAnalyzer\Result\Location;
use IshanDeepsource\PsalmAnalyzer\Result\Position;
use IshanDeepsource\PsalmAnalyzer\Result\Coordinate;
use IshanDeepsource\PsalmAnalyzer\Contract\IssueInterface;

/**
 * Builder class helps to create instace of `\IshanDeepsource\PsalmAnalyzer\Contract\IssueInterface` object.
 */
final class IssueBuilder
{
    private string $message;

    private string $issueCode = '';

    private string $file = '';

    private int $beginLine = 0;

    private int $endLine = 0;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public static function message(string $message): self
    {
        return new self($message);
    }

    public function code(string $issueCode): self
    {
        $this->issueCode = $issueCode;

        return $this;
    }

    public function line(int $lineNumber): self
    {
        $this->beginLine = $lineNumber;
        $this->endLine = $lineNumber;

        return $this;
    }

    public function beginLine(int $lineNumber): self
    {
        $this->beginLine = $lineNumber;

        return $this;
    }

    public function endLine(int $lineNumber): self
    {
        $this->endLine = $lineNumber;

        return $this;
    }

    public function file(string $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function build(): IssueInterface
    {
        return new Issue(
            $this->issueCode,
            $this->message,
            new Location(
                $this->file,
                new Position(
                    new Coordinate($this->beginLine, 0),
                    new Coordinate($this->endLine, 0)
                )
            )
        );
    }
}
