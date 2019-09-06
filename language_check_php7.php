<?php
/* use of namespace */
namespace Api;

class LanguageGroupCheck{
	
	private $__countryX, $__countryY;
	
	/* use of scalar type declaration PHP7 */
	public function __construct(int $argc, array $argv){
				
		if (isset($argc) && is_int($argc) && $argc > 0) {
			
			/* us of coalescing operator php7 */
			$this->_countryX	=	$argv[1] ?? '';
			$this->_countryY	=	$argv[2] ?? '';
			
			/* if only a county is passing */
			if($this->_countryX !== "" && $this->_countryY == ""){
				$this->__langGroup();
			}
			
			/* if two countries are passing */
			if($this->_countryX !== "" && $this->_countryY != ""){
				$this->__similarLanguageCountries();
			}
			
		}
	
	}
	
	
	private function __langGroup() {
		
		if($this->_countryX !== "" && $this->_countryY == ""){
			
			$this->_reqeustURL	=	"https://restcountries.eu/rest/v2/name/{$this->_countryX}?fullText=true";			
			$countryInfo 		=	$this->__getRestData();
			
			foreach($countryInfo[0]->languages as $index=>$arrlangInfo){
				
				$langCode 			= 	$arrlangInfo->iso639_1;
				
				echo "\n\n\nCountry {$arrlangInfo->name} language code: {$arrlangInfo->iso639_1} \n";			
						
				$this->_reqeustURL				=	"https://restcountries.eu/rest/v2/lang/{$arrlangInfo->iso639_1}";
				$sameLanguageInOtherCountries 	=	$this->__getRestData();
				
					$sameLanguageCountries		=	[];
				foreach($sameLanguageInOtherCountries as $sameLanguageCountryList){
					$sameLanguageCountries[]	=	$sameLanguageCountryList->name;
				}
				
				echo "{$this->_countryX} speaks same language ({$arrlangInfo->name}) with these countries : ".implode($sameLanguageCountries, ', ');
				echo "\n/***********************************************/\n";
				
			}
			
		}
	
	}
	
	private function __similarLanguageCountries(){
		
		$this->_reqeustURL	=	"https://restcountries.eu/rest/v2/name/{$this->_countryX}?fullText=true";			
		$countryInfo1 		=	$this->__getRestData();
		$speakingLang		=	implode(array_column($countryInfo1[0]->languages, 'name'), ' ,');
		echo "\n\n{$this->_countryX} speaks {$speakingLang}\n\n";
		
		
		if(!empty($countryInfo1[0]->languages)){
			
			foreach($countryInfo1[0]->languages as $arrlangInfo){
				$this->_reqeustURL				=	"https://restcountries.eu/rest/v2/lang/{$arrlangInfo->iso639_1}";			
				$sameLanguageInOtherCountries 	=	$this->__getRestData();
				
					$sameLanguageCountries		=	[];
				foreach($sameLanguageInOtherCountries as $sameLanguageCountryList){
					$sameLanguageCountries[]	=	$sameLanguageCountryList->name;
				}
				
				echo "\n\n{$arrlangInfo->name} speaks Countries: ".implode($sameLanguageCountries, ', ')."\n\n";
			}
			
		}
		
		/* checking second country with same languages */
		$this->_reqeustURL	=	"https://restcountries.eu/rest/v2/name/{$this->_countryY}?fullText=true";			
		$countryInfo2 		=	$this->__getRestData();
		$speakingLang2		=	implode(array_column($countryInfo2[0]->languages, 'name'), ' ,');
		
		echo "Belgium speaks x,y,z\n\n";
		echo "Inida speaks x,y,z\n\n";
		
		echo "Belgium and India does not speaks any similar language.";
		print_r($speakingLang2);exit;
	}
	
	/* use of return type declaration PHP7  */
	public function __getRestData() : array{
		
		if(isset($this->_reqeustURL) && $this->_reqeustURL != ""){
			return json_decode(file_get_contents($this->_reqeustURL));
		}else{
			return array();
		}
		
	}
	
}

$c = new \Api\LanguageGroupCheck($argc, $argv); // see "Global Space" section
?>