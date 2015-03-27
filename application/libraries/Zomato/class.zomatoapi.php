<?php
/**
* Zomato API Class
* API Documentation: http://www.zomato.com/api/documentation
*
* @author Faizan Ayubi
**/
class ZomatoApi
{
	
	/**
	* The Zomato API Key
	*
	*@var string
	*/
	private $_apikey 	= '7749b19667964b87a3efc739e254ada2';
	
	/**
	* The API base URL
	*/
	private $_baseUrl 	= 'https://api.zomato.com/v1/';
	
	/**
	* Store Error
	*
	*@var array
	*/
	private $_error 		= '';
	
	/**
	* Available Data Format
	* @var string
	*/
	private $_apiDataFormat = array('json','xml');
	
	/**
	* Data Format
	* @var string
	*/
	private $_dataformat = '';
	
	/**
	* Default constructor
	* @param array|string $config          Zomato configuration data
	* @return void
	*/
	function __construct($config)
	{
		if(!empty($config['apikey']))		{ $this->setApiKey($config['apikey']); } //Assign the api key if api key not  empty 		
		if(!empty($config['dataformat']) && true === in_array($config['dataformat'], $this->_apiDataFormat))	{ $this->setDataFormat($config['dataformat']); 	} //Assign the return format
		$this->_error = new stdClass; 
		
	}
	public function __call($method, $args)
	{      
		
        if(method_exists($this,$method))
        {
        	return call_user_func_array(array($this, $method), $args);	
        }
        else
        {
        	$this->_error->details ='Method Does Not exist';
        }
       
    }
	/**
	*	[verifyDate description]
	* 	@param 	name 		summary 									type 			required
	*	        date		date										datetime		Required				
	*  	@return boolean
	**/
	private function verifyDate($date)
	{
		return (DateTime::createFromFormat('m-d-Y H:i:s', $date) !== false);
	}
	/**
	*	[validationFields description]
	* 	@param 	name 		summary 									type 			required
	*	        field		Field Name									String			Required
	*			val			Value of Field								String			Required
	*			required	Empty check 0 - Not Required, 1 - Required	Boolean			Optional
	*  	@return boolean
	**/
	private function validationFields($field, $val, $required=false)
	{
		switch($field)
		{
			case 'city id':
				if($required)
				{
					if(empty($val))
					{
						$this->_error->details ='City Id is empty';
						return false;	
					}
					else if(!preg_match('/^[1-9]+[0-9]*$/', $val))
					{
						$this->_error->details ='Invalid City Id';
						return false;	
					}
				}
				else
				{
					if(!empty($val) && !preg_match('/^|[1-9 ]+[0-9]*$/', $val))
					{
						$this->_error->details ='Invalid City Id';
						return false;	
					}
				}
			break;
			case 'lat':
				if($required)
				{
					if(empty($val))
					{
						$this->_error->details ='Latitude is empty';
						return false;	
					}
					else if(!preg_match('/^[0-9\.]+$/', $val))
					{
						$this->_error->details ='Invalid Latitude';
						return false;
					}
				}
				else
				{
					if(!preg_match('/^[0-9\. ]+$/', $val))
					{
						$this->_error->details ='Invalid Latitude';
						return false;
					}				
				}
			
			break;
			case 'lon':
				if($required)
				{
					if(empty($val))
					{
						$this->_error->details ='Longitude is empty';
						return false;	
					}
					else if(!preg_match('/^[0-9\.]+$/', $val))
					{
						$this->_error->details ='Invalid Longitude';
						return false;
					}
				}
				else
				{
					if(!preg_match('/^[0-9\. ]+$/', $val))
					{
						$this->_error->details ='Invalid Longitude';
						return false;
					}				
				}
			break;
			case 'zone id':
				if($required)
				{
					if(empty($val))
					{
						$this->_error->details ='Zone Id is empty';
						return false;	
					}
					else if(!preg_match('/^[1-9]+[0-9]*$/', $val))
					{
						$this->_error->details ='Invalid Zone Id';
						return false;	
					}
				}
				else
				{
					if(!preg_match('/^|[1-9 ]+[0-9]*$/', $val))
					{
						$this->_error->details ='Invalid Zone Id';
						return false;	
					}
				}
			break;
			case 'subzone id':
				if($required)
				{
					if(empty($val))
					{
						$this->_error->details ='Subzone Id is empty';
						return false;	
					}
					else if(!preg_match('/^[1-9]+[0-9]*$/', $val))
					{
						$this->_error->details ='Invalid Subzone';
						return false;	
					}
				}
				else
				{
					if(!preg_match('/^|[1-9 ]+[0-9]*$/', $val))
					{
						$this->_error->details ='Invalid Subzone';
						return false;	
					}
				}
			break;	

			case 'category':
				if($required)
				{
					if(empty($val))
					{
						$this->_error->details ='Category is empty';
						return false;	
					}
					else if(!preg_match('/^[1-3]+$/', $val))
					{
						$this->_error->details ='Invalid Category';
						return false;	
					}
										
				}
				else
				{					
					if($val  !=="" &&  !preg_match('/^[1-3 ]+$/', $val))
					{
						$this->_error->details ='Invalid Category';
						return false;	
					}
				
				}
			break;
			case 'start':

				if($required)
				{
					if(empty($val))
					{
						$this->_error->details ='Start is empty';
						return false;	
					}
					else if(!preg_match('/^[0-9]+$/', $val)) 
					{
						$this->_error->details ='Invalid Start';
						return false;
					}
				}
				else
				{
					if(!empty($val) && !preg_match('/^[0-9]+$/', $val)) 
					{
						$this->_error->details ='Invalid Start';
						return false;
					}
				}
			break;
			case 'count':

				if($required)
				{
					if(empty($val))
					{
						$this->_error->details ='Count is empty';
						return false;	
					}
					else if(!preg_match('/^[1-9]+[0-9]*$/', $val)) 
					{
						$this->_error->details ='Invalid Count';
						return false;
					}
				}
				else
				{					
					if(!preg_match('/^[1-9 ]+[0-9]*$/', $val)) 
					{
						$this->_error->details ='Invalid Count';
						return false;
					}
				}
			break;
			case 'restaurant id';
				if($required)
				{
					if(empty($val))
					{
						$this->_error->details ='Restaurant Id is empty';
						return false;	
					}
					else if(!preg_match('/^[1-9]+[0-9]*$/', $val))
					{
						$this->_error->details ='Invalid Restaurant Id';
						return false;	
					}
				}
				else
				{
					if(!preg_match('/^|[1-9 ]+[0-9]*$/', $val))
					{
						$this->_error->details ='Invalid Restaurant Id';
						return false;	
					}
				}
			break;
			case 'data':
				if($required)
				{
					if(empty($val))
					{
						$this->_error->details ='Data is empty';
						return false;	
					}					
				}		
			break;
			case 'name':
				if($required)
				{
					if(empty($val))
					{
						$this->_error->details ='Name is empty';
						return false;	
					}
					else if(!preg_match('/^[a-z 0-9]+$/i', $val))
					{
						$this->_error->details ='Invalid Name';
						return false;	
					}
				}
				else
				{
					if($val !=='' && !preg_match('/^[a-z 0-9]+$/', $val))
					{
						$this->_error->details ='Invalid Name';
						return false;	
					}
				}
			break;
			case 'queryText':
				if($required)
				{
					if(empty($val))
					{
						$this->_error->details ='Q is empty';
						return false;	
					}
					else if(!preg_match('/^[1-9a-z]+$/i', $val))
					{
						$this->_error->details ='Invalid Q';
						return false;	
					}
				}
				else
				{
					if(!empty($val) && !preg_match('/^|[1-9a-z ]+$/', $val))
					{
						$this->_error->details ='Invalid Q';
						return false;	
					}
				}
			break;
			case 'radius';
				if($required)
				{
					if(empty($val))
					{
						$this->_error->details ='Radius is empty';
						return false;	
					}
					else if(!preg_match('/^[1-9]+[0-9]*$/', $val))
					{
						$this->_error->details ='Invalid Radius';
						return false;	
					}
				}
				else
				{
					if(!preg_match('/^|[1-9 ]+[0-9]*$/', $val))
					{
						$this->_error->details ='Invalid Radius';
						return false;	
					}
				}
			break;
			case 'mincft';
				if($required)
				{
					if(empty($val))
					{
						$this->_error->details ='Mincft is empty';
						return false;	
					}
					else if(!preg_match('/^[0-9]+$/', $val)) 
					{
						$this->_error->details ='Invalid Mincft';
						return false;
					}
				}
				else
				{
					if(!empty($val) && !preg_match('/^[0-9]+$/', $val)) 
					{
						$this->_error->details ='Invalid Mincft';
						return false;
					}
				}
			break;
			case 'maxcft';
				if($required)
				{
					if(empty($val))
					{
						$this->_error->details ='Maxcft is empty';
						return false;	
					}
					else if(!preg_match('/^[0-9]+$/', $val)) 
					{
						$this->_error->details ='Invalid Maxcft';
						return false;
					}
				}
				else
				{
					if(!empty( $val) && !preg_match('/^[0-9]+$/', $val)) 
					{
						$this->_error->details ='Invalid Maxcft';
						return false;
					}
				}
			break;
			case 'minrating';
				if($required)
				{
					if(empty($val))
					{
						$this->_error->details ='Minrating is empty';
						return false;	
					}
					else if(!preg_match('/^[0-9]+$/', $val)) 
					{
						$this->_error->details ='Invalid Minrating';
						return false;
					}
				}
				else
				{
					if(!empty($val) && !preg_match('/^[0-9]+$/', $val)) 
					{
						$this->_error->details ='Invalid Minrating';
						return false;
					}
				}
			break;
			case 'maxrating';
				if($required)
				{
					if(empty($val))
					{
						$this->_error->details ='Maxrating is empty';
						return false;	
					}
					else if(!preg_match('/^[0-9]+$/', $val)) 
					{
						$this->_error->details ='Invalid Maxrating';
						return false;
					}
				}
				else
				{
					if(!empty($val) && !preg_match('/^[0-9]+$/', $val)) 
					{
						$this->_error->details ='Invalid Maxrating';
						return false;
					}
				}
			break;
			case 'cc';
				if($required)
				{
					if(empty($val))
					{
						$this->_error->details ='Cc is empty';
						return false;	
					}
					else if(!preg_match('/^0|1+$/', $val)) 
					{
						$this->_error->details ='Invalid Start';
						return false;
					}
				}
				else
				{
					if(!preg_match('/^[0-1 ]+$/', $val)) 
					{
						$this->_error->details ='Invalid Cc';
						return false;
					}
				}
			break;
			case 'bar';
				if($required)
				{
					if(empty($val))
					{
						$this->_error->details ='Bar is empty';
						return false;	
					}
					else if(!preg_match('/^0|1+$/', $val)) 
					{
						$this->_error->details ='Invalid Bar';
						return false;
					}
				}
				else
				{
					if(!empty($val) && !preg_match('/^[0-1]+$/', $val)) 
					{
						$this->_error->details ='Invalid Bar';
						return false;
					}
				}
			break;
			case 'veg';
				if($required)
				{
					if(empty($val))
					{
						$this->_error->details ='Veg is empty';
						return false;	
					}
					else if(!preg_match('/^0|1+$/', $val)) 
					{
						$this->_error->details ='Invalid Veg';
						return false;
					}
				}
				else
				{
					if(!empty($val) && !preg_match('/^[0-1]+$/', $val)) 
					{
						$this->_error->details ='Invalid Veg';
						return false;
					}
				}
			break;
			case 'open';
				if($required)
				{
					if(empty($val))
					{
						$this->_error->details ='Open is empty';
						return false;	
					}
					else if(!$this->verifyDate($val)) 
					{
						$this->_error->details ='Invalid Open';
						return false;
					}
				}
				else
				{
					if(!empty($val) &&  !$this->verifyDate($val)) 
					{
						$this->_error->details ='Invalid Open';
						return false;
					}
				}
			break;
			case 'buffet';
				if($required)
				{
					if(empty($val))
					{
						$this->_error->details ='Buffet is empty';
						return false;	
					}
					else if(!preg_match('/^0|1+$/', $val)) 
					{
						$this->_error->details ='Invalid Buffet';
						return false;
					}
				}
				else
				{
					if(!empty($val) &&  !preg_match('/^[0-1]+$/', $val)) 
					{
						$this->_error->details ='Invalid Buffet';
						return false;
					}
				}
			break;
			case 'happyhour';
				if($required)
				{
					if(empty($val))
					{
						$this->_error->details ='Happyhour is empty';
						return false;	
					}
					else if(!preg_match('/^0|1+$/', $val)) 
					{
						$this->_error->details ='Invalid Happyhour';
						return false;
					}
				}
				else
				{
					if(!preg_match('/^[0-1 ]+$/', $val)) 
					{
						$this->_error->details ='Invalid Happyhour';
						return false;
					}
				}
			break;
			case 'cuisine id':
				if($required)
				{
					if(empty($val))
					{
						$this->_error->details ='Cuisine Id is empty';
						return false;	
					}
					else if(!preg_match('/^[1-9]+[0-9]*$/', $val))
					{
						$this->_error->details ='Invalid Cuisine Id';
						return false;	
					}
				}
				else
				{
					if(!preg_match('/^|[1-9 ]+[0-9]*$/', $val))
					{
						$this->_error->details ='Invalid Cuisine Id';
						return false;	
					}
				}
			break;
		}
		return true;
	}
	/**
	*	[where description]
	* 	@param 	name 		summary 							type 			required
	*	        arrWhere	Prepare the Params for request		Array String	required				
	*  	@return string
	**/
	private function where($arrWhere = array())
	{
		$query = '';
		foreach($arrWhere as $key=>$value)
		{
			if(!empty($value) && $value !== 0)
			{
				if(empty($query))
				{
					$query = '?'.$key .'='. $value;
				}
				else
				{
					$query .= '&'.$key .'='. $value;	
				}
			}
		}
		return $query;
	}
	/**
	*	[getRequest description]
	* 	@param 	name 	summary 							type 	required
	*	        url		API Request URL	with params			String	required	*			
	*   @return xml/json      xml or json depend on the $this->_dataformat;
	**/
	private function getRequest($url)
	{

		$ch = curl_init($url);
		$timeout = 5; // set to zero for no timeout
		$customHeader = array('X-Zomato-API-Key:'.$this->getApiKey());
		curl_setopt($ch, CURLOPT_URL, $url);		
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $customHeader);
		$result = curl_exec($ch);		
		curl_close($ch);
		return $result;
	}
	/**
	*	[postRequest description]
	* 	@param 	name 	summary 					type 	required
	*	        url		API Request URL				String	required
	*			data	Post Data					Array String	required
	*   @return xml/json      xml or json depend on the $this->_dataformat;
	**/
	private function postRequest($url, $data = array())
	{
		$fields_string = "";
		foreach($data as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		rtrim($fields_string, '&');		
		
		$ch = curl_init($url);
		$timeout = 5; // set to zero for no timeout
		$customHeader = array('X-Zomato-API-Key:'.$this->getApiKey());
		curl_setopt($ch, CURLOPT_URL, $url);		
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $customHeader);
		curl_setopt($ch, CURLOPT_POST, count($data));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
		$result = curl_exec($ch);		
		curl_close($ch);
		return $result;
	
	}
	/**
	*	[responseAnalyse description]
	* 	@param 	name 	summary 					type 	required
	*	        content	JSON content return API 	String	required
	*  	@return array
	**/
	private function responseAnalyse($output)
	{
		switch($this->getDataFormat())
		{ 
			case 'json':			
				$arrData = json_decode($output);
				if(isset($arrData->status))
				{
					$this->_error = $arrData;
					return false;
				}
				else
				{
					return $arrData;
				}
			break;
			case 'xml':			
			$arrData = simplexml_load_string($output);			
			if(isset($arrData->status))
			{
				$this->_error = $arrData;
				return false;
			}
			else
			{
				return $arrData;
			}
		}
	}
	/**
	*	[getError description]
	* 	@param 	name 	method 	summary type 	required
	*	        None	None	None	None	None
	*  	@return object
	**/
	function getError()
	{
		return $this->_error;
	}
	/**
	*	[printError description]
	* 	@param 	name 	method 	summary type 	required
	*	        None	None	None	None	None
	*  	@return void
	**/
	function printError()
	{
		echo '<pre>';
		print_r($this->_error);
		echo '</pre>';
	}
	/**
	*	[getAllCity description]
	* 	@param 	name 	method 	summary type 	required
	*	        None	None	None	None	None
	*  @return xml/json      xml or json depend on the $this->_dataformat;
	**/
	function getAllCity()
	{		
		$url =  $this->_baseUrl . 'cities.'. $this->getDataFormat();
		$retResult = $this->getRequest($url);
		return $this->responseAnalyse($retResult);

	}
	/**
	*	[getLocalityFromCoordinates description]
	* 	@param 	name 	method 	summary 			type 	required
	*	        lat		GET		Device latitude		double	Required
	*	        lon		GET		Device longitude	double	Required
	*   @return xml/json      xml or json depend on the $this->_dataformat;
	**/
	function getLocalityFromCoordinates($lat = '', $lon = '')
	{
		
		if(!$this->validationFields('lat', $lat, true) || !$this->validationFields('lon', $lon, true)){	return false; }	
		$where = $this->where(array('lat'=>$lat, 'lon'=> $lon));
		$url =  $this->_baseUrl . 'geocode.'.$this->getDataFormat() . $where;		
		$retResult = $this->getRequest($url);
		return $this->responseAnalyse($retResult);		
	}
	/**
	*	[getZonesInCity description]
	* 	@param 	name 	summary 	type 	required
	*  	        cityId	City id		int		Required
	*   @return xml/json      xml or json depend on the $this->_dataformat;
	**/
	function getZonesInCity($cityId = '')
	{		
		if(!$this->validationFields('city id', $cityId, true))	{ return false;	}
		$where = $this->where(array('city_id'=>$cityId));
		$url =  $this->_baseUrl . 'zones.'.$this->getDataFormat().$where;		
		$retResult = $this->getRequest($url);
		return $this->responseAnalyse($retResult);		
	}
	/**
	*	[getLocalitiesInCity description]
	* 	@param 	name 			summary 	type 	required
	*  	        city_id			city id		int		Required
	*   @return xml/json      xml or json depend on the $this->_dataformat;
	**/
	function getLocalitiesInCity($cityId = '')
	{
		if(!$this->validationFields('city id', $cityId, true))	{	return false;	}
		$where = $this->where(array('city_id'=>$cityId));
		$url =  $this->_baseUrl . 'subzones.'.$this->getDataFormat().$where;	
		$retResult = $this->getRequest($url);	
		return $this->responseAnalyse($retResult);		
	}
	/**
	*	[getLocalitiesZone description]
	* 	@param name 	summary 	type 	required
	*  	       zone_id	Zone id		int		Required
	*   @return xml/json      xml or json depend on the $this->_dataformat;
	**/
	function getLocalitiesZone($zoneId = '')
	{		
		if(!$this->validationFields('zone id', $zoneId, true)){ return false;	}
		$where = $this->where(array('zone_id'=>$zoneId));
		$url =  $this->_baseUrl . 'subzones.'.$this->getDataFormat().$where;
		$retResult = $this->getRequest($url);	
		return $this->responseAnalyse($retResult);	
	}
	/**
 	* [getCuisinesByCityId description]
	* @param   name 		summary 								type 	required
	*		   city_id		City id									int		Required
	* @return xml/json      xml or json depend on the $this->_dataformat;
	*/
	function getCuisinesByCityId($cityId = '')
	{		
		if(!$this->validationFields('city id', $cityId, true)){ return false;	}
		$where = $this->where(array('city_id'=>$cityId));
		$url =  $this->_baseUrl . 'cuisines.'.$this->getDataFormat(). $where;
		$retResult = $this->getRequest($url);
		return $this->responseAnalyse($retResult);
	}
	/**
	* [getRestaurantsInZone description]
	* @param  	name		summary													type    required
	* 			city_id		city id													int		Required
	* 			zone_id		Zone id													int		Required
	* 			category	1 for Delivery, 2 for Dineout, 3 for Nightlife. 		int		Optional
	* 						Skip this to get all results	
	* 			start		The starting location within results from which 		int		Optional
	* 						the results should be fetched. Default is 0	
	* 			count		The number of results to fetch. Default is 10, 			int		Optional	
	* 						max is 50.	
	* @return xml/json      xml or json depend on the $this->_dataformat;
	*/	
	function getRestaurantsInZone($cityId = '', $zoneId = '', $category = '', $start = 0, $count = 10)
	{		
		if(!$this->validationFields('city id', $cityId, true)){ return false;	}	
		if(!$this->validationFields('zone id', $zoneId, true)){ return false;	}		
		if(!$this->validationFields('category', $category, false)){ return false;	}
		if(!$this->validationFields('start', $start, false)){ return false;	}
		if(!$this->validationFields('count', $count, false)){ return false;	}
		$where = $this->where(array('city_id'=> $cityId,'zone_id'=>$zoneId, 'category'=> $category, 'start'=> $start, 'count'=> $count));
		$url =  $this->_baseUrl . 'search.'.$this->getDataFormat().$where;
		$retResult = $this->getRequest($url);
		return $this->responseAnalyse($retResult);	
	}
	/**
	* [getRestaurantsInLocality description]
	* @param 	name 		summary 													type 	required  
	*			city_id		City id														int		Required
	*			subzone_id	Subzone id													int		Required
	*			category	1 for Delivery, 2 for Dineout, 3 for Nightlife. 			int		Optional
	*						Skip this to get all results	
	*			start		The starting location within results from which 			int		Optional
	*						the results should be fetched. Default is 0	
	*			count		The number of results to fetch. Default is 10, max is 50	int		Optional
	* @return xml/json      xml or json depend on the $this->_dataformat;
	**/
	function getRestaurantsInLocality($cityId = '', $subzoneId = '', $category = '', $start = 0, $count = 10)
	{		
		if(!$this->validationFields('city id', $cityId, true)){ return false;	}	
		if(!$this->validationFields('subzone id', $subzoneId, true)){ return false;	}
		if(!$this->validationFields('category', $category, false)){ return false;	}
		if(!$this->validationFields('start', $start, false)){ return false;	}
		if(!$this->validationFields('count', $count, false)){ return false;	}
		$where = $this->where(array('city_id'=>$cityId, 'subzone_id'=> $subzoneId ,'category'=> $category, 'start'=> $start, 'count'=> $count));		
		$url =  $this->_baseUrl . 'search.'.$this->getDataFormat(). $where;
		$retResult = $this->getRequest($url);
		return $this->responseAnalyse($retResult);	
	}
	/**
	* [getRestaurantDetails description]
	* @param   name 			summary 			type 	required
	*          restaurantId		restaurant Id		int		Required
	*  @return xml/json      xml or json depend on the $this->_dataformat;
	**/
	function getRestaurantDetails($restaurantId = '')
	{
		if(!$this->validationFields('restaurant id', $restaurantId, true)){  return false;	}			
		$url =  $this->_baseUrl . 'restaurant.'.$this->getDataFormat().'/'.$restaurantId;
		$retResult = $this->getRequest($url);
		//echo '$url'.$url;
		return $this->responseAnalyse($retResult);			
	}
	/**
	* [getReviewsForRestaurant description]
	* @param  	name 			summary 													type 	required
	*			restaurantId	restaurant Id												int		Required.
	*         	start			The starting location within results from 					int		Optional
	*         					which the results should be fetched. Default is 0	
	*	      	count			The number of results to fetch. Default is 10, max is 50	int		Optional
	* @return xml/json      xml or json depend on the $this->_dataformat;
	*/
	function getReviewsForRestaurant($restaurantId = '', $start = 0, $count = 10)
	{	
		if(!$this->validationFields('restaurant id', $restaurantId, true)){ return false;	}
		if(!$this->validationFields('start', $start, false)){ return false;	}
		if(!$this->validationFields('count', $count, false)){ return false;	}
		$where = $this->where(array('start'=>$start, 'count'=> $count));		
		$url =  $this->_baseUrl . 'reviews.'.$this->getDataFormat().'/'.$restaurantId.'/user'. $where;
		
		$retResult = $this->getRequest($url);	
		return $this->responseAnalyse($retResult);			
	}
	/**
	* [postErrorInRestaurantDetails description]
	* @param  	
	*		name 		summary 					type 	required
	*		res_id		User email					int		Required
	*		data		Error in restaurant data	string	Required
	*		name		User name					string	Optional
	*  @return xml/json      xml or json depend on the $this->_dataformat;
	**/
	function postErrorInRestaurantDetails($res_id = '', $changeData = '', $name = '')
	{
		if(!$this->validationFields('restaurant id', $res_id, true)){ return false;	}
		if(!$this->validationFields('data', $changeData, true)){ return false;	}
		if(!$this->validationFields('name', $name, false)){ return false;	} 		
			
		$url =  $this->_baseUrl . 'contact.'.$this->getDataFormat();		
		$retResult = $this->postRequest($url, array('res_id'=> $res_id, 'data'=> $changeData, 'name' => $name));	
		return $this->responseAnalyse($retResult);	
	
	}
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
	*  @return xml/json      xml or json depend on the $this->_dataformat;
	**/
	function getRestaurantsByCuisine($cityId = '', $cuisineId = '', $category= '', $start = 0, $count = 10, $mincft = '', $maxcft = '', $minrating = '', $maxrating = '', $cc = 0, $bar = 0, $veg = 0, $open  = '', $buffet = 0, $happyhour = 0)
	{
		if(!$this->validationFields('city id', $cityId, true)){ return false;	}
		if(!$this->validationFields('cuisine id', $cuisineId, true)){ return false;	}
		if(!$this->validationFields('category', $category, false)){ return false;	}
		if(!$this->validationFields('mincft', $mincft, false)){ return false;	}
		if(!$this->validationFields('maxcft', $maxcft, false)){ return false;	}
		if(!$this->validationFields('minrating', $minrating, false)){ return false;	}
		if(!$this->validationFields('maxrating', $maxrating, false)){ return false;	}
		if(!$this->validationFields('cc', $cc, false)){ return false;	}
		if(!$this->validationFields('bar', $bar, false)){ return false;	}
		if(!$this->validationFields('veg', $veg, false)){ return false;	}
		if(!$this->validationFields('open', $open, false)){ return false;	}
		if(!$this->validationFields('buffet', $buffet, false)){ return false;	}
		if(!$this->validationFields('happyhour', $happyhour, false)){ return false;	}
		if(!$this->validationFields('start', $start, false)){ return false;	}
		if(!$this->validationFields('count', $count, false)){ return false;	}
		$where = $this->where(array('city_id' => $cityId, 'cuisine_id' => $cuisineId, 'category' => $category, 'start' => $start, 'count' => $count, 'mincft' => $mincft,  'maxcft' =>$maxcft, 'minrating' => $minrating,  'maxrating' => $maxrating, 'cc' => $cc, 'bar' => $bar, 'veg' => $veg, 'open'  => $open, 'buffet' => $buffet, 'happyhour' => $happyhour));
		$url =  $this->_baseUrl . 'search.'.$this->getDataFormat().$where;
		$retResult = $this->getRequest($url);
		return $this->responseAnalyse($retResult);				
	}
	/**
	* [getRandomRestaurantNearLocation description]
	* @param  	name 		summary 											type 	required
	*           lat			Device latitude										double	Required
	* 			lon			Device longitude									double	Required
	* 			city_id		City id												int		Required
	* 			random		Set this to true									bool	Required
	* 			radius		Radius within which to search(in meters)			integer	Optional
	* 			cuisine_id	Cuisine id	int	Required
	* 			category	1 for Delivery, 2 for Dineout, 3 for Nightlife.		int		Optional 
	* 								Skip this to get all results	
	* 			start		The starting location within results from which 	int		Optional
	* 								the results should be fetched. Default is 0	
	* 			count		The number of results to fetch. Default is 10, 		int		Optional
	* 								max is 50	
	* 			mincft		Filter restaurants where average cost for two is 			Optional
	* 								less than this value		
	* 			maxcft		Filter restaurants where average cost for two is 			Optional
	* 								above this value		
	* 			minrating	Filter restaurants with rating less than this value			Optional
	* 			maxrating	Filter restaurants with rating above this value				Optional
	* 			cc			Set 1 to check if credit cards are accepted else 0	int		Optional
	* 			bar			Set 1 to check if restaurant has a bar else 0		int		Optional
	* 			veg			Set 1 to check if restaurant is pure veg else 0		int		Optional
	* 			open		Set 'now' to check if restaurant is open			string	Optional
	* 			buffet		Set 1 to check if restaurant has a buffet else 0	int		Optional
	* 			happyhour	Set 1 to check if restaurant has happy hours else 0	int		Optional
	*  @return xml/json      xml or json depend on the $this->_dataformat;
	**/
	function getRandomRestaurantNearLocation($lat = '', $lon = '', $cityId = '', $radius = '', $cuisine_id = '', $category = '', $start = '', $count = '', $mincft = '', $maxcft = '', $minrating = '', $maxrating = '', $cc = '', $bar = '', $veg = '', $open = '', $buffet = '', $happyhour = '')
	{
		if(!$this->validationFields('lat', $lat, true) || !$this->validationFields('lon', $lon, true)){	return false; }	
		if(!$this->validationFields('city id', $cityId, true)){ return false; }	
		if(!$this->validationFields('radius', $radius, false)){ return false;	}
		if(!$this->validationFields('cuisine id', $cuisineId, false)){ return false;	}
		if(!$this->validationFields('category', $category, false)){ return false;	}
		if(!$this->validationFields('start', $start, false)){ return false;	}
		if(!$this->validationFields('count', $count, false)){ return false;	}
		if(!$this->validationFields('mincft', $mincft, false)){ return false;	}
		if(!$this->validationFields('maxcft', $maxcft, false)){ return false;	}
		if(!$this->validationFields('minrating', $minrating, false)){ return false;	}
		if(!$this->validationFields('cc', $cc, false)){ return false;	}
		if(!$this->validationFields('bar', $bar, false)){ return false;	}
		if(!$this->validationFields('veg', $veg, false)){ return false;	}
		if(!$this->validationFields('open', $open, false)){ return false;	}
		if(!$this->validationFields('buffet', $buffet, false)){ return false;	}
		if(!$this->validationFields('happyhour', $happyhour, false)){ return false;	}
			
		$where = $this->where(array('random'=>true,'city_id' => $cityId, 'cuisine_id' => $cuisineId, 'category' => $category, 'start' => $start, 'limit' => $limit, 'mincft' => $mincft,  'maxcft' => $maxcft, 'minrating' => $minrating,  'maxrating' => $maxrating, 'cc' => $cc, 'bar' => $bar, 'veg' => $veg, 'open'  => $open, 'buffet' => $buffet, 'happyhour' => $happyhour));
		
		$url =  $this->_baseUrl . 'search./'.$this->getDataFormat().'near'.$where; 
		$retResult = $this->getRequest($url);	
		return $this->responseAnalyse($retResult);		
	}
	/**
	* [searchRestaurants description]
	* @param  	name 		summary 														type 	required
	*			city_id		The city from which search results are to be returned.					Required
	*			q			query for keyword search												Optional
	*			lat			Latitude of the point near which search is to be made.					Optional
	*			lon			Longitude of the point near which search is to be made.					Optional
	*			mincft		Filter restaurants where average cost for two is less 					Optional
	*						than this value		
	*			maxcft		Filter restaurants where average cost for two is above 					Optional
	*						this value		
	*			minrating	Filter restaurants with rating less than this value						Optional
	*			maxrating	Filter restaurants with rating above this value							Optional
	*			start		Offset from the start of results. For e.g. if you require 				Optional
	*						results starting from the 10th result onwards, pass start=10		
	*			count		Number of results to be returned, default is 10, max is 50				Optional
	*			cuisines	cuisine id	int	Optional
	*			cc			Set 1 to check if credit cards are accepted else 0				int		Optional
	*			bar			Set 1 to check if restaurant has a bar else 0					int		Optional
	*			veg			Set 1 to check if restaurant is pure veg else 0					int		Optional
	*   		open		Set 'now' to check if restaurant is open						string	Optional
	*			buffet		Set 1 to check if restaurant has a buffet else 0				int		Optional
	*			happyhour	Set 1 to check if restaurant has happy hours else 0				int		Optiona
	*@return xml/json      xml or json depend on the $this->_dataformat;
	*/	
	function searchRestaurants($cityId = '', $queryText = '', $lat = '', $lon = '', $mincft = '', $maxcft = '', $minrating = '', $maxrating = '', $start = '', $count = '', $cuisines = '',  $cc = '', $bar = '', $veg = '', $open = '', $buffet = '', $happyhour = '' )
	{
		
		if(!$this->validationFields('city id', $cityId, true)){ return false;	}
		if(!$this->validationFields('queryText', $queryText, false)){ return false;	}
		if(!$this->validationFields('lat', $lat, false)){ return false;	}
		if(!$this->validationFields('lon', $lon, false)){ return false;	}
		if(!$this->validationFields('mincft', $mincft, false)){ return false;	}
		if(!$this->validationFields('maxcft', $maxcft, false)){ return false;	}
		if(!$this->validationFields('minrating', $minrating, false)){ return false;	}
		if(!$this->validationFields('maxrating', $maxrating, false)){ return false;	}
		if(!$this->validationFields('start', $start, false)){ return false;	}
		if(!$this->validationFields('count', $count, false)){ return false;	}
		if(!$this->validationFields('cuisines', $cuisines, false)){ return false;	}
		if(!$this->validationFields('cc', $cc, false)){ return false;	}
		if(!$this->validationFields('bar', $bar, false)){ return false;	}
		if(!$this->validationFields('veg', $veg, false)){ return false;	}
		if(!$this->validationFields('open', $open, false)){ return false;	}
		if(!$this->validationFields('buffet', $buffet, false)){ return false;	}
		if(!$this->validationFields('happyhour', $happyhour, false)){ return false;	}

		$where = $this->where(array('q' => $queryText, 'random'=>true,'city_id' => $cityId, 'cuisine_id' => $cuisineId, 'category' => $category, 'start' => $start, 'limit' => $limit, 'mincft' => $mincft,  'maxcft' => $maxcft, 'minrating' => $minrating,  'maxrating' => $maxrating, 'cc' => $cc, 'bar' => $bar, 'veg' => $veg, 'open'  => $open, 'buffet' => $buffet, 'happyhour' => $happyhour));

		$url =  $this->_baseUrl . 'search.'.$this->getDataFormat(). $where; 
		$retResult = $this->getRequest($url);
		return $this->responseAnalyse($retResult);	
	}
	/**
	* [getNearByRestaurants description]
	*  name 		summary 														type 	required
	*  lat			Latitude of the point near which search is to be made.					Required
	*  lon			Longitude of the point near which search is to be made.					Required
	*  start		Offset from the start of results. For e.g. if you require 
	*  				results starting from the 10th result onwards, pass start=10			Optional
	*  count		Number of results to be returned, max is 50		Optional
	*  mincft		Filter restaurants where average cost for two is less than 				Optional
	*  				this value	
	*  maxcft		Filter restaurants where average cost for two is above 					Optional
	*  				this value		
	*  minrating	Filter restaurants with rating less than this value						Optional
	*  maxrating	Filter restaurants with rating above this value							Optional
	*  Returned Fields 
	*  @return xml/json      xml or json depend on the $this->_dataformat;
	*/
	function getNearByRestaurants($lat = '', $lon = '', $start = '', $count = '', $mincft = '', $maxcrf = '', $minrating = '', $maxrating = '')
	{
		if(!$this->validationFields('lat', $lat, true) || !$this->validationFields('lon', $lon, true)){	return false; }	
		if(!$this->validationFields('start', $start, false)){ return false;	}
		if(!$this->validationFields('count', $count, false)){ return false;	}
		if(!$this->validationFields('mincft', $mincft, false)){ return false;	}
		if(!$this->validationFields('maxcft', $mincft, false)){ return false;	}
		if(!$this->validationFields('minrating', $mincft, false)){ return false;	}
		if(!$this->validationFields('maxrating', $mincft, false)){ return false;	}
		
		
		$where = $this->where(array('lat' => $lat, 'lon' => $lon, 'start' => $start, 'count' => $count, 'mincft' => $mincft, 'maxcft' => $maxcft, 'minrating' => $minrating, 'maxrating' => $maxrating));
		$url =  $this->_baseUrl . 'search.'.$this->getDataFormat().'/near'.$where; 
		$retResult = $this->getRequest($url);
		return $this->responseAnalyse($retResult);	
	}
	/**
	* API-key Setter
	*
	* @param string $apiKey
	* @return void
	*/
	public function setApiKey($apiKey) 
	{
		$this->_apikey = $apiKey;
	}	
	/**
	* API Key Getter
	*
	* @return string
	*/
	public function getApiKey() 
	{
		return $this->_apikey;
	}
	/**
	*API Data Format Setter
	*
	*@param string $format
	*@return void
	*/
	public function setDataFormat($dataformat)
	{
		$this->_dataformat = $dataformat;
	}
	/**
	*API Data Format getter
	*
	*@return string
	*/
	public function getDataFormat()
	{
		return $this->_dataformat;
	}
}

