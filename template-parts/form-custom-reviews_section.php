<?php
  /*
   * Custom contact form template
   * 
   *
   */
  if( !isset( $title ) || empty( $title )  ) {
    $title    = ( hcc_get_acf_header() != false ) ? hcc_get_acf_header('text-white text-center title') 
                                   : '<b>' . __('Нет Вашего вопроса? Попробуйте написать нам', 'hcc') . '</b>'; 
  }
  else {
    $title    = wp_kses_post( $title );
  }
  
  $subtitle = __('Оставьте свой вопрос и мы ответим вам как можно скорее', 'hcc');
?>
<section class="cf cf-section">
    <div class="container">
        <div class="row">
            <div class="col-12 justify-content-center align-items-center d-flex flex-column cf-section__header">
               
                <?php if( false ) : ?>
                <strong class="text-center text-white"><span class="text-white"><?php echo $subtitle; ?></span></strong>
                <?php endif; ?>
                
                <?php if( !empty( $title ) ) : ?>
                  <div class="text-center text-white d-flex justify-content-center cf-section__header__title">
                    <?php echo $title; ?>
                  </div>
                <?php endif; ?>
                
            </div>
            
            <form action="" method="post" class="custom-form col-12 col-lg-8 ml-auto mr-auto needs-validation" novalidate>
                    <textarea name="comment" class="hd"></textarea>
                    <textarea name="message" class="hd"></textarea>
                    <div class="row d-flex justify-content-center">
                       
                       
                       <div class="form-group col-12 col-md-6">
                                <label for="name" class="sr-only"><?php echo __('Ваше имя', 'hcc'); ?></label>
                                <div class="input-group validation-group">
                                    <div class="input-group-prepend d-none">
                                        <div class="input-group-text ">
                                            <!-- icon, text, etc -->
                                        </div>
                                    </div>
                                    <input name="name" type="text" class="form-control w-100 form-element-validation" id="name" aria-describedby="name" maxlength="30" placeholder="<?php echo __('Ваше имя', 'hcc'); ?>" required="required">
                                    <span id="help-text" class="text-muted form-help d-none"><!-- help text --></span>
                                    <div class="valid-feedback valid-helper"><?php echo __('Выглядит неплохо, все верно!', 'hcc'); ?></div>
                                    <div class="valid-warning-feedback valid-helper"><?php echo __('Необязательно, но было бы недурно узнать', 'hcc'); ?></div>
                                    <div class="invalid-feedback valid-helper"><?php echo __('Пожалуйста, проверьте еще раз', 'hcc'); ?></div>
                                </div>
                            </div>
                            
                            <div class="form-group col-12 col-md-6">
                                <label for="purchase" class="sr-only"><?php echo __('Ваше имя', 'hcc'); ?></label>
                                <div class="input-group validation-group">
                                    <div class="input-group-prepend d-none">
                                        <div class="input-group-text ">
                                            <!-- icon, text, etc -->
                                        </div>
                                    </div>
                                    <input name="purchase" type="text" class="form-control w-100 form-element-validation" id="purchase" aria-describedby="purchase" maxlength="30" placeholder="<?php echo __('Что вы купили?', 'hcc'); ?>" required="required">
                                    <span id="help-text" class="text-muted form-help d-none"><!-- help text --></span>
                                    <div class="valid-feedback valid-helper"><?php echo __('Выглядит неплохо, все верно!', 'hcc'); ?></div>
                                    <div class="valid-warning-feedback valid-helper"><?php echo __('Необязательно, но было бы недурно узнать', 'hcc'); ?></div>
                                    <div class="invalid-feedback valid-helper"><?php echo __('Пожалуйста, проверьте еще раз', 'hcc'); ?></div>
                                </div>
                            </div>
                           
                            <?php if( false ) : ?>
                            <div class="form-group col-12 col-md-6">
                                <label for="email" class="sr-only"><?php echo __('Ваш E-mail', 'hcc'); ?></label>
                                <div class="input-group validation-group">
                                    <div class="input-group-prepend d-none">
                                        <div class="input-group-text ">
                                            <!-- icon, text, etc -->
                                        </div>
                                    </div>
                                    <input name="email" type="email" class="form-control w-100 form-element-validation" id="email" aria-describedby="email" placeholder="<?php echo __('Ваш E-mail', 'hcc'); ?>">
                                    <span id="help-email" class="text-muted form-help d-none"><!-- help text --></span>
                                    <div class="valid-feedback valid-helper"><?php echo __('Выглядит неплохо, все верно!', 'hcc'); ?></div>
                                    <div class="valid-warning-feedback valid-helper"><?php echo __('Необязательно, но было бы недурно узнать', 'hcc'); ?></div>
                                    <div class="invalid-feedback valid-helper"><?php echo __('Пожалуйста, проверьте еще раз', 'hcc'); ?></div>
                                </div>
                            </div>
                            <?php endif; ?>
                       
                            <div class="form-group col-12">
                                <label for="question" class="sr-only"><?php echo __('Ваш вопрос', 'hcc'); ?></label>
                                <div class="input-group validation-group">
                                    <textarea name="question" id="question" cols="30" rows="6" placeholder="<?php echo __('Ваш отзыв', 'hcc'); ?>" class="form-control w-100 form-element-validation" required="required"></textarea>
                                    <span id="help-textarea" class="text-muted form-help d-none"><!-- help text --></span>
                                    <div class="valid-feedback valid-helper"><?php echo __('Выглядит неплохо, все верно!', 'hcc'); ?></div>
                                    <div class="valid-warning-feedback valid-helper"><?php echo __('Необязательно, но было бы недурно узнать', 'hcc'); ?></div>
                                    <div class="invalid-feedback valid-helper"><?php echo __('Пожалуйста, проверьте еще раз', 'hcc'); ?></div>
                                </div>
                            </div>
                        
                            <div class="col-12 d-flex justify-content-end align-items-center">
                                <input type="submit" value="<?php echo __('Отправить', 'hcc'); ?>">
                            </div>
                     </div>
               </form>
        </div>
    </div>
</section>