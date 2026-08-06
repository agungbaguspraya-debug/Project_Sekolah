<?php

namespace App\Helpers;

use Carbon\Carbon;

class WaktuHelper
{
    /**
     * Get Indonesian time of day string (Pagi, Siang, Sore, Malam).
     * Jam 07:30 - 12:00 -> Pagi
     * Jam 12:01 - 16:00 -> Siang (termasuk 13:15 dan 15:10)
     * Jam 16:01 - 18:30 -> Sore
     * Jam 18:31 - 03:59 -> Malam (termasuk 23:59)
     */
    private static function getBagianWaktu(Carbon $carbon): string
    {
        $hour = (int)$carbon->format('H');
        $minute = (int)$carbon->format('i');

        if ($hour >= 4 && ($hour < 12 || ($hour == 12 && $minute == 0))) {
            return 'Pagi';
        } elseif (($hour == 12 && $minute > 0) || ($hour >= 13 && $hour <= 16)) {
            return 'Siang';
        } elseif ($hour > 16 && $hour < 19) {
            return 'Sore';
        } else {
            return 'Malam';
        }
    }

    /**
     * Format Carbon/DateTime into Indonesian format with Pagi, Siang, Sore, Malam.
     * Example: 05 Agustus 2026, 07:30 Pagi
     *          05 Agustus 2026, 12:00 Pagi
     *          05 Agustus 2026, 13:15 Siang
     *          05 Agustus 2026, 15:10 Siang
     *          05 Agustus 2026, 23:59 Malam
     */
    public static function format($datetime, $withDate = true)
    {
        if (!$datetime) {
            return '-';
        }

        try {
            $carbon = Carbon::parse($datetime);
            $bagianWaktu = self::getBagianWaktu($carbon);
            $timeStr = $carbon->format('H:i') . ' ' . $bagianWaktu;

            if ($withDate) {
                return $carbon->translatedFormat('d F Y') . ', ' . $timeStr;
            }

            return $timeStr;
        } catch (\Exception $e) {
            return (string)$datetime;
        }
    }

    public static function formatShort($datetime)
    {
        if (!$datetime) {
            return '-';
        }

        try {
            $carbon = Carbon::parse($datetime);
            $bagianWaktu = self::getBagianWaktu($carbon);

            return $carbon->translatedFormat('d M Y') . ', ' . $carbon->format('H:i') . ' ' . $bagianWaktu;
        } catch (\Exception $e) {
            return (string)$datetime;
        }
    }
}
