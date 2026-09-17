<?php

declare(strict_types=1);

namespace crojasaragonez\LightService\Attributes;

use Attribute;

/**
 * Declares the context keys an action needs before it runs.
 *
 * #[Expects('url', 'file_path')]
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
final readonly class Expects extends ContextKeys
{
}
