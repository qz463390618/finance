<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadFileController extends Controller
{
    //配置
    /*
     * 上传保存路径,可以自定义保存路径和文件名格式
     * {filename} 会替换成原文件名
     * {rand:6} 会替换成随机数,后面的数字是随机数的位数
     * {time}   会替换成时间戳
     * {yyyy}   会替换成四位年份
     * {yy}     会替换成两位年份
     * {mm}     会替换成两位月份
     * {dd}     会替换成两位日期
     * {hh}     会替换成两位小时
     * {ii}     会替换成两位分钟
     * {ss}     会替换成两位秒
     * 非法字符 \ : * ? " < > |
     * */
    public $config = [
        'pathFormat' => '/upload/images/{yyyy}/{mm}{dd}/{time}{rand:6}', //存储目录
        'maxSize' => '2048000',
        'allowFiles' => [".png", ".jpg", ".jpeg", ".gif", ".bmp"],
    ];
    public $fileField; //文件域名
    public $file; //文件上传对象
    public $oriName = 1; //原始文件名
    public $fileName; //新文件名
    public $fullName; //完整文件名,即从当前配置目录开始的URL
    public $filePath; //完整文件名,即从当前配置目录开始的URL
    public $fileSize; //文件大小
    public $fileType; //文件类型
    //上传文件
    public function upFile($fileInfo)
    {
        //获取上传图片
        $file = $this -> file = $fileInfo;
        //获取原来文件名
        $this -> oriName = $file['name'];
        //获取文件大小
        $this -> fileSize = $file['size'];
        //获取文件类型,扩展名
        $this -> fileType = $this -> getFIleExt();
        //生成完整文件名
        $this->fullName = $this->getFullName();
        //获取文件完整路径
        $this->filePath = $this->getFilePath();
        //新的文件名
        $this->fileName = $this->getFileName();
        $dirname = dirname($this -> filePath);
        //检查文件大小是否超出限制
        if (!$this -> checkSize())
        {
            $this -> stateInfo = '文件大小超出网站限制';
            return;
        }

        //检查是否不允许的文件格式
        if(!$this -> checkType())
        {
            $this->stateInfo = '文件类型不允许';
            return;
        }

        //创建目录失败
        if(!file_exists($dirname) && !mkdir($dirname, 0777,true))
        {
            $this->stateInfo = '目录创建失败';
            return;
        }else if(!is_writeable($dirname))
        {
            $this->stateInfo = '该目录没有写入权限';
            return;
        }

        //移动临时文件,代表上传成功
        //var_dump($file["tmp_name"],$this -> filePath);die;
        if(!(copy($file["tmp_name"],$this -> filePath) && file_exists($this -> filePath)))
        {
            $this -> stateInfo = '文件保存时出错';
        }else{
            $arr = $this ->getFileInFo();
            //$this->stateInfo = $this->stateMap[0];
            return $arr['url'];
        }
    }

    //获取文件扩展名
    public function getFIleExt()
    {
        return strtolower(strrchr($this->oriName,'.'));
    }

    //重命名文件
    public function getFullName()
    {
        //替换日期事件
        $t = time();
        $d = explode('-',date('Y-y-m-d-H-i-s'));

        //获取配置,存放目录
        $format = $this -> config['pathFormat'];
        //替换存放目录的关键词
        $format = str_replace("{yyyy}",$d[0],$format);
        $format = str_replace("{yy}",$d[1],$format);
        $format = str_replace("{mm}",$d[2],$format);
        $format = str_replace("{dd}",$d[3],$format);
        $format = str_replace("{hh}",$d[4],$format);
        $format = str_replace("{ii}",$d[5],$format);
        $format = str_replace("{ss}",$d[6],$format);
        $format = str_replace("{time}",$t,$format);

        //过滤文件名的非法自负,并替换文件名
        $oriName = substr($this->oriName, 0, strrpos($this->oriName, '.'));
        $oriName = preg_replace("/[\|\?\"\<\>\/\*\\\\]+/", '', $oriName);
        $format = str_replace("{filename}", $oriName, $format);
        //替换随机字符串
        $randNum = rand(1,9999999) . rand(1,9999999);
        if (preg_match("/\{rand\:([\d]*)\}/i", $format, $matches)) {
            $format = preg_replace("/\{rand\:[\d]*\}/i", substr($randNum, 0, $matches[1]), $format);
        }

        $ext = $this->getFileExt();
        return $format . $ext;
    }

    //获取文件完整目录
    public function getFIlePath()
    {
        $fullname = $this -> fullName;
        $rootPath = $_SERVER['DOCUMENT_ROOT'];//获取域名
        if(substr($fullname, 0, 1) != '/'){
            $fullname = '/' . $fullname;
        }
        return $rootPath . $fullname;
    }

    //获取文件名
    public function getFileName()
    {
        return substr($this -> filePath,strpos($this->filePath,'/') + 1);
    }

    //文件大小检测
    public function checkSize()
    {
        return $this -> fileSize <= ($this->config["maxSize"]);
    }

    //文件类型检测
    public  function checkType()
    {
        return in_array($this -> getFIleExt(),$this -> config['allowFiles']);
    }

    public function getFileInFo()
    {
        return array(
            //"state" => $this->stateInfo,
            "url" => 'http://[!--img.hosts--]'.str_replace('/upload/images/','',$this->fullName),
            //"url" => $this->fullName,
            "title" => $this->fileName,
            "original" => $this->oriName,
            "type" => $this->fileType,
            "size" => $this->fileSize
        );
    }
}
