<?php

namespace Core;

use App\Config;

/**
 * Class Error
 * @package Core
 */
class Error
{
    /**
     * Error handler. Convert all errors to Exceptions by throwing an ErrorException.
     *
     * @param int $level  Error level
     * @param string $message  Error message
     * @param string $file  Filename the error was raised in
     * @param int $line  Line number in the file
     * @throws \ErrorException
     */
    public static function errorHandler($level, $message, $file, $line)
    {
        if (error_reporting() !== 0) {  // to keep the @ operator working
            throw new \ErrorException($message, 0, $level, $file, $line);
        }
    }

    /**
     * Exception handler.
     *
     * @param \Exception $exception The exception
     */
    public static function exceptionHandler($exception)
    {
        // Code is 404 (not found) or 500 (general error)
        $code = $exception->getCode();
        if ($code != 404) {
            $code = 500;
        }
        http_response_code($code);

        $exceptionClass = get_class($exception);
        if (Config::SHOW_ERRORS) {
            echo <<<EOF
                <h1>Fatal error</h1>
                <p>Uncaught exception: '$exceptionClass'</p>
                <p>Message: '{$exception->getMessage()}'</p>
                <p>Stack trace:<pre>{$exception->getTraceAsString()}</pre></p>
                <p>Thrown in '{$exception->getFile()}' on line {$exception->getLine()}</p>
EOF;
        } else {
            $log = dirname(__DIR__) . '/logs/' . date('Y-m-d') . '.log';

            ini_set('error_log', $log);

            $message = <<<EOF
                Uncaught exception: '$exceptionClass' with message '{$exception->getMessage()}'";
                Stack trace: {$exception->getTraceAsString()}
                Thrown in ' {$exception->getFile()}' on line {$exception->getLine()}
EOF;
            error_log($message);

            View::renderTemplate("$code.html");
        }
    }
}
