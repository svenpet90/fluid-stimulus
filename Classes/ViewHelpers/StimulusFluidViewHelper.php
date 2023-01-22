<?php

namespace DSKZPT\WebpackEncoreTYPO3Bridge\ViewHelpers;

use DSKZPT\WebpackEncoreTYPO3Bridge\Dto\StimulusControllersDto;
use DSKZPT\WebpackEncoreTYPO3Bridge\Dto\StimulusActionsDto;
use DSKZPT\WebpackEncoreTYPO3Bridge\Dto\StimulusTargetsDto;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class StimulusFluidViewHelper extends AbstractViewHelper
{
    /**
     * @param string $controllerName the Stimulus controller name
     * @param array $controllerValues array of controller values
     * @param array $controllerClasses array of controller CSS classes
     */
    public function renderStimulusController(string $controllerName, array $controllerValues = [], array $controllerClasses = []): StimulusControllersDto
    {
        $dto = new StimulusControllersDto();

        if (\is_array($controllerName)) {
            trigger_deprecation('symfony/webpack-encore-bundle', 'v1.15.0', 'Passing an array as first argument of stimulus_controller() is deprecated.');

            if ($controllerValues || $controllerClasses) {
                throw new \InvalidArgumentException('You cannot pass an array to the first and second/third argument of stimulus_controller(): check the documentation.');
            }

            $data = $controllerName;

            foreach ($data as $controllerName => $controllerValues) {
                $dto->addController($controllerName, $controllerValues);
            }

            return $dto;
        }

        $dto->addController($controllerName, $controllerValues, $controllerClasses);

        return $dto;
    }

    /**
     * @param array $parameters Parameters to pass to the action. Optional.
     */
    public function renderStimulusAction($controllerName, string $actionName = null, string $eventName = null, array $parameters = []): StimulusActionsDto
    {
        $dto = new StimulusActionsDto();
        if (\is_array($controllerName)) {
            trigger_deprecation('symfony/webpack-encore-bundle', 'v1.15.0', 'Passing an array as first argument of stimulus_action() is deprecated.');

            if ($actionName || $eventName || $parameters) {
                throw new \InvalidArgumentException('You cannot pass a string to the second or third argument nor an array to the fourth argument while passing an array to the first argument of stimulus_action(): check the documentation.');
            }

            $data = $controllerName;

            foreach ($data as $controllerName => $controllerActions) {
                if (\is_string($controllerActions)) {
                    $controllerActions = [[$controllerActions]];
                }

                foreach ($controllerActions as $possibleEventName => $controllerAction) {
                    if (\is_string($possibleEventName) && \is_string($controllerAction)) {
                        $controllerAction = [$possibleEventName => $controllerAction];
                    } elseif (\is_string($controllerAction)) {
                        $controllerAction = [$controllerAction];
                    }

                    foreach ($controllerAction as $eventName => $actionName) {
                        $dto->addAction($controllerName, $actionName, \is_string($eventName) ? $eventName : null);
                    }
                }
            }

            return $dto;
        }

        $dto->addAction($controllerName, $actionName, $eventName, $parameters);

        return $dto;
    }

    public function appendStimulusController(StimulusControllersDto $dto, string $controllerName, array $controllerValues = [], array $controllerClasses = []): StimulusControllersDto
    {
        $dto->addController($controllerName, $controllerValues, $controllerClasses);

        return $dto;
    }

    /**
     * @param array $parameters Parameters to pass to the action. Optional.
     */
    public function appendStimulusAction(StimulusActionsDto $dto, string $controllerName, string $actionName, string $eventName = null, array $parameters = []): StimulusActionsDto
    {
        $dto->addAction($controllerName, $actionName, $eventName, $parameters);

        return $dto;
    }

    /**
     * @param string $controllerName the Stimulus controller name
     * @param string|null $targetNames The space-separated list of target names if a string is passed to the 1st argument. Optional.
     */
    public function renderStimulusTarget($controllerName, string $targetNames = null): StimulusTargetsDto
    {
        $dto = new StimulusTargetsDto();
        if (\is_array($controllerName)) {
            trigger_deprecation('symfony/webpack-encore-bundle', 'v1.15.0', 'Passing an array as first argument of stimulus_target() is deprecated.');

            if ($targetNames) {
                throw new \InvalidArgumentException('You cannot pass a string to the second argument while passing an array to the first argument of stimulus_target(): check the documentation.');
            }

            $data = $controllerName;

            foreach ($data as $controllerName => $targetNames) {
                $dto->addTarget($controllerName, $targetNames);
            }

            return $dto;
        }

        $dto->addTarget($controllerName, $targetNames);

        return $dto;
    }

    /**
     * @param string $controllerName the Stimulus controller name
     * @param string|null $targetNames The space-separated list of target names if a string is passed to the 1st argument. Optional.
     */
    public function appendStimulusTarget(StimulusTargetsDto $dto, string $controllerName, string $targetNames = null): StimulusTargetsDto
    {
        $dto->addTarget($controllerName, $targetNames);

        return $dto;
    }
}
