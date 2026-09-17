<?php

declare(strict_types=1);

namespace crojasaragonez\LightService;

use crojasaragonez\LightService\Attributes\Expects;
use crojasaragonez\LightService\Attributes\Promises;

#[Expects('foo')]
#[Promises('bar')]
class CombinedAction extends Action
{
    /** @var array<string> */
    public array $expects = ['foo', 'baz'];

    /** @var array<string> */
    public array $promises = ['qux'];

    public function execute(): void
    {
        $this->context['bar'] = 1;
        $this->context['qux'] = 1;
    }
}
