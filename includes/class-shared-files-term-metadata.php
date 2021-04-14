<?php

class SharedFilesTermMetadata {
  
  /**
   * Get the specified metadata value for the term or from
   * one of it's parent terms.
   *
   * @since 1.0.0
   *
   * @param WP_Term $term Term object
   * @param string $meta_key The meta key to retrieve.
   *
   * @return mixed|null
   */
  public static function get_hierarchichal_term_metadata( WP_Term $term, $meta_key ) {
  
    if ( ! is_taxonomy_hierarchical( $term->taxonomy ) ) {
      return;
    }
  
    if ( ! self::has_parent_term( $term ) ) {
      $meta = get_term_meta( $term->term_id, $meta_key, true );
      return $meta;
    }
  
    return self::get_term_metadata_recursively( $term, $meta_key );
  }
  
  /**
   * Recursively get the term metadata by the specified meta key.
   * 
   * This function walks up the term hierarchical tree, searching for
   * a valid metadata value for the given meta key.
   * 
   * The recursive action stops when:
   *      1. The current term level has the metadata value.
   *      2. The current term level does not have a parent term.
   *
   * @since 1.0.0
   *
   * @param WP_Term $term Term object
   * @param string $meta_key The meta key to retrieve.
   * @param mixed|null $meta
   *
   * @return mixed|null
   */
  private static function get_term_metadata_recursively( WP_Term $term, $meta_key, $meta = null ) {
    $meta = get_term_meta( $term->term_id, $meta_key, true );
    if ( $meta ) {
      return $meta;
    }
  
    if ( ! self::has_parent_term( $term ) ) {
      return $meta;
    }
  
    // Get the parent term
    $parent_term = get_term_by( 'id', $term->parent, $term->taxonomy );
    if ( $parent_term === false ) {
      return $meta;
    }
  
    // Try again
    return self::get_term_metadata_recursively( $parent_term, $meta_key, $meta );
  }
  
  /**
   * Checks if the term has a parent.
   *
   * @since 1.0.0
   *
   * @param WP_Term $term Term object.
   *
   * @return bool
   */
  private static function has_parent_term( WP_Term $term ) {
    return ( $term->parent > 0 );
  }

}
