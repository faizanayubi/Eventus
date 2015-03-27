<?php

require_once 'class.zomatoapi.php';

$objZomatoApi = new ZomatoApi(array('apikey'=>'7749b19667964b87a3efc739e254ada2','dataformat'=>'xml'));
/**
	* [getRestaurantsByCuisine description]
	* @param  
    * 			name 			summary 												type 	required
	* 			city_id			City id													int		Required
	* 			cuisine_id		Cuisine id												int		Required
	* 			category		1 for Delivery, 2 for Dineout, 3 for Nightlife. 		int		Optional
	* 							Skip this to get all results	
	* 			start			The starting location within results from which 		int		Optional
	* 							the results should be fetched. Default is 0	
	* 			count			The number of results to fetch. Default is 10, 			int		Optional	
	* 							max is 50	
	* 			mincft			Filter restaurants where average cost for two is 				Optional
	* 							less than this value										
	* 			maxcft			Filter restaurants where average cost for two is 				Optional
	* 							above this value		
	* 			minrating		Filter restaurants with rating less than this 					Optional
	* 							value		
	* 			maxrating		Filter restaurants with rating above this value					Optional
	* 			cc				Set 1 to check if credit cards are accepted else 0		int		Optional
	* 			bar				Set 1 to check if restaurant has a bar else 0			int		Optional
	* 			veg				Set 1 to check if restaurant is pure veg else 0			int		Optional
	* 			open			Set 'now' to check if restaurant is open				string	Optional
	* 			buffet			Set 1 to check if restaurant has a buffet else 0		int		Optional
	* 			happyhour		Set 1 to check if restaurant has happy hours else 0		int		Optional
	* @return [type]             [description]
	**/
$data = $objZomatoApi->getRestaurantsByCuisine(1,2);
if($data)
{
	echo '<pre>';
	print_r($data);
	echo '</pre>';
}
else
{
	$error = $objZomatoApi->getError();
	echo '<pre>';
	print_r($error);
	echo '</pre>';
}




?>