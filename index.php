<?php
include "classes/Customers.php";

# Coordinates of dublin office
$destination_coordinates = [53.3381985, -6.2592576];

# Customers within this range in kilometers
$distance_allowed = 100; # default value

# optional
# @param int distance
if(isset($_GET['distance']) && is_numeric($_GET['distance'])) {
	$distance_allowed = $_GET['distance'];
}

# Customers class object
$customers = new Customers('customer.json');

# getting customers with in the limit passed
$selected_customers = $customers->getCustomersWithinLimit($destination_coordinates, $distance_allowed);

# Print selected customer(s)
if($selected_customers) {
	foreach($selected_customers as $customer) {
		echo $customer->user_id . " " . ($customer->name?$customer->name:'N/A') . " (" . number_format($customer->distance, 1) . "km)<br>";
	}
} else {
	echo "No Customer found";
}

?>