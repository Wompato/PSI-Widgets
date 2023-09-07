<?php
/*
Plugin Name: PSI Custom Widgets
Description: A custom WordPress plugin to hold multiple custom widgets.
Version: 1.0
Author: Alex Shelton
*/

// Include all widgets from the widgets folder
require_once(plugin_dir_path(__FILE__) . 'widgets/dynamic-cat-recent-posts/dynamic-cat-recent-posts.php');
require_once(plugin_dir_path(__FILE__) . 'widgets/dynamic-cat-archives/dynamic-cat-archives.php');