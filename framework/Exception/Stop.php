<?php

namespace Framework\Exception;

/**
 * Stop Exception
 *
 * This Exception is thrown when the Framework application needs to abort
 * processing and return control flow to the outer PHP script.
 *
 * @package Framework
 * @since   1.0.0
 */
class Stop extends \Exception
{
}
