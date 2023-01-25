<?php

declare(strict_types=1);

namespace SvenPetersen\FluidStimulus\ViewHelpers;

class TargetViewHelper extends AbstractStimulusViewHelper
{
    protected $escapeOutput = false;

    public function initializeArguments(): void
    {
        $this->registerArgument('controller', 'string', 'Name of the controller this target belongs to', true);
        $this->registerArgument('name', 'string', 'Target name', true);
    }

    public function render(): string
    {
        return $this->renderStimulusTarget($this->arguments['controller'], $this->arguments['name'])->__toString();
    }
}
