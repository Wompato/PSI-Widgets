<?php

class Dynamic_Category_Archive extends WP_Widget {

    public function __construct() {
        $widget_options = array(
            'classname' => 'as-category-archive-widget',
            'description' => 'A as widget that displays category-based archives.',
        );

        parent::__construct(
            'dynamic_category_archive',
            'Dynamic Category Archive',
            $widget_options
        );
    }

    public function widget($args, $instance) {
        if (is_archive() && is_category()) {
            //echo $args['before_widget'];

            $current_category = get_queried_object();
            

            // Get the current category
            $category_id = ($current_category && property_exists($current_category, 'term_id')) ? $current_category->term_id : 0;
            $category_name = ($current_category && property_exists($current_category, 'term_id')) ? strtoupper($current_category->name . ' ARCHIVE') : 'CATEGORY ARCHIVES';
        
            // Query posts within the current category
            $args = array(
                'cat' => $category_id,
                'posts_per_page' => -1,
            );
            $query = new WP_Query($args);
        
            // Collect years from post dates
            $years = array();
            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    $years[] = get_the_date('Y');
                }
                wp_reset_postdata();
            }
            
            // Remove duplicate years and sort
            $years = array_unique($years);
            sort($years);
        
            echo '<aside id="block-10" class="widget inner-padding widget_block dynamic_category_widget_archive">';
            // Output the label element with the current category name
            echo '<label for="custom-year-select" class="wp-block-archives__label">' . esc_html($category_name) . '</label>';
            // Output the select element
            echo '<select id="custom-year-select">';
            echo '<option value="">Select Year</option>';
            foreach ($years as $year) {
                echo '<option value="' . esc_attr($year) . '">' . esc_html($year) . '</option>';
            }
            echo '</select>';

            echo '</aside>'; // Close the widget container

        
            wp_enqueue_script('widget-js', plugin_dir_url(__FILE__) . 'dynamic-cat-archives/widget.js', array('jquery'), '1.0', true);

        
            // Pass data to the JavaScript file
            $localized_data = array(
                'categoryId' => $category_id,
                'baseUrl' => home_url('/blog'), // Get the base URL
                // Add more data as needed
            );
            wp_localize_script('widget-js', 'customWidgetData', $localized_data);
        
            //echo $args['after_widget'];
        }
    }
    
}

function register_dynamic_category_archive() {
register_widget('Dynamic_Category_Archive');
}

add_action('widgets_init', 'register_dynamic_category_archive');
