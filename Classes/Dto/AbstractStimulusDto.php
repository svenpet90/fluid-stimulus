<?php

declare(strict_types=1);

namespace SvenPetersen\FluidStimulus\Dto;

abstract class AbstractStimulusDto implements \Stringable
{
    abstract public function toArray(): array;

    protected function getFormattedControllerName(string $controllerName): string
    {
        return $this->escapeAsHtmlAttr($this->normalizeControllerName($controllerName));
    }

    protected function getFormattedValue($value)
    {
        if ($value instanceof \Stringable || (\is_object($value) && \is_callable([$value, '__toString']))) {
            $value = (string)$value;
        } elseif (!\is_scalar($value)) {
            $value = json_encode($value);
        } elseif (\is_bool($value)) {
            $value = $value ? 'true' : 'false';
        }

        return (string)$value;
    }

    protected function escapeAsHtmlAttr($value): string
    {
        return htmlspecialchars($value, ENT_QUOTES);
    }

    /**
     * Normalize a Stimulus controller name into its HTML equivalent (no special character and / becomes --).
     *
     * @see https://stimulus.hotwired.dev/reference/controllers
     */
    private function normalizeControllerName(string $controllerName): string
    {
        return preg_replace('/^@/', '', str_replace('_', '-', str_replace('/', '--', $controllerName)));
    }
}
