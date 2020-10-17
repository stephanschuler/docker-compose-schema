<?php
declare(strict_types=1);

namespace StephanSchuler\DockerComposeSchema;

class Image implements \JsonSerializable
{
    const LATEST = 'latest';

    /** @var string */
    private $vendor;
    /** @var string */
    private $image;
    /** @var ?string */
    private $version;

    private function __construct(string $vendor, string $image)
    {
        $this->vendor = $vendor;
        $this->image = $image;
    }

    public static function create(string $vendor, string $image): self
    {
        return new static($vendor, $image);
    }

    public function withVersion(string $version): self
    {
        $this->version = $version;
        return $this;
    }

    public function jsonSerialize(): string
    {
        return $this->vendor . '/' . $this->image . ($this->version ? ':' . $this->version : '');
    }
}
