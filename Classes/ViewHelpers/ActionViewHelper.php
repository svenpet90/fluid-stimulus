<?php

declare(strict_types=1);

namespace SvenPetersen\FluidStimulus\ViewHelpers;

class ActionViewHelper extends AbstractStimulusViewHelper
{
    public function initializeArguments(): void
    {
        $this->registerArgument('controllerName', 'string', 'Name of the controller  to render', true);
        $this->registerArgument('actionName', 'string', 'Action name');
        $this->registerArgument('eventName', 'string', 'Event name');
        $this->registerArgument('parameters', 'array', 'Parameters', false, []);
    }

    // $controllerName, string $actionName = null, string $eventName = null, array $parameters = []
    public function render(): string
    {
        return $this->renderStimulusAction(
            $this->arguments['controllerName'],
            $this->arguments['actionName'],
            $this->arguments['eventName'],
            $this->arguments['parameters']
        )->__toString();
    }
}
