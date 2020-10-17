<?php
declare(strict_types=1);

namespace StephanSchuler\DockerComposeSchema;

final class EnvironmentVariable implements \JsonSerializable
{
    /** @var string */
    private $name;
    /** @var string|null */
    private $value;

    private function __construct(string $name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public static function named(string $name): self
    {
        return new static($name, null);
    }

    public function withValue(string $value): self
    {
        $this->value = $value;
        return $this;
    }

    public function jsonSerialize(): string
    {
        if (is_string($this->value)) {
            return $this->name . '=' . $this->value;
        }
        return $this->name;
    }
}
