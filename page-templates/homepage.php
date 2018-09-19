<?php
/**
 * Template Name: Home page
 *
 * Template for displaying a page without sidebar even if a sidebar widget is published.
 *
 * @package understrap
 */

get_header('agp');
$container = get_theme_mod( 'understrap_container_type' );
global $wpdb;
$get_plugin_gallery_table = $wpdb->prefix . "advance_green_plugin_gallery";
$gallery = $wpdb->get_results( "SELECT * FROM $get_plugin_gallery_table", OBJECT_K );
?>
<div class="wrapper pt-1" id="full-width-page-wrapper ">
	<div class="<?php echo esc_attr( $container ); ?>" id="content">
		<!--Gallery Starts-->
		<?php if($gallery){ ?>
		<div class="row">
			<div class="d-none px-3 d-md-block w-100">
				<div class="no-radius">
					<div class="card-group text-center">
						<?php foreach($gallery as $image) { ?>
							<div class="card bg-dark text-white">
								<img src="<?php echo $image->Image; ?>" alt="" class="card-img">
								<div class="card-img-overlay">
									<div class="card-img-overlay h-100 d-flex flex-column justify-content-center align-items-center">
										<h6 class="card-title"><?php echo $image->Title; ?></h6>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
    	</div><!-- .row end -->
		<?php } ?>

		<!--workshop portfolio-->
		<div class="workshops">
			<h2>Latest Workshops</h2>
			
			<ul id="filters" class="list-unstyled nav m-3">
				<?php  $terms = get_terms('workshop_category',array("order"=>"ASC"));
				$data_filter = '';
				$dt = '';
				foreach($terms as $key=>$term){
						$data_filter .= ".".$term->term_id.", ";
						$dt=rtrim($data_filter,", ");
				}
				$count = count($terms);
					echo '<li class="nav-item"><span data-filter="'.$dt.'" class="filter all nav-link">All</span></li>';
				if ( $count > 0 ){

					foreach ( $terms as $term ) {

						$termname = strtolower($term->term_id);
						$termname = str_replace(' ', '-', $termname);
						echo '<li class="nav-item"><span class="filter nav-link" data-filter=".'.$termname.'">'.$term->name.'</span</li>';
					}
				} ?>
			</ul>
			<div id="portfoliolist" class="card-deck">
				<?php  global $post;
				$args = array( 'post_type' => 'agp_workshop','posts_per_page' => '10' );
				$loop = new WP_Query( $args );
				while ( $loop->have_posts() ) : $loop->the_post(); 
					$terms = get_the_terms( $post->ID, 'workshop_category' );   
			        if ( $terms && ! is_wp_error( $terms ) ) : 
						$links = array();
						foreach ( $terms as $term ) {
							$links[] = $term->term_id;
						}
						$tax_links = join( " ", str_replace(' ', '-', $links));          
						$tax = strtolower($tax_links);
					else :  
					$tax = '';                  
					endif; 
					?>
					<div class="card portfolio item <?php echo $tax; ?>" data-cat="<?php echo $tax;?>">
						<img src="<?php the_post_thumbnail_url(); ?>" alt="" class="card-img-top">
						<div class="card-body pt-3 pb-0">
							<a class="decoration-none" data-toggle="collapse" href="#workshop_<?php echo the_ID(); ?>" role="button" aria-expanded="false" aria-controls="workshop_<?php echo the_ID(); ?>" >
								<div class="d-flex justify-content-between header">
									<h5 class="card-title"><?php the_title()?></h5>
									<a class="collapsed" data-toggle="collapse" href="#workshop_<?php echo the_ID(); ?>" role="button" name="header" aria-expanded="false" aria-controls="workshop_<?php echo the_ID(); ?>" >
										<span class="arrow"></span>
									</a>
								</div> 
							</a>
							<h6 class="card-subtitle text-muted mb-2 pb-2"><?php the_terms( $post->ID, 'workshop_category' ); ?></h6>
							<div class="collapse my-2" id="workshop_<?php echo the_ID(); ?>"  data-parent="#accordion">
								<p class="card-text"><?php echo get_field('brief_intro');?></p>
								<div class="d-flex justify-content-start mb-3">
									<a href="<?php the_permalink(); ?>">Know more</a>
									<a href="#" class="ml-5">Register now</a>
								</div>     
							</div>
							<hr class="p-0 m-0 mt-2">
							<div class="footer d-flex justify-content-between">
							<?php $date = get_field('date_selector'); ?>
								<div class="py-3">
									<span class="mr-auto">Starts - </span>
									<strong><?php echo $date['start_date'];?></strong>
								</div>
								<span class="line border border-gray mx-auto"></span>
								<div class="py-3 pl-2">
									<span class="mr-auto">Ends -</span>
									<strong><?php echo $date['end_date'];?></strong>
								</div>
							</div>
						</div>
					</div> 
				<?php endwhile;?>
			</div>
		</div><!--workshop ends-->
	</div><!-- Container end -->
</div><!-- Wrapper end -->

<style>

#filters li span {
    display: block;
    padding: 5px 20px;
    text-decoration: none;
    color: #666;
    cursor: pointer;
}
#filters li span.active {
	font-weight:bold;
}
#portfoliolist {
    width: 100%;
    margin: 0 auto;
    display: block;
}

#portfoliolist .portfolio {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    -o-box-sizing: border-box;
    display: none;
    overflow: hidden;
}
.portfolio img {
    width: 100%;
    height: 220px;
    position: relative;
    top: 0;
}














</style>

<?php get_footer(); ?>
