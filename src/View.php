<?php
/**
 * Clover Route  PHP������ͼ
 *
 * @author Donghaichen [<chendongahai888@gmailc.com>]
 * @todo ģ�滺��
 */

namespace Cloves\View;

class View
{
    const VIEW_BASE_PATH = '/resources/views/';

    public $view;
    public $data;

    public function __construct($view)
    {
        $this->view = $view;
    }

    public function __call($method, $parameters)
    {
        if (starts_with($method, 'with'))
        {
            return $this->with(snake_case(substr($method, 4)), $parameters[0]);
        }

        throw new BadMethodCallException("���� [$method] �����ڣ�.");
    }

    public static function make($viewName)
    {
            $viewFilePath = self::getFilePath($viewName);
            if ( is_file($viewFilePath) ) {
                return new View($viewFilePath);
            } else {
                throw new UnexpectedValueException("��ͼ�ļ������ڣ�");
            }
    }

    public function with($key, $value = null)
    {
        $this->data[$key] = $value;
        return $this;
    }

    private static function getFilePath($viewName)
    {
        $filePath = str_replace('.', '/', $viewName);
        return BASE_PATH.self::VIEW_BASE_PATH.$filePath.'.php';
    }

}