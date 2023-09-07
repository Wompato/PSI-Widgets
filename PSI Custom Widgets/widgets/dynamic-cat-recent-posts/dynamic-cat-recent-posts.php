<?php
class Dynamic_Category_Recent_Posts extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'dynamic_category_recent_posts',
            'Dynamic Category Recent Posts',
            array(
                'description' => 'Display recent articles from the current post category.'
            )
        );
    }

    public function widget($args, $instance) {
        if (is_single()) {
            global $post;
            $categories = get_the_category($post->ID);
            if (!empty($categories)) {
                $category = $categories[0]; // Assuming one category per post
                $category_name = $category->name;
                $number_of_posts = isset($instance['number_of_posts']) ? intval($instance['number_of_posts']) : 5;
    
                echo $args['before_widget'];
                echo '<h4 style="font-family: Roboto, sans-serif; font-weight: bold; text-transform: uppercase; text-decoration: none; font-size: 20px; margin-bottom: 5px;">';
                echo 'Recent ' . esc_html($category_name) . ' Articles';
                echo '</h4>';
    
                $args = array(
                    'post_type' => 'post',
                    'cat' => $category->term_id,
                    'posts_per_page' => $number_of_posts,
                    'post_status' => 'publish',
                    'ignore_sticky_posts' => true,
                );
    
                $query = new WP_Query($args);
    
                if ($query->have_posts()) {
                    echo '<ul>';
                    while ($query->have_posts()) {
                        $query->the_post();
                        echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
                    }
                    echo '</ul>';
                }
    
                wp_reset_postdata();
                
            }
        }
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? esc_attr($instance['title']) : '';
        $number_of_posts = isset($instance['number_of_posts']) ? intval($instance['number_of_posts']) : 5;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('number_of_posts'); ?>">Number of Posts:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('number_of_posts'); ?>" name="<?php echo $this->get_field_name('number_of_posts'); ?>" type="number" min="1" value="<?php echo $number_of_posts; ?>">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['number_of_posts'] = (isset($new_instance['number_of_posts'])) ? intval($new_instance['number_of_posts']) : 5;
        return $instance;
    }
}

function register_dynamic_category_recent_posts() {
    register_widget('Dynamic_Category_Recent_Posts');
}

add_action('widgets_init', 'register_dynamic_category_recent_posts');
