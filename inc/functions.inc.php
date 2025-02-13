<?php

/**
 * Escapes special characters in a string to prevent XSS atacks.
 * @param string $value: The string to be escaped.
 * @return string: The escaped string.
 */
function e($value)
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
