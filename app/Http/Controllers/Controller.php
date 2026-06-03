<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Controller
{
	const CODE_200 = 200; // Success
	const CODE_422 = 422; // Validation error
	const CODE_401 = 401; // Unauthorized
	const CODE_400 = 400; // Bad Request
	const CODE_403 = 403; // Forbidden
	const CODE_405 = 405; // Not Allowed Method
	const CODE_500 = 500; // unknown error

	public $status      = 200;
	public $data        = null;
	public $message     = '';
	public $httpError   = 500;
	public $exception;

	private function buildResponse()
	{
		if ($this->status !== self::CODE_200) {
			$this->responseForError($this->message);
		}

		$re = [
			'status'    => $this->status,
			'message'   => empty($this->message) ? $this->buildResponseMessage() : $this->message,
			'data'      => $this->data,
		];

		return $re;
	}

	private function buildResponseMessage()
	{
		$this->message = trans('error_api.' . $this->status);

		return $this->message;
	}

	private function buildHttpErrorCode()
	{
		return $this->status;
	}

	public function response()
	{
		return response()->json(
			$this->buildResponse(),
			$this->buildHttpErrorCode()
		);
	}

	public function responseForError($exception)
	{
		$this->exception = $exception;

        if ($exception instanceof \Exception || $exception instanceof \Throwable) {
            $this->message = $exception->getMessage();

            if (in_array($exception->getCode(), [self::CODE_200, self::CODE_422, self::CODE_401, self::CODE_400, self::CODE_403, self::CODE_405, self::CODE_500])) {
                $this->status = $exception->getCode();
                $this->message = $exception->getMessage();
            }
        } else {
            $this->message = (string) $exception;
            $this->status = self::CODE_500; // Set status ke 500 untuk unknown error
        }
	}
}
