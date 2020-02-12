<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content
 * after.  Calls sidebar-footer.php for bottom widgets.
 *
 * @package Cryout Creations
 * @subpackage Zombie Apocalypse
 * @since Zombie Apocalypse 0.5
 */
?>	<div style="clear:both;"></div>
	</div> <!-- #forbottom -->
	</div><!-- #main -->


	<div id="footer" role="contentinfo">
		<div id="colophon">

<?php
	/* A sidebar in the footer? Yep. You can can customize
	 * your footer with four columns of widgets.
	 */
	get_sidebar( 'footer' );
?><?php
/* This  retrieves  admin options. */
$options = get_option('za_options');
$zmb_info = $options['zmb_info'];
$zmb_copyright = $options['zmb_copyright'];
?>

			<div id="site-info"  <?php if($options) if ($zmb_info == "Hide") { ?> style="background:none;padding-top:10px;" <?php }   ?> >
				<a href="<?php echo home_url( '/' ) ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
					<?php bloginfo( 'name' ); ?>
				</a>
			</div><!-- #site-info -->
	<?php if ($zmb_copyright != '') { ?><div id="site-copyright"><?php echo $zmb_copyright; ?> </div> <?php } ?>
			<div id="site-generator">
				<?php do_action( 'zombie_credits' ); ?>
				<a href="<?php echo esc_url( __('http://wordpress.org/', 'zombie') ); ?>"
						title="<?php esc_attr_e('Semantic Personal Publishing Platform', 'zombie'); ?>" rel="generator">
					<?php /*printf( __('Proudly powered by %s.', 'zombie'), 'WordPress' );*/ ?>
				</a>
			</div><!-- #site-generator -->

		</div><!-- #colophon -->
	</div><!-- #footer -->

</div><!-- #wrapper -->

</div><!-- #splatter -->
</div><!-- #topper -->
<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>

</body>
</html>
