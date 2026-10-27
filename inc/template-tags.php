<?php
/**
 * Template tags used across the theme templates.
 *
 * @package Temple
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The VGA colors used for rainbow text, in rainbow order. These are the dark
 * half of the 16-color palette, which stays readable on a white screen.
 *
 * @return string[] Color slugs matching the .tos-fg-* classes in main.css.
 */
function temple_rainbow_colors() {
	return array( 'red', 'brown', 'green', 'cyan', 'blue', 'purple' );
}

/**
 * Return text with each character wrapped in a different VGA color.
 *
 * Screen readers get the plain text; the colored copy is hidden from them.
 *
 * @param string $text   Plain text.
 * @param int    $offset Which color to start from.
 * @return string Safe HTML.
 */
function temple_rainbow( $text, $offset = 0 ) {
	$text = wp_strip_all_tags( (string) $text );
	if ( '' === $text ) {
		return '';
	}

	$colors = temple_rainbow_colors();
	$chars  = function_exists( 'mb_str_split' ) ? mb_str_split( $text ) : str_split( $text );
	$i      = $offset;
	$out    = '';

	foreach ( $chars as $char ) {
		if ( ' ' === $char ) {
			$out .= ' ';
			continue;
		}
		$out .= sprintf( '<span class="tos-fg-%s">%s</span>', $colors[ $i % count( $colors ) ], esc_html( $char ) );
		++$i;
	}

	return sprintf(
		'<span class="screen-reader-text">%1$s</span><span class="tos-rainbow" aria-hidden="true">%2$s</span>',
		esc_html( $text ),
		$out
	);
}

/**
 * The site title, in rainbow unless that is switched off in the Customizer.
 *
 * @return string Safe HTML.
 */
function temple_site_title_html() {
	$name = get_bloginfo( 'name', 'display' );

	if ( get_theme_mod( 'temple_rainbow_title', true ) ) {
		return temple_rainbow( $name );
	}

	return esc_html( $name );
}

/**
 * A TempleOS-style file path for the current view, e.g. C:/Home/Blog/hello-world.DD.Z
 *
 * Shown in the main window's title bar.
 *
 * @return string Plain text (escape on output).
 */
function temple_doc_path() {
	$path = 'C:/Home';

	if ( is_front_page() && is_home() ) {
		$path .= '/Index.DD.Z';
	} elseif ( is_front_page() ) {
		$path .= '/' . temple_slug_for_path( get_post_field( 'post_name', get_queried_object_id() ) ) . '.DD.Z';
	} elseif ( is_home() ) {
		$path .= '/Blog/Index.DD.Z';
	} elseif ( is_page() ) {
		$ids   = array_reverse( get_post_ancestors( get_queried_object_id() ) );
		$ids[] = get_queried_object_id();
		foreach ( $ids as $id ) {
			$path .= '/' . temple_slug_for_path( get_post_field( 'post_name', $id ) );
		}
		$path .= '.DD.Z';
	} elseif ( is_singular() ) {
		$type   = get_post_type_object( get_post_type() );
		$folder = ( 'post' === get_post_type() ) ? 'Blog' : ( $type ? $type->labels->name : 'Doc' );
		$path  .= '/' . temple_slug_for_path( $folder ) . '/' . temple_slug_for_path( get_post_field( 'post_name', get_queried_object_id() ) ) . '.DD.Z';
	} elseif ( is_category() || is_tag() || is_tax() ) {
		$term  = get_queried_object();
		$tax   = get_taxonomy( $term->taxonomy );
		$path .= '/' . temple_slug_for_path( $tax ? $tax->labels->singular_name : 'Term' ) . '/' . temple_slug_for_path( $term->slug ) . '/';
	} elseif ( is_author() ) {
		$path .= '/Author/' . temple_slug_for_path( get_the_author_meta( 'user_nicename', (int) get_query_var( 'author' ) ) ) . '/';
	} elseif ( is_date() ) {
		$parts = array_filter( array( (int) get_query_var( 'year' ), (int) get_query_var( 'monthnum' ), (int) get_query_var( 'day' ) ) );
		$path .= '/Date/' . ( $parts ? implode( '/', $parts ) : get_the_date( 'Y/m' ) ) . '/';
	} elseif ( is_search() ) {
		$path .= '/Find("' . get_search_query( false ) . '")';
	} elseif ( is_404() ) {
		$path .= '/NotFound.DD.Z';
	} elseif ( is_archive() ) {
		$path .= '/Archive/';
	}

	return apply_filters( 'temple_doc_path', $path );
}

