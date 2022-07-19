<?php

get_header(); ?>


<?php
$controller = new PostController;
$current_posts = $controller->getPosts();
$current_taxo = $controller->taxonomy;
?>

<div class="row">
	<div class="ab-primary col-9">

		<?php if (isset($current_posts)) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php echo $current_taxo->name ?></h1>
				<div class="taxonomy-description"><?php echo $current_taxo->description ?></div>
			</header>

			<?php
			foreach ($current_posts as $post) {
			?>
			<div class="postpreview">
				<div class="post-thumbnail" style='background-image: url(<?php echo $post->thumb ?>);'>
					<div class="card-content">
						<h6>
							<?php echo $post->category ?>
						</h6>
						<h5>
							<a href="<?php echo $post->permalink ?>">
								<?php echo $post->title ?>
							</a>
						</h5>
						<p>
							<?php echo $post->excerpt ?>
						</p>
					</div>
				</div>
			</div>
			<?php } 

		endif; ?>

		<div class="paginate">
			<?php echo paginate_links(); ?>
		</div>
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