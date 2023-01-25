<?php

declare(strict_types=1);

namespace SvenPetersen\FluidStimulus\Dto;

class StimulusControllersDto extends AbstractStimulusDto
{
    private $controllers = [];
    private $values = [];
    private $classes = [];

    public function addController(string $controllerName, array $controllerValues = [], array $controllerClasses = []): void
    {
        $controllerName = $this->getFormattedControllerName($controllerName);

        $this->controllers[] = $controllerName;

        foreach ($controllerValues as $key => $value) {
            if (null === $value) {
                continue;
            }

            $key = $this->escapeAsHtmlAttr($this->normalizeKeyName($key));
            $value = $this->getFormattedValue($value);

            $this->values['data-'.$controllerName.'-'.$key.'-value'] = $value;
        }

        foreach ($controllerClasses as $key => $class) {
            $key = $this->escapeAsHtmlAttr($this->normalizeKeyName($key));

            $this->values['data-'.$controllerName.'-'.$key.'-class'] = $class;
        }
    }

    public function __toString(): string
    {
        if (0 === \count($this->controllers)) {
            return '';
        }

        return rtrim(
            'data-controller="'.implode(' ', $this->controllers).'" '.
            implode(' ', array_map(function (string $attribute, string $value): string {
                return $attribute.'="'.$this->escapeAsHtmlAttr($value).'"';
            }, array_keys($this->values), $this->values)).' '.
            implode(' ', array_map(function (string $attribute, string $value): string {
                return $attribute.'="'.$this->escapeAsHtmlAttr($value).'"';
            }, array_keys($this->classes), $this->classes))
        );
    }

    public function toArray(): array
    {
        if (0 === \count($this->controllers)) {
            return [];
        }

        return [
                'data-controller' => implode(' ', $this->controllers),
            ] + $this->values + $this->classes;
    }

    private function normalizeKeyName(string $str): string
    {
        // Adapted from ByteString::camel
        $str = ucfirst(str_replace(' ', '', ucwords(preg_replace('/[^a-zA-Z0-9\x7f-\xff]++/', ' ', $str))));

        // Adapted from ByteString::snake
        return strtolower(preg_replace(['/([A-Z]+)([A-Z][a-z])/', '/([a-z\d])([A-Z])/'], '\1-\2', $str));
    }
}
