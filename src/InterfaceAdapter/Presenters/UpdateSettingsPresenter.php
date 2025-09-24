<?php

namespace InterfaceAdapter\Presenters;

readonly class UpdateSettingsPresenter
{
    public function __construct(private array $settings) {}
    public function present(): array
    {
        return array_map(fn($setting) => [
            'key' => $setting->getKey(),
            'value' => $setting->getValue(),
        ], $this->settings);
    }
}