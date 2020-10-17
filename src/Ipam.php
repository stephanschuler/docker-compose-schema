<?php
declare(strict_types=1);

namespace StephanSchuler\DockerComposeSchema;

final class Ipam implements \JsonSerializable
{
    use ExposingData;

    protected $__subnets = [];

    public static function create(): self
    {
        return new static();
    }

    public function withSubnet(string $subnet): self
    {
        $this->__subnets[] = $subnet;
        return $this;
    }

    public function getVars()
    {
        $vars = [
            'config' => []
        ];
        foreach ($this->__subnets as $subnet) {
            $vars['config'][] = ['subnet' => $subnet];
        }
        return $vars;
    }
}
