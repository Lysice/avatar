<?php
/**
 * Created by PhpStorm.
 * User: zhao
 * Date: 19-9-6
 * Time: 下午6:27
 */
namespace Lysice\Avatar;

use Illuminate\Config\Repository;
use Illuminate\Support\Facades\Response;

class Avatar {
    /**
     * @var mixed
     */
    protected $config;

    /**
     * Avatar constructor.
     * @param Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->config = $config->get('avatar');
    }

    private function generate($name)
    {
        // 创建图片资源
        $img_res = imagecreate($this->config['width'], $this->config['height']);
        // 背景颜色
        $bg_color = imagecolorallocate($img_res, mt_rand(120, 190), mt_rand(120, 190), mt_rand(120, 190));
        // 文字颜色
        $font_color = imagecolorallocate($img_res, mt_rand(190, 255), mt_rand(190, 255), mt_rand(190, 255));
        // 填充背景色
        imagefill($img_res, 1, 1, $bg_color);
        // 计算文字的宽高
        $pos = imagettfbbox($this->config['size'], 0, $this->config['font_file'], mb_substr($name, 0, 1));
        $font_width = $pos[2] - $pos[0] + 0.32 * $this->config['size'];
        $font_height = $pos[1] - $pos[5] + -0.16 * $this->config['size'];
        // 写入文字
        imagettftext(
            $img_res,
            $this->config['size'],
            0,
            10,
            ($this->config['height'] - $font_height) / 2 + $font_height,
            $font_color, $this->config['font_file'],
            $name);
        return $img_res;
    }

    /**
     * 输出图片（默认输出到浏览器，给定输出文件位置则输出到文件）
     * @param string|false $path 保存路径
     */
    public function output($name, $path = false)
    {
        ob_clean();
        ob_start();
        $img_res = $this->generate($name);
        // 确定输出类型和生成用的方法名
        $content_type = 'image/' . $this->config['type'];
        $generateMethodName = 'image' . $this->config['type'];
        // 确定是否输出到浏览器
        if (!$path) {
            $generateMethodName($img_res);
        } else {
            $generateMethodName($img_res, $path);
        }
        // 释放图片内存
        imagedestroy($img_res);
        $content = ob_get_contents();
        ob_end_clean();
//        dd($content_type);
        return Response::make($content)->header('Content-Type', 'image/png');
    }
}
