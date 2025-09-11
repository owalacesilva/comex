<?php

namespace Application\Exceptions;

use Application\Enumerations\HttpStatusCode;
use Exception;

/**
 * Represents an exception that occurs within the domain layer of an application.
 * This class serves as a specific type of exception for handling domain-related errors.
 */
abstract class DomainException extends Exception
{
    /** The error message */
    protected $message = "Domain error";

    /** The error code */
    protected $code = HttpStatusCode::INTERNAL_SERVER_ERROR;
}