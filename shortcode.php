<?php
/**
 * Created by PhpStorm.
 * User: Pro
 * Date: 02.12.2015
 * Time: 14:29
 * Short codes wp functions
 */

add_shortcode( 'mycity_top_promo_bloc', 'mycity_top_promo_bloc_func' );

/**
 * @param $atts
 *
 * @return string
 */
function mycity_top_promo_bloc_func( $atts ) {
	$atts = shortcode_atts(
		array(
			'h' => esc_html__( 'welcome to my city guide!', "mycity" ),
			'desc' => esc_html__( 'See and visit interesting places. Share experiences with your friends. Simply', "mycity" ),
			'find' => esc_html__( "Find places or events", "mycity" ),
			'sc' => esc_html__( 'Select category', 'mycity' ),
			'st' => esc_html__( 'Select type', 'mycity' ),
			'stp' => esc_html__( 'Places', 'mycity' ),
			'sta' => esc_html__( 'All', 'mycity' ),
			'search' => esc_html__( "Search", "mycity" )
		), $atts
	);
	ob_start();
	?>
	<div class="top_promo_block" id="promo_head">
		<div class="section-bg-overlay infinite-background above-bg"></div>
		<script>
			jQuery('#promo_head').css({
				height: jQuery(window).height() + 'px'
			});
			winHeight = jQuery(window).height();
			jQuery('#hero-bg').height(winHeight + 30);
		</script>
		<div class="start_descrition">
			<h1>
				<hi><?php echo esc_html( $atts['h'] ); ?></hi>
				<span id='ispan'></span></h1>
			<span><?php echo esc_html( $atts['desc'] ); ?></span>

			<div class="search_promo">
				<form action='<?php echo esc_url( get_home_url( '/' ) ) ?>/places' method='post'>
					<div class="input-group">
						<input id="search_cat_hide" type="hidden" value="" name="cat_slug"/>
						<input id="search_type_hide" type="hidden" value="" name="search_type"/>
						<input type="text" name='search'
						       placeholder="<?php echo esc_html( $atts['find'] ); ?>"
						       class="form-control">

						<div class="input-group-btn btn_cat1 btn_cat">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
							        aria-expanded="false">
                                <span><a data-catis="-1"></a> <i class="fa fa-caret-square-o-down"></i>
	                                <?php echo esc_html( $atts['sc'] ); ?>
	                                <span class="caret"></span></span>
							</button>
							<ul class="dropdown-menu dropdown-menu-right place_dd" role="menu">
								<?php
								$mycity_categories = get_categories( "parent=0&taxonomy=places_categories&hide_empty=0" );
								foreach ( $mycity_categories as $mycity_place_cat ) {
									$icon = get_option( "fa_icon_" . (int) $mycity_place_cat->term_id );
									$class = ( preg_match( '/fmr/', $icon ) ) ? " fmr " : " fa ";
									?>
									<li><a href="#" data-catis="<?php echo esc_attr( $mycity_place_cat->term_id ); ?>"
									       class="cinema">
											<i class="<?php echo esc_attr( $class ); ?> <?php echo esc_attr( $icon ); ?>"></i><?php echo esc_html( $mycity_place_cat->name ); ?>
										</a></li>
									<?php
								}
								?>
							</ul>


						</div>
						<!---
                        <div class="input-group-btn btn_cat  btn_cat2">
                            <button type="button"
                                    class="btn btn-default dropdown-toggle2" data-toggle="dropdown"
                                    aria-expanded="false">
        <span><a data-catis="-1"></a> <i class="fa fa-caret-square-o-down"></i>
    <?php echo esc_html( $atts['st'] ); ?>
    <span class="caret"></span></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right2 place_dd" role="menu" style="
    width: 100px;
">
                                <li><a href="#" data-catis="1" class="cinema">
                                        <i class=""></i> <?php echo esc_html( $atts['stp'] );; ?></a></li>
                                <li><a href="#" data-catis="2" class="cinema">
                                        <i class=""></i><?php echo esc_html( $atts['sta'] );; ?></a></li>

                            </ul>
                        </div>


                        -->
						<div class="input-group-btn btn_promo_search">
							<button type="submit"
							        class="btn btn-success"><?php echo esc_html( $atts['search'] ); ?></button>
						</div>
					</div>
				</form>

			</div>
		</div>
		<div class="scroll_block">
			<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/scroll.png"
			     class="animated infinite bounce" alt="<?php esc_html_e( "Use your scrollwheel :)", "mycity" ); ?>">
		</div>
	</div>

	<script>

		jQuery(document).ready(function ($) {

			$(document).on("click", '#edited_Searchindex', function (e) {

				jQuery('#search_cat_hide').val(jQuery('.btn_cat1 .dropdown-toggle a').data('catis'));
				jQuery('#search_type_hide').val(jQuery('.btn_cat2 .dropdown-toggle a').data('catis'));

			});
		});
	</script>
	<?php
	return ob_get_clean();
}

