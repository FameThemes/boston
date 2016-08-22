<?php


class Boston_Customize_Radio_Image_Control extends WP_Customize_Control {
    public $type = 'radio-image';
    function render_content(){
        if ( empty( $this->choices ) )
            return;

        $name = '_customize-radio-' . $this->id;

        if ( ! empty( $this->label ) ) : ?>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
        <?php endif;
        if ( ! empty( $this->description ) ) : ?>
            <span class="description customize-control-description"><?php echo $this->description ; ?></span>
        <?php endif; ?>
        <div class="choices">
        <?php foreach ( $this->choices as $value => $item ) {
            $is_pro = isset( $item['pro'] ) && $item['pro'] ? true : false;
            ?>
            <div class="col">
                <label class="choice-item <?php echo ( $is_pro ) ? 'pro-item' : ''; ?>">
                    <?php if ( $is_pro ) { ?>
                        <span class="pr"><?php esc_html_e( 'Pro', 'boston' ); ?></span>
                    <?php } else { ?>
                        <input type="radio" value="<?php echo esc_attr($value); ?>" name="<?php echo esc_attr($name); ?>" <?php $this->link();
                        checked($this->value(), $value); ?> />
                    <?php } ?>

                    <img src="<?php echo esc_attr($item['img']); ?>" alt="">
                </label>
            </div>
            <?php
        } ?>
        </div>
        <?php

    }
}