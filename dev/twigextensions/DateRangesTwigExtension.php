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
                'numeric' => '01',
                'short' => 'Jan',
                'name' => 'January',
            ],
            [
                'numeric' => '02',
                'short' => 'Feb',
                'name' => 'February',
            ],
            [
                'numeric' => '03',
                'short' => 'Mar',
                'name' => 'March',
            ],
            [
                'numeric' => '04',
                'short' => 'Apr',
                'name' => 'April',
            ],
            [
                'numeric' => '05',
                'short' => 'May',
                'name' => 'May',
            ],
            [
                'numeric' => '06',
                'short' => 'Jun',
                'name' => 'June',
            ],
            [
                'numeric' => '07',
                'short' => 'Jul',
                'name' => 'July',
            ],
            [
                'numeric' => '08',
                'short' => 'Aug',
                'name' => 'August',
            ],
            [
                'numeric' => '09',
                'short' => 'Sep',
                'name' => 'September',
            ],
            [
                'numeric' => '10',
                'short' => 'Oct',
                'name' => 'October',
            ],
            [
                'numeric' => '11',
                'short' => 'Nov',
                'name' => 'November',
            ],
            [
                'numeric' => '12',
                'short' => 'Dec',
                'name' => 'December',
            ],
        ];
    }
}
