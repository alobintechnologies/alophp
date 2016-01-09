<?php

class URL
{
    public static function asset($value)
    {
        return public_path(). '/' . $value;
    }
}
