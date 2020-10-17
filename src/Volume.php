<?php
declare(strict_types=1);

namespace StephanSchuler\DockerComposeSchema;

final class Volume implements \JsonSerializable
{
    private const CACHE_FLAGS_CONSITENT = 'consistent';
    private const CACHE_FLAGS_CACHED = 'cached';
    private const CACHE_FLAGS_DELEGATED = 'delegated';

    /** @var string */
    private $source;

    /** @var string */
    private $target;

    private $cachingOption = Composition::EMPTY;

    private function __construct(string $source, string $target)
    {
        $this->source = $source;
        $this->target = $target;
    }

    public static function create(string $source, string $target): self
    {
        return new static($source, $target);
    }

    public function withConsistentCache(): self
    {
        $this->cachingOption = self::CACHE_FLAGS_CONSITENT;
        return $this;
    }

    public function withCache(): self
    {
        $this->cachingOption = self::CACHE_FLAGS_CACHED;
        return $this;
    }

    public function withDelegatedView(): self
    {
        $this->cachingOption = self::CACHE_FLAGS_DELEGATED;
        return $this;
    }

    public function jsonSerialize(): string
    {
        return $this->source . ':' . $this->target . ($this->cachingOption ? ':' . $this->cachingOption : '');
    }
}
