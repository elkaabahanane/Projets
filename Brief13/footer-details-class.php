<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
  exit;
}

/**
 * Adds Footer Details widget.
 */
class Footer_Details extends WP_Widget
{

  /**
   * Register widget with WordPress.
   */
  function __construct()
  {
    parent::__construct(
      'footer_details_widget', // Base ID
      esc_html__('[Footer Details]', 'fd_domain'), // Name
      array('description' => esc_html__('Afficher des informations sur le footer', 'fd_domain'),) // Args
    );
  }

  /**
   * Front-end display of widget.
   *
   * @see WP_Widget::widget()
   *
   * @param array $args     Widget arguments.
   * @param array $instance Saved values from database.
   */
  public function widget($args, $instance)
  {
    echo $args['before_widget'];

    if (!empty($instance['title'])) {
      echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
    }

    // Widget Content Output
    echo '<ul>';
    echo '<li><a href="mailto:' . $instance['email'] . '">' . $instance['email'] . '</a></li>';
    echo '<li><a href="tel:' . $instance['telephone'] . '">' . $instance['telephone'] . '</a></li>';
    echo '<li>' . $instance['copyright'] . '</li>';
    echo '</ul>';

    echo $args['after_widget'];
  }

  /**
   * Back-end widget form.
   *
   * @see WP_Widget::form()
   *
   * @param array $instance Previously saved values from database.
   */
  public function form($instance)
  {
    $title = !empty($instance['title']) ? $instance['title'] : esc_html__('Widget Title', 'fd_domain');

    $email = !empty($instance['email']) ? $instance['email'] : esc_html__('example@example.com', 'fd_domain');
    $telephone = !empty($instance['telephone']) ? $instance['telephone'] : esc_html__('+2126 66 66 66 66', 'fd_domain');
    $copyright = !empty($instance['copyright']) ? $instance['copyright'] : esc_html__('Tous les droits sont reserve &copy; 2020', 'fd_domain');
?>

    <!-- TITLE -->
    <p>
      <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
        <?php esc_attr_e('Title:', 'fd_domain'); ?>
      </label>

      <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
    </p>

    <!-- Email -->
    <p>
      <label for="<?php echo esc_attr($this->get_field_id('email')); ?>">
        <?php esc_attr_e('Email:', 'fd_domain'); ?>
      </label>

      <input class="widefat" id="<?php echo esc_attr($this->get_field_id('email')); ?>" name="<?php echo esc_attr($this->get_field_name('email')); ?>" type="text" value="<?php echo esc_attr($email); ?>">
    </p>

    <!-- Telephone -->
    <p>
      <label for="<?php echo esc_attr($this->get_field_id('telephone')); ?>">
        <?php esc_attr_e('Telephone:', 'fd_domain'); ?>
      </label>

      <input class="widefat" id="<?php echo esc_attr($this->get_field_id('telephone')); ?>" name="<?php echo esc_attr($this->get_field_name('telephone')); ?>" type="text" value="<?php echo esc_attr($telephone); ?>">
    </p>

    <!-- COPYRIGHT -->
    <p>
      <label for="<?php echo esc_attr($this->get_field_id('copyright')); ?>">
        <?php esc_attr_e('Copyright:', 'fd_domain'); ?>
      </label>

      <input class="widefat" id="<?php echo esc_attr($this->get_field_id('copyright')); ?>" name="<?php echo esc_attr($this->get_field_name('copyright')); ?>" type="text" value="<?php echo esc_attr($copyright); ?>">
    </p>
<?php
  }

  /**
   * Sanitize widget form values as they are saved.
   *
   * @see WP_Widget::update()
   *
   * @param array $new_instance Values just sent to be saved.
   * @param array $old_instance Previously saved values from database.
   *
   * @return array Updated safe values to be saved.
   */
  public function update($new_instance, $old_instance)
  {
    $instance = array();

    $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';

    $instance['email'] = (!empty($new_instance['email'])) ? strip_tags($new_instance['email']) : '';
    $instance['telephone'] = (!empty($new_instance['telephone'])) ? strip_tags($new_instance['telephone']) : '';
    $instance['copyright'] = (!empty($new_instance['copyright'])) ? strip_tags($new_instance['copyright']) : '';

    return $instance;
  }
}
