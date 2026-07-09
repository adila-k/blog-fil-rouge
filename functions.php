<?php

        // ======================
        // TO TRUNCATE LONG TEXT
        // ======================

function truncate (string $text, $length = 150){
    if(strlen($text) > $length){
        return substr($text, 0, $length) . " (...)";
        }
        return $text;
        }
        // substr(string $string, int $start [, ?int $length] ). Here it's from index 0 to 20


        // ============================
        // TO REDIRECT USER TO HOMEPAGE
        // ============================

function redirectUrl(string $url) : void
        {
        header("location: {$url}");
        exit();
        }


        // ============================
        // TO GET A PROPER ARTICLE URL
        // ============================

function slugify(string $string) {
    // == Put everthings in lowercase ==
    $title = strtolower($string);

    // == Remove accents == 
    $title = iconv("UTF-8", "us-ascii//TRANSLIT", $title);

    // == Replace everything that isn't a letter or a number with a hyphen == 
    $title = preg_replace('~[^\pL\d]+~u', '-', $title);

    // == Removes any remaining odd characters == 
    $title = preg_replace('~[^-\w]+~', '', $title);

    // == Removes extra dashes at the beginning and end ==
    $title = trim($title, "-");

    return empty($title) ? "n-a" : $title;
}
  


        // ============================
        // CREATE PROPER URL
        // ============================
function createArticleUrl(int $id, string $title, $score = null)
{
    // I get a proper URL
    $slug = slugify($title);

    return 'article/' . $id . '-' . $slug . '.html';
}