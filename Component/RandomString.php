<?php


namespace App\Component;


class RandomString
{
    private $len_str;
    private $symbols;
    private $string;
    function random_string(): string
    {
        $this->len_str = 12;
        $this->symbols = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        for($i = 0; $i < $this->len_str; $i++) {
            if($i % 2 == 0)
                $this->string .= $this->symbols[rand(0,31)];
            else
                $this->string .= $this->symbols[rand(32,61)];
        }

        return $this->string;
    }
}