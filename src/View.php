<?php
/**
 * Clover Route  PHP极速视图
 *
 * @author Donghaichen [<chendongahai888@gmail.com>]
 * @todo 模版缓存
 */

namespace Clovers\View;
use UnexpectedValueException;
use BadMethodCallException;
class View
{

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

        throw new BadMethodCallException("方法 [$method] 不存在！.");
    }

    public static function make($view_name)
    {
        $view_file_path = self::getFilePath($view_name);
        if ( is_file($view_file_path) ) {
            return new View($view_file_path);
        } else {
            throw new UnexpectedValueException("视图文件[$view_file_path]不存在！");
        }
    }

    public function with($key, $value = null)
    {
        $this->data[$key] = $value;
        return $this;
    }

    private static function getFilePath($view_name)
    {
        $file_path = str_replace('.', DS, $view_name);
        return THEME_PATH . DS . THEME . DS .  $file_path . '.blade.php';
    }

}
