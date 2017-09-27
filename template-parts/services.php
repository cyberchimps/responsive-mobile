<?php
$responsive_options = responsive_mobile_get_options();
   
    if ( isset( $responsive_options['services_toggle_btn']) && $responsive_options['services_toggle_btn'] == '1') { 
    
?>

<div id="services_section">
    <div id="services_wrapper" class="container">
        <div class="services_content row">
            <div class="col-md-12">
            <?php
            $responsive_services_title = isset( $responsive_options['services_title']) ?  $responsive_options['services_title'] : 'Our Services';
                if($responsive_services_title){
               ?>
               <h2 class="service_section_title"> 
                           <?php echo esc_html($responsive_services_title); ?>
               </h2>
                <?php 

                } ?>
                <?php
                    $responsive_services_category = $responsive_options['services_cat'];
                    $services_featured_img = ( ! empty( $responsive_options['services_featured_image'] ) ) ? $responsive_options['services_featured_image'] : get_template_directory_uri().'/images/services_featured.png';
                   
                   
                    if(!empty($responsive_services_category))
                    {
                            $cat_obj_services  = get_term( $responsive_services_category, 'category' );
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
                            $services_posts = get_posts( $args_services );
                    }
                ?>
                <div class="row res_services">
                    <div class="col-md-6">
                        <div class="res_column-inner col-md-12">
                            <?php 
                            if(isset($services_posts)){
                            foreach($services_posts as $services)
                            {
                                $post_id = $services->ID;
                                $services_title = get_the_title( $post_id );
                                $services_img = wp_get_attachment_url( get_post_thumbnail_id( $post_id ) );
                                $services_text = $services->post_content;
                            ?>
                                    <div class="services-block-list">
                                        <div class="services-icon">
                                            <?php if($services_img){
                                                ?>
                                            <img src=<?php echo esc_url($services_img); ?> />
                                            <?php } ?>
                                        </div>
                                        <h4><?php echo esc_html($services_title);?></h4>
                                        <div class="services-content">
                                            <span>
                                                <?php echo $services_text;?>
                                            </span>
                                        </div>
                                    </div>
                            <?php } 
                                }
                            ?>
                        </div>
                        
                    </div>
                    <div class="col-md-6">
                        
                        <div class="res_column-inner col-md-12 services_featured">
                            
                                <img src=<?php echo esc_url($services_featured_img); ?> />  
                           
                        </div> 
                    </div>
                </div>
              
            </div>
            
        
        </div>
    </div>
</div>
    <?php } ?>