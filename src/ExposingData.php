<?php
declare(strict_types=1);

namespace StephanSchuler\DockerComposeSchema;

trait ExposingData
{
    public function jsonSerialize(): array
    {
        $vars = get_object_vars($this);

        $vars = array_filter($vars, function ($key) {
            return strpos((string)$key, '__') !== 0;
        }, ARRAY_FILTER_USE_KEY);
        $vars = array_filter($vars, function ($value) {
            return $value !== Composition::EMPTY;
        });

        if (is_callable([$this, 'getVars'])) {
            $vars = array_merge($vars, $this->getVars());
        }

        return $vars;
    }
}
