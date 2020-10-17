<?php
declare(strict_types=1);

namespace StephanSchuler\DockerComposeSchema;

final class WorkingDirectory implements \JsonSerializable
{
    /** @var string */
    private $name;

    private function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function create(string $name): self
    {
        return new static($name);
    }

    public function jsonSerialize(): string
    {
        return $this->name;
    }
}
