<?php

function truncate (string $text, $length = 150){
    if(strlen($text) > $length){
        return substr($text, 0, $length) . " (...)";
        }
        return $text;
        }

        // substr(string $string, int $start [, ?int $length] ). Here it's from index 0 to 20