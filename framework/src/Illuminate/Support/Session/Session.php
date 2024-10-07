<?php 

namespace Illuminate\Support\Session;


class Session
{
    static $instance;

    protected const FLASH_KEY = 'flash';

    public function __construct()
    {
        if(session_status() == PHP_SESSION_NONE)
        {
            session_name(config('app.app_name') ? config('app.app_name') .'_session' : 'mvc_session');
            session_start();
        }

        if($this->has(self::FLASH_KEY))
        {
            $this->refactorFlash();
        }
    }
    private function refactorFlash()
    {
        foreach ($this->get(self::FLASH_KEY) as $key => $value)
        {
            $_SESSION[self::FLASH_KEY][$key]['remove'] = true;
        }
    }
    public function put($key , $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get($key = null)
    {
        return  !$key ? $_SESSION : $_SESSION[$key];
    }

    public function has($key)
    {
        return isset($_SESSION[$key]) ? true : false;
    }

    public function remove($key)
    {
        unset($_SESSION[$key]);
    }

    public function flash($key , $value)
    {
        return $_SESSION[self::FLASH_KEY][$key] =
        [
            'remove' => false,
            'content' => $value
        ];
    }

     public function __destruct()
    {
        if($this->has(self::FLASH_KEY))
        {
            $this->removeFlashMessages();
        }
    }
    private function removeFlashMessages()
    {
        foreach ($this->get(self::FLASH_KEY) as $key => $flashMessage) {
            if ($flashMessage['remove']) {
                unset($_SESSION[self::FLASH_KEY][$key]);
            }
        }
    }
}