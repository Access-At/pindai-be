<?php

namespace Modules;

use App\Helper\ResponseApi;
use Exception;

class CustomException extends Exception
{
    public $error;

    public function __construct($message, $code = 400, $error = null)
    {
        $this->error = $error;
        parent::__construct($message, $code);
    }

    public function render($request)
    {
        return ResponseApi::statusQueryError()
            ->error($this->error)
            ->status($this->code) // Use $this->code for the status
            ->message($this->getMessage())
            ->json();
    }
}
