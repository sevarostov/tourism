<?php

namespace App\Common;

use DateTimeInterface;

final class CommonDefinition
{
    /**
     * Date or (and) time formats
     */
    const DATE_TIME_FORMAT = 'd.m.Y H:i:s';
    const DATE_FORMAT = 'd.m.Y';
    const TIME_FORMAT = 'H:i:s';
    const DATE_TIME_FILENAME_FORMAT = 'Y-m-d-H-i-s-u';
    const API_DATE_TIME_FORMAT = DateTimeInterface::W3C;
    const API_DATE_FORMAT = '!Y-m-d';
    const API_DATE_FORMAT_FROM_DATETIME = 'Y-m-d';
    const INTL_DATE_DATE_FORMAT = 'd MMMM Y';
    const INTL_DATE_FULL_MONTH_FORMAT = 'MMMM';
}
