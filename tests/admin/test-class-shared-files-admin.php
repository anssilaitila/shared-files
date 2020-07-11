<?php 

class Shared_Files_AdminTest extends WP_UnitTestCase {

  public function setUp() {
    parent::setUp();
    $this->class_instance = new Shared_Files_Admin('shared-files', '1.6.2');
  }

  public function test_human_filesize() {

    $filesize = $this->class_instance->human_filesize(1024);
    $expected = '1.00 KB';

    $this->assertEquals($expected, $filesize);

  }

}
