<?php
/**
 * Created by PhpStorm.
 * User: perse
 * Date: 21/02/2019
 * Time: 01:27
 */

namespace Core\Stdlib;

use Zend\Stdlib\RequestInterface;

trait CurrentUrl
{
    public function getUrl(RequestInterface $request){
        $protocol = 'http://';
        if($request->getServer('HTTPS') != null){
            $protocol = 'https://';
        }

        return $protocol.$request->getServer('HTTP_HOST');
    }
}