add_shortcode( 'mycity_item_wide', 'mycity_item_wide_func' );
/*
 *
 */
function mycity_item_wide_func( $atts, $content ) {
	$content = ( !empty( $content ) ) ? $content : "";
	$atts = shortcode_atts(
		array(
			'h' => esc_html__( 'Features My City', 'mycity' ),
		), $atts
	);
	ob_start();
	?>
	<div class="item_wide_container">
		<div class="fea_block container-fluid">
			<div class="fixed_w">
				<h2><?php echo esc_html__( $atts['h'] ); ?></h2>

				<div class="row">
					<?php
					echo do_shortcode( $content );

					?>
				</div>
			</div>
		</div>
	</div>
	<?php

	return ob_get_clean();
}


add_shortcode( 'mycity_features_block', 'mycity_mycity_features_block_func' );

function mycity_mycity_features_block_func( $atts, $content = '' ) {
	$atts = shortcode_atts(
		array(
			'h' => esc_html__( 'features block', 'mycity' ),
			'icon' => 'fa-mobile'
		), $atts
	);
	$class = ( preg_match( '/fmr/', $atts['icon'] ) ) ? "fmr" : "fa";
	ob_start();
	?>
	<div class="col-md-4 fea_item wow bounceInUp">
		<h3>
			<i class="<?php echo esc_attr( $class . " " . $atts['icon'] ); ?>"></i><?php echo esc_html( $atts['h'] ); ?>
		</h3>
		<span><?php echo wp_kses_post( $content ); ?></span>
	</div>
	<?php
	return ob_get_clean();
}

//categori_block
add_shortcode( 'mycity_categori_block', 'mycity_categori_block_func' );
/**
 * @param $atts
 *
 * @return string
 */
function mycity_categori_block_func( $atts ) {
	$atts = shortcode_atts(
		array(
			'h' => esc_html__( 'We know all the places in your city', 'mycity' ),
			'btn' => esc_html__( 'View all places', 'mycity' ),
			'url' => '/places'
		), $atts
	);
	ob_start();
	?>
	<div class="categori_block container-fluid">
		<div class="fixed_w">
			<h2><?php echo esc_html( $atts['h'] ); ?></h2>

			<div class="row">
				<?php
				$mycity_categories = get_categories( "parent=0&taxonomy=places_categories&hide_empty=0" );

				foreach ( $mycity_categories as $mycity_place_cat ) {
					$class = ( preg_match( '/fmr/', get_option( "fa_icon_" . (int) $mycity_place_cat->term_id ) ) ) ? "fmr" : "fa";
					?>
					<div class="col-md-3 cat_item wow bounceInLeft">
						<div class="car_item_in" onclick="location.href='<?php
						$link = get_term_link( $mycity_place_cat );

						if ( !is_wp_error( $link ) ) {
							echo esc_url( $link );
						}
						?>';">
							<i class=" <?php echo esc_html( $class . ' ' .
							                                get_option( "fa_icon_" . (int) $mycity_place_cat->term_id ) ); ?>"
							></i>
							<h4><?php echo esc_html( $mycity_place_cat->name ); ?></h4>
						</div>
					</div>
					<?php
				}
				?>
			</div>
			<a href="<?php echo esc_url( $atts['url'] ); ?>"
			   class="btn btn-success va"><?php echo esc_html( $atts['btn'] ); ?></a>
		</div>
	</div>
	<?php
	return ob_get_clean();

}

