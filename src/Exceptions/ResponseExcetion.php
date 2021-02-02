<?php
namespace Codeinfo\Bytedance\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class ResponseExcetion extends Exception
{
    // 错误提示
    protected $custom_message;
    // 错误码
    protected $custom_code;

    public function __construct($message, $code, $e = null)
    {
        $this->custom_message = $message;

        $this->custom_code = $code;

        $this->exception = $e;
    }

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report()
    {
        if (isset($this->exception)) {
            Log::error($this->custom_message, [
                'message' => $this->exception->getMessage(),
            ]);
        }
    }

    /**
     * 将异常渲染至 HTTP 响应值中。
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response()->json([
            'code' => $this->custom_code,
            'message' => $this->custom_message,
        ]);
    }
}
