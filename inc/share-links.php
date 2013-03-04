<?php global $size; ?>
<div class="border share-links <?php echo (isset($size)) ? $size : '' ?>">
	<header class="header">
		<h5 class="novecento-bold uppercase title"><?php _e("Share", 'editer'); ?></h5>
	</header>
	<div class="inner">
		<ul class="unstyled-list">
			<li>
				<a class="share-email-btn" href="mailto: your.friends.email@address.com" target="_blank"><?php _e('Email this article');?></a>
			</li>
			<li>
				<a class="share-twitter-btn share-popup-btn" href="http://twitter.com/share?text=<?php the_title();?>"><?php _e('Tweet this article');?></a>
			</li>
			<li>
				<a class="share-facebook-btn share-popup-btn" href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>&t=<?php the_title();?>"><?php _e('Share on Facebook');?></a>
			</li>
			<li>
				<a class="share-link-btn tooltip-btn"><?php _e('Link to this article');?><div class="tooltip"><input type="text" value="<?php the_permalink(); ?>" /></div></a>
			</li>
		</ul>
	</div>
</div>
<?php unset($size); ?>