//map
add_shortcode( 'mycity_map', 'mycity_map_func' );
/**
 * @param $atts
 *
 * @return string
 */
function mycity_map_func( $atts ) {
	$atts = shortcode_atts(
		array(
			'h' => esc_html__( 'View full place catalog', 'mycity' ),
		), $atts
	);
	$short_return = "";
	ob_start();

	?>
	<div class="map_block container-fluid">
		<div class="map_descr">
			<span><?php echo esc_html( $atts['h'] ); ?></span>
		</div>

		<script>
			var
				mapObject,
				markers = [],
				markersData = {
					<?php
					$short_return = ob_get_clean();

					$mycity_categories = get_categories( "taxonomy=places_categories&hide_empty=0" );
					$places_categories = array();

					foreach ( $mycity_categories as $mycity_place_cat ) {
						$mycity_init_maps_point_by_term_slug = mycity_init_maps_point_by_term_slug( $mycity_place_cat->term_id );
						if ( !$mycity_init_maps_point_by_term_slug ) {
							continue;
						}
						$places_categories[] = "'" . esc_html( $mycity_place_cat->slug ) . "': [" . print_r( $mycity_init_maps_point_by_term_slug, true ) . "]";
					}

					$short_return .= implode( ",", $places_categories );
					ob_start();
					?>
				};
			var global_scrollwheel = false;
			var global_drag = false;

			function initialize_map() {
				loadScript("<?php echo esc_url( get_template_directory_uri() ); ?>/js/infobox.js", after_load);
			}

			function after_load() {

				var global_scrollwheel = true;
				var markerClusterer = null;
				var markerCLuster;
				var Clusterer;

				initialize_new();

			}
		</script>
		<div class="index_map" id="map"></div>


	</div>


	<?php
	$short_return .= ob_get_clean();
	return $short_return;

}


/*
 * Users blocks-
 */


add_shortcode( 'mycity_users_blocks', 'mycity_users_blocks_func' );
/**
 * @param $atts
 *
 * @return string
 */
