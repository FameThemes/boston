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
            $label = isset( $item['label'] ) ? $item['label'] : '';
            ?>
            <div class="col">
                <?php if ( $is_pro ) { ?>
                <a title="<?php echo esc_attr( $label ); ?>" href="<?php echo ( isset( $item['link'] ) ) ? esc_url( $item['link'] ) : '#'; ?>" target="_blank" class="choice-item <?php echo ( $is_pro ) ? 'pro-item' : ''; ?>">
                    <span class="pr"><?php esc_html_e( 'Pro', 'boston' ); ?></span>
                    <img src="<?php echo esc_attr($item['img']); ?>" alt="">
                </a>
                <?php } else { ?>
                    <label title="<?php echo esc_attr( $label ); ?>" class="choice-item <?php echo ( $is_pro ) ? 'pro-item' : ''; ?>">
                        <input type="radio" value="<?php echo esc_attr($value); ?>" name="<?php echo esc_attr($name); ?>" <?php $this->link();
                        checked($this->value(), $value); ?> />
                        <img src="<?php echo esc_attr($item['img']); ?>" alt="">
                    </label>
                <?php } ?>
            </div>
            <?php
        } ?>
        </div>
        <?php

    }
}

class Boston_Customize_Pro_Control extends WP_Customize_Control {
    public $type = 'boston_pro';
    function render_content(){
        if ( ! empty( $this->label ) ) : ?>
            <span class="customize-control-title boston-pro-title"><?php echo esc_html( $this->label ); ?></span>
        <?php endif;
        if ( ! empty( $this->description ) ) : ?>
            <div class="description customize-control-description boston-pro-description"><?php echo $this->description ; ?></div>
        <?php endif; ?>
        <?php

    }
}
