<?php

//Set theme up
if ( ! function_exists( 'bplate_setup' ) ) :

    function bplate_setup() {
        //RSS feed links to head
        add_theme_support( 'automatic-feed-links' );

        //Let WordPress handle the title tag
        add_theme_support( 'title-tag' );

        //Add post thumbnail support
        add_theme_support( 'post-thumbnails' );

        //Add a navigation menu
        register_nav_menus( array(
            'menu-1' => esc_html__( 'Primary', 'bplate' ),
        ) );

        //Change core markup so it's valid HTML5
        add_theme_support( 'html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ) );

        //Add support for selective refresh widgets
        add_theme_support( 'customize-selective-refresh-widgets' );
    }

endif;
add_action( 'after_setup_theme', 'bplate_setup' );

//Add a widget area
function bplate_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'bplate' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'bplate' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'bplate_widgets_init' );

//Enqueue scripts and styles
function bplate_scripts() {
    //Enqueue style.css
	wp_enqueue_style( 'bplate-style', get_stylesheet_uri() );

    //Enqueue JQuery
    wp_deregister_script('jquery');
    wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js", false, null, true);
    wp_enqueue_script('jquery');

    //Enqueue Comment Reply script
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'bplate_scripts' );

//Added posted on function (Meta information)
if ( ! function_exists( 'bplate_posted_on' ) ) :
function bplate_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		/* translators: %s: post date. */
		esc_html_x( 'Posted on %s', 'post date', 'bplate' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		/* translators: %s: post author. */
		esc_html_x( 'by %s', 'post author', 'bplate' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

}
endif;

?>