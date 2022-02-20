<?php

declare(strict_types=1);

namespace app\i18n;

class Formatter extends \yii\i18n\Formatter
{
    /**
     * @param $value
     *
     * @return string
     *
     * @throws \Exception
     */
    public function asTimeDuration($value): string
    {
        if ($value === null) {
            return $this->nullDisplay;
        }

        if ($value instanceof \DateInterval) {
            $isNegative = $value->invert;
            $interval = $value;
        } elseif (is_numeric($value)) {
            $isNegative = $value < 0;
            $zeroDateTime = (new \DateTime())->setTimestamp(0);
            $valueDateTime = (new \DateTime())->setTimestamp(abs($value));
            $interval = $valueDateTime->diff($zeroDateTime);
        } elseif (strncmp($value, 'P-', 2) === 0) {
            $interval = new \DateInterval('P' . substr($value, 2));
            $isNegative = true;
        } else {
            $interval = new \DateInterval($value);
            $isNegative = $interval->invert;
        }

        $parts = [];

        if ($interval->h > 0) {
            $parts[] = \str_pad((string)$interval->h, 2, '0', STR_PAD_LEFT);
        }

        $parts[] = \str_pad((string)$interval->i, 2, '0', STR_PAD_LEFT);
        $parts[] = \str_pad((string)$interval->s, 2, '0', STR_PAD_LEFT);

        return ($isNegative ? '-' : '') . \implode(':', $parts);
    }
}
