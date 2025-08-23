<?php

/**
 * Enumeration representing various HTTP status codes.
 *
 * This enumeration classifies HTTP status codes into the following categories:
 * - Successful responses (2xx)
 * - Redirection messages (3xx)
 * - Client error responses (4xx)
 * - Server error responses (5xx)
 *
 * Each case corresponds to a specific HTTP status code, along with its standard associated meaning.
 */

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
    public const OK = 200;
    public const CREATED = 201;
    public const ACCEPTED = 202;
    public const NON_AUTHORITATIVE_INFORMATION = 203;
    public const NO_CONTENT = 204;
    public const RESET_CONTENT = 205;
    public const PARTIAL_CONTENT = 206;

    // Redirection messages
    public const MULTIPLE_CHOICE = 300;
    public const MOVED_PERMANENTLY = 301;
    public const FOUND = 302;
    public const SEE_OTHER = 303;
    public const NOT_MODIFIED = 304;
    public const TEMPORARY_REDIRECT = 307;
    public const PERMANENT_REDIRECT = 308;

    // Client error responses
    public const BAD_REQUEST = 400;
    public const UNAUTHORIZED = 401;
    public const FORBIDDEN = 403;
    public const NOT_FOUND = 404;
    public const METHOD_NOT_ALLOWED = 405;
    public const NOT_ACCEPTABLE = 406;
    public const PROXY_AUTHENTICATION_REQUIRED = 407;
    public const REQUEST_TIMEOUT = 408;
    public const CONFLICT = 409;
    public const GONE = 410;
    public const LENGTH_REQUIRED = 411;
    public const PRECONDITION_FAILED = 412;
    public const PAYLOAD_TOO_LARGE = 413;
    public const URI_TOO_LONG = 414;
    public const UNSUPPORTED_MEDIA_TYPE = 415;
    public const RANGE_NOT_SATISFIABLE = 416;
    public const EXPECTATION_FAILED = 417;
    public const UNPROCESSABLE_ENTITY = 422;
    public const TOO_MANY_REQUESTS = 429;

    // Server error responses
    public const INTERNAL_SERVER_ERROR = 500;
    public const NOT_IMPLEMENTED = 501;
    public const BAD_GATEWAY = 502;
    public const SERVICE_UNAVAILABLE = 503;
    public const GATEWAY_TIMEOUT = 504;
    public const HTTP_VERSION_NOT_SUPPORTED = 505;
}