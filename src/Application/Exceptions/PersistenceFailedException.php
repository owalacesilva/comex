<?php

namespace Application\Exceptions;

use Application\Enumerations\HttpStatusCode;

class PersistenceFailedException extends DomainException
{
    public function __construct($message = 'Persistence failed')
    {
        parent::__construct(
            $message,
            HttpStatusCode::UNPROCESSABLE_ENTITY
        );
    }
}