<?php

namespace App\Component;

class Render
{
    protected $vars = [];

    function insert(array $vars = [])
    {
        $this->vars = $vars;
    }

    function render(string $fname)
    {
        if(!preg_match("/^[a-zA-Z_0-9.]+$/i", $fname))
        {
            die("Недопустимые символы в названии файла");
        }
        if(file_exists('Template/'.$fname.'.tpl.php'))
        {
            ob_start();
            extract($this->vars);
            require ('Template/'.$fname.'.tpl.php');
            return ob_get_clean();
        }
        else die("Файл не найден.");
    }

}