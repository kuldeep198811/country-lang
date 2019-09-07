<?php
/* 
used Single Responsibility Principle 
used PHP7
used my best practices for clean coding 
using echo to print output one-by-one same like commands output
use of namespace 
*/
namespace Api;

class LanguageGroupCheck{
	
	private $_countryX, $_countryY;
	public  $_reqeustURL;
	
	/* use of scalar type declaration PHP7 */
	public function __construct(int $argc, array $argv){
				
		if (isset($argc) && is_int($argc) && $argc > 0) {
			
			/* us of coalescing operator php7 */
			$this->_countryX	=	ucfirst(strtolower($argv[1] ?? ''));
			$this->_countryY	=	ucfirst(strtolower($argv[2] ?? ''));

			/* validation */
			if($this->_countryX == "" && $this->_countryY == ""){
				
				$this->__formatOutPutMsg("Country name can't be blank! Please enter any country name", "error:");
				
			}else if(($this->_countryX != "" && !preg_match('/[a-zA-Z]/', $this->_countryX)) || ($this->_countryY != "" && !preg_match('/[a-zA-Z]/', $this->_countryY))){
				
				$this->__formatOutPutMsg("Invalid value! Only country name allowed. E.g. Balgium, Germany, Inida, Spain, etc.", "error:");
				
			}else{
				
				//all good to go further
				
			}
			
			/* if only a county is passing */
			if($this->_countryX !== "" && $this->_countryY == ""){
				$this->__similarSpeakingLangCntry();
			}
			
			/* if two countries are passing */
			if($this->_countryX !== "" && $this->_countryY != ""){
				$this->__checkSimilarSpeakingLangCntry();
			}
			
		}
	
	}
	
	/* similar speaking language countries */
	private function __similarSpeakingLangCntry() {
		
		try{
			$this->_reqeustURL	=	"https://restcountries.eu/rest/v2/name/{$this->_countryX}?fullText=true";
			$_arrCountryInfo 	=	$this->__getRestData();
			
					$_strMsg	=	'';
			if(!empty($_arrCountryInfo)){
				foreach($_arrCountryInfo[0]->languages as $_key=>$_arrLangInfo){
					
					$_strLangCode	= 	$_arrLangInfo->iso639_1;
					$_strCntryName	=	$_arrLangInfo->name;
					
					$_strMsg 	.=	"\nCountry {$_strCntryName} language code: {$_strLangCode} \n";	
							
					$this->_reqeustURL		=	"https://restcountries.eu/rest/v2/lang/{$_strLangCode}";
					$_arrSimiliarLangCntry	=	$this->__getRestData();
								
					$_strMsg 	.=	"\n{$this->_countryX} speaks same language ({$_strCntryName}) with these countries : ".implode(array_column($_arrSimiliarLangCntry, 'name'), ', ');
										
					
				}
				
				$this->__formatOutPutMsg($_strMsg, "Result:\n");
				
			}else{
				
				$this->__formatOutPutMsg("No data found! Please check entered country name.", "error:");
				
			}
			
		} catch (Exception $_e) {
			echo 'Caught exception: ',  $_e->getMessage(), "\n";
		} finally{
			
		}
	
	}
	
	/* check similar speaking language country */
	private function __checkSimilarSpeakingLangCntry(){
		
		try{
			/* get data for first country */
			$this->_reqeustURL	=	"https://restcountries.eu/rest/v2/name/{$this->_countryX}?fullText=true";			
			$_countryInfo1 		=	$this->__getRestData();
			
			if(!empty($_countryInfo1)){
				$_findInArrayCntry1	=	array_column($_countryInfo1[0]->languages, 'name');		
				$_speakingLngsCntry1=	implode($_findInArrayCntry1, ' ,');
						
				
				/* get data for second country */
				$this->_reqeustURL	=	"https://restcountries.eu/rest/v2/name/{$this->_countryY}?fullText=true";			
				$_countryInfo2 		=	$this->__getRestData();
				
				if(!empty($_countryInfo2)){
					$_findInArrayCntry2	=	array_column($_countryInfo2[0]->languages, 'name');		
					$_speakingLngsCntry2=	implode($_findInArrayCntry2, ' ,');
					
					
					/* country first and second speaking languages list */
					$_strMsg	=	"\n{$this->_countryX} speaks {$_speakingLngsCntry1}";
					$_strMsg   .=	"\n{$this->_countryY} speaks {$_speakingLngsCntry2}";
					
					$_similarLangCheck 	=	implode(array_intersect($_findInArrayCntry1, $_findInArrayCntry2), ',');
					
					if(!empty($_similarLangCheck)){
						$_strMsg	.=	"\n{$this->_countryX} and {$this->_countryY} both speaks {$_similarLangCheck}";
					}else{
						$_strMsg	.=	"\n{$this->_countryX} and {$this->_countryY} both does not speaks any similar language.";
					}
					$this->__formatOutPutMsg($_strMsg, "Result:\n");
				}else{
					$this->__formatOutPutMsg("Data not found for `{$this->_countryY}`. Please verify entered country name.", "error:");
				}
				
			}else{
				$this->__formatOutPutMsg("Data not found for `{$this->_countryX}`. Please verify entered country name.", "error:");
			}
			
		} catch (Exception $_e) {
			echo 'Caught exception: ',  $_e->getMessage(), "\n";
		}
		
	}
	
	/* use of return type declaration PHP7  */
	public function __getRestData() : array{
		
		if(isset($this->_reqeustURL) && $this->_reqeustURL != ""){
			
			//  Initiate curl
			$ch = curl_init();
			// Will return the response, if false it print the response
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			// Set the url
			curl_setopt($ch, CURLOPT_URL, $this->_reqeustURL);
			// Execute
			$result=curl_exec($ch);
			//checking response code
			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			// Closing
			curl_close($ch);
			
			/* check result and return error code */
			if(!empty($result) && $httpCode < 400){
				return json_decode($result);
			}else{
				return array();
			}
			
		}else{
			return array();
		}
		
	}
	
	/* $_msg contains message and $_type contains type e.g success, error or warning */
	public function __formatOutPutMsg($_msg=null, $_type="error"){
		$_strText 	 =	"\n/***********************************************/\n";
		$_strText 	.=	ucwords(strtolower($_type)). " {$_msg}";
		$_strText 	.=	"\n/***********************************************/\n";
		exit($_strText);
	}
	
}

$c = new \Api\LanguageGroupCheck($argc, $argv); // see "Global Space" section
?>