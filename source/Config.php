<?php
/** BASE URL - OBS: Em Caso Erro possívelmente sera aqui */
define("ROOT", "https://localhost/teste_bludata_maycon");
/*
    Caso aconteça ocorra algum problema possívelmente será por conta dos URLs nas requisições ajax.
*/

function url(string $path): string
{
    if ($path) {
        return ROOT . "{$path}";
    }
    return ROOT;
}

/**
 * @param string $message
 * @param string $type
 * @return string
 */
function message(string $message, string $type): string
{
    return "<div class=\"message {$type}\">{$message}</div>";
}