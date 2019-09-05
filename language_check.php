<?php
/* Note that if register_argc_argv is disabled / set to false in php.ini then these method will not work  */
if (isset($argc) && count($argc) > 0) {
	
	$fileName 	=	$argv[0];
	$param1		=	isset($argv[1])? $argv[1]:'';
	$param2		=	isset($argv[2])? $argv[2]:'';
	
	//echo $param1.'=='.$param2;
	
	echo "Checking...\n";
	
	if($param1 !== "" && $param2 == ""){
		$countryInfo 	=	json_decode(file_get_contents('https://restcountries.eu/rest/v2/name/'.$param1.'?fullText=true'));
		foreach($countryInfo[0]->languages as $index=>$arrlangInfo){
			$langCode = $arrlangInfo->iso639_1;
			$languagePreference	=	$index == 0 ? 'Primary':'Other';
			echo "\n\n\nCountry {$languagePreference} language code: {$langCode} \n";			
						
			$sameLanguageInOtherCountries 	=	json_decode(file_get_contents("https://restcountries.eu/rest/v2/lang/{$langCode}"));
			
				$sameLanguageCountries	=	[];
			foreach($sameLanguageInOtherCountries as $sameLanguageCountryList){
				$sameLanguageCountries[]	=	$sameLanguageCountryList->name;
			}
			
			echo "{$param1} speaks same language with these countries : ".implode($sameLanguageCountries, ', ');
			echo "\n/***********************************************/\n";
			
		}
	}
	
	if($param1 !== "" && $param2 != ""){
		
		$countryInfo1 	=	json_decode(file_get_contents('https://restcountries.eu/rest/v2/name/'.$param1.'?fullText=true'));
		print_r($countryInfo1[0]->languages);
		
		$countryInfo2 	=	json_decode(file_get_contents('https://restcountries.eu/rest/v2/name/'.$param2.'?fullText=true'));
		print_r($countryInfo2[0]->languages);
	}
	
}
else {
	echo "argc and argv disabled\n";
}
?>