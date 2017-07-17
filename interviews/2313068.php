<?php
$html = file_get_contents('http://archive-grbj-2.s3-website-us-west-1.amazonaws.com/'); //get the html returned from the following url

$pk_doc = new DOMDocument();

libxml_use_internal_errors(TRUE); //disable libxml errors
$pk_list = array();
$pk_title_list = array();
$pk_name_list = array();

if(!empty($html)){ //if any html is actually returned

	$pk_doc->loadHTML($html);
	libxml_clear_errors(); 
	
	$pk_xpath = new DOMXPath($pk_doc);
	
	
	$pk_and_type = $pk_xpath->query('//div[@id="section-1"]');

	if($pk_and_type->length > 0){	

		foreach($pk_and_type as $pat){
			//get all Article Title
			$article_title_row = $pk_xpath->query('//h2[@class="headline"]', $pat);
			if($article_title_row->length > 0){
				foreach($article_title_row as $row){
					$pk_title_list[] = array('Title' => $row->nodeValue);
				}
			}
			
			//get all Author Name
			$pk_name_row = $pk_xpath->query('//div[@class="author"]', $pat);

			if($pk_name_row->length > 0){
				foreach($pk_name_row as $row){
					$pk_name_list[] = array('Name' => $row->nodeValue);
				}
			}



			$pk_list[] = array('Article'=>$pk_title_list,'Author' => $pk_name_list);
		}
	}
//Output
echo "<pre>";
print_r($pk_list);
echo "</pre>";
}
?>
