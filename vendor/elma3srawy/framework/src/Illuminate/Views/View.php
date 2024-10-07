<?php 

namespace Illuminate\Views;

class View
{
    private $pathDir;
    private $pathFile;
    private $path;

    public function __construct(protected $view , array $args = null)
    {
        $path = explode('.' , $view);

        $this->pathFile = array_pop($path);
        $separator = $path ? '\\' : '';

        $this->pathDir = base_path('resources\views' . $separator . implode('\\' , $path));
       
        $this->path =  $this->pathDir . "\\" . $this->pathFile .'.php'; 

        $this->getContentFile($args);
    }


    public function fileExists()
    {
        if(file_exists($this->path))
        {
            return true;
        }
        return false;
    }

    public function getContentFile($args)
    {
        if(!$this->fileExists())
        {
            throw new \ErrorException('View Page Not Found');
        }
        foreach($args ?? [] as $key =>  $value)
        {
            $$key = $value;
        }

        include $this->path;
    }
}

