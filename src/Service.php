<?php
declare(strict_types=1);

namespace StephanSchuler\DockerComposeSchema;

class Service implements \JsonSerializable
{
    use ExposingData;

    /** @var Image */
    protected $image;
    /** @var EnvironmentVariable[] */
    protected $environment = Composition::EMPTY;
    /** @var Volume[] */
    protected $volumes = Composition::EMPTY;
    /** @var Port[] */
    protected $ports = Composition::EMPTY;
    /** @var string[] */
    protected $links = Composition::EMPTY;
    /** @var string[] */
    protected $networks = Composition::EMPTY;
    /** @var WorkingDirectory */
    protected $working_dir = Composition::EMPTY;
    /** @var Command */
    protected $command = Composition::EMPTY;
    /** @var string */
    protected $shm_size = Composition::EMPTY;
    /** @var Composition */
    private $__composition;

    public function __construct(Composition $composition)
    {
        $this->__composition = $composition;
    }

    public static function inComposition(Composition $composition): self
    {
        return new static($composition);
    }

    public function fromImage(Image $image): self
    {
        $this->image = $image;
        return $this;
    }

    public function withEnvironment(EnvironmentVariable ...$environment): self
    {
        $this->environment = $this->environment === Composition::EMPTY ? [] : $this->environment;
        $this->environment = array_merge($this->environment, $environment);
        return $this;
    }

    public function withVolume(Volume ...$volume): self
    {
        $this->volumes = $this->volumes === Composition::EMPTY ? [] : $this->volumes;
        $this->volumes = array_merge($this->volumes, $volume);
        return $this;
    }

    public function withPort(Port ...$port): self
    {
        $this->ports = $this->ports === Composition::EMPTY ? [] : $this->ports;
        $this->ports = array_merge($this->ports, $port);
        return $this;
    }

    public function withLinkedService(Service...$service): self
    {
        $this->links = $this->links === Composition::EMPTY ? [] : $this->links;
        array_walk($service, function (Service $service) {
            $this->links[] = $service->getServiceName();
        });
        $this->links = array_unique($this->links);
        sort($this->links);
        return $this;
    }

    public function withNetwork(Network ...$network): self
    {
        $this->networks = $this->networks === Composition::EMPTY ? [] : $this->networks;
        array_walk($network, function (Network $network) {
            $this->networks[] = $network->getNetworkName();
        });
        $this->networks = array_unique($this->networks);
        sort($this->networks);
        return $this;
    }

    public function withCommand(Command $command): self
    {
        $this->command = $command;
        return $this;
    }

    public function withWorkingDirectory(WorkingDirectory $workingDirectory): self
    {
        $this->working_dir = $workingDirectory;
        return $this;
    }

    public function withShmSize(string $shmSize): self
    {
        $this->shm_size = $shmSize;
        return $this;
    }

    public function getServiceName(): string
    {
        return $this->__composition->getServiceName($this);
    }
}
