<?php
get_header();
global $wp_query;
?>

<div class="row">
	<h1 class="search-title">
		<?php _e('Résultat(s) de recherche pour ', 'locale'); ?>: "<?php the_search_query(); ?>" </h1>
	<div class="ab-primary col-9">
		<?php if (have_posts()) :
			while (have_posts()) : the_post(); ?>
				<div class="col my-5 post-thumbnail" style='background-image: url(<?php the_post_thumbnail_url() ?>);'>
					<div class="card-img-overlay">
						<h6 class="#">
							<?php the_category() ?>
						</h6>
						<h5 class="#">
							<a href="<?php the_permalink() ?>" class="#">
								<?php the_title() ?>
							</a>
						</h5>
						<p class="#">
							<?php the_excerpt() ?>
						</p>
					</div>
				</div>
			<?php endwhile;
		else : ?>
			<h1>Pas d'articles</h1>
		<?php endif; ?>
	</div>
	<div class="ab-secondary col-3">
		<?php
		$sidebar = get_sidebar('blog-sidebar');
		if ($sidebar = true) :
		?>
			<aside class="">
				<?php dynamic_sidebar('blog-sidebar') ?>
			</aside>
		<?php endif; ?>
	</div>
</div>

<?php get_footer(); ?>