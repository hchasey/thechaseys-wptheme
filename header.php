<!DOCTYPE html>
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <!--[if lt IE 9]>
    <script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
    <![endif]-->
    <link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<header class="site-header">
		<h1 class="site-title">
        	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<?php bloginfo( 'name' ); ?>
            </a>
        </h1>
	</header><!-- .site-header -->
	<div id="main" class="wrapper">