<?php
// base class with member properties and methods
class Geo {

    var $earth_radius = 6371000;

    public function greatCircleDistance($latitude_from, $longitude_from, $latitude_to, $longitude_to) {
        # Great circle / orthodomic distance calculation
        # Ref: https://en.wikipedia.org/wiki/Great-circle_distance

        $latitude_from_radian = deg2rad($latitude_from);
        $longitude_from_radian = deg2rad($longitude_from);
        $latitude_to_radian = deg2rad($latitude_to);
        $longitude_to_radian = deg2rad($longitude_to);

        $latitude_delta = $latitude_to_radian - $latitude_from_radian;
        $longitude_delta = $longitude_to_radian - $longitude_from_radian;

        $angle = acos(
            sin($latitude_from_radian) * sin($latitude_to_radian) + cos($latitude_from_radian) * cos($latitude_to_radian) * cos($longitude_delta)
        );

        return $angle * $this->earth_radius;
    }

    public function haversineGreatCircleDistance($latitude_from, $longitude_from, $latitude_to, $longitude_to)
    {
        # Harversine formula to calculate distance between two points
        # Ref: http://www.movable-type.co.uk/scripts/latlong.html

        // converting from degrees to radians
        $latitude_from_radian = deg2rad($latitude_from);
        $longitude_from_radian = deg2rad($longitude_from);
        $latitude_to_radian = deg2rad($latitude_to);
        $longitude_to_radian = deg2rad($longitude_to);

        $latitude_delta = $latitude_to_radian - $latitude_from_radian;
        $longitude_delta = $longitude_to_radian - $longitude_from_radian;

        # Harversine formula implementation
        $angle = 2 * asin(
            sqrt(
                pow(
                    sin($latitude_delta / 2), 2) + cos($latitude_from_radian) * cos($latitude_to_radian) * pow(sin($longitude_delta / 2), 2
                )
            )
        );

        return $angle * $this->earth_radius;
    }

} // end of class Geo