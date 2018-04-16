<?php

/**
 * Function helper to add flash notification.
 *
 * @param  null|string $message The flashed message.
 * @param  string $level   Level/type of message
 * @return void
 */
function flash($message = null, $level = 'info')
{
    $session = app('session');

    if (!is_null($message)) {
        $session->flash('flash_notification.message', $message);
        $session->flash('flash_notification.level', $level);
    }
}

/**
 * Indonesian Number Format.
 *
 * @param int $number
 *
 * @return string Number in Indonesian format.
 */
function formatNo($number)
{
    return number_format($number, 0, ',', '.');
}

/**
 * Rupiah Format.
 *
 * @param int $number Money in integer format.
 *
 * @return string Money in string format.
 */
function formatRp($number)
{
    if ($number == 0) {return '-';}
    return 'Rp. '.formatNo($number);
}

/**
 * Indonesian Decimal Format.
 *
 * @param float $number Decimal number in Indonesian format.
 *
 * @return string Decimal number in Indonesian format.
 */
function formatDecimal($number)
{
    return number_format($number, 2, ',', '.');
}

/**
 * Convert file size to have unit string.
 *
 * @param int $bytes File size.
 *
 * @return string Converted file size with unit.
 */
function formatSizeUnits($bytes)
{
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2).' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2).' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2).' KB';
    } elseif ($bytes > 1) {
        $bytes = $bytes.' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes.' byte';
    } else {
        $bytes = '0 bytes';
    }

    return $bytes;
}
