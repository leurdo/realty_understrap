<?php
/**
 * Single post partial template.
 *
 * @package understrap
 */

?>
<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header">

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta">

			<?php understrap_posted_on(); ?>

			<?php $types = get_the_terms( get_the_ID() , 'realty_type' ); ?>
			<?php foreach ( $types as $type ) : ?>
                <p><?php echo __( 'Тип объекта: ', 'rlt' ) . '<a href="' . get_term_link( $type->term_id ) . '">' . $type->name . '</a>' ?></p>
			<?php endforeach; ?>

		</div><!-- .entry-meta -->

	</header><!-- .entry-header -->

	<?php echo get_the_post_thumbnail( $post->ID, 'full' ); ?>

	<div class="entry-content">

		<?php the_content(); ?>

        <div class="alert alert-dark">
            <p><?php echo __( 'Площадь:', 'rlt' ) . ' ' . get_field('area') . ' ' .  __( 'кв. м.', 'rlt' ) ?></p>
            <p><?php echo __( 'Жилая площадь:', 'rlt' ) . ' ' . get_field('living_area') . ' ' .  __( 'кв. м.', 'rlt' )?></p>
            <p><?php echo __( 'Стоимость:', 'rlt' ) . ' ' . get_field('price') . ' ' .  __( 'руб', 'rlt' ) ?></p>
            <p><?php echo __( 'Адрес:', 'rlt' ) . ' ' . get_field('address') ?></p>
            <p><?php echo __( 'Этаж:', 'rlt' ) . ' ' . get_field('floor') ?></p>
        </div>

		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
			'after'  => '</div>',
		) );
		?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php understrap_entry_footer(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
