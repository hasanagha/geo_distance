
An example to calculate distance between two points
---------------------------
A simple php library to calculate distance between two coordinates using:
1. Great Circle Distance Formula
2. Harversine Formula

Usage - Great Circle Formula
---------------------------

```php

$geoObj = new Geo();
 
$distance_in_metres = $geoObj->greatCircleDistance($latitude_from, $longitude_from, $latitude_to, $longitude_to);

```

Usage - Harversine Formula
---------------------------

```php

$geoObj = new Geo();
 
$distance_in_metres = $geoObj->haversineGreatCircleDistance($latitude_from, $longitude_from, $latitude_to, $longitude_to);

```
