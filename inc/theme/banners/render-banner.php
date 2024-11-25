<?php
function top_banner($custom_title = null, $custom_content = null)
{ ?>
    <section class="top-banner">
        <div class="content">
            <div class="container">
                <h1><?php echo $custom_title ? esc_html($custom_title) : the_title(); ?></h1>
                <p><?php echo $custom_content ? esc_html($custom_content) : the_content(); ?></p>
            </div>
        </div>
    </section>
<?php } ?>
