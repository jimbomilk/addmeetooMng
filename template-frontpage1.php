<?php
/**
 * Template Name: template-frontpage1.php (basic)
 * Preview:
 */

$mycity_noheader=1;
$mycity_id =(get_theme_mod('my_ok_video_url'));
if(strlen($mycity_id) > 1)
    $GLOBALS['mycity_paralax_hide'] = true;


global $mycity_dditional;

if (!function_exists("mycity_q")) {
    esc_html_e("Activate GeoCity plugin ","mycity");
    echo "<a href='".admin_url()."'>".esc_html__("Go wp-admin")."</a>";
    die();
}

$mycity_dditional .= " home";
get_header();

get_sidebar();

?>
    <!-- Site Overlay -->
    <div class="site-overlay"></div>
<?php
$mycity_id =(get_theme_mod('my_ok_video_url'));
if(strlen($mycity_id) > 1) {

    ?>
    <script type="text/javascript">
        jQuery(function($){
            $.okvideo({ source: '<?php
            echo esc_html($mycity_id);        
         ?>',
                volume: 0,
                loop: true,
                hd:true,
                adproof: true,
                annotations: false,
                onFinished: function() { console.log('finished') },
                unstarted: function() { console.log('unstarted') },
                onReady: function() { console.log('onready') },
                onPlay: function() { console.log('onplay') },
                onPause: function() { console.log('pause') },
                buffering: function() { console.log('buffering') },
                cued: function() { console.log('cued') },
            });
        });
    </script>

    <?php
}
?>
    <div id="container">
        <div class="top_promo_block" id="promo_head">
            <div class="section-bg-overlay infinite-background above-bg" ></div>
            <script>
                jQuery('#promo_head').css({
                    height : jQuery(window).height() + 'px'
                });
                winHeight = jQuery(window).height();
                jQuery('#hero-bg').height(winHeight+30);
            </script>

            <div class="start_descrition">
                <h1><hi class='edited' id='edited_h100'><?php esc_html_e("welcome to my city guide!","mycity"); ?></hi><span id='ispan'></span></h1>
                <span class='edited' id='edited_description'><?php esc_html_e("See and visit interesting places. Share experiences with your friends. Simply.","mycity");?></span>
                
            </div>
            <div class="scroll_block">
                <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/scroll.png" class="animated infinite bounce" alt="<?php esc_html_e("Use your scrollwheel :)","mycity"); ?>">
            </div>
        </div>

        <!--Features block-->

        <div class="item_wide_container">
            <div class="fea_block container-fluid">
                <div class="fixed_w">
                    <h2 class='edited' id='edited_h2'><?php esc_html_e( 'Features My City', 'mycity' ); ?></h2>
                    <div class="row">
                        <div class="col-md-4 fea_item wow bounceInUp">
                            <h3 class='edited' id='edited_features1h'><i class="fa fa-picture-o"></i><?php esc_html_e("Slider Revolution included","mycity");?></h3>
                            <span class='edited' id='edited_features1'><?php esc_html_e("Lorem Ipsum is simply dummy text of theif printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since.","mycity");?></span>
                        </div>
                        <div class="col-md-4 fea_item wow bounceInUp">
                            <h3 class="edited" id='edited_features2h0'><i class="fa fa-globe"></i><?php esc_html_e("Google maps API support","mycity");?></h3>
                            <span class='edited' id='edited_features2'><?php esc_html_e("Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since.","mycity");?></span>
                        </div>
                        <div class="col-md-4 fea_item wow bounceInUp">
                            <h3  class="edited" id='edited_features3h00'><i class="fa fa-video-camera"></i><?php esc_html_e("Simple animation css3 framework","mycity");?></h3>
                            <span class='edited' id='edited_features3'><?php esc_html_e("Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since.","mycity");?></span>
                        </div>
                        <div class="col-md-4 fea_item wow bounceInUp">
                            <h3 class=" edited " id='edited_features4h00'><i class="fa fa-twitter"></i><?php esc_html_e("Twitter bootstrap 3","mycity");?></h3>
                            <span class='edited' id='edited_features4'><?php esc_html_e("Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since.","mycity");?></span>
                        </div>
                        <div class="col-md-4 fea_item wow bounceInUp">
                            <h3 class="edited" id='edited_features5h0'><i class="fa fa-html5"></i><?php esc_html_e("Valid HTML pages","mycity");?></h3>
                            <span class='edited' id='edited_features5'><?php esc_html_e("Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since.","mycity");?></span>
                        </div>
                        <div class="col-md-4 fea_item wow bounceInUp">
                            <h3 class="edited" id='edited_features6h0' ><i class="fa fa-mobile"></i><?php esc_html_e("Adaptive design","mycity");?></h3>
                            <span class='edited' id='edited_features6'><?php esc_html_e("Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since.","mycity");?></span>
                        </div>
                    </div>
                </div>
            </div>



            <?php

            if (function_exists("putRevSlider")) putRevSlider("mainslider") ?>

            <!--Categori blocks-->
            <div class="categori_block container-fluid">
                <div class="fixed_w">
                    <h2 class="edited" id='edited_weknow'><?php esc_html_e( 'We know all the places in your city', 'mycity' ); ?></h2>
                    <div class="row">
                        <?php
                        $mycity_categories = get_categories("parent=0&taxonomy=places_categories&hide_empty=0");

                        foreach ($mycity_categories  as $mycity_place_cat) {
                            $class = (preg_match('/fmr/',get_option("fa_icon_".(int)$mycity_place_cat->term_id))) ? "fmr" : "fa";
                            ?>
                            <div class="col-md-3 cat_item wow bounceInLeft">
                                <div class="car_item_in" onclick="location.href='<?php
                                $link = get_term_link($mycity_place_cat);
                                if( !isset( $link["errors"])){
                                    echo esc_url($link);
                                }

                                ?>';">
                                    <i class=" <?php echo esc_html( $class . ' '.get_option("fa_icon_".(int)$mycity_place_cat->term_id));?>"></i>
                                    <h4><?php echo esc_html($mycity_place_cat->name);?></h4>
                                </div>
                            </div>

                            <?php
                        }
                        ?>
                    </div>
                    <a href="/places" class="btn btn-success va"><?php esc_html_e( 'View all places', 'mycity' ); ?></a>
                </div>
            </div>
            <!--Map block-->
            <div class="map_block container-fluid">
                <div class="map_descr">
  <span class='edited' id='edited_viewfullplacecatalog' ><?php esc_html_e( 'View full place catalog', 'mycity' ); ?>
  
  </span></div>

                <!--Map js-->


                <script>
                    var
                        mapObject,
                        markers = [],
                        markersData = {<?php
		
		$mycity_categories=  get_categories("taxonomy=places_categories&hide_empty=0");
		$places_categories = array();
		foreach ($mycity_categories  as $mycity_place_cat) {
			$mycity_init_maps_point_by_term_slug = mycity_init_maps_point_by_term_slug($mycity_place_cat->term_id);
			if (!$mycity_init_maps_point_by_term_slug) continue;
			
			ob_start();
			?>
                            '<?php echo esc_html($mycity_place_cat->slug);?>': [<?php print_r($mycity_init_maps_point_by_term_slug);?>]
                            <?php
                            $places_categories[] = ob_get_clean();

                        }

                        echo implode(",",$places_categories);

                        ?>
                        };
                    var global_scrollwheel = false;
                    var global_drag = false;

                    function initialize_map() {
                        loadScript("<?php echo esc_url( get_template_directory_uri() ); ?>/js/infobox.js",after_load);
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

                <!--Users blocks-->
                <div class="user_block container-fluid">
                    <div class="fixed_w">
                        <h2 class='edited' id='edited_bestuserweeklyindex' >
                            <?php esc_html_e( 'The best user weekly', 'mycity' ); ?>
                        </h2>
                        <div class="row">
                            <?php
                            do_action( 'bp_before_directory_members_list' );

                            ?>
                            <?php
                            $blogusers = get_users( 'orderby=registered&number=4' );
                            foreach ( $blogusers as $user) {
                                //get commments count

                                $comment_counts = (array) $wpdb->get_results(  $wpdb->prepare("SELECT user_id, COUNT( * ) AS total FROM {$wpdb->comments}
        WHERE comment_approved = 1 AND user_id = '%d'
		GROUP BY user_id",
                                    $user->ID
                                ), object);

                                $followers_count = (array) $wpdb->get_results($wpdb->prepare("SELECT COUNT( * ) AS total FROM follow	WHERE user2 = '%d'", $user->ID
                                ), object);
                                ?>
                                <div class="col-md-3 user_cover wow bounceInLeft">
                                    <div class="user_item">
                                        <div class="user_item_cont">
                                            <img src="<?php
                                            $params = array('width' =>100, 'height' => 100);
                                            $img_url=  bfi_thumb(mycity_get_url_by_avatar(get_avatar($user->ID,66)), $params);
                                            echo esc_url($img_url); ?>" alt="#">
                                            <a href="<?php echo mycity_get_member_permalink($user->ID);?>" class="names"><?php echo esc_html($user->display_name);?></a>
                                            <div class="bottom_link">
                                                <ul>
                                                    <li><a href="<?php echo mycity_get_member_permalink($user->ID);?>"><i class="fa fa-thumbs-o-up"></i><?php echo esc_html(get_user_meta($user->ID, "folowing", true));?></a></li>
                                                    <li><a href="<?php echo mycity_get_member_permalink($user->ID);?>"><i class="fa fa-comment-o"></i><?php if (isset($comment_counts[0]->total)) echo esc_html($comment_counts[0]->total); ?></a></li>
                                                    <li><a href="<?php echo mycity_get_member_permalink($user->ID);?>"><i class="fa fa-users"></i><?php echo esc_html($followers_count[0]->total);?></a></li>
                                                    <li class="last"><a href="<?php echo mycity_get_member_permalink($user->ID);?>"><i class="fa fa-map-marker"></i>0</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <?php
                                        $user_date =  get_userdata($user->ID)->data;
                                        $site = sanitize_text_field($user_date->user_url);

                                        if ($site) {
                                            ?>
                                            <a href="<?php echo esc_html($site);?>" class="fb_btn"><i class="fa fa-facebook-official"></i></a>
                                        <?php } ?>

                                        <img src="<?php  echo esc_url(mycity_get_url_by_avatar(get_avatar($user->ID, 100))); ?>" class="blurbg"  alt="" >
                                    </div>
                                </div>
                            <?php }

                            ?>

                        </div>

                        <?php
                        $n=0;
                        $blogusers = get_users( 'orderby=registered&offset=4&number=12' );
                        foreach ( $blogusers as $user) {  ?>
                            <div class="user_sm col-md-1 wow bounceInRight" onclick="location.href='<?php echo mycity_get_member_permalink($user->ID);?>';">
                                <span class="user_num"><?php echo esc_attr($n++);?></span>
                                <div class="min_u_hover">
                                    <div class="user_go">
                                        <i class="fa fa-link"></i>
                                    </div>
                                    <img src="<?php
                                    $params = array('width' =>66, 'height' => 66);
                                    $img_url=  bfi_thumb(mycity_get_url_by_avatar(get_avatar($user->ID,66)), $params);
                                    echo esc_url($img_url); ?>" alt="#">
                                </div>
                            </div>
                            <?php
                        }
                        ?>

                    </div>
                </div>



                <!--promo block-->
                <div class="promo_block container-fluid">
                    <div class="cd-pricing-container">

                        <p class='edited' id='edited_seeplaceindex'><?php echo esc_html_e("See and visit interesting places. Share experiences with your friends. Simply","mycity");?></p>
                        <ul class="cd-pricing-list cd-bounce-invert">
                            <li>
                                <ul class="cd-pricing-wrapper">
                                    <li class="is-visible">
                                        <div class="cd-pricing-header">
                                            <h2 class="edited" id="edited_h1free"><?php echo esc_html_e("Free","mycity");?></h2>

                                            <div class="cd-price">
                                                <span class="cd-currency edited" id='edited_curdollar'>$</span>
                                                <span class="cd-value edited" id='edited_cur0'>0</span>
                                                <span class="cd-duration edited" id='edited_curmo0'><?php echo esc_html_e("mo","mycity");?></span>
                                            </div>
                                        </div> <!-- .cd-pricing-header -->

                                        <div class="cd-pricing-body">
                                            <ul class="cd-pricing-features">
                                                <li><em class='edited' id='edited_0cmb'><?php echo esc_html_e("One","mycity");?></em> <span class='edited' id='edited_0cmem'><?php echo esc_html_e("client","mycity");?></span></li>
                                                <li><em class='edited' id='edited_0cm'><?php echo esc_html_e("Google","mycity");?></em> <span class='edited' id='edited_0cmem0'><?php echo esc_html_e("placement","mycity");?></li>
                                                <li><em class='edited' id='edited_0cm1'><?php echo esc_html_e("Promotion","mycity");?></em> <span class='edited' id='edited_0cmem1'><?php echo esc_html_e("in sotial network","mycity");?> </li>
                                                <li><em class='edited' id='edited_0cm2'><?php echo esc_html_e("Testimonials","mycity");?></em> <span class='edited' id='edited_0cmem2'><?php echo esc_html_e("and review","mycity");?></li>
                                                <li><em class='edited' id='edited_0cm3'><?php echo esc_html_e("E-mail","mycity");?></em> <span class='edited' id='edited_0cmem3'><?php echo esc_html_e("Support","mycity");?> </span></li>
                                            </ul>
                                        </div> <!-- .cd-pricing-body -->

                                        <div class="cd-pricing-footer">
                                            <a class="cd-select" href="<?php fmr_l("template-add.php");?>#1"><?php echo esc_html_e("Add place","mycity");?></a>
                                        </div> <!-- .cd-pricing-footer -->
                                    </li>
                                </ul> <!-- .cd-pricing-wrapper -->
                            </li>

                            <li class="cd-popular">
                                <ul class="cd-pricing-wrapper">
                                    <li class="is-visible">
                                        <div class="cd-pricing-header">

                                            <h2 class="edited" id="edited_h1annual"><?php esc_html_e("Annual","mycity");?></h2>

                                            <div class="cd-price">
                                                <span class="cd-currency edited" id='edited_curdollar'>$</span>
                                                <span class="cd-value edited" id='edited_cur60'>60</span>
                                                <span class="cd-duration edited" id='edited_curmo1'><?php echo esc_html_e("year","mycity");?></span>
                                            </div>
                                        </div> <!-- .cd-pricing-header -->

                                        <div class="cd-pricing-body">
                                            <ul class="cd-pricing-features">
                                                <li><em class='edited' id='edited_cmb'><?php echo esc_html_e("Many","mycity");?></em> <span class='edited' id='edited_cmem'><?php echo esc_html_e("clients","mycity");?></span></li>
                                                <li><em class='edited' id='edited_cm'><?php echo esc_html_e("Google","mycity");?></em> <span class='edited' id='edited_cmem0'><?php echo esc_html_e("placement","mycity");?></li>
                                                <li><em class='edited' id='edited_cm1'><?php echo esc_html_e("Promotion","mycity");?></em> <span class='edited' id='edited_cmem1'><?php echo esc_html_e("in sotial network","mycity");?> </li>
                                                <li><em class='edited' id='edited_cm2'><?php echo esc_html_e("Testimonials","mycity");?></em> <span class='edited' id='edited_cmem2'><?php echo esc_html_e("and review","mycity");?></li>
                                                <li><em class='edited' id='edited_cm3'><?php echo esc_html_e("E-mail","mycity");?></em> <span class='edited' id='edited_cmem3'><?php echo esc_html_e("Support","mycity");?> </span></li>
                                            </ul>
                                        </div> <!-- .cd-pricing-body -->

                                        <div class="cd-pricing-footer">
                                            <a class="cd-select" href="<?php fmr_l("template-add.php");?>#2"><?php esc_html_e("Add place","mycity");?></a>
                                        </div> <!-- .cd-pricing-footer -->
                                    </li>

                                </ul> <!-- .cd-pricing-wrapper -->
                            </li>

                            <li>
                                <ul class="cd-pricing-wrapper">
                                    <li class="is-visible">
                                        <div class="cd-pricing-header">
                                            <h2 class="edited" id="edited_h2annual"><?php echo esc_html_e("Monthly","mycity");?></h2>

                                            <div class="cd-price">
                                                <span class="cd-currency edited" id='edited_curdollar'>$</span>
                                                <span class="cd-value edited" id='edited_cur20'>20</span>
                                                <span class="cd-duration edited" id='edited_curmo2'>mo</span>
                                            </div>
                                        </div> <!-- .cd-pricing-header -->

                                        <div class="cd-pricing-body">
                                            <ul class="cd-pricing-features">
                                                <li><em class='edited' id='edited_1cmb'><?php echo esc_html_e("Many","mycity");?></em> <span class='edited' id='edited_1cmem'><?php echo esc_html_e("clients","mycity");?></span></li>
                                                <li><em class='edited' id='edited_1cm'><?php echo esc_html_e("Google","mycity");?></em> <span class='edited' id='edited_1cmem0'><?php echo esc_html_e("placement","mycity");?></li>
                                                <li><em class='edited' id='edited_1cm1'><?php echo esc_html_e("Promotion","mycity");?></em> <span class='edited' id='edited_1cmem1'><?php echo esc_html_e("in sotial network","mycity");?> </li>
                                                <li><em class='edited' id='edited_1cm2'><?php echo esc_html_e("Testimonials","mycity");?></em> <span class='edited' id='edited_1cmem2'><?php echo esc_html_e("and review","mycity");?></li>
                                                <li><em class='edited' id='edited_1cm3'><?php echo esc_html_e("E-mail","mycity");?></em> <span class='edited' id='edited_1cmem3'><?php echo esc_html_e("Support","mycity");?> </span></li>
                                            </ul>
                                        </div> <!-- .cd-pricing-body -->

                                        <div class="cd-pricing-footer">
                                            <a class="cd-select" href="<?php fmr_l("template-add.php");?>#3"><?php echo esc_html_e("Add place","mycity");?></a>
                                        </div>  <!-- .cd-pricing-footer -->
                                    </li>
                                </ul> <!-- .cd-pricing-wrapper -->
                            </li>

                        </ul> <!-- .cd-pricing-list -->
                    </div> <!-- .cd-pricing-container -->
                </div>
                <!--place block-->
                <div class="places_index_block container-fluid">
                    <div class="fixed_w">
                        <h2 class='edited' id='edited_bestplacesweeklyindex' ><?php esc_html_e( 'The best places weekly', 'mycity' ); ?></h2>
                        <div class="row">
                            <?php

                            wp_reset_postdata() ;
                            global $MyCity_class;
                            $args = array(
                                'post__not_in' => $MyCity_class->get_empty_places(),
                                'post_type' => array(
                                    'places'
                                ),
                                'posts_per_page' => 100,
                                'orderby' => 'id',
                                'order'=>'desc'
                            );


                            $related_post = new WP_Query($args);


                            $i1= 0;
                            if ($related_post->have_posts()) {
                                while ($related_post->have_posts()) {
                                    $related_post->the_post();

                                    $big_img = wp_get_attachment_url(  get_post_meta((int)$post->ID, '_big_img', true) );
                                    $big_img  = bfi_thumb($big_img, array(  'width' => 360, 'height' =>210 ));
                                    $except = (get_post_meta(get_the_ID(), 'smalldescr', true)) ? (get_post_meta(get_the_ID(), 'smalldescr', true)) : get_the_excerpt();

                                    ?>

                                    <?php

                                    if(strlen($big_img) > 0 && $i1 < 3) {
                                        ?>
                                        <div class="col-xs-12 col-sm-12 col-md-4 place_index_item  wow bounceInLeft">
                                            <div class="place_inn">
                                                <div class="place_indexImg">
                                                    <img src="<?php  echo esc_url($big_img); ?>" alt="<?php the_title(); ?>">
                                                </div>

                                                <div class="pl_descr">
                                                    <a href="<?php  echo esc_url(get_the_permalink()); ?>"><?php  the_title(); ?></a>
           
            <span>
             <?php
             echo str_replace(array('<p>','</p>'),array('',''), $except);

             ?>
            </span>

                                                    <?php
                                                    mycity_stars(4);
                                                    ?>

                                                </div>
                                            </div>
                                        </div>

                                        <?php $i1++;}


                                } }
                            wp_reset_postdata();
                            ?>
                        </div>
                        <a href="<?php echo esc_url(get_post_type_archive_link("places"));?>" class="btn btn-success va"><?php esc_html_e( 'View all places', 'mycity' ); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        jQuery(document).ready( function( $ ) {

            $(document).on("click", '#edited_Searchindex', function (e) {

                jQuery('#search_cat_hide').val(jQuery('.dropdown-toggle a').data('catis'));

            });
        });
    </script>


<?php
get_footer();
?>