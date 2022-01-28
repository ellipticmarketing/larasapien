<?php

namespace EllipticMarketing\Larasapien\Checkers;

use Illuminate\Support\Str;
use EllipticMarketing\Larasapien\Contracts\CheckerContract;
use Carbon\Carbon;

class GitChecker implements CheckerContract
{
    /**
     * Git repository path, could not be relative.
     *
     * @var string
     */
    protected $repository_path;

    public function __construct($repository_path = null)
    {
        if (is_null($repository_path)) {
            $this->repository_path = base_path('.git');
        }
    }

    /**
     * Return data about last commit.
     *
     * @return array
     */
    public function run(): array
    {
        if (! file_exists($this->repository_path)) {
            return [ 'git' => false ];
        }

        $current_branch = $this->currentBranch();

        return [
            'git' => [
                'enabled' => true,
                'branch' => $current_branch,
                'last_commit' =>$this->lastCommit($current_branch)
            ]
        ];
    }

    protected function currentBranch(): string
    {
        $branch_path = Str::of($this->getFileContents('HEAD'))
                          ->split('/[\s]+/')->last(function ($value) { return ! empty($value); });

        return Str::of($branch_path)->replace('refs/heads/', '');
    }

    protected function lastCommit($log_path)
    {
        if (! file_exists("{$this->repository_path}/logs/refs/heads/$log_path")) {
            return null;
        }

        $file = fopen("{$this->repository_path}/logs/refs/heads/$log_path", 'r');
        $position = -1;
        $line = '';

        while (-1 !== fseek($file, $position, SEEK_END)) {
            $char = fgetc($file);

            if (PHP_EOL == $char || feof($file)) {
                $commit = $this->parseCommitLine($line);
                if ($commit) return $commit;

                $line = '';
            } else {
                $line = $char . $line;
            }

            $position--;
        }

        // Check line content if exit from while loop prematurely
        $commit = $this->parseCommitLine($line);
        if ($commit) return $commit;

        return null;
    }

    /**
     * Parse commit line from refs/head.
     *
     * @return array|null
     */
    protected function parseCommitLine(string $line)
    {
        preg_match(
            '/^(?:[^\s]+)\ (?<hash>[^\s]+)\ (?:.+)\ (?<time>\d+\ [+|-]\d+)\t(?<message>.+)$/m',
            $line,
            $results
        );

        if (! empty($results)) {
            $message_segments = Str::of($results['message'])->split('/:+/', 2);

            if (Str::of($message_segments->first())->contains('commit')) {
                $date = Carbon::createFromTimestamp(
                    ...Str::of($results['time'])->split('/\s+/')
                );

                return [
                    'hash' => $results['hash'],
                    'date' => $date->toIso8601String(),
                    'message' => trim($message_segments->last())
                ];
            }
        }

        return null;
    }

    /**
     * Returns file content using as prefix the repository path.
     *
     * @return string
     */
    protected function getFileContents($path): string
    {
        return file_get_contents("{$this->repository_path}/$path");
    }
}
