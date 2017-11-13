<?php

/**
 * This file is part of the Dialog package.
 *
 * For the full copzright and license information, please view the
 * LICENSE file that was distributed with this source code.
 *
 * @copyright (c) Henning Huncke - <mordilion@gmx.de>
 */

namespace Dialog;

use Psr\Log\LogLevel;
use Psr\Log\LoggerInterface;

/**
 * Dialog Error-Handler-Class.
 *
 * @author Henning Huncke <mordilion@gmx.de>
 */
class ErrorHandler
{
    /**
     * The Logger instance to use for the error handling.
     *
     * @var LoggerInterface
     */
    private $logger;

    /**
     * PHP-Error-Codes with their translation into a string.
     *
     * @var array
     */
    private $errorCodes = array(
        E_ERROR             => 'E_ERROR',
        E_WARNING           => 'E_WARNING',
        E_PARSE             => 'E_PARSE',
        E_NOTICE            => 'E_NOTICE',
        E_CORE_ERROR        => 'E_CORE_ERROR',
        E_CORE_WARNING      => 'E_CORE_WARNING',
        E_COMPILE_ERROR     => 'E_COMPILE_ERROR',
        E_COMPILE_WARNING   => 'E_COMPILE_WARNING',
        E_USER_ERROR        => 'E_USER_ERROR',
        E_USER_WARNING      => 'E_USER_WARNING',
        E_USER_NOTICE       => 'E_USER_NOTICE',
        E_STRICT            => 'E_STRICT',
        E_RECOVERABLE_ERROR => 'E_RECOVERABLE_ERROR',
        E_DEPRECATED        => 'E_DEPRECATED',
        E_USER_DEPRECATED   => 'E_USER_DEPRECATED'
    );

    /**
     * The default Error-Code to LogLevel mapping.
     *
     * @var array
     */
    private $defaultErrorMapping = array(
        E_ERROR             => LogLevel::ALERT,
        E_WARNING           => LogLevel::WARNING,
        E_PARSE             => LogLevel::ALERT,
        E_NOTICE            => LogLevel::NOTICE,
        E_CORE_ERROR        => LogLevel::ALERT,
        E_CORE_WARNING      => LogLevel::WARNING,
        E_COMPILE_ERROR     => LogLevel::ALERT,
        E_COMPILE_WARNING   => LogLevel::WARNING,
        E_USER_ERROR        => LogLevel::ERROR,
        E_USER_WARNING      => LogLevel::WARNING,
        E_USER_NOTICE       => LogLevel::NOTICE,
        E_STRICT            => LogLevel::NOTICE,
        E_RECOVERABLE_ERROR => LogLevel::ERROR,
        E_DEPRECATED        => LogLevel::NOTICE,
        E_USER_DEPRECATED   => LogLevel::NOTICE
    );

    /**
     * The Error-Code to LogLevel mapping.
     *
     * @var array
     */
    private $errorMapping = array();

    /**
     * The previouse error handler if exists.
     *
     * @var mixed
     */
    private $previouseErrorHandler;


    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public static function register(LoggerInterface $logger, $errorMapping = array(), $exceptionMapping = array(), $fatalLevel = null)
    {
        $handler = new static($logger);

        if (is_array($errorMapping)) {
            $handler->registerErrorHandler($errorMapping);
        }

        if (is_array($exceptionMapping)) {
            $handler->registerExceptionHandler($exceptionMapping);
        }
    }

    public function registerErrorHandler(array $mapping = array(), $preventPreviouse = false, $errorTypes = -1)
    {
        $this->errorMapping = array_replace($this->defaultErrorMapping, $mapping);
        $this->previouseErrorHandler = set_error_handler(array($this, 'handleError'), $errorTypes);

        if ($preventPreviouse) {
            $this->previouseErrorHandler = null;
        }

        return $this;
    }

    private function codeToString($code)
    {
        if (isset($this->errorCodes[$code])) {
            return $this->errorCodes[$code];
        }

        return 'Unknown PHP-Error';
    }
}