<?php

namespace dev\twigextensions;

use Twig_Function;
use Twig_Extension;

/**
 * Class DateRangesTwigExtension
 */
class DateRangesTwigExtension extends Twig_Extension
{
    /**
     * Returns the functions for this Twig Extension
     * @return Twig_Function[]
     */
    public function getFunctions(): array
    {
        return [
            new Twig_Function('years', [$this, 'getYears']),
            new Twig_Function('months', [$this, 'getMonths']),
        ];
    }

    /**
     * @param int $rangeTo = 10
     * @return array
     */
    public function getYears(int $rangeTo = 10): array
    {
        $year = date('Y');
        return range($year, $year + $rangeTo);
    }

    /**
     * @return array
     */
    public function getMonths(): array
    {
        return [
            [
                'num' => 1,
                'numeric' => '01',
                'short' => 'Jan',
                'name' => 'January',
            ],
            [
                'num' => 2,
                'numeric' => '02',
                'short' => 'Feb',
                'name' => 'February',
            ],
            [
                'num' => 3,
                'numeric' => '03',
                'short' => 'Mar',
                'name' => 'March',
            ],
            [
                'num' => 4,
                'numeric' => '04',
                'short' => 'Apr',
                'name' => 'April',
            ],
            [
                'num' => 5,
                'numeric' => '05',
                'short' => 'May',
                'name' => 'May',
            ],
            [
                'num' => 6,
                'numeric' => '06',
                'short' => 'Jun',
                'name' => 'June',
            ],
            [
                'num' => 7,
                'numeric' => '07',
                'short' => 'Jul',
                'name' => 'July',
            ],
            [
                'num' => 8,
                'numeric' => '08',
                'short' => 'Aug',
                'name' => 'August',
            ],
            [
                'num' => 9,
                'numeric' => '09',
                'short' => 'Sep',
                'name' => 'September',
            ],
            [
                'num' => 10,
                'numeric' => '10',
                'short' => 'Oct',
                'name' => 'October',
            ],
            [
                'num' => 11,
                'numeric' => '11',
                'short' => 'Nov',
                'name' => 'November',
            ],
            [
                'num' => 12,
                'numeric' => '12',
                'short' => 'Dec',
                'name' => 'December',
            ],
        ];
    }
}
