<?php

declare(strict_types=1);

namespace crojasaragonez\LightService;

class DuplicateKeysAction extends Action
{
    /** @var array<string> */
    public array $expects = ['foo', 'foo'];

    public function execute(): void
    {
    }
}