function mycity_users_blocks_func( $atts ) {
	global $wpdb;
	$atts = shortcode_atts(
		array(
			'h' => esc_html__( 'The best user weekly', 'mycity' ),
		), $atts
	);
	ob_start();
	?>
	<!--Users blocks-->
	<div class="user_block container-fluid">
		<div class="fixed_w">
			<h2><?php echo esc_html( $atts['h'] ); ?></h2>

			<div class="row">
				<?php
				do_action( 'bp_before_directory_members_list' );

				?>
				<?php
				$blogusers = get_users( 'orderby=registered&number=4' );
				foreach ( $blogusers as $user ) {
					//get commments count

					$comment_counts = (array) $wpdb->get_results( $wpdb->prepare( "SELECT user_id, COUNT( * ) AS total FROM {$wpdb->comments}
        WHERE comment_approved = 1 AND user_id = '%d'
		GROUP BY user_id",
						$user->ID
					), object );

					$followers_count = (array) $wpdb->get_results( $wpdb->prepare( "SELECT COUNT( * ) AS total FROM follow	WHERE user2 = '%d'", $user->ID
					), object );
					?>
					<div class="col-md-3 user_cover wow bounceInLeft">
						<div class="user_item">
							<div class="user_item_cont">
								<img src="<?php
								$params = array( 'width' => 100, 'height' => 100 );
								$img_url = bfi_thumb( mycity_get_url_by_avatar( get_avatar( $user->ID, 66 ) ), $params );
								echo esc_url( $img_url ); ?>" alt="#">
								<a href="<?php echo mycity_get_member_permalink( $user->ID ); ?>"
								   class="names"><?php echo esc_html( $user->display_name ); ?></a>

								<div class="bottom_link">
									<ul>
										<li><a href="<?php echo mycity_get_member_permalink( $user->ID ); ?>"><i
													class="fa fa-thumbs-o-up"></i><?php echo esc_html( get_user_meta( $user->ID, "folowing", true ) ); ?>
											</a></li>
										<li><a href="<?php echo mycity_get_member_permalink( $user->ID ); ?>"><i
													class="fa fa-comment-o"></i><?php if ( isset( $comment_counts[0]->total ) ) {
													echo esc_html( $comment_counts[0]->total );
												} ?></a></li>
										<li><a href="<?php echo mycity_get_member_permalink( $user->ID ); ?>"><i
													class="fa fa-users"></i><?php echo esc_html( $followers_count[0]->total ); ?>
											</a></li>
										<li class="last"><a
												href="<?php echo mycity_get_member_permalink( $user->ID ); ?>"><i
													class="fa fa-map-marker"></i>0</a></li>
									</ul>
								</div>
							</div>
							<?php
							$user_date = get_userdata( $user->ID )->data;
							$site = sanitize_text_field( $user_date->user_url );

							if ( $site ) {
								?>
								<a href="<?php echo esc_html( $site ); ?>" class="fb_btn"><i
										class="fa fa-facebook-official"></i></a>
							<?php } ?>

							<img
								src="<?php echo esc_url( mycity_get_url_by_avatar( get_avatar( $user->ID, 100 ) ) ); ?>"
								class="blurbg" alt="">
						</div>
					</div>
				<?php }

				?>

			</div>

			<?php
			$n = 0;
			$blogusers = get_users( 'orderby=registered&offset=4&number=12' );
			foreach ( $blogusers as $user ) { ?>
				<div class="user_sm col-md-1 wow bounceInRight"
				     onclick="location.href='<?php echo mycity_get_member_permalink( $user->ID ); ?>';">
					<span class="user_num"><?php echo esc_attr( $n ++ ); ?></span>

					<div class="min_u_hover">
						<div class="user_go">
							<i class="fa fa-link"></i>
						</div>
						<img src="<?php
						$params = array( 'width' => 66, 'height' => 66 );
						$img_url = bfi_thumb( mycity_get_url_by_avatar( get_avatar( $user->ID, 66 ) ), $params );
						echo esc_url( $img_url ); ?>" alt="#">
					</div>
				</div>
				<?php
			}
			?>

		</div>
	</div>


	<?php
	return ob_get_clean();
}

///places_block

add_shortcode( 'mycity_places_block', 'mycity_places_block_func' );
/**
 * @param $atts
 *
 * @return string
 */
