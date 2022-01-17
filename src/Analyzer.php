<?php

declare(strict_types=1);

namespace IshanDeepsource\PsalmAnalyzer;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Process\Process;
use IshanDeepsource\PsalmAnalyzer\IssueMapping;
use IshanDeepsource\PsalmAnalyzer\Result\AnalysisResult;
use IshanDeepsource\PsalmAnalyzer\Result\Builder\IssueBuilder;
use Symfony\Component\Process\Exception\ProcessFailedException;

/**
 * Mapping for Psalm issue type to DeepSource issue code.
 */
class Analyzer
{
    private AnalysisResult $analysisResult;

    public function __construct()
    {
        $this->analysisResult = new AnalysisResult();
    }

    public function run(): int
    {
        $codePath = getenv('CODE_PATH');
        $toolboxPath = getenv('TOOLBOX_PATH');
        $appPath = dirname(__DIR__);
        $psalmResultPath = $toolboxPath . '/psalm_result.json';
        $analysisResultPath = $toolboxPath . '/' . AnalysisResult::FILE_NAME;

        /**
         * 1. Get files to analyze
         *
         * This step may be optional. Need to confirm.
         */
        $finder = new Finder();
        $finder->files()->in($codePath)->name('*.php')->exclude('vendor')->ignoreVCSIgnored(true);

        if (! $finder->hasResults()) {
            echo 'No file to analyze', PHP_EOL;

            $this->analysisResult->write($analysisResultPath);

            return 0;
        }

        /**
         * 2. Run analysis
         */
        // initialize psalm config file using "psalm --init --root=code_path" command
        $process = new Process(['php', $toolboxPath . '/psalm.phar', '--init', "--root={$codePath}"]);
        $process->run();
        if (! $process->isSuccessful()) {
            echo 'Unable to create psalm.xml config file', PHP_EOL;

            return 1;
        }
        echo 'Process output: ', $process->getOutput(), PHP_EOL;

        // run analysis using "psalm --root=code_path --no-cache" command
        $process = new Process([
            'php',
            $toolboxPath . '/psalm.phar',
            "--root={$codePath}",
            '--no-cache',
            "--report={$psalmResultPath}"
        ]);
        $process->run();
        if ($process->getExitCode() === 1) {
            echo 'There was a problem running Psalm.', PHP_EOL;
            echo $process->getErrorOutput(), PHP_EOL;

            // TODO: use constant
            return 1;
        } elseif ($process->getExitCode() === 2) { // completed successfully but found some issues
            // read analysis result
            $psalmIssues = json_decode(file_get_contents($psalmResultPath), true);

            if (empty($psalmIssues)) {
                echo 'No issues from psalm analysis result!', PHP_EOL;

                return 1;
            }

            foreach ($psalmIssues as $psalmIssue) {
                if (! IssueMapping::exists($psalmIssue['type'])) {
                    echo "{$psalmIssue['type']} is not mapped with any issue code. Skipping...", PHP_EOL;

                    continue;
                }

                $issue = IssueBuilder::message($psalmIssue['message'])
                    ->file($psalmIssue['file_name'])
                    ->code(IssueMapping::getIssueCode($psalmIssue['type']))
                    ->beginLine($psalmIssue['line_from'])
                    ->endLine($psalmIssue['line_to'])
                    ->build();

                $this->analysisResult->pushIssue($issue);
            }
        }

        // write analysis result
        if (! $this->analysisResult->write($analysisResultPath)) {
            echo 'Something went wrong while writing analysis result.', PHP_EOL;

            return 1;
        }

        return $process->getExitCode();
    }
}
