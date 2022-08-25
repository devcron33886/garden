<?php

function format_phone_us($phone)
{
    // note: making sure we have something
    if (! isset($phone)) {
        return '';
    }

    // note: strip out everything but numbers
    $phone = preg_replace('/[^0-9]/', '', $phone);
    $length = strlen($phone);
    switch ($length) {
        case 7:
            return preg_replace('/([0-9]{3})([0-9]{4})/', '$1-$2', $phone);
        case 10:
            return preg_replace('/([0-9]{3})([0-9]{3})([0-9]{4})/', '($1) $2-$3', $phone);
        case 11:
            return preg_replace('/([0-9]{1})([0-9]{3})([0-9]{3})([0-9]{4})/', '$1($2) $3-$4', $phone);
        default:
            return $phone;
    }
}

if (! function_exists('encryptId')) {
    /**
     * Checking if user has permission
     *
     * @param $id
     * @return string
     */
    function encryptId($id): string
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyz-ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $hashids = new Hashids\Hashids('', 32);

        return $hashids->encode($id);
    }
}

if (! function_exists('decryptId')) {
    /**
     * @param $id
     * @return int
     */
    function decryptId($id): int
    {
        $hashids = new Hashids\Hashids('', 32);

        return $hashids->decode($id)[0];
    }
}
