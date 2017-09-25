<?php

$responsive_options = responsive_mobile_get_options();
wp_enqueue_style( 'fontawesome-style', get_template_directory_uri() . '/css/font-awesome.min.css', false, '4.7.0');


 if ( isset( $responsive_options['team']) && $responsive_options['team'] == '1') { ?>
<div class="container" id="team_inner_div">
<?php 
	$responsive_team_title = isset( $responsive_options['team_title']) ?  $responsive_options['team_title'] : 'Team';
			
 ?>
 <h2 class="section_title"> 
			<span><?php echo esc_html($responsive_team_title); ?></span>
 </h2>
 <?php 
 	$responsive_team_category = $responsive_options['team_val'];
 	if(!empty($responsive_team_category))
 	{
 		$cat_obj_team  = get_term( $responsive_team_category, 'category' );
 		$cat_type_team = $cat_obj_team->name;
 	
 		$args_team = array(
 				'numberposts'      => -1,
 				'offset'           => 0,
 				'category_name' => $cat_type_team,
 				'orderby'          => 'post_date',
 				'order'            => 'ASC',
 				'post_type'        => 'post',
 				'post_status'      => 'publish',
 				'suppress_filters' => false
 		);
 		$team_posts = get_posts( $args_team );
 	}
 	
 	if(!empty($team_posts))
 	{
 	?>
 		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 team_first_row">
 	<?php
 	
 	$count_array=array(1,2,5,6,9,10);
 	$count=0;
 		foreach($team_posts as $team)
 		{
 			$count++;
 			
 			$post_id = $team->ID;
 			$responsive_showcase_img = wp_get_attachment_url( get_post_thumbnail_id( $post_id ) );
 			$responsive_showcase_title = get_the_title( $post_id );
 			$image_id = responsive_get_attachment_id_from_url($responsive_showcase_img);
 			$alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true);
 			if ($alt_text == "")
 				$alt_text = get_the_title( $post_id );
 			$responsive_showcase_designation = get_post_meta($post_id, 'responsive_meta_box_designation', true);
 			$responsive_showcase_desc = $team->post_content; 			
 			$responsive_showcase_facebook = get_post_meta($post_id, 'responsive_meta_box_facebook', true);
 			$responsive_showcase_twitter = get_post_meta($post_id, 'responsive_meta_box_twitter', true);
 			$responsive_showcase_googleplus = get_post_meta($post_id, 'responsive_meta_box_googleplus', true);
 			$responsive_showcase_linkedin = get_post_meta($post_id, 'responsive_meta_box_text_linkedin', true);
		?>
		
		<?php if(in_array($count,$count_array)){?>
		<div class="team_single_row col-md-6">
			<div class="col-xs-6 col-sm-6 col-md-6 team_img">
			
			<a href="#portfolioModal<?php echo $post_id;?>" class="portfolio-link" data-toggle="modal">
											<div class="entry_hover animate_icon"></div>
											<div style="background:url('<?php echo esc_url($responsive_showcase_img); ?>'); background-size:cover; height:290px; background-position:center;"></div>
											<i class="fa fa-plus" aria-hidden="true"></i>
										</a>
										<div class="arrow-left"></div>


			</div>
		     <div class="col-xs-6 col-sm-6 col-md-6 team_data">
		     <div class="team_member">
			<?php echo esc_html($responsive_showcase_title); ?>
		     </div>
		     <div class="team_designation">
			<?php echo esc_html($responsive_showcase_designation); ?>
		     </div>
		     <div class="team_desc">
			<?php echo esc_html(wp_trim_words($responsive_showcase_desc, 20, '...')); ?>
		     </div>


			<div class="social">
			<?php if(!empty($responsive_showcase_facebook)) { ?>
						<a class="tw_showcase_facebook" href="<?php echo esc_url($responsive_showcase_facebook); ?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
			<?php } ?>
			<?php if(!empty($responsive_showcase_twitter)) { ?>
						<a class="tw_showcase_twitter" href="<?php echo esc_url($responsive_showcase_twitter); ?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
			<?php } ?>
			<?php if(!empty($responsive_showcase_googleplus)) { ?>
					<a class="tw_showcase_googleplus" href="<?php echo esc_url($responsive_showcase_googleplus); ?>" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
			<?php } ?>
			<?php if(!empty($responsive_showcase_linkedin)) { ?>
					<a class="tw_showcase_linkedin" href="<?php echo esc_url($responsive_showcase_linkedin); ?>" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
			<?php } ?></div>
		</div>
		</div>
		<?php }
		else{?>
		<div class="team_single_row col-md-6">
		
			<div class="col-xs-6 col-sm-6 col-md-6 col-md-push-6 col-lg-push-6 team_img">
			
			<a href="#portfolioModal<?php echo $post_id;?>" class="portfolio-link" data-toggle="modal">
											<div class="entry_hover animate_icon"></div>
											<div style="background:url('<?php echo esc_url($responsive_showcase_img); ?>'); background-size:cover; height:290px; background-position:center;"></div>
											<i class="fa fa-plus" aria-hidden="true"></i>
										</a>
										<div class="arrow-right"></div>


			</div>

		     <div class="col-xs-6 col-sm-6 col-md-6 col-md-pull-6 col-lg-pull-6 team_data">
		     <div class="team_member">
			<?php echo esc_html($responsive_showcase_title); ?>
		     </div>
		     <div class="team_designation">
			<?php echo esc_html($responsive_showcase_designation); ?>
		     </div>
		     <div class="team_desc">
			<?php echo esc_html(wp_trim_words($responsive_showcase_desc, 20, '...')); ?>
		     </div>

			<div class="social">
			<?php if(!empty($responsive_showcase_facebook)) { ?>
						<a class="tw_showcase_facebook" href="<?php echo esc_url($responsive_showcase_facebook); ?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
			<?php } ?>
			<?php if(!empty($responsive_showcase_twitter)) { ?>
						<a class="tw_showcase_twitter" href="<?php echo esc_url($responsive_showcase_twitter); ?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
			<?php } ?>
			<?php if(!empty($responsive_showcase_googleplus)) { ?>
					<a class="tw_showcase_googleplus" href="<?php echo esc_url($responsive_showcase_googleplus); ?>" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
			<?php } ?>
			<?php if(!empty($responsive_showcase_linkedin)) { ?>
					<a class="tw_showcase_linkedin" href="<?php echo esc_url($responsive_showcase_linkedin); ?>" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
			<?php } ?></div>
		     </div>
		

		</div>
		<?php } ?>
	
	<?php if($responsive_showcase_desc){?>	
	<div class="portfolio-modal modal fade" id="portfolioModal<?php echo $post_id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-content">
            <div class="close-modal" data-dismiss="modal">
                <div class="lr">
                    <div class="rl">
                    </div>
                </div>
            </div>
            <div class="container-full-width">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="modal-body">
                            
                            <p class="item-intro text-muted"><?php echo $responsive_showcase_desc; ?></p>
                       
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<?php 	}		 		 		
 		}
 	?>
 		</div>
 	<?php 	
 	}	
 ?>
 

 </div>
 <?php $testimonial_full_desc = $team->post_content; ?>
 <div class="portfolio-modal modal fade" id="portfolioModal1" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-content">
            <div class="close-modal" data-dismiss="modal">
                <div class="lr">
                    <div class="rl">
                    </div>
                </div>
            </div>
            <div class="container-full-width">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="modal-body">
                            
                            <p class="item-intro text-muted"><?php echo $testimonial_full_desc; ?></p>
                       
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php }
    
?>