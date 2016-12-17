<?php

namespace Framework\Exception;

/**
 * Pass Exception
 *
 * This Exception will cause the Router::dispatch method
 * to skip the current matching route and continue to the next
 * matching route. If no subsequent routes are found, a
 * HTTP 404 Not Found response will be sent to the client.
 *
 * @package Framework
 * @since   1.0.0
 */
class Pass extends \Exception
{
}
