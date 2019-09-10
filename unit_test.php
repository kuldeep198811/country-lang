<?php
declare(strict_types=1);

use \PHPUnit\Framework\TestCase;
include('api\language_group_check.php');
use api\languageGroupCheck as lgc;
final class apiTest extends TestCase
{
	
	/* case to test blank countries */
	public function testCheckInValidBlankCountryNames()
    {

		$_expected	=	true;
		$_testVal1	=	'';
		$_testVal2	=	'';
		$lgcObj		=	new lgc();
		$returnVal	=	($lgcObj->__validateCountryArguments($_testVal1, $_testVal2) !== false)? true:false;
        $this->assertTrue($_expected === $returnVal);

    }
	
	/* case to test invalid primary country name */
    public function testCheckInValidPrimaryCountryName()
    {

		$_expected	=	true;
		$_testVal1	=	'123';
		$_testVal2	=	'spain';
		$lgcObj		=	new lgc();
		$returnVal	=	($lgcObj->__validateCountryArguments($_testVal1, $_testVal2) !== false)? true:false;
        $this->assertTrue($_expected === $returnVal);

    }
	
	/* case to test valid primary country name */
	public function testCheckValidPrimaryCountryName()
    {

		$_expected	=	true;
		$_testVal1	=	'Spain';
		$_testVal2	=	'';
		$lgcObj		=	new lgc();
		$returnVal	=	($lgcObj->__validateCountryArguments($_testVal1, $_testVal2) !== false)? true:false;
        $this->assertTrue($_expected === $returnVal);

    }
	
	/* case to test blank primary country name */
    public function testCheckBlankPrimaryCountryName()
    {

		$_expected	=	true;
		$_testVal1	=	'';
		$_testVal2	=	'spain';
		$lgcObj		=	new lgc();
		$returnVal	=	($lgcObj->__validateCountryArguments($_testVal1, $_testVal2) !== false)? true:false;
        $this->assertTrue($_expected === $returnVal);

    }
	
	/* case to test invalid secondary country name */
	public function testCheckValidSecondaryCountryName()
    {

		$_expected	=	true;
		$_testVal1	=	'Spain';
		$_testVal2	=	'1234';
		$lgcObj		=	new lgc();
		$returnVal	=	($lgcObj->__validateCountryArguments($_testVal1, $_testVal2) !== false)? true:false;
        $this->assertTrue($_expected === $returnVal);

    }
	
	
	
	/* case to test with value values */
	public function testCheckValidCountryName()
    {

		$_expected	=	true;
		$_testVal1	=	'Spain';
		$_testVal2	=	'Belgium';
		$lgcObj		=	new lgc();
		$returnVal	=	($lgcObj->__validateCountryArguments($_testVal1, $_testVal2) !== false)? true:false;
        $this->assertTrue($_expected === $returnVal);

    }
	
}




//
