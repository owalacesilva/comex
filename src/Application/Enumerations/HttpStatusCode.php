<?php

namespace Application\Enumerations;

/**
 * Represents HTTP status codes defined by the Internet Assigned Numbers Authority (IANA).
 *
 * These codes are grouped into categories based on the type of response:
 *
 * - Successful responses (2xx): Indicates that the request was successfully received,
 *   understood, and accepted.
 * - Redirection messages (3xx): Indicates that further action needs to be taken
 *   in order to complete the request.
 * - Client error responses (4xx): Indicates that there was an error in the request
 *   sent by the client.
 * - Server error responses (5xx): Indicates that the server failed to fulfill
 *   a valid request.
 */
final class HttpStatusCode
{
    // Successful responses
    public const int OK = 200;
    public const int CREATED = 201;
    public const int ACCEPTED = 202;
    public const int NON_AUTHORITATIVE_INFORMATION = 203;
    public const int NO_CONTENT = 204;
    public const int RESET_CONTENT = 205;
    public const int PARTIAL_CONTENT = 206;

    // Redirection messages
    public const int MULTIPLE_CHOICE = 300;
    public const int MOVED_PERMANENTLY = 301;
    public const int FOUND = 302;
    public const int SEE_OTHER = 303;
    public const int NOT_MODIFIED = 304;
    public const int TEMPORARY_REDIRECT = 307;
    public const int PERMANENT_REDIRECT = 308;

    // Client error responses
    public const int BAD_REQUEST = 400;
    public const int UNAUTHORIZED = 401;
    public const int FORBIDDEN = 403;
    public const int NOT_FOUND = 404;
    public const int METHOD_NOT_ALLOWED = 405;
    public const int NOT_ACCEPTABLE = 406;
    public const int PROXY_AUTHENTICATION_REQUIRED = 407;
    public const int REQUEST_TIMEOUT = 408;
    public const int CONFLICT = 409;
    public const int GONE = 410;
    public const int LENGTH_REQUIRED = 411;
    public const int PRECONDITION_FAILED = 412;
    public const int PAYLOAD_TOO_LARGE = 413;
    public const int URI_TOO_LONG = 414;
    public const int UNSUPPORTED_MEDIA_TYPE = 415;
    public const int RANGE_NOT_SATISFIABLE = 416;
    public const int EXPECTATION_FAILED = 417;
    public const int UNPROCESSABLE_ENTITY = 422;
    public const int TOO_MANY_REQUESTS = 429;

    // Server error responses
    public const int INTERNAL_SERVER_ERROR = 500;
    public const int NOT_IMPLEMENTED = 501;
    public const int BAD_GATEWAY = 502;
    public const int SERVICE_UNAVAILABLE = 503;
    public const int GATEWAY_TIMEOUT = 504;
    public const int HTTP_VERSION_NOT_SUPPORTED = 505;

    /**
     * Private constructor class
     */
    private function __construct() {}

    /**
     * Checks if the given status code is valid based on a predefined set of codes.
     *
     * @param int $statusCode The HTTP status code to check.
     * @return bool Returns true if the status code is in the predefined set, false otherwise.
     */
    public static function check(int $statusCode): bool
    {
        return in_array($statusCode, [
            self::OK,
            self::CREATED,
            self::ACCEPTED,
            self::NON_AUTHORITATIVE_INFORMATION,
            self::NO_CONTENT,
            self::RESET_CONTENT,
            self::PARTIAL_CONTENT,
            self::MULTIPLE_CHOICE,
            self::MOVED_PERMANENTLY,
            self::FOUND,
            self::SEE_OTHER,
            self::NOT_MODIFIED,
            self::TEMPORARY_REDIRECT,
            self::PERMANENT_REDIRECT,
            self::BAD_REQUEST,
            self::UNAUTHORIZED,
            self::FORBIDDEN,
            self::NOT_FOUND,
            self::METHOD_NOT_ALLOWED,
            self::NOT_ACCEPTABLE,
            self::PROXY_AUTHENTICATION_REQUIRED,
            self::REQUEST_TIMEOUT,
            self::CONFLICT,
            self::GONE,
            self::LENGTH_REQUIRED,
            self::PRECONDITION_FAILED,
            self::PAYLOAD_TOO_LARGE,
            self::URI_TOO_LONG,
            self::UNSUPPORTED_MEDIA_TYPE,
            self::RANGE_NOT_SATISFIABLE,
            self::EXPECTATION_FAILED,
            self::UNPROCESSABLE_ENTITY,
            self::TOO_MANY_REQUESTS,
            self::INTERNAL_SERVER_ERROR,
            self::NOT_IMPLEMENTED,
            self::BAD_GATEWAY,
            self::SERVICE_UNAVAILABLE,
            self::GATEWAY_TIMEOUT,
            self::HTTP_VERSION_NOT_SUPPORTED
        ]);
    }
}