function mycity_places_block_func( $atts ) {

	global $wpdb;
	$atts = shortcode_atts(
		array(
			'h' => esc_html__( 'The best places weekly', 'mycity' ),
			'btn' => esc_html__( 'View all places', 'mycity' ),
			'count' => 3,
			'show_rating' => 1,
			'max_chars' => 250,
			'cat' => 0
		), $atts
	);

	extract( $atts );

	$count = (int) $count;
	if ( $count == 0 ) {
		$count = 3;
	}

	$max_chars = (int) $max_chars;
	if ( $max_chars == 0 ) {
		$max_chars = 250;
	}

	ob_start();

	?>
	<div class="places_index_block container-fluid">
		<div class="fixed_w">
			<h2><?php echo esc_html( $atts['h'] ); ?></h2>
			<div class="row">
				<?php

				wp_reset_postdata();
				global $MyCity_class, $post;
				$stiky = array();
				if ( get_option( 'sticky_posts' ) ) {
					$stiky = get_option( 'sticky_posts' );
				}
				$args = array(
					'post__not_in' => array_merge( $MyCity_class->get_empty_places(), $stiky ),
					'post_type' => array(
						'places'
					),
					'posts_per_page' => 100,
					'orderby' => 'date',
					'order' => 'DESC'
				);
				$cat = trim( $cat );
				if ( isset( $cat{2} ) ) {
					$args['tax_query'] = array(
						array(
							'taxonomy' => 'places_categories',
							'terms' => sanitize_text_field( $cat ),
							'field' => 'slug'
						)
					);

				}

				$related_post = new WP_Query( $args );

				$j = 0;
				if ( $related_post->have_posts() ) {
					while ( $related_post->have_posts() ) {
						$related_post->the_post();
						//var_dump($related_post);
						$big_img = wp_get_attachment_url( get_post_meta( (int) $post->ID, '_big_img', true ) );
						$big_img = bfi_thumb( $big_img, array( 'width' => 360, 'height' => 210 ) );
						if ( strlen( $big_img ) > 0 && $j < $count ) {
							$except = ( get_post_meta( get_the_ID(), 'smalldescr', true ) ) ? ( get_post_meta( get_the_ID(), 'smalldescr', true ) ) : get_the_excerpt();
							if ( iconv_strlen( $except, 'utf-8' ) > $max_chars ) {
								$out = trim( $except, '/' );
								$out = str_replace( "/", '', $out );
								$out = iconv_substr( $out, 0, $max_chars, 'utf-8' );
								$except = preg_replace( '@(.*)\s[^\s]*$@s', '\\1...', $out );
							}
							?>
							<div class="col-xs-12 col-sm-12 col-md-4 place_index_item  wow bounceInLeft">
								<div class="place_inn">
									<div class="place_indexImg">
										<img src="<?php echo esc_url( $big_img ); ?>" alt="<?php the_title(); ?>">
									</div>
									<div class="pl_descr">
										<a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_title(); ?></a>
            <span>
                <?php echo str_replace( array( '<p>', '</p>' ), array( '', '' ), $except ); ?>
            </span>
										<?php

										$rating = mycity_get_currentplace_rating( get_the_ID() );
										if ( $rating == 0 ) {
											$rating = 5;
										}

										mycity_stars( $rating );

										?>
									</div>
								</div>
							</div>
							<?php $j ++;
						}
					}
				}
				wp_reset_postdata();
				?>
			</div>
			<a href="<?php echo esc_url( get_post_type_archive_link( "places" ) ); ?>" class="btn btn-success va">
				<?php echo esc_html( $atts['btn'] ); ?></a>
		</div>
	</div>
	<?php
	return ob_get_clean();
}

///places_block

add_shortcode( 'mycity_price_table', 'mycity_price_table_func' );
/**
 * @param $atts
 *
 * @return string
 */
