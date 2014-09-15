<?php

if (!function_exists('humanize')) {
    /**
     * Return the humanized version of a string.
     *
     * @param $string
     * @return string
     */
    function humanize($string)
    {
        return ucwords(str_replace('_', ' ', snake_case($string)));
    }
}

if (!function_exists('boolean')) {
    /**
     * Return the evaluated boolean value of a value.
     *
     * @param       $value
     * @param array $arguments
     * @return mixed
     */
    function boolean($value, $arguments = [])
    {
        return filter_var(evaluate($value, $arguments), FILTER_VALIDATE_BOOLEAN);
    }
}

if (!function_exists('evaluate')) {
    /**
     * Return the evaluated value of a value (ya, that's right).
     *
     * @param       $value
     * @param array $arguments
     * @return mixed|null
     */
    function evaluate($value, $arguments = [])
    {
        if ($value instanceof \Closure) {
            try {
                return call_user_func_array($value, $arguments);
            } catch (\Exception $e) {
                return null;
            }
        } elseif (is_array($value)) {
            foreach ($value as &$val) {
                $val = evaluate($val, $arguments);
            }
        }

        return $value;
    }
}

if (!function_exists('hashify')) {
    /**
     * Return a hash value from anything.
     *
     * @param        $value
     * @param string $algorithm
     * @return string
     */
    function hashify($value, $algorithm = 'md5')
    {
        ob_start();
        var_dump($value);

        return hash($algorithm, ob_get_clean());
    }
}

if (!function_exists('evaluate_key')) {
    /**
     * Return the evaluated value of an array key.
     * If no key exists return the default value.
     *
     * @param       $array
     * @param       $key
     * @param null  $default
     * @param array $arguments
     * @return mixed|null
     */
    function evaluate_key($array, $key, $default = null, $arguments = [])
    {
        return evaluate(key_value($array, $key, $default), $arguments);
    }
}

if (!function_exists('key_value')) {
    /**
     * Return the value of an array.
     * If no key exists return the default value.
     *
     * @param      $array
     * @param      $key
     * @param null $default
     * @return null
     */
    function key_value($array, $key, $default = null)
    {
        return isset($array[$key]) ? $array[$key] : $default;
    }
}
