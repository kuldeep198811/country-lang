<?php
declare(strict_types=1);

use \PHPUnit\Framework\TestCase;
include('api\language_group_check.php');
use api\languageGroupCheck as lgc;
final class apiTest extends TestCase
{
    public function testCheckValidCountryName()
    {

        $this->assertInstanceOf(
            lgc::class,
            lgc::__validateCountryArguments(['', 'spain'])
        );
    }
}




//