/**
 * Tidy a slug for display in a fake file path.
 *
 * @param string $slug Slug or label.
 * @return string
 */
function temple_slug_for_path( $slug ) {
	$slug = urldecode( (string) $slug );
	$slug = str_replace( array( '-', '_' ), ' ', $slug );
	$slug = ucwords( $slug );

	return '' === $slug ? 'Untitled' : str_replace( ' ', '', $slug );
}

/**
 * Print the top status bar: clock, task name, memory and CPU meters.
 *
 * Numbers are filled in by assets/js/templeos.js. Without JavaScript the
 * server time is shown and the meters stay still.
 */
function temple_status_bar() {
	if ( ! get_theme_mod( 'temple_show_status_bar', true ) ) {
		return;
	}

	$cores = (int) apply_filters( 'temple_status_bar_cores', 4 );
	?>
	<div class="tos-statusbar" aria-hidden="true">
		<span class="tos-statusbar__time" data-tos-clock><?php echo esc_html( wp_date( 'D M d H:i:s' ) ); ?></span>
		<span class="tos-statusbar__task"><?php echo esc_html( temple_status_task() ); ?></span>
		<span class="tos-statusbar__mem">Mem:<span data-tos-mem>0x0001F3A000</span></span>
		<span class="tos-statusbar__cpu">
			<?php for ( $i = 0; $i < $cores; $i++ ) : ?>
				<span class="tos-cpu" data-tos-cpu><span class="tos-cpu__label">CPU<?php echo (int) $i; ?></span><span class="tos-cpu__bar"><span class="tos-cpu__fill" style="width:<?php echo (int) ( 10 + ( $i * 17 ) % 60 ); ?>%"></span></span></span>
			<?php endfor; ?>
		</span>
	</div>
	<?php
}

/**
 * The "task" shown in the status bar, like TempleOS shows the focused task.
 *
 * @return string
 */
function temple_status_task() {
	if ( is_search() ) {
		return 'Task:Find';
	}
	if ( is_404() ) {
		return 'Task:Panic';
	}
	if ( is_singular() ) {
		return 'Task:Ed';
	}

	return 'Task:Adam';
}

/**
 * Print a post's date, author, categories and comment count in DolDoc colors.
 */
function temple_entry_meta() {
	$time = sprintf(
		'<time class="entry-date published" datetime="%1$s">%2$s</time>',
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date() )
	);

	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time .= sprintf(
			'<time class="updated screen-reader-text" datetime="%1$s">%2$s</time>',
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);
	}

	echo '<ul class="entry-meta">';

	printf(
		'<li class="entry-meta__date"><span class="tos-key">%1$s</span> <a href="%2$s" rel="bookmark">%3$s</a></li>',
		esc_html__( 'Date:', 'temple' ),
		esc_url( get_permalink() ),
		$time // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above.
	);

	if ( get_the_author() ) {
		printf(
			'<li class="entry-meta__author byline"><span class="tos-key">%1$s</span> <span class="author vcard"><a class="url fn n" href="%2$s">%3$s</a></span></li>',
			esc_html__( 'User:', 'temple' ),
			esc_url( get_author_posts_url( (int) get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() )
		);
	}

	if ( 'post' === get_post_type() ) {
		$categories = get_the_category_list( esc_html_x( ', ', 'list separator', 'temple' ) );
		if ( $categories ) {
			printf(
				'<li class="entry-meta__cats"><span class="tos-key">%1$s</span> %2$s</li>',
				esc_html__( 'Dir:', 'temple' ),
				$categories // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- core-generated links.
			);
		}
	}

	if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<li class="entry-meta__comments"><span class="tos-key">' . esc_html__( 'Msgs:', 'temple' ) . '</span> ';
		comments_popup_link(
			esc_html__( '0', 'temple' ),
			esc_html__( '1', 'temple' ),
			esc_html__( '%', 'temple' )
		);
		echo '</li>';
	}

	echo '</ul>';
}

