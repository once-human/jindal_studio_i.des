<?php 

if ( !defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( !class_exists( 'Liquid_Term_Category_Color' ) ) :

    class Liquid_Term_Category_Color {
        
        
        /**
         * Constructor
         */
        public function __construct() {

            add_action( 'category_add_form_fields', [ $this, 'colorpicker_field_add_new_category' ] );
            add_action( 'category_edit_form_fields', [ $this, 'colorpicker_field_edit_category' ] ); 
            add_action( 'post_tag_add_form_fields', [ $this, 'colorpicker_field_add_new_category' ] );
            add_action( 'post_tag_edit_form_fields', [ $this, 'colorpicker_field_edit_category' ] ); 
            add_action( 'created_category', [ $this, 'save_term_meta' ] );
            add_action( 'edited_category',  [ $this, 'save_term_meta' ] );
            add_action( 'created_post_tag', [ $this, 'save_term_meta' ] );
            add_action( 'edited_post_tag',  [ $this, 'save_term_meta' ] );
            add_action( 'admin_enqueue_scripts', [ $this, 'category_colorpicker_enqueue' ] );
            add_action( 'admin_print_scripts', [ $this, 'colorpicker_init_inline' ], 20 );
            
        }
        
        /**
         * Add new colorpicker field to "Add new Category" screen
         * - https://developer.wordpress.org/reference/hooks/taxonomy_add_form_fields/
         *
         * @param String $taxonomy
         *
         * @return void
         */
        function colorpicker_field_add_new_category( $taxonomy ) {

            ?>
        
            <div class="form-field term-colorpicker-wrap">
                <label for="term-colorpicker">Badge Color</label>
                <input name="lqd_category_color" value="#ffffff" class="colorpicker" id="term-colorpicker" />
                <p>Set badge color.</p>
            </div>
        
            <?php
        
        }

        /**
         * Add new colopicker field to "Edit Category" screen
         * - https://developer.wordpress.org/reference/hooks/taxonomy_add_form_fields/
         *
         * @param WP_Term_Object $term
         *
         * @return void
         */
        function colorpicker_field_edit_category( $term ) {

            $color = get_term_meta( $term->term_id, 'lqd_category_color', true );
            $color = ( ! empty( $color ) ) ? "#{$color}" : '#ffffff';

        ?>

            <tr class="form-field term-colorpicker-wrap">
                <th scope="row"><label for="term-colorpicker">Badge Color</label></th>
                <td>
                    <input name="lqd_category_color" value="<?php echo $color; ?>" class="colorpicker" id="term-colorpicker" />
                    <p class="description">Set badge color.</p>
                </td>
            </tr>

        <?php

        }
        
        /**
         * Term Metadata - Save Created and Edited Term Metadata
         * - https://developer.wordpress.org/reference/hooks/created_taxonomy/
         * - https://developer.wordpress.org/reference/hooks/edited_taxonomy/
         *
         * @param Integer $term_id
         *
         * @return void
         */
        function save_term_meta( $term_id ) {

            // Save term color if possible
            if( isset( $_POST['lqd_category_color'] ) && ! empty( $_POST['lqd_category_color'] ) ) {
                update_term_meta( $term_id, 'lqd_category_color', sanitize_hex_color_no_hash( $_POST['lqd_category_color'] ) );
            } else {
                delete_term_meta( $term_id, 'lqd_category_color' );
            }

        }

        /**
         * Enqueue colorpicker styles and scripts.
         * - https://developer.wordpress.org/reference/hooks/admin_enqueue_scripts/
         *
         * @return void
         */
        function category_colorpicker_enqueue( $taxonomy ) {

            if( null !== ( $screen = get_current_screen() ) && ( 'edit-category' !== $screen->id && 'edit-post_tag' !== $screen->id ) ) {
                return;
            }

            // Colorpicker Scripts
            wp_enqueue_script( 'wp-color-picker' );

            // Colorpicker Styles
            wp_enqueue_style( 'wp-color-picker' );

        }

        /**
         * Print javascript to initialize the colorpicker
         * - https://developer.wordpress.org/reference/hooks/admin_print_scripts/
         *
         * @return void
         */
        function colorpicker_init_inline() {

            if( null !== ( $screen = get_current_screen() ) && ( 'edit-category' === $screen->id || 'edit-post_tag' === $screen->id ) ) {
                ?>
                <script>
                    jQuery( document ).ready( function( $ ) {
                        $( '.colorpicker' ).wpColorPicker();
                    } ); 
                </script>
            <?php
            }
        
        }

    } new Liquid_Term_Category_Color();

endif;