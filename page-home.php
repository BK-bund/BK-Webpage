<?php get_header(); ?>

<div class="visible-xs">
  <?php get_template_part('navi' , ''); ?>
</div>

<div class="container nopadding"> 
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <?php the_content(); ?>
  <?php endwhile; endif; ?>
</div><!-- body -->

<?php get_footer(); ?>
