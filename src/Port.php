<?php
declare(strict_types=1);

namespace StephanSchuler\DockerComposeSchema;

final class Port implements \JsonSerializable
{
    /** @var int */
    private $containerPort;
    /** @var int */
    private $hostPort;

    private function __construct(int $containerPort, int $hostPort)
    {
        $this->containerPort = $containerPort;
        $this->hostPort = $hostPort;
    }

    public static function create(int $port): self
    {
        return new static($port, $port);
    }

    public function redirectedTo(int $hostPort): self
    {
        $this->hostPort = $hostPort;
        return $this;
    }

    public function jsonSerialize(): string
    {
        return sprintf('%d:%d', $this->hostPort, $this->containerPort);
    }
}
