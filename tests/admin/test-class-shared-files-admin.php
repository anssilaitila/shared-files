<?php 

class Shared_Files_AdminTest extends WP_UnitTestCase {

  public function setUp() {
    parent::setUp();

    $this->admin_user_id = $this->factory->user->create(['role' => 'admin']);
    wp_set_current_user($this->admin_user_id);

    $this->class_instance = new Shared_Files_Admin('shared-files', '1.6.5');
  }

  public function tearDown() {
    parent::tearDown();
  }

  public function test_plugin_loaded_success() {
    $this->assertTrue(class_exists('Shared_Files_Admin'), "Class 'Shared_Files_Admin' not found.");
  }

  public function test_create_post_success() {

    $post = $this->factory->post->create_and_get([
      'post_type'    => 'shared-file',
      'post_title'   => 'Toimiiko324972',
    ]);
    
    $this->assertTrue($post->ID > 0, 'Post did not get created successfully.');

    $post_title = get_the_title($post->ID);
    $this->assertEquals('Toimiiko324972', $post_title, 'Incorrect post name.');

  }

}
