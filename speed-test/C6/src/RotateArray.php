<?php

final class RotateArray
{
    public static function solution($a)
    {
        $r = [];
        $count = count($a);
        $countItem = count($a[0]);
        for ($i = 0; $i < $count; $i++) {
            $push = [];
            for ($j = $countItem -1; $j >= 0; $j--) {
                $push[] = $a[$j][$i];
            }
            $r[] = $push;
        }
        return $r;
    }
}