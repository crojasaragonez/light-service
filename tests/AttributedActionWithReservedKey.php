<?php

declare(strict_types=1);

namespace crojasaragonez\LightService;

use crojasaragonez\LightService\Attributes\Promises;

#[Promises('skip_remaining')]
class AttributedActionWithReservedKey extends Action
{
    public function execute(): void
    {
    }
}
