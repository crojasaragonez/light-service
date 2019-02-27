<?php

declare(strict_types=1);

namespace crojasaragonez\LightService;

use Exception;

class PostProcessor
{
    private $organizer;
    private $action;
    public function __construct(Organizer $organizer, Action $action)
    {
        $this->organizer = $organizer;
        $this->action    = $action;
    }

    public static function validate(Organizer $organizer, Action $action)
    {
        $instance = new self($organizer, $action);
        $instance->checkPromises();
    }

    private function checkPromises()
    {
        foreach ($this->action->promises as $key) {
            if (!isset($this->organizer->context[$key])) {
                throw new Exception("promised '$key' to be in the context during " . get_class($this->action), 1);
            }
        }
    }
}
