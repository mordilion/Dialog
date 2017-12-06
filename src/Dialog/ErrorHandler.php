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

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

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
     * The default Exception-Class to LogLevel mapping.
     *
     * @var array
     */
    private $defaultExceptionMapping = array(
        'ParseError' => LogLevel::CRITICAL,
        'Throwable'  => LogLevel::ERROR,
    );

    /**
     * The Error-Code to LogLevel mapping.
     *
     * @var array
     */
    private $errorMapping = array();

    /**
     * The Exception-Code to LogLevel mapping.
     *
     * @var array
     */
    private $exceptionMapping = array();

    /**
     * The previouse error handler if exists.
     *
     * @var mixed
     */
    private $previouseErrorHandler;

    /**
     * The previouse exception handler if exists.
     *
     * @var mixed
     */
    private $previouseExceptionHandler;


    /**
     * Constructor.
     *
     * @param LoggerInterface $logger
     *
     * @return void
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Static method to register Eroor- and Exception-Handling.
     *
     * @param LoggerInterface $logger
     * @param array|false $errorMapping
     * @param array|false $exceptionMapping
     *
     * @return void
     */
    public static function register(LoggerInterface $logger, $errorMapping = array(), $exceptionMapping = array())
    {
        $handler = new static($logger);

        if (is_array($errorMapping)) {
            $handler->registerErrorHandler($errorMapping);
        }

        if (is_array($exceptionMapping)) {
            $handler->registerExceptionHandler($exceptionMapping);
        }
    }

    /**
     * Method for Error-Handling.
     *
     * @param integer $code
     * @param string $message
     * @param string $file
     * @param integer $line
     * @param array $context
     *
     * @return mixed
     */
    public function handleError($code, $message, $file = '', $line = 0, $context = array())
    {
        $level = isset($this->errorMapping[$code]) ? $this->errorMapping[$code] : LogLevel::CRITICAL;

        $this->logger->log($level, $this->codeToString($code) . ': ' . $message, array('code' => $code, 'message' => $message, 'file' => $file, 'line' => $line));

        if ($this->previouseErrorHandler !== null) {
            return call_user_func($this->previouseErrorHandler, $code, $message, $file, $line, $context);
        }
    }

    /**
     * Method for Exception-Handling.
     *
     * @param Exception $ex
     *
     * @return void
     */
    public function handleException($ex)
    {
        $level = LogLevel::ERROR;

        foreach ($this->exceptionMapping as $class => $logLevel) {
            if ($ex instanceof $class) {
                $level = $logLevel;
                break;
            }
        }

        $class   = get_class($ex);
        $code    = $ex->getCode();
        $message = $ex->getMessage();
        $file    = $ex->getFile();
        $line    = $ex->getLine();

        $this->logger->log($level, 'Uncaught Exception "' . $class . '" with message "' . $message . '" in ' . $file . ':' . $line);

        if ($this->previouseExceptionHandler !== null) {
            call_user_func($this->previouseExceptionHandler, $ex);
        }

        //exit(255);
    }

    /**
     * Method to register the Error-Handling.
     *
     * @param array $mapping
     * @param boolean $preventPreviouse
     * @param integer $errorTypes
     *
     * @return ErrorHandler
     */
    public function registerErrorHandler(array $mapping = array(), $preventPreviouse = false, $errorTypes = -1)
    {
        $this->errorMapping          = array_replace($this->defaultErrorMapping, $mapping);
        $this->previouseErrorHandler = set_error_handler(array($this, 'handleError'), $errorTypes);

        if ($preventPreviouse) {
            $this->previouseErrorHandler = null;
        }

        return $this;
    }

    /**
     * Method to register the Exception-Handling.
     *
     * @param array $mapping
     * @param boolean $preventPreviouse
     *
     * @return ErrorHandler
     */
    public function registerExceptionHandler(array $mapping = array(), $preventPreviouse = false)
    {
        $this->exceptionMapping          = array_merge($this->defaultExceptionMapping, $mapping);
        $this->previouseExceptionHandler = set_exception_handler(array($this, 'handleException'));

        if ($preventPreviouse) {
            $this->previouseExceptionHandler = null;
        }

        return $this;
    }

    /**
     * Returns the string for the provided Error-Code.
     *
     * @param integer $code
     *
     * @return string
     */
    private function codeToString($code)
    {
        if (isset($this->errorCodes[$code])) {
            return $this->errorCodes[$code];
        }

        return 'Unknown PHP-Error';
    }
}