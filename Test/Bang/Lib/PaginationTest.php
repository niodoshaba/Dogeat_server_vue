<?php

require_once 'auto_load.php';

use Bang\Lib\Pagination;

class PaginationTest extends PHPUnit_Framework_TestCase {

    protected function setUp() {
        
    }

    public function testGetStartAndEndIndex1() {
        $test1 = new Pagination(1054, 2, 20);
        $start_index = $test1->GetStartIndex();
        $end_index = $test1->GetEndIndex();

        $this->assertEquals($start_index, 21);
        $this->assertEquals($end_index, 40);
    }
    
    public function testGetStartAndEndIndex2() {
        $test1 = new Pagination(53, 3, 20);
        $start_index = $test1->GetStartIndex();
        $end_index = $test1->GetEndIndex();

        $this->assertEquals($start_index, 41);
        $this->assertEquals($end_index, 53);
    }

    public function testHasNextPage() {
        // Arrange
        $test1 = new Pagination(101, 2, 10);
        $test2 = new Pagination(10, 1, 100);

        // Act
        $true = $test1->HasNextPage();
        $false = $test2->HasNextPage();

        // Assert
        $this->assertEquals(TRUE, $true);
        $this->assertEquals(FALSE, $false);
    }

    public function testSkipCount() {
        // Arrange
        $test1 = new Pagination(101, 2, 10);
        $test2 = new Pagination(10, 1, 100);
        $test3 = new Pagination(101, 5, 20);

        // Act
        $_10 = $test1->GetSkipCount();
        $_0 = $test2->GetSkipCount();
        $_80 = $test3->GetSkipCount();

        // Assert
        $this->assertEquals(10, $_10);
        $this->assertEquals(0, $_0);
        $this->assertEquals(80, $_80);
    }

}
