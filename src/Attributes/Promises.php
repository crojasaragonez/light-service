<?php

declare(strict_types=1);

namespace crojasaragonez\LightService\Attributes;

use Attribute;

/**
 * Declares the context keys an action leaves behind once it ran.
 *
 * #[Promises('zip_path')]
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
final readonly class Promises extends ContextKeys
{
}
