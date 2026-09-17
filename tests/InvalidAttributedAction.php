<?php

declare(strict_types=1);

namespace crojasaragonez\LightService;

use crojasaragonez\LightService\Attributes\Promises;

#[Promises('bar')]
class InvalidAttributedAction extends Action
{
    public function execute(): void
    {
    }
}