function mycity_price_table_func( $atts ) {

	global $wpdb;
	$atts = shortcode_atts(
		array(
			'h' => esc_html__( "See and visit interesting places. Share experiences with your friends. Simply", "mycity" ),
			'btn' => esc_html__( 'View all places', 'mycity' ),
			'items1' => '',
			'items2' => '',
			'items3' => '',
			'bt1' => esc_html__( "Add place", "mycity" ),
			'bt2' => esc_html__( "Add place", "mycity" ),
			'bt3' => esc_html__( "Add place", "mycity" ),
			'url1' => '#',
			'url2' => '#',
			'url3' => '#',
		), $atts
	);
	//extract($atts);

	if ( function_exists( 'vc_param_group_parse_atts' ) ) {
		$items_v1 = vc_param_group_parse_atts( $atts['items1'] );
		$items_v2 = vc_param_group_parse_atts( $atts['items2'] );
		$items_v3 = vc_param_group_parse_atts( $atts['items3'] );
	}


	ob_start();
	/// var_dump($atts);

	?>

	<div class="promo_block container-fluid">
		<div class="cd-pricing-container">

			<p class='edited'
			   id='edited_seeplaceindex'><?php echo esc_html( $atts['h'] ); ?></p>
			<ul class="cd-pricing-list cd-bounce-invert">
				<li>
					<ul class="cd-pricing-wrapper">
						<li class="is-visible">
							<div class="cd-pricing-header">
								<h2 class="cd-value edited"
								    id='edited_cur0free'><?php echo esc_html_e( "Free", "mycity" ); ?></h2>

								<div class="cd-price">
									<span class="cd-currency edited" id='edited_curdollar'>$</span>
									<span class="cd-value edited" id='edited_cur0'>0</span>
                                    <span class="cd-duration edited"
                                          id='edited_curmo0'><?php echo esc_html_e( "mo", "mycity" ); ?></span>
								</div>
							</div> <!-- .cd-pricing-header -->

							<div class="cd-pricing-body">
								<ul class="cd-pricing-features">

									<?php if ( $items_v1 ) {
										foreach ( $items_v1 as $item ) {

											?>
											<li>
												<em><?php if ( isset( $item['title'][0] ) ) {
														echo esc_html( $item['title'] );
													} ?></em>
                                                <span
                                                ><?php if ( isset( $item['value'][0] ) )
		                                                echo esc_html( $item['value'] ) ?></span>
											</li>
										<?php }
									} ?>
								</ul>
							</div> <!-- .cd-pricing-body 222-->

							<div class="cd-pricing-footer">
								<a class="cd-select"
								   href="<?php echo esc_url( $atts['url1'] ); ?>"><?php echo esc_html( $atts['bt1'] ); ?></a>
							</div> <!-- .cd-pricing-footer -->
						</li>
					</ul> <!-- .cd-pricing-wrapper -->
				</li>

				<li class="cd-popular">
					<ul class="cd-pricing-wrapper">
						<li class="is-visible">
							<div class="cd-pricing-header">

								<h2 class="edited" id='edited_h1annual2'><?php esc_html_e( "Annual", "mycity" ); ?></h2>

								<div class="cd-price">
									<span class="cd-currency edited" id='edited_curdollar2'>$</span>
									<span class="edited cd-value " id='edited_cur600'>60</span>
                                    <span class="cd-duration edited"
                                          id='edited_curmo12'><?php echo esc_html_e( "year", "mycity" ); ?></span>
								</div>
							</div> <!-- .cd-pricing-header -->

							<div class="cd-pricing-body">
								<ul class="cd-pricing-features">
									<?php if ( $items_v2 ) {
										foreach ( $items_v2 as $item ) {

											?>
											<li>
												<em><?php if ( isset( $item['title'][0] ) ) {
														echo esc_html( $item['title'] );
													} ?></em>
                                                <span
                                                ><?php if ( isset( $item['value'][0] ) )
		                                                echo esc_html( $item['value'] ) ?></span>
											</li>
										<?php }
									} ?>
								</ul>
							</div> <!-- .cd-pricing-body -->

							<div class="cd-pricing-footer">
								<a class="cd-select"
								   href="<?php echo esc_url( $atts['url2'] ); ?>"><?php echo esc_html( $atts['bt2'] ); ?></a>
							</div> <!-- .cd-pricing-footer -->
						</li>

					</ul> <!-- .cd-pricing-wrapper -->
				</li>

				<li>
					<ul class="cd-pricing-wrapper">
						<li class="is-visible">
							<div class="cd-pricing-header">
								<h2 class="edited"
								    id='edited_cur20_an'><?php echo esc_html_e( "Monthly", "mycity" ); ?></h2>

								<div class="cd-price">
									<span class="cd-currency edited" id='edited_curdollar'>$</span>
									<span class="cd-value edited" id='edited_cur20'>20</span>
									<span class="cd-duration edited" id='edited_curmo2'>mo</span>
								</div>
							</div> <!-- .cd-pricing-header -->

							<div class="cd-pricing-body">
								<ul class="cd-pricing-features">
									<?php if ( $items_v3 ) {
										foreach ( $items_v3 as $item ) {

											?>
											<li>
												<em><?php if ( isset( $item['title'][0] ) ) {
														echo esc_html( $item['title'] );
													} ?></em>
                                                <span
                                                ><?php if ( isset( $item['value'][0] ) )
		                                                echo esc_html( $item['value'] ) ?></span>
											</li>
										<?php }
									} ?>
								</ul>
							</div> <!-- .cd-pricing-body -->

							<div class="cd-pricing-footer">
								<a class="cd-select"
								   href="<?php echo esc_url( $atts['url3'] ); ?>"><?php echo esc_html( $atts['bt3'] ); ?></a>
							</div>  <!-- .cd-pricing-footer -->
						</li>
					</ul> <!-- .cd-pricing-wrapper -->
				</li>

			</ul> <!-- .cd-pricing-list -->
		</div> <!-- .cd-pricing-container -->
	</div>

	<?php
	return ob_get_clean();
}


