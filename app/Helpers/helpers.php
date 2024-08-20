<?php


if (! function_exists('generateSlug')) {

    function generateSlug($text, string $divider = '-')
    {
        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, $divider);

        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text))
        {
            return 'n-a';
        }

        return $text;
    }
}

if (! function_exists('germanNoFormat')) {

    function germanNoFormat($number)
    {
        $locale = localeconv();
        return number_format($number, 2, $locale['decimal_point'], $locale['thousands_sep']);
    }
}

if (! function_exists('enCryptData')) {

    function enCryptData($string)
    {
        $ciphering = "camellia-128-cbc";
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
        $encryption_iv = '1344507891011121';
        $encryption_key = "MonteurzimmerKing";
        $encryptedData = openssl_encrypt($string, $ciphering, $encryption_key, $options, $encryption_iv);
        return base64_encode($encryptedData);
    }
}

if (! function_exists('deCryptData')) {

    function deCryptData($string)
    {
        $string = base64_decode($string);
        $ciphering = "camellia-128-cbc";
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
        $encryption_iv = '1344507891011121';
        $encryption_key = "MonteurzimmerKing";
        $encryptedData = openssl_decrypt($string, $ciphering, $encryption_key, $options, $encryption_iv);
        return $encryptedData;
    }
}

if (! function_exists('getRoleByName')) {

    function getRoleByName($name) {

        $role = Cache::rememberForever('getRoleByName-'.$name.'-cache', function() use($name) {
           return DB::table('roles')->select('id')->where('name', $name)->get()->first();
        });
        if( $role ){
            return $role->id;
        }
    }
}

?>