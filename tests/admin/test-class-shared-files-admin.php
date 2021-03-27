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

    // List of images here: https://core.trac.wordpress.org/browser/trunk/tests/phpunit/data/images

    // create a user
    $author = $this->factory->user->create_and_get( array( 'user_login' => 'jdoe', 'user_pass' => NULL, 'role' => 'administrator' ));

    // Make sure it was created in this testing environment
    $this->assertTrue($author->ID !== 0);

    // Set the current user to $author
    wp_set_current_user($author->ID);

    // create a nonce with the same action our production code uses
    $nonce = wp_create_nonce('shared-files-nonce-' . $author->ID);
    
    // set $_POST array with nonce
    $_POST['_sf_file_nonce'] = $nonce;

    $filename = (DIR_TESTDATA . '/images/test-image.jpg');
    $contents = file_get_contents($filename);
    $upload = wp_upload_bits(basename($filename), null, $contents);

    $_POST['_sf_file'] = $upload['file'];

    // Filename with path
    $_FILES['_sf_file']['tmp_name'] = $upload['file'];

    // Filename
    $filename_rand = rand(1000000, 9999999) . '_' . basename($upload['file']);
    $_FILES['_sf_file']['name'] = $filename_rand;

    $_POST['post_type'] = 'shared_file';

    $post = $this->factory->post->create_and_get([
      'post_type'    => 'shared_file',
      'post_title'   => 'Toimiiko324972',
      'meta_input' => [
        '_sf_file' => $upload['file']
      ]
    ]);

    $file_added = get_post_meta($post->ID, '_sf_file_added', true);
    $file_details = get_post_meta($post->ID, '_sf_file', true);

    echo "\n\n";
    var_dump($file_added);
    var_dump($filename);
    var_dump($upload['file']);
    var_dump($file_details);

    $this->assertTrue($post->ID > 0, 'Post did not get created successfully.');

    $post_title = get_the_title($post->ID);
    $this->assertEquals($filename_rand, $post_title, 'Incorrect post name: ' . $post_title);

    $new_post_filename = get_post_meta($post->ID, '_sf_filename', true);
    $this->assertEquals($filename_rand, $new_post_filename, 'Incorrect filename in _sf_filename: ' . $new_post_filename);

    $new_post_file = get_post_meta($post->ID, '_sf_file', true);
    $this->assertEquals('image/jpeg', $new_post_file['type'], 'Incorrect file type in _sf_file: ' . $new_post_file['type']);

  }

}
