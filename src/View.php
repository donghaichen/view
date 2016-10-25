<?php
/**
 * Clover Route  PHP极速视图
 *
 * @author Donghaichen [<chendongahai888@gmail.com>]
 * @todo 模版缓存
 */

namespace Clovers\View;
use UnexpectedValueException;
class View
{
    protected static $view = '';
    protected static $data;

    public static function __callStatic($name, $arguments)
    {
        self::$view = $arguments[0];
        self::$data = $arguments[1];
        return self::_view($arguments[0]);
    }

    public static function _view($view_name)
    {
        $view_file_path = self::getFilePath($view_name);
        if (is_file($view_file_path) ) {
            if(is_array(self::$data))
            {
                extract(self::$data);
            }
            include $view_file_path;
        } else {
            throw new UnexpectedValueException("视图文件[$view_file_path]不存在！");
        }
    }

    private static function getFilePath($view_name)
    {
        $file_path = str_replace('.', DS, $view_name);
        return THEME_PATH . DS . THEME . DS .  $file_path . VIEW_SUFFIX;
    }

}
