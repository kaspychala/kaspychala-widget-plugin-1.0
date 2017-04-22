<?php
/**
 * Plugin Name:   Słowo na dziś NFJP
 * Plugin URI:    #
 * Description:   Podbiera losowe słowo ze strony nfjp.pl.
 * Version:       1.0
 * Author:        Kasper Spychała
 * Author URI:    https://www.github.com/kaspychala
 */

class kaspychala_widget extends WP_Widget {


  // Set up the widget name and description.
  public function __construct() {
    $widget_options = array( 'classname' => 'example_widget', 'description' => 'Podbiera losowe słowo ze strony nfjp.pl' );
    parent::__construct( 'example_widget', 'NFJP.PL', $widget_options );
  }


  // Create the widget output.
  public function widget( $args, $instance ) {  
  echo $args['before_widget'] . $args['before_title'] . $args['after_title']; ?>
    </br>
    <p><h2>Słowo na dziś!</h2></p>
    <hr />
    <p><h3><b><?php

  $doc = new DOMDocument();
  @$doc->loadHTMLFile('http://nfjp.pl/random/');
  $xPath = new DOMXpath($doc);
  $src = $xPath->query("//*[@id='post-x']/div[1]/img/@src");
  $elements = $xPath->query("//*[@id='post-x']/div[1]/h1");
  if( !is_null( $elements)){
    foreach ($elements as $element){
      echo utf8_decode($element->nodeValue);
      $element->parentNode->removeChild( $element);
    }
  }
  ?></b></h3></p>
  <p><img src="<?php
    if( !is_null( $src)){
    foreach ($src as $element){
      echo utf8_decode($element->nodeValue);
      }
    }
    ?>"></img>
  
    <?php echo $args['after_widget'];
  }

  
  // Create the admin area widget settings form.
  public function form( $instance ) {
    $title = ! empty( $instance['title'] ) ? $instance['title'] : ''; ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
      <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
    </p><?php
  }


  // Apply settings to the widget instance.
  public function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
    return $instance;
  }

}

// Register the widget.
function kaspychala_register_widget() { 
  register_widget( 'kaspychala_widget' );
}
add_action( 'widgets_init', 'kaspychala_register_widget' );

?>