<section class="banner-sliders">
    <div class="splide" role="group" id="banner-sliders">
        <div class="splide__track">
            <ul class="splide__list">
                <?php if (have_rows('banners_inicio')): ?>
                    <?php while (have_rows('banners_inicio')):
                        the_row(); ?>

                        <?php
                        $title_banner = get_sub_field('titulo_banner');
                        $desc_banner = get_sub_field('descripcion_banner');
                        $bg_banner = get_sub_field('fondo_banner');
                        ?>

                        <?php if (!empty($title_banner && $desc_banner && $bg_banner)) { ?>

                            <li class="splide__slide" style="background-image: url('<?php echo $bg_banner ?>')">
                                <span class="gr"></span>
                                <div class="container margin">
                                    <div class="banner-info">
                                        <h2><?php echo $title_banner ?></h2>
                                        <p><?php echo $desc_banner ?></p>
                                    </div>
                                </div>
                            </li>

                        <?php } ?>

                    <?php endwhile; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</section>