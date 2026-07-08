<?php

//[marquee_text direction="left" speed="40" text="motion | design | gsap | wordpress"]
function marquee_text_cb($atts)
{

    $atts = shortcode_atts([
        'text'      => 'motion | design | gsap | wordpress',
        'speed'     => 40,
        'direction' => 'left'
    ], $atts);

    $id = 'marquee-text-' . uniqid();

    $items = array_map('trim', explode('|', $atts['text']));

    ob_start(); ?>

    <div class="marquee-text"
        id="<?php echo esc_attr($id); ?>"
        data-speed="<?php echo esc_attr($atts['speed']); ?>"
        data-direction="<?php echo esc_attr($atts['direction']); ?>">

        <div class="marquee-text__track">

            <?php foreach ($items as $item) { ?>
                <span class="marquee-text__item"><?php echo esc_html($item); ?></span>
            <?php } ?>

            <?php foreach ($items as $item) { ?>
                <span class="marquee-text__item" aria-hidden="true"><?php echo esc_html($item); ?></span>
            <?php } ?>

        </div>
    </div>

<?php
    return ob_get_clean();
};
add_shortcode('marquee_text', 'marquee_text_cb');
