<?php
declare(strict_types=1);

namespace StephanSchuler\DockerComposeSchema;

class Composition implements \JsonSerializable
{
    const EMPTY = 'c720de94-7fba-47a5-bcf4-b5967ed39ab9';

    use ExposingData;

    /** @var string */
    private $version = self::EMPTY;
    private $__services = [];
    private $__networks = [];

    public static function create(): self
    {
        return new static();
    }

    public function service(string $name, string ...$arguments): Service
    {
        $name = vsprintf($name, $arguments);
        $serviceNames = array_column($this->__services, 'name');
        if (array_key_exists($name, $serviceNames)) {
            throw new \Exception(sprintf('The service named "%s" does already exist.', $name));
        }

        $service = Service::inComposition($this);
        $id = spl_object_hash($service);
        $this->__services[$id] = [
            'name' => $name,
            'object' => $service
        ];
        return $service;
    }

    public function network(string $name): Network
    {
        $serviceNames = array_column($this->__networks, 'name');
        if (array_key_exists($name, $serviceNames)) {
            throw new \Exception(sprintf('The service named "%s" does already exist.', $name));
        }

        $network = Network::inComposition($this);
        $id = spl_object_hash($network);
        $this->__networks[$id] = [
            'name' => $name,
            'object' => $network
        ];
        return $network;
    }

    public function withVersion(string $version): self
    {
        $this->version = $version;
        return $this;
    }

    public function getServiceName(Service $service): string
    {
        return $this->__services[spl_object_hash($service)]['name'];
    }

    public function getNetworkName(Network $network): string
    {
        return $this->__networks[spl_object_hash($network)]['name'];
    }

    public function getVars()
    {
        $services = array_combine(
            array_column($this->__services, 'name'),
            array_column($this->__services, 'object')
        );
        $networks = array_combine(
            array_column($this->__networks, 'name'),
            array_column($this->__networks, 'object')
        );
        return [
            'services' => $services,
            'networks' => $networks,
        ];
    }
}