/**
 * Print tags and the edit link under a post.
 */
function temple_entry_footer() {
	if ( 'post' === get_post_type() ) {
		$tags = get_the_tag_list( '', ' ' );
		if ( $tags ) {
			printf(
				'<p class="tags-links"><span class="tos-key">%1$s</span> %2$s</p>',
				esc_html__( 'Tags:', 'temple' ),
				$tags // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- core-generated links.
			);
		}
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Post title. Only visible to screen readers. */
			esc_html__( '[Edit]%s', 'temple' ),
			'<span class="screen-reader-text"> ' . esc_html( get_the_title() ) . '</span>'
		),
		'<p class="edit-link">',
		'</p>'
	);
}

/**
 * Print the featured image, linked on archive views.
 */
function temple_post_thumbnail() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ) {
		echo '<figure class="post-thumbnail">';
		the_post_thumbnail( 'post-thumbnail', array( 'class' => 'tos-sprite' ) );
		echo '</figure>';
		return;
	}

	printf( '<a class="post-thumbnail" href="%s" aria-hidden="true" tabindex="-1">', esc_url( get_permalink() ) );
	the_post_thumbnail(
		'post-thumbnail',
		array(
			'class' => 'tos-sprite',
			'alt'   => the_title_attribute( array( 'echo' => false ) ),
		)
	);
	echo '</a>';
}

/**
 * Archive pagination, labeled like keyboard keys.
 */
function temple_pagination() {
	the_posts_pagination(
		array(
			'mid_size'           => 1,
			'prev_text'          => esc_html__( '<< PgUp', 'temple' ),
			'next_text'          => esc_html__( 'PgDn >>', 'temple' ),
			'before_page_number' => '<span class="screen-reader-text">' . esc_html__( 'Page', 'temple' ) . ' </span>',
		)
	);
}

/**
 * Print the window "[X]" button. It is decoration that links home.
 */
function temple_window_close() {
	printf(
		'<a class="tos-window__close" href="%1$s" title="%2$s"><span aria-hidden="true">[X]</span><span class="screen-reader-text">%2$s</span></a>',
		esc_url( home_url( '/' ) ),
		esc_attr__( 'Close window and go home', 'temple' )
	);
}

/**
 * Fallback for the menu bar when no menu is assigned: list top-level pages.
 */
function temple_menu_fallback() {
	echo '<ul id="primary-menu" class="tos-menu">';
	printf( '<li><a href="%s">%s</a></li>', esc_url( home_url( '/' ) ), esc_html__( 'Home', 'temple' ) );
	wp_list_pages(
		array(
			'title_li' => '',
			'depth'    => 1,
			'number'   => 6,
		)
	);
	echo '</ul>';
}

/**
 * The fake file name of the current post in the loop, e.g. HelloWorld.DD.Z
 *
 * @return string Plain text (escape on output).
 */
function temple_post_filename() {
	$slug = get_post_field( 'post_name', get_the_ID() );
	if ( '' === $slug ) {
		$slug = get_the_title() ? sanitize_title( get_the_title() ) : (string) get_the_ID();
	}

	return temple_slug_for_path( $slug ) . '.DD.Z';
}

/**
 * Pick a window border color for the nth item in a list, so archive windows
 * cycle through the palette.
 *
 * @param int $index Position in the list.
 * @return string Color slug.
 */
function temple_cycle_color( $index ) {
	$colors = array( 'blue', 'red', 'green', 'purple', 'cyan', 'brown' );

	return $colors[ absint( $index ) % count( $colors ) ];
}
