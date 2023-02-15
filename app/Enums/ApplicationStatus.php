<?php

namespace App\Enums;

use Spatie\Enum\Enum;

/**
 * @method static self prelim()
 * @method static self await_order()
 * @method static self ordered()
 * @method static self error()
 * @method static self completed()
 * @method static self abandoned()
 */
class ApplicationStatus extends Enum
{

}
