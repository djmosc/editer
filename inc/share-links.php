<div class="share-links dotted-border">
	<div class="inner">
		<div class="text-center no-margin">
			<a class="share-email-btn" href="mailto: your.friends.email@address.com" target="_blank"><?php _e('Email this article');?></a>
			<a class="share-twitter-btn share-popup-btn" href="http://twitter.com/share?text=<?php the_title();?>"><?php _e('Tweet this article');?></a>
			<a class="share-facebook-btn share-popup-btn" href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>&t=<?php the_title();?>"><?php _e('Share on Facebook');?></a>
			<a class="share-link-btn tooltip-btn"><?php _e('Link to this article');?><div class="tooltip"><input type="text" value="<?php the_permalink(); ?>" /></div></a>
		</div>
	</div>
</div>