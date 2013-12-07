<?php
/*
Author: Lu Chen 
Date: 07/12/2013 
Usage: Search from Flickr 

Key:
b2e7c3b94dd6587a6165e010fa4e75ee

Secret:
40c3072fbc92a229
*/
class Flickr 
{
	private $apiKey = 'b2e7c3b94dd6587a6165e010fa4e75ee';
	private $apiSecret = '40c3072fbc92a229';
	
	public function __construct() 
	{
	
	}
	
	public function search($query, $page = null) 
	{
		if(empty($query)) {
			return 1; 
		}
		
		if(empty($page) || intval($page) == 0) {
			$page = 1; 
		}
		
		$search = 'http://flickr.com/services/rest/?method=flickr.photos.search&api_key=' . $this->apiKey . '&text=' . urlencode($query) . '&per_page=5&page=' . intval($page) . '&format=php_serial';
		$result = unserialize(file_get_contents($search)); 
		return $result; 
	}
	
	public function __destruct()
	{

	}
}
?>