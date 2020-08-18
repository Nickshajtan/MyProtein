<?php
/*
* This file for modal parts of theme
*
*/
?>
<!--- ACF modals -->
<?php if( function_exists('get_field') ) :
            /*--- https://github.com/VodkaBears/Remodal#remodal ---*/
            $modals = get_field('modal_windows', 'options');
            if( !empty( $modals ) ) : 
                $counter = 0;
                foreach( $modals as $modal ) :
                    $header    = get_conf_title('text-center', $modal);
                    $subheader = wp_kses_post( $modal['subheader'] );
                    $text      = wp_kses_post( $modal['text'] );
                    $image     = esc_url( $modal['image'] );
                    $choose    = $modal['choose'];
                ?>
                    <?php if( $choose === 'yes' ) : ?>
                    <div class="modal ml-auto mr-auto remodal" data-remodal-id="modal-<?php echo $counter; ?>" data-remodal-options="">
                        <div class="modal-wrapper align-items-center justify-content-center ml-auto mr-auto d-flex h-100 w-100">
                            <div class="modal-content align-items-center justify-content-center d-flex ml-auto mr-auto">
                                <div data-remodal-action="close" class="remodal-close closer">
                                    <div>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </div>
                                <?php if( !empty( $header ) ) : ?>
                                    <div class="modal-header w-100 text-center align-items-center justify-content-center d-flex"><?php echo $header; ?></div>
                                <?php endif; ?>
                                <?php if( !empty( $subheader ) ) : ?>
                                    <div class="modal-subheader w-100 text-center align-items-center justify-content-center d-flex"><?php echo $subheader; ?></div>
                                <?php endif; ?>
                                <?php if( !empty( $text )  || !empty( $image ) ) : ?>
                                    <div class="modal-body w-100 text-center align-items-center justify-content-center d-flex">
                                        <?php if( !empty( $header ) ) : ?>
                                        <div class="w-50">
                                            <?php echo $text; ?>
                                        </div>
                                        <?php endif; ?>
                                        <?php if( !empty( $image ) ) : ?>
                                        <div class="w-50">
                                            <img src="<?php echo $image; ?>" alt="" title="">
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                <button data-remodal-action="cancel" class="remodal-cancel"><?php echo __('Cancel', 'hcc'); ?></button>
                                <button data-remodal-action="confirm" class="remodal-confirm"><?php echo __('OK', 'hcc'); ?></button>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
            <?php $counter++; endforeach;
            endif; 
endif; ?>
<script>
jQuery(document).on('opening', '.remodal', function () {
  console.log('Modal is opening');
});
</script>
