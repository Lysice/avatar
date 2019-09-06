<?php
/**
 * Created by PhpStorm.
 * User: zhao
 * Date: 19-9-6
 * Time: 下午6:30
 */
namespace Lysice\Avatar\Facades;
use Illuminate\Support\Facades\Facade;
class Avatar extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'avatar';
    }
}
