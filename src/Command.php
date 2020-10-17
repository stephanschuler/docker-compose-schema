<?php
declare(strict_types=1);

namespace StephanSchuler\DockerComposeSchema;

final class Command implements \JsonSerializable
{
    /** @var string[] */
    private $arguments;

    private function __construct(string ...$arguments)
    {
        $this->arguments = $arguments;
    }

    public static function create(string $name, string ...$additionalArguments): self
    {
        return new static(... func_get_args());
    }

    public function jsonSerialize(): array
    {
        return $this->arguments;
    }
}
