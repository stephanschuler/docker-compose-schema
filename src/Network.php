<?php
declare(strict_types=1);

namespace StephanSchuler\DockerComposeSchema;

final class Network implements \JsonSerializable
{
    use ExposingData;

    /** @var Composition */
    private $__composition;

    /** @var Ipam */
    private $ipam = Composition::EMPTY;

    private function __construct(Composition $composition)
    {
        $this->__composition = $composition;
    }

    public static function inComposition(Composition $composition): self
    {
        return new static($composition);
    }

    public function withIpam(Ipam $ipam): self
    {
        $this->ipam = $ipam;
        return $this;
    }

    public function getNetworkName(): string
    {
        return $this->__composition->getNetworkName($this);
    }
}
