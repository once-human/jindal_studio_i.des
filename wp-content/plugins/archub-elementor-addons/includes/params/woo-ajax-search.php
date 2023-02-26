<?php

defined( 'ABSPATH' ) || die();

class LD_Woo_AjaxSearch_Handler {

    public function __construct() {
        add_action( 'wp_ajax_liquid_wc_get_products_by_input_text', [ $this, 'get_products_by_input_text' ] );
		add_action( 'wp_ajax_nopriv_liquid_wc_get_products_by_input_text', [ $this, 'get_products_by_input_text' ] );
    }

    public function get_search_results_wrap_start() {
        return '<div class="liquid-wc-product-search-results"><ul class="reset-ul">';
    }

    public function get_search_results_wrap_end() {
        return '</ul></div>';
    }

    public function get_search_results_list_item( $product_id ) {

        $product = wc_get_product( $product_id );

        if ( ! $product ) {
            return '';
        }

        ob_start(); ?>
            <li class="ld-wc-search-result py-3">
                <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="d-flex align-items-center px-2">
                    <div class="ld-wc-search-result--thumbnail">
                        <?php echo $product->get_image(); ?>
                    </div>
                    <div class="ld-wc-search-result--meta pl-3">
                        <h4><?php esc_html_e( $product->get_name() ); ?></h4>
                        <p><?php echo wp_kses_post( $product->get_short_description() ); ?></p>
                        <p class="mt-0 mb-0 ld-wc-search-result--price">
                            <?php echo $product->get_price_html(); ?>
                        </p>
                    </div>
                </a>
            </li>
        <?php
        return ob_get_clean();
    }

    public function get_search_results_view_all() {
        return '<li class="ld-wc-search-view-all"><a href="#">' . esc_html( 'View all results', 'archub-elementor-addons' ) . '</a>';
    }

    public function get_products_by_input_text() {

        $search_text = strval( $_POST[ 'searchText' ] );
        $category_id = intval( $_POST[ 'termId' ] );

        $args = [
            'post_type'      => 'product',
            's'              => $search_text,
            'posts_per_page' => 5,
        ];

        if ( $category_id ) {

            $parent_category = get_term( $category_id, 'product_cat' );
            $categories      = get_term_children( $parent_category->term_id, 'product_cat' );
            $categories      = array_merge( $categories, [ $parent_category->term_id ] );

            $args[ 'tax_query' ] = [
                [
                    'taxonomy' => 'product_cat',
                    'field'    => 'term_id',
                    'terms'    => $categories,
                    'operator' => 'IN'
                ]
            ];
        }

        $query = new \WP_Query( $args );

        if ( $query->have_posts() ) {

            $products       = [];
            $found_products = $query->get_posts();

            foreach ( $found_products as $product ) {
                $products[] = $this->get_search_results_list_item( $product->ID );
            }

            if ( $query->found_posts > $query->post_count ) {
                $output = $this->get_search_results_wrap_start() . implode( '', $products ) . $this->get_search_results_view_all() . $this->get_search_results_wrap_end();
            } else {
                $output = $this->get_search_results_wrap_start() . implode( '', $products ) . $this->get_search_results_wrap_end();
            }

        } else {
            ob_start();
            wc_no_products_found();
            $output = $this->get_search_results_wrap_start() . ob_get_clean() . $this->get_search_results_wrap_end();
        }

        wp_send_json_success( [ 'html' => $output ] );
    }
}
new LD_Woo_AjaxSearch_Handler();
