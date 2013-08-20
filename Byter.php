<?php

class Byter
{
    protected $bytes = 0;
    protected $base = 1024;

    protected static $steps = array(
        'B', // Byte
        'KB', // Kilobyte
        'MB', // Megabyte
        'GB', // Gigabyte
        'TB', // Terabyte
        'PB', // Petabyte
        'EB' // Exabyte
    );

    public function __construct($bytes)
    {
        $this->bytes = $bytes;
    }

    public function useBinary()
    {
        $this->base = 1000;
        return $this;
    }

    public static function fromBytes($bytes)
    {
        return new static($bytes);
    }

    public static function fromString($string)
    {
        if (preg_match('/^(?P<digits>[\d\.,]+)\s*?(?P<modifier>[a-zA-Z]+)$/', $string, $matches) === 1)
        {
            if (substr_count($matches['digits'], ',') === 1 || substr_count($matches['digits'], '.') === 1)
            {
                $number = (float) str_replace(',', '.', $matches['digits']);
            }
            else
            {
                $number = (int) $matches['digits'];
            }

            $base = 1024;

            $modifier = $matches['modifier'];
            $binary = preg_match('/iB$/',  $modifier);

            if ($binary === 1)
            {
                $base = 1000;
                $modifier = str_replace('iB', 'B', $modifier);
            }

            $exponent = array_search($modifier, static::$steps);

            if ($exponent > 0)
            {
                $multiplier = pow($base, $exponent);
                return new static($number * $multiplier);
            }
            else if ($exponent === 0)
            {
                return new static($number);
            }
        }

        throw new \InvalidArgumentException('Given number string cannot be converted to bytes.');
    }

    public function __call($method, $arguments)
    {
        if (($steps = array_search(str_replace('to', '', $method), static::$steps)) !== false)
        {
            return $this->bytes /= pow($this->base, $steps);
        }

        throw new \BadMethodCallException('Call to undefined method ' . get_called_class() . '::' . $method . '()');
    }
}
