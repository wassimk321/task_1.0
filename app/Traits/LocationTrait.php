<?php

namespace App\Traits;

trait LocationTrait
{
    function calculateHaversineDistance($lat1, $lon1, $lat2, $lon2) {
        $earthRadius = 6371; // in kilometers

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $earthRadius * $c;

        return $distance;
    }

    function calculateTotalDistance($userLocation, $storeLocations) {
        // User location
        $userLat = $userLocation['lat'];
        $userLon = $userLocation['lon'];

        // Sort store locations by distance from the user
        usort($storeLocations, function ($a, $b) use ($userLat, $userLon) {
            $distanceA = $this->calculateHaversineDistance($userLat, $userLon, $a['lat'], $a['lon']);
            $distanceB = $this->calculateHaversineDistance($userLat, $userLon, $b['lat'], $b['lon']);

            return $distanceA - $distanceB;
        });
        $totalDistance = 0;
        if(count($storeLocations) == 1){
            $totalDistance =  $this->calculateHaversineDistance($userLat, $userLon, $storeLocations[0]['lat'], $storeLocations[0]['lon']);
            return $totalDistance;
        }

        for ($i = 0; $i < count($storeLocations) - 1; $i++) {
            $lat1 = $storeLocations[$i]['lat'];
            $lon1 = $storeLocations[$i]['lon'];
            $lat2 = $storeLocations[$i + 1]['lat'];
            $lon2 = $storeLocations[$i + 1]['lon'];

            $totalDistance += $this->calculateHaversineDistance($lat1, $lon1, $lat2, $lon2);
        }

        return $totalDistance;
    }


}
