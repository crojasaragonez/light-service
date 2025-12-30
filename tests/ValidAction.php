<?php

declare(strict_types=1);

namespace crojasaragonez\LightService;

class ValidAction extends Action
{
    /** @var array<string> */
    public array $expects = ['foo'];

    /** @var array<string> */
    public array $promises = ['bar'];

    public function execute(): void
    {
        $this->context['bar'] = 1;
    }
}