/*********************************Buttons for WordPress TinyMCE Editor*///////////////////////////////////////////////*

// Filter Functions with Hooks
function custom_mce_button() {
	// Check if user have permission
	if ( !current_user_can( 'edit_posts' ) || !current_user_can( 'edit_pages' ) ) {
		return;
	}
	// Check if WYSIWYG is enabled
	if ( 'true' == get_user_option( 'rich_editing' ) ) {
		add_filter( 'mce_external_plugins', 'custom_tinymce_plugin' );
		add_filter( 'mce_buttons', 'register_mce_button' );
	}
}

add_action( 'admin_head', 'custom_mce_button' );

// Function for new button
function custom_tinymce_plugin( $plugin_array ) {
	$plugin_array['custom_mce_button'] = get_template_directory_uri() . '/js/editor_plugin.js';
	return $plugin_array;
}

// Register new button in the editor
function register_mce_button( $buttons ) {
	array_push( $buttons, 'custom_mce_button' );
	return $buttons;
}

function custom_css_mce_button() {

	$obj = array(
		'TinyMCE_html' => mycity_fmr_icons()
	);
	wp_localize_script( 'jquery', 'mycity_obj', $obj );

	wp_enqueue_style( 'mycity_shortcode_tin', get_template_directory_uri() . "/css/admin/shortcode.css" );
}

add_action( 'admin_enqueue_scripts', 'custom_css_mce_button', 500 );

/**
 * @return string
 */
function mycity_fmr_icons() {
	global $mycity_fmr_icon;
	ob_start();
	?>
	<div id="mycity_icon_content">
		<div class="mycity_icon_block">
			<b><?php echo esc_html( 'Trendy icon name', 'mycity' ); ?> </b> <br/>


			<?php
			$exclude = array(
				'fmr-icon-114',
				'fmr-icon-268',
				'fmr-icon-2412',
				'fmr-icon-3516',
				'fmr-icon-4412',
				'fmr-icon-69',
				'fmr-icon-340',
				'fmr-icon-483',
				'fmr-icon-2103',
				'fmr-icon-2104',
				'fmr-icon-2104',
				'fmr-icon-4519'
			);
			foreach ( $mycity_fmr_icon as $v ) {
				if ( in_array( $v, $exclude ) ) {
					continue;
				}
				?>

				<i class="fmr extra_admin_1 <?php echo esc_attr( $v ); ?>" data-icon="<?php echo esc_html( $v ); ?>"
				   onclick='jQuery(".extra_admin_1").removeClass("active"); jQuery(this).addClass("active"); '> <?php ?></i>
				<?php

			}
			?>
		</div>
		<div class="mycity_icon_block">
			<br/>
			<b><?php esc_html_e( 'Font awesome icon name',
					'mycity' ); ?> </b> <br/>


			<?php
			global $mycity_fa;
			foreach ( $mycity_fa as $v ) {
				?>
				<i class="extra_admin_1 fa <?php echo esc_attr( $v ); ?>" data-icon="<?php echo esc_html( $v ); ?>"
				   onclick='jQuery(".extra_admin_1").removeClass("active"); jQuery(this).addClass("active"); '> <?php ?></i>
				<?php
			}
			?>

		</div>
	</div>

	<?php
	return ob_get_clean();

}


add_shortcode( 'places', 'mycity_places_func' );
/**
 * @param $atts
 *
 * @return string
 */
function mycity_places_func( $atts ) {
	ob_start();
	global $MyCity_class;
	$atts = shortcode_atts(
		array(
			'cat' => '',
			'type' => 'list'

		), $atts
	);

	$mycity_args = array(
		'post_type' => 'places',
		'post_status' => 'publish',
		'showposts' => sanitize_text_field( get_option( 'posts_per_page' ) ),
		'post__not_in' => $MyCity_class->get_empty_places(),
		'paged' => 1

	);


	if ( isset( $atts['cat']{0} ) ) {
		$mycity_args['tax_query'] = array(
			array(
				'taxonomy' => 'places_categories',
				'terms' => sanitize_text_field( $atts['cat'] ),
				'field' => 'slug'
			)
		);

		global $mycity_query_my2;
		$mycity_query_my2 = new WP_Query( $mycity_args );

		?>
		<div class="place_li_cont">

			<?php get_template_part( 'partials/loop', 'placelist' );
			wp_reset_postdata(); ?>

		</div>
		<?php


	}
	return ob_get_clean();


}


