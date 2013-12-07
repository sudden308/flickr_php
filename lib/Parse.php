<?php
/*
Author: Lu Chen
Date: 07/12/2013
Usage: Template parser of my small MVC
*/

class Parse 
{
	private $templateFile; 
	private $templateContent; 
	private $patternOfImage = '/(IF\[IMAGE_FOREACH\]\s*\{)(\s*\<table\s*.+?\>\s*?.*?)({!IMAGE_FOREACH!})(\s*?.*?\<\/table\>\s*?)(\})/';
	private $patternOfError = '/(IF\[ERROR\]\s*\{)(\s*\<div\s*.+?\>\s*?.*?)({!ERROR!})(\s*?.*?\<\/div\>\s*?)(\})/';
	private $initialized = false; //It is not good to reload this file every time 
	
	public function __construct($template)
	{
		$this->templateFile = $template; 

	}
	
	public function initialize()
	{
		$this->templateContent = file_get_contents($this->templateFile);
		if($this->templateContent === FALSE) {
			throw('Parse cannot access the template file.');
			$this->templateContent = '';
		}
		
		$this->initialized = true; 
	}
	
	public function renderInitialPageWithoutImage()
	{
		if($this->initialized === false) {
			$this->initialize(); 
		}
		$this->templateContent = preg_replace($this->patternOfImage, '', $this->templateContent);
		$this->templateContent = preg_replace($this->patternOfError, '', $this->templateContent);
		
		echo $this->templateContent; 
	}
	
	public function getTemplateFile()
	{
		return $this->templateFile;
	}
	
	public function setTemplateFile($template)
	{
		$this->templateFile = $template;
	}
	
	public function getTemplateContent()
	{
		return $this->templateContent; 
	}
	
	public function setTemplateContent($templateContent) 
	{
		$this->templateContent = $templateContent;
	}
	
	//Parse IMAGE_FOREACH 
	public function parseImageForeach($parse = false, $replacment)
	{
		if($this->initialized === false) {
			$this->initialize(); 
		}
		if($parse === true){
			//start parse 
			$this->templateContent = preg_replace($this->patternOfImage, '$2'.$replacment.'$4', $this->templateContent);
			//remove error
			$this->templateContent = preg_replace($this->patternOfError, '', $this->templateContent);
			
			echo $this->templateContent; 
		}else {
			//remove the parse tag still render the page properly
			$this->templateContent = preg_replace($this->patternOfImage, '', $this->templateContent);
			$this->templateContent = preg_replace($this->patternOfError, '$2'.$replacment.'$4', $this->templateContent);
			
			echo $this->templateContent; 
		}
	}
}
?>