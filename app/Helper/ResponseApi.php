<?php

namespace App\Helper;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class ResponseApi
 * Handles API response formatting with standardized status codes and messages
 */
class ResponseApi
{
    /**
     * @var array Holds the response data
     */
    private $data = [];

    /**
     * Constructor
     * @param array $args Initial response data
     */
    public function __construct(array $args)
    {
        $this->data = $args;
    }

    /**
     * Returns a 500 Internal Server Error response
     */
    public static function statusFatalError(): self
    {
        return new self([
            'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
            'error' => 'A fatal error has occurred.',
        ]);
    }

    /**
     * Returns a 422 Validation Error response
     */
    public static function statusValidateError(): self
    {
        return new self([
            'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
            'error' => 'Validation error.',
        ]);
    }

    /**
     * Returns a 401 Unauthorized Error response
     */
    public static function statusQueryError(): self
    {
        return new self([
            'status' => Response::HTTP_UNAUTHORIZED,
            'error' => 'Query error - unauthorized access',
        ]);
    }

    /**
     * Returns a 403 Forbidden Error response
     */
    public static function statusUniversalError(): self
    {
        return new self([
            'status' => Response::HTTP_FORBIDDEN,
            'error' => 'Invalid schema or forbidden access',
        ]);
    }

    /**
     * Returns a 201 Created Success response
     */
    public static function statusSuccessCreated(): self
    {
        return new self([
            'status' => Response::HTTP_CREATED,
            'message' => 'Resource created successfully.',
        ]);
    }

    /**
     * Returns a 200 OK Success response
     */
    public static function statusSuccess(): self
    {
        return new self([
            'status' => Response::HTTP_OK,
            'message' => 'Request completed successfully.',
        ]);
    }

    /**
     * Returns a 203 Non-Authoritative Information response
     */
    public static function statusDefault(): self
    {
        return new self([
            'status' => Response::HTTP_NON_AUTHORITATIVE_INFORMATION,
            'message' => 'Non-authoritative information',
        ]);
    }

    /**
     * Sets the response message
     * @param string $message Response message
     * @return $this
     */
    public function message(string $message): self
    {
        $this->data['message'] = $message;
        return $this;
    }

    /**
     * Sets the response data
     * @param mixed $data Response data
     * @return $this
     */
    public function data($data): self
    {
        $this->data['data'] = $data;
        return $this;
    }

    /**
     * Sets additional information for the response
     * @param mixed $info Additional information
     * @return $this
     */
    public function info($info): self
    {
        $this->data['info'] = $info;
        return $this;
    }

    /**
     * Sets the error message
     * @param string $error Error message
     * @return $this
     */
    public function error(string $error): self
    {
        $this->data['error'] = $error;
        return $this;
    }

    /**
     * Sets the response status code
     * @param int $status HTTP status code
     * @return int
     */
    public function setStatus(int $status): int
    {
        return $this->data['status'] = $status;
    }

    /**
     * Gets the error message
     * @return string|null
     */
    public function getError(): ?string
    {
        return $this->data['error'] ?? null;
    }

    /**
     * Gets the response message
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->data['message'] ?? null;
    }

    /**
     * Gets the response data
     * @return mixed
     */
    public function getData()
    {
        return $this->data['data'] ?? null;
    }

    /**
     * Gets the additional information
     * @return mixed
     */
    public function getInfo()
    {
        return $this->data['info'] ?? null;
    }

    /**
     * Gets the response status code
     * @return int
     */
    public function getStatus(): int
    {
        return $this->data['status'] ?? 500;
    }

    /**
     * Removes the data field from the response
     */
    public function removeData()
    {
        unset($this->data['data']);
        return $this;
    }

    /**
     * Removes the message field from the response
     */
    public function removeMessage()
    {
        unset($this->data['message']);
        return $this;
    }

    /**
     * Removes the info field from the response
     */
    public function removeInfo()
    {
        unset($this->data['info']);
        return $this;
    }

    /**
     * Removes the error field from the response
     */
    public function removeError()
    {
        unset($this->data['error']);
        return $this;
    }

    /**
     * Converts the response to an array
     * @return array
     */
    public function toArray(): array
    {
        return $this->data;
    }

    /**
     * Returns a JSON response with appropriate HTTP status code
     * @return \Illuminate\Http\JsonResponse
     */
    public function json()
    {
        $status = $this->getStatus();
        return response()->json($this->toArray(), $status);
    }
}