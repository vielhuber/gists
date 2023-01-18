add_action('widgets_init', function () {
  register_widget(new test_widget());
});

class test_widget extends \WP_Widget
{
    function __construct()
    {
        parent::__construct('test_widget', __('Test widget', 'domain'), [
            'description' => __('A test widget.', 'domain')
        ]);
    }
    public function widget($args, $instance)
    {
        $title = apply_filters('widget_title', $instance['title']);
        echo $args['before_widget'];
        if (!empty($title)) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        echo '...';
        echo $args['after_widget'];
    }
    public function form($instance)
    {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('Custom title', 'domain');
        }
        echo '<p>';
        echo '<label for="' . $this->get_field_id('title') . '">' . __('Title', 'domain') . ':</label>';
        echo '<input class="widefat" id="' .
            $this->get_field_id('title') .
            '" name="' .
            $this->get_field_name('title') .
            '" type="text" value="' .
            esc_attr($title) .
            '" />';
        echo '</p>';
    }
    public function update($new_instance, $old_instance)
    {
        $instance = [];
        $instance['title'] = !empty($new_instance['title']) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }
}