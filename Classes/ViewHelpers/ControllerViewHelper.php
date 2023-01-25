<?php

declare(strict_types=1);

namespace SvenPetersen\FluidStimulus\ViewHelpers;

class ControllerViewHelper extends AbstractStimulusViewHelper
{
    protected $escapeOutput = false;

    public function initializeArguments(): void
    {
        $this->registerArgument('name', 'string', 'Name of the controller to render', true);
        $this->registerArgument('values', 'array', 'Values for the given controller');
    }

    public function render(): string
    {
        return $this->renderStimulusController($this->arguments['name'], $this->arguments['values'])->__toString();
    }
}
