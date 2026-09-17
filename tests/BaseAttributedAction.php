<?php

declare(strict_types=1);

namespace crojasaragonez\LightService;

use crojasaragonez\LightService\Attributes\Expects;

#[Expects('foo')]
abstract class BaseAttributedAction extends Action
{
}
