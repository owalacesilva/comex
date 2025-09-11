<?php

namespace Application\Helpers;

use Application\Enumerations\HttpStatusCode;
use InvalidArgumentException;
use Stringable;

/**
 * Class Result
 *
 * Represents a result object that can contain data, error messages and HTTP status codes.
 * Used to standardize API responses across the application.
 */
readonly class Result implements Stringable
{
    /**
     * Private constructor to create a new Result instance.
     * Use the static factory methods to create instances.
     *
     * @param mixed $data The result data
     * @param int $httpStatusCode HTTP status code
     * @param string|null $errorMessage Optional error message
     * @param string|null $errorCode Optional error code
     */
    private function __construct(
        private mixed   $data,
        private int     $httpStatusCode,
        private ?string $errorMessage = null,
        private ?string $errorCode = null
    )
    {
        if (!HttpStatusCode::check($httpStatusCode)) {
            throw new InvalidArgumentException("Invalid HTTP status code: {$httpStatusCode}");
        }
    }

    /**
     * Gets the result data
     */
    public function getData(): mixed
    {
        return $this->data;
    }

    /**
     * Gets the HTTP status code
     */
    public function getHttpStatusCode(): int
    {
        return $this->httpStatusCode;
    }

    /**
     * Gets the error message
     */
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    /**
     * Gets the error code
     */
    public function getErrorCode(): string
    {
        return $this->errorCode;
    }

    /**
     * Checks if the result represents a successful operation
     */
    public function isSuccess(): bool
    {
        return $this->httpStatusCode >= 200 && $this->httpStatusCode < 300;
    }

    /**
     * Checks if the result represents a failed operation
     */
    public function isFail(): bool
    {
        return !$this->isSuccess();
    }

    /**
     * Converts the result to a JSON string representation
     */
    public function __toString(): string
    {
        $data = is_object($this->data) && method_exists($this->data, '__toString') ? (string)$this->data : $this->data;
        return sprintf(
            '{"data":%s,"message":"%s","errorCode":"%s","httpStatusCode":"%s"}',
            $data === null ? 'null' : (is_string($data) ? '"' . $data . '"' : $data),
            $this->errorMessage,
            $this->errorCode,
            $this->httpStatusCode
        );
    }

    /**
     * Creates a failure result with error details
     */
    public static function fail(string $errorMessage, string $errorCode, ?int $statusCode = HttpStatusCode::INTERNAL_SERVER_ERROR): Result
    {
        return new self(null, $statusCode, $errorMessage, $errorCode);
    }

    /**
     * Creates a success result with custom status code
     */
    public static function success(mixed $data, int $statusCode): Result
    {
        return new self($data, $statusCode);
    }

    /**
     * Creates a success result with HTTP 201 Created status
     */
    public static function created(mixed $data): Result
    {
        return new self($data, HttpStatusCode::CREATED);
    }

    /**
     * Creates a success result with HTTP 200 OK status
     */
    public static function ok(mixed $data): Result
    {
        return new self($data, HttpStatusCode::OK);
    }
}