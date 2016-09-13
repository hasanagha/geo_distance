<?php
include 'Geo.php';

// base class with member properties and methods
class Customers {

    var $file_name;
    var $selected_customers = array();

    public function __construct($file_name)
    {
        $this->file_name = $file_name;
    }

    public function getFileContent($file_name="") {
        # Method to read given file and return its content
        $content = '';

        if ($file_name)
            $this->file_name = $file_name;

        if(file_exists($this->file_name)){
            $my_file = fopen($this->file_name, "r") or die("Unable to open file!");
            $content = fread($my_file, filesize($this->file_name));
            fclose($my_file);
        }

        return $content;
    }

    public function getCustomersInfoArray() {
        $array = array();
        $file_content = trim($this->getFileContent($this->file_name));

        if ($file_content) {
            $file_content_array = explode("\n", $file_content);
            foreach($file_content_array as $item) {
                $array[] = json_decode($item);
            }
        }

        return $array;
    }

    public function getCustomersWithinLimit($destination_coordinates, $distance_allowed=0){
        $selected_customers = array();
        $customers_in_array = $this->getCustomersInfoArray();

        if ($customers_in_array) {
            foreach($customers_in_array as $customer) {
                if (!$customer) {
                    # if not a valid json, skip this customer and continue
                    continue;
                }

                $latitude_from = $destination_coordinates[0];
                $longitude_from = $destination_coordinates[1];
                $latitude_to = isset($customer->latitude)?$customer->latitude:null;
                $longitude_to = isset($customer->longitude)?$customer->longitude:null;

                if ( abs($latitude_from) && abs($longitude_from) && abs($latitude_to) && abs($longitude_to) ) {

                    $geo = new Geo();
                    $distance_in_metres = $geo->greatCircleDistance($latitude_from, $longitude_from, $latitude_to, $longitude_to);

                    $distance_in_kilometres = $distance_in_metres / 1000;
                    if($distance_in_kilometres < $distance_allowed) {
                        $customer->distance = $distance_in_kilometres;
                        $selected_customers[$customer->user_id] = $customer;
                    }
                }
            }

            ksort($selected_customers);


        }

        return $selected_customers;
    }

} // end of class Customers
