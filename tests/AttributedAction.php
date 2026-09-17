<?php

declare(strict_types=1);

namespace crojasaragonez\LightService;

use crojasaragonez\LightService\Attributes\Expects;
use crojasaragonez\LightService\Attributes\Promises;

#[Expects('foo')]
#[Promises('bar')]
class AttributedAction extends Action
{
    public function execute(): void
    {
        $this->context['bar'] = 1;
    }
}
