<?php

namespace route1rodent\SwordShieldData;

abstract class Parser
{
    public const SRC_DIR = __DIR__ . '/../data/raw';
    public const DEST_DIR = __DIR__ . '/../data/json';

    /**
     * @var string
     */
    private $sourceFile;

    /**
     * @var resource
     */
    private $sourceFileHandle;

    /**
     * @var string
     */
    private $destinationFile;

    public function __construct(string $srcFileName, string $destFileName)
    {
        $this->sourceFile = self::SRC_DIR . DIRECTORY_SEPARATOR . ltrim($srcFileName, DIRECTORY_SEPARATOR);
        $this->destinationFile = self::DEST_DIR . DIRECTORY_SEPARATOR . ltrim($destFileName, DIRECTORY_SEPARATOR);
    }

    public function __destruct()
    {
        if ($this->sourceFileHandle) {
            fclose($this->sourceFileHandle);
        }
    }

    abstract protected function parseBlock(?array $block): ?array;

    public function __invoke(): \Generator
    {
        $block = $this->readBlock();

        if ($block === null) {
            yield from [];
            return;
        }

        while ($block !== null) {
            yield $this->parseBlock($block);
            $block = $this->readBlock();
        }
    }

    public function export()
    {
        file_put_contents($this->destinationFile, '[' . PHP_EOL);

        foreach ($this->__invoke() as $item) {
            $json = json_encode($item) . ',' . PHP_EOL;

            file_put_contents($this->destinationFile, $json, FILE_APPEND);
        }

        file_put_contents($this->destinationFile, '{}]' . PHP_EOL, FILE_APPEND);
    }

    protected function readLine(): ?string
    {
        if ($this->sourceFileHandle === false) {
            return null;
        }

        if (!$this->sourceFileHandle) {
            $this->sourceFileHandle = fopen($this->sourceFile, "r");

            if (!$this->sourceFileHandle) {
                throw new \RuntimeException("Cannot open file {$this->sourceFile}");
            }
        }

        $line = fgets($this->sourceFileHandle);
        if ($line === false) {
            fclose($this->sourceFileHandle);
            $this->sourceFileHandle = false;
            return null;
        }

        return trim($line);
    }

    protected function readBlock(): ?array
    {
        $delimiter = '======';
        $block = [];

        $line = $this->readLine();

        if ($line === null) {
            return null;
        }

        if ($line != $delimiter) {
            throw new ParseException("Unexpected line: '{$line}'");
        }

        $delimiterCount = 1;

        while ($line !== null) {
            if (!in_array($line, [$delimiter, PHP_EOL, null, ''], true)) {
                $block[] = $line;
            }
            $prevPos = ftell($this->sourceFileHandle);
            $line = $this->readLine();
            if ($line === $delimiter) {
                if ($delimiterCount == 2) {
                    $line = null;
                    fseek($this->sourceFileHandle, $prevPos);
                    break;
                }
                $delimiterCount++;
            }
        }

        return $block;
    }
}