<?php
$responsive_options = responsive_mobile_get_options();
   
       if ( isset( $responsive_options['testimonial_toggle_btn']) && $responsive_options['testimonial_toggle_btn'] == '1') { 
    
?>

<div id="testimonial_section">
    <div id="testimonial_wrapper" class="container">
        <div class="services_content row">
            <div class="col-md-12">
            <?php
            $responsive_testimonial_title = isset( $responsive_options['testimonial_title']) ?  $responsive_options['testimonial_title'] : 'Testimonial';
                if($responsive_testimonial_title){
               ?>
               <h2 class="testimonial_section_title"> 
                           <?php echo esc_html($responsive_testimonial_title); ?>
               </h2>
                <?php 

                } ?>
                <?php
                    $responsive_testimonial_category = $responsive_options['testimonial_cat'];
                   // $services_featured_img = ( ! empty( $responsive_options['services_featured_image'] ) ) ? $responsive_options['services_featured_image'] : get_template_directory_uri().'/images/featured-image.png';
                   
                   
                    if(!empty($responsive_testimonial_category))
                    {
                            $cat_obj_services  = get_term( $responsive_testimonial_category, 'category' );
                            $cat_type_services = $cat_obj_services->name;
                            
                            $args_services = array(
                                            'numberposts'      => -1,
                                            'offset'           => 0,
                                            'category_name' => $cat_type_services,
                                            'orderby'          => 'post_date',
                                            'order'            => 'ASC',
                                            'post_type'        => 'post',
                                            'post_status'      => 'publish',
                                            'suppress_filters' => false
                            );
                            $testimonial_posts = get_posts( $args_services );
                    }
                ?>
                <div class="row text-center">
                        <div id="carousel-testimonial" class="carousel slide" data-ride="carousel">
                          <div class="carousel-inner">
                            <div class="testimonial_main_div item active">
                              <?php
                              $slide_counter1 = 0;
                              if(isset($testimonial_posts)){
                              foreach ($testimonial_posts as $testimonial)
                              {
                                  // Getting  ID of the current post;
                                  $post_id = $testimonial->ID;
                                  // Getting individual options of each post
                                  $so_testimonial_img        = wp_get_attachment_url( get_post_thumbnail_id( $post_id ) );
                                  $so_testimonial_title      = get_the_title( $post_id ); 
                                  $so_testimonial_text       = $testimonial->post_content;
                                  if($slide_counter1 != 0)
                                  {
                                      if($slide_counter1%3==0) {

                                             echo '</div><div class="item">';

                                         }
                                  }

                              ?>


                                  <div class="col-lg-4 col-md-4">
                                      <div class="card testimonial-card">
                                          <div class="card-up testimonial_top_color">
                                          </div>
                                          <div class="testimonial_img"><img src="<?php echo esc_url($so_testimonial_img); ?>" class="rounded-circle img-responsive">
                                          </div>
                                           <div class="card-block">
                                          <!--Name-->
                                          <h4 class="card-title"><?php echo esc_html($so_testimonial_title);?></h4>
                                          <hr>
                                          <!--Quotation-->
                                          <p class="text-muted"><i class="fa fa-quote-left"></i><?php echo $so_testimonial_text; ?></p>
                                          </div>
                                      </div>
                                  </div>

                              <?php 

                              $slide_counter1++;
                                 } 
                                }  
                            ?>
                          </div>
                          </div>
                            <?php
                           if(isset($testimonial_posts)){
                            if(count($testimonial_posts) > 3)
                            {
                            ?>
                            <a class="left carousel-control" href="#carousel-testimonial" role="button" data-slide="prev">
                                  <span class="glyphicon glyphicon-chevron-left"></span>
                              </a>
                              <a class="right carousel-control" href="#carousel-testimonial" role="button" data-slide="next">
                                  <span class="glyphicon glyphicon-chevron-right"></span>
                              </a>
                            <?php
                              }
                            }
                            ?>
                          </div><!-- corousal main div ends -->
                    </div>
              
            </div>
            
        
        </div>
    </div>
</div>
    <?php } ?>