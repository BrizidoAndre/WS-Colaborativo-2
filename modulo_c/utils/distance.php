<?php

function haversine($lat1, $lon1, $lat2, $lon2) {
    $earthRadius = 6371000;

    $lat1 = deg2rad($lat1);
    $lon1 = deg2rad($lon1);
    $lat2 = deg2rad($lat2);
    $lon2 = deg2rad($lon2);

    $deltaLat = $lat2 - $lat1;
    $deltaLon = $lon2 - $lon1;

    $angle = 2 * asin(sqrt(
        pow(sin($deltaLat / 2), 2) +
        cos($lat1) * cos($lat2) * pow(sin($deltaLon / 2), 2)
    ));

    return $earthRadius * $angle;
}