<?php
namespace Codeinfo\Bytedance\Contracts;

interface WeappInterface
{
    public function code2Session($data);

    public function createQRCode($form_params);
}
