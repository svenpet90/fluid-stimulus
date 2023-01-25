<?php

declare(strict_types=1);

namespace SvenPetersen\FluidStimulus\Dto;

final class StimulusActionsDto extends AbstractStimulusDto
{
    private $actions = [];
    private $parameters = [];

    /**
     * @param array $parameters Parameters to pass to the action. Optional.
     */
    public function addAction(string $controllerName, string $actionName, string $eventName = null, array $parameters = []): void
    {
        $controllerName = $this->getFormattedControllerName($controllerName);
        $action = $controllerName.'#'.$this->escapeAsHtmlAttr($actionName);

        if (null !== $eventName) {
            $action = $eventName.'->'.$action;
        }

        $this->actions[] = $action;

        foreach ($parameters as $name => $value) {
            $this->parameters['data-'.$controllerName.'-'.$name.'-param'] = $this->getFormattedValue($value);
        }
    }

    public function __toString(): string
    {
        if (0 === \count($this->actions)) {
            return '';
        }

        return rtrim('data-action="'.implode(' ', $this->actions).'" '.implode(' ', array_map(function (string $attribute, string $value): string {
            return $attribute.'="'.$this->escapeAsHtmlAttr($value).'"';
        }, array_keys($this->parameters), $this->parameters)));
    }

    public function toArray(): array
    {
        return ['data-action' => implode(' ', $this->actions)] + $this->parameters;
    }
}
