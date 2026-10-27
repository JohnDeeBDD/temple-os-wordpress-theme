<?php
/**
 * Widget areas and the Oracle widget.
 *
 * Widget areas use classic widgets (see inc/classic-editor.php). Each widget
 * renders as a small TempleOS window: a double-line border with the title
 * sitting in the top edge.
 *
 * @package Temple
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The before/after markup shared by every widget area, so the_widget() calls
 * in the fallback sidebar match registered widgets.
 *
 * the_widget() fills before_widget with a single class name, while
 * register_sidebar() fills an id and a class, so the placeholders differ.
 *
 * @param string $color      A VGA color slug for the window border.
 * @param bool   $the_widget Whether the args are for a the_widget() call.
 * @return array
 */
function temple_widget_args( $color = 'blue', $the_widget = false ) {
	$placeholders = $the_widget ? '%s' : '%2$s';
	$id           = $the_widget ? '' : ' id="%1$s"';

	return array(
		'before_widget' => '<section' . $id . ' class="widget tos-window tos-border-' . esc_attr( $color ) . ' ' . $placeholders . '">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title tos-window__title">',
		'after_title'   => '</h2>',
	);
}

/**
 * Register widget areas.
 */
function temple_widgets_init() {
	register_sidebar(
		array_merge(
			array(
				'name'        => __( 'Sidebar', 'temple' ),
				'id'          => 'sidebar-1',
				'description' => __( 'Windows shown beside posts and pages.', 'temple' ),
			),
			temple_widget_args( 'blue' )
		)
	);

	register_sidebar(
		array_merge(
			array(
				'name'        => __( 'Footer', 'temple' ),
				'id'          => 'footer-1',
				'description' => __( 'Windows shown in a row above the footer.', 'temple' ),
			),
			temple_widget_args( 'purple' )
		)
	);

	register_widget( 'Temple_Oracle_Widget' );
}
add_action( 'widgets_init', 'temple_widgets_init' );

/**
 * Word list for the Oracle. In TempleOS, pressing F7 picks random words from
 * the dictionary. This short list keeps the page light; replace it with the
 * temple_oracle_words filter.
 *
 * @return string[]
 */
function temple_oracle_words() {
	$words = array(
		'light', 'stone', 'river', 'mountain', 'bread', 'wine', 'fire', 'water', 'gold', 'silver',
		'king', 'servant', 'shepherd', 'temple', 'altar', 'garden', 'desert', 'sea', 'star', 'moon',
		'sun', 'cloud', 'wind', 'thunder', 'rain', 'seed', 'harvest', 'vine', 'fig', 'olive',
		'lamb', 'lion', 'eagle', 'dove', 'serpent', 'fish', 'net', 'boat', 'gate', 'wall',
		'city', 'tower', 'road', 'door', 'key', 'lamp', 'oil', 'salt', 'honey', 'milk',
		'joy', 'peace', 'mercy', 'wisdom', 'truth', 'grace', 'faith', 'hope', 'patience', 'courage',
		'laugh', 'sing', 'dance', 'build', 'rest', 'wait', 'listen', 'watch', 'remember', 'forgive',
		'begin', 'finish', 'return', 'arise', 'behold', 'rejoice', 'wander', 'gather', 'scatter', 'shine',
		'compile', 'kernel', 'byte', 'pixel', 'sprite', 'compiler', 'register', 'interrupt', 'cursor', 'window',
		'perfect', 'simple', 'holy', 'humble', 'bright', 'quiet', 'ancient', 'new', 'small', 'great',
		'morning', 'evening', 'night', 'sabbath', 'hymn', 'psalm', 'song', 'word', 'name', 'voice',
		'heaven', 'earth', 'dust', 'bones', 'heart', 'hand', 'eye', 'ear', 'feet', 'crown',
	);

	$words = apply_filters( 'temple_oracle_words', $words );

	return array_values( array_filter( array_map( 'sanitize_text_field', (array) $words ) ) );
}

/**
 * Oracle widget: shows a few random words, with a button to draw again.
 */
class Temple_Oracle_Widget extends WP_Widget {

	/**
	 * Set up the widget.
	 */
	public function __construct() {
		parent::__construct(
			'temple_oracle',
			__( 'Oracle (TempleOS)', 'temple' ),
			array(
				'classname'                   => 'widget_temple_oracle',
				'description'                 => __( 'Random words, drawn like the TempleOS oracle.', 'temple' ),
				'customize_selective_refresh' => true,
			)
		);
	}

	/**
	 * Front-end output.
	 *
	 * @param array $args     Widget area markup.
	 * @param array $instance Saved settings.
	 */
	public function widget( $args, $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->defaults() );
		$title    = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$count    = max( 1, min( 32, (int) $instance['count'] ) );
		$words    = temple_oracle_words();

		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- theme/plugin markup.

		if ( $title ) {
			echo $args['before_title'] . esc_html( $title ) . $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		$picked = array();
		if ( $words ) {
			for ( $i = 0; $i < $count; $i++ ) {
				$picked[] = $words[ wp_rand( 0, count( $words ) - 1 ) ];
			}
		}
		?>
		<div class="tos-oracle" data-tos-oracle data-count="<?php echo (int) $count; ?>">
			<p class="tos-oracle__prompt"><?php esc_html_e( 'Oracle says...', 'temple' ); ?></p>
			<p class="tos-oracle__words" aria-live="polite" data-tos-oracle-words><?php echo esc_html( implode( ' ', $picked ) ); ?></p>
			<button type="button" class="tos-button" data-tos-oracle-button><?php esc_html_e( 'Ask Again [F7]', 'temple' ); ?></button>
		</div>
		<?php

		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Settings form.
	 *
	 * @param array $instance Saved settings.
	 * @return string
	 */
	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->defaults() );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'temple' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'Number of words:', 'temple' ); ?></label>
			<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number" min="1" max="32" step="1" value="<?php echo (int) $instance['count']; ?>">
		</p>
		<?php
		return '';
	}

	/**
	 * Sanitize settings on save.
	 *
	 * @param array $new_instance New values.
	 * @param array $old_instance Old values.
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		return array(
			'title' => sanitize_text_field( $new_instance['title'] ?? '' ),
			'count' => max( 1, min( 32, (int) ( $new_instance['count'] ?? 8 ) ) ),
		);
	}

	/**
	 * Default settings.
	 *
	 * @return array
	 */
	private function defaults() {
		return array(
			'title' => __( 'Oracle', 'temple' ),
			'count' => 8,
		);
	}
}
