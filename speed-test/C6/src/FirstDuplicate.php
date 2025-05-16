<?php

final class FirstDuplicate
{
    public static function solution($a)
    {
        $duplicate = [];

        foreach ($a as $item) {
            $count = count($duplicate);
            for ($i = 0; $i < $count; $i++) {
                $itemDuplicate = $duplicate[$i];
                if ($itemDuplicate === $item) {
                    return $itemDuplicate;
                }
            }
            $duplicate[] = $item;
        }
        return -1;
    }
}