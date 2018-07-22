<?php
/**
 * The template for displaying front page.
 *
 * @package realty
 */

get_header();

$container   = get_theme_mod( 'understrap_container_type' );

?>

<div class="wrapper" id="page-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check -->
			<?php get_template_part( 'global-templates/left-sidebar-check' ); ?>

			<main class="site-main" id="main">

				<?php $cities = get_terms( array(
					'taxonomy'    => 'realty_place',
				) ); ?>

				<?php if ( !empty( $cities ) && !is_wp_error( $cities ) ) : ?>
					<?php foreach ( $cities as $city ) : ?>
                        <section class="bg-light mb-5 p-1 col-12">
                            <div class="media text-dark">
		                        <?php $image = wp_get_attachment_image_src(get_field('image', $city), 'thumbnail'); ?>
                                <img class="mr-3" src="<?php echo $image[0]; ?>" alt="<?php echo get_the_title(get_field('image', $city)) ?>" />
                                <div class="media-body">
                                    <h2 class="mt-0"><a href="<?php echo get_term_link($city->term_id) ?>"><?php echo $city->name ?></a></h2>
			                        <?php echo lineToParagraph( $city->description ) ?>
                                </div>
                            </div>
                            <h4 class="mb-3 mt-3"><?php echo __( 'Свежие объекты в этом городе', 'rlt' ) ?></h4>
                            <?php $posts = get_posts( array(
                                    'numberposts' => 6,
                                    'post_type' => 'realty',
                                    'tax_query' => array(
	                                    array(
		                                    'taxonomy' => 'realty_place',
		                                    'terms' => $city->term_id
	                                    )
                                    )
                                ) ); ?>
                                <div class="container">
                                    <div class="row">
	                                    <?php foreach ( $posts as $post ) : ?>
                                            <?php setup_postdata( $post ); ?>
                                            <div class="col-md-4 mb-3">
                                                <div class="card">
                                                    <?php the_post_thumbnail() ?>
                                                    <div class="card-body">
                                                        <h5 class="card-title"><?php the_title() ?></h5>
                                                        <?php $types = get_the_terms( get_the_ID() , 'realty_type' ); ?>
                                                        <?php foreach ( $types as $type ) : ?>
                                                            <p><?php echo __( 'Тип объекта: ', 'rlt' ) . '<a href="' . get_term_link( $type->term_id ) . '">' . $type->name . '</a>' ?></p>
                                                        <?php endforeach; ?>
                                                        <div class="alert alert-dark">
                                                            <p><?php echo __( 'Площадь:', 'rlt' ) . ' ' . get_field('area') . ' ' .  __( 'кв. м.', 'rlt' ) ?></p>
                                                            <p><?php echo __( 'Жилая площадь:', 'rlt' ) . ' ' . get_field('living_area') . ' ' .  __( 'кв. м.', 'rlt' )?></p>
                                                            <p><?php echo __( 'Стоимость:', 'rlt' ) . ' ' . get_field('price') . ' ' .  __( 'руб', 'rlt' ) ?></p>
                                                            <p><?php echo __( 'Адрес:', 'rlt' ) . ' ' . get_field('address') ?></p>
                                                            <p><?php echo __( 'Этаж:', 'rlt' ) . ' ' . get_field('floor') ?></p>
                                                        </div>
                                                        <p class="card-text"><?php the_excerpt() ?></p>
                                                    </div>
                                                </div>
                                            </div>
	                                    <?php endforeach; ?>
                                        <?php wp_reset_postdata(); ?>
                                    </div>
                                </div>
                        </section>

					<?php endforeach; ?>
				<?php endif; ?>

			</main><!-- #main -->

			<!-- Do the right sidebar check -->
			<?php get_template_part( 'global-templates/right-sidebar-check' ); ?>

		</div><!-- .row -->

	</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
