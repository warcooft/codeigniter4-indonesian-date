<?php

declare(strict_types=1);

/**
 * This file is part of CodeIgniter Shield.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Aseslsan\IndonesianDate\Traits;

use CodeIgniter\I18n\Time;

trait IndonesianDateTraits
{
    public function indonesianDate(string $attribute, bool $showDayOfWeek = true, bool $showTime = false): string
    {
        $datetime = $this->attributes[$attribute];
        return $this->output($datetime, $showDayOfWeek, $showTime);
    }

    public function zodiac(string $attribute)
    {
        $datetime = $this->attributes[$attribute];
        $parse    = Time::parse($datetime);
        $month    = (int) $parse->getMonth();
        $day      = (int) $parse->getDay();

        return static::determineZodiac($day, $month);
    }

    public function age(string $attribute)
    {
        $datetime = $this->attributes[$attribute];
        $parse    = Time::parse($datetime);

        return $parse->getAge();
    }

    private static function determineZodiac(int $day, int $month): string
    {
        $zodiacRanges = [
            'Capricorn' => [['month' => 12, 'day' => 22], ['month' => 1, 'day' => 19]],
            'Aquarius' => [['month' => 1, 'day' => 20], ['month' => 2, 'day' => 18]],
            'Pisces' => [['month' => 2, 'day' => 19], ['month' => 3, 'day' => 20]],
            'Aries' => [['month' => 3, 'day' => 21], ['month' => 4, 'day' => 19]],
            'Taurus' => [['month' => 4, 'day' => 20], ['month' => 5, 'day' => 20]],
            'Gemini' => [['month' => 5, 'day' => 21], ['month' => 6, 'day' => 20]],
            'Cancer' => [['month' => 6, 'day' => 21], ['month' => 7, 'day' => 22]],
            'Leo' => [['month' => 7, 'day' => 23], ['month' => 8, 'day' => 22]],
            'Virgo' => [['month' => 8, 'day' => 23], ['month' => 9, 'day' => 22]],
            'Libra' => [['month' => 9, 'day' => 23], ['month' => 10, 'day' => 22]],
            'Scorpio' => [['month' => 10, 'day' => 23], ['month' => 11, 'day' => 21]],
            'Sagittarius' => [['month' => 11, 'day' => 22], ['month' => 12, 'day' => 21]],
        ];

        // Loop melalui zodiak dan tentukan apakah tanggal lahir ada dalam rentang tersebut
        foreach ($zodiacRanges as $zodiac => $range) {
            if (static::isDateInRange($day, $month, $range[0], $range[1])) {
                return $zodiac;
            }
        }

        return 'Unknown';
    }

    private static function isDateInRange(int $day, int $month, array $start, array $end): bool
    {
        if (($month == $start['month'] && $day >= $start['day']) ||
            ($month == $end['month'] && $day <= $end['day']) ||
            ($month > $start['month'] && $month < $end['month'])
        ) {
            return true;
        }

        return false;
    }

    // Indonesian standard datetime output
    // E.g: Senin, 23 September 2024 18.00
    private function output($datetime, bool $showDayOfWeek = true, bool $showTime = false): string
    {
        $parse    = Time::parse($datetime);

        $year        = $parse->getYear();
        $month       = $parse->getMonth();
        $dayWeek     = $parse->getDayOfWeek();
        $day         = $parse->getDay();
        $hour        = $parse->getHour();
        $minute      = str_pad($parse->getMinute(), 2, '0', STR_PAD_LEFT);

        $dayString   = static::day($dayWeek);
        $monthString = static::month($month);

        $output = "$dayString, $day $monthString $year";

        if (!$showDayOfWeek && !$showTime) {
            $output = "$day $monthString $year";
        } elseif (!$showDayOfWeek && $showTime) {
            $output = "$day $monthString $year $hour.$minute";
        } elseif ($showDayOfWeek && $showTime) {
            $output .= " $hour.$minute";
        }

        return $output;
    }

    private static function day($key): string|false
    {
        $day = [
            1 => 'Minggu',
            2 => 'Senin',
            3 => 'Selasa',
            4 => 'Rabu',
            5 => 'Kamis',
            6 => "Jum'at",
            7 => 'Sabtu',
        ];

        if (!array_key_exists($key, $day)) {
            return false;
        }

        return $day[$key];
    }

    private static function month($key): string|false
    {
        $month = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => "Juni",
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        if (!array_key_exists($key, $month)) {
            return false;
        }

        return $month[$key];
    }
}