add_shortcode( 'alloffers', 'mycity_alloffers_func' );
/**
 * @param $atts
 *
 * @return string
 */
function mycity_alloffers_func( $atts ) {
	ob_start();
	global $MyCity_class;

	$atts = shortcode_atts(
		array(
			'cat' => '',
			'type' => 'list'

		), $atts
	);

	$mycity_args = array(
		'post_type' => 'places',
		'post_status' => 'publish',
		'showposts' => 100000,
		'post__not_in' => $MyCity_class->get_empty_places(),
		'paged' => 1,
		'meta_query' => array( array( 'key' => 'coupontitle' ) )

	);

	global $mycity_query_my2;
	$mycity_query_my2 = new WP_Query( $mycity_args );

	?>
	<div class="place_li_cont">

		<?php


		if ( $mycity_query_my2->have_posts() ) {
			// Start the loop.
			$cats_arr = array(); // count chald cats
			while ( $mycity_query_my2->have_posts() ) {
				$mycity_query_my2->the_post();

				if ( strlen( get_post_meta( get_the_ID(), 'coupontitle', true ) ) < 2 ) {
					continue;
				}
				//if not isset cordinats then exit
				$cordinats = get_post_meta( get_the_ID(), '_myfield', true );
				preg_match( "/(.*?),(.*?)$/", $cordinats, $math );
				if ( !isset( $math[1] ) ) {
					$math[1] = 0;
				}
				if ( !isset( $math[2] ) ) {
					$math[2] = 0;
				}
				$location_latitude = $math[1];
				$location_longitude = $math[2];
				if ( !$location_latitude ) {
					continue;
				}
				//get images
				$img = esc_url( get_template_directory_uri() ) . "/img/pl3.jpg";
				$small_img = wp_get_attachment_url( get_post_meta( get_the_ID(), '_big_img', true ) );
				$img = bfi_thumb( $small_img, array( 'width' => 200, 'height' => 200, 'crop' => true ) );

				$except = get_the_excerpt();

				if ( get_post_meta( get_the_ID(), 'smalldescr', true ) ) {
					$except = get_post_meta( get_the_ID(), 'smalldescr', true );
				}


				// object terms
				$obj_term = wp_get_post_terms( get_the_ID(), 'places_categories' );
				$slug_this_cat = $obj_term[0]->slug;
				//cunt post in cats
				if ( !isset( $cats_arr[$slug_this_cat] ) && empty( $cats_arr[$slug_this_cat] ) ) {
					$cats_arr[$slug_this_cat] = 0;
				}


				?>
				<div
					data-marker="<?php echo esc_attr( $slug_this_cat ); ?>[<?php echo esc_attr( $cats_arr[$slug_this_cat] ); ?>]"
					class="pg style_list places_list_my">

					<div class="con clearfix">
						<a href="<?php the_permalink(); ?>">
							<img class="wh200" src="<?php echo esc_html( $img ); ?>" alt=""></a>
						<div class="content_li">
							<h2>
								<a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php echo esc_html( get_post_meta( get_the_ID(), 'coupontitle', true ) ); ?></a>
								<span></span>
							</h2>
                            <span>
                            <?php echo esc_html( get_post_meta( get_the_ID(), 'coupondescr', true ) ); ?>

                            </span>

						</div>
					</div>
				</div>
				<?php

				if ( isset( $cats_arr[$slug_this_cat] ) ) {
					$cats_arr[$slug_this_cat] ++;
				}
				// End the loop.
			}
		} else { ?>

			<?php

		} ?>
		<?php
		wp_reset_postdata(); ?>

	</div>
	<?php


	return ob_get_clean();


}