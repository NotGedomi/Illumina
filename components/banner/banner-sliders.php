<section class="banner-sliders">
    <div class="splide" role="group" id="banner-sliders">
        <div class="splide__track">
            <ul class="splide__list">
                <?php if (have_rows('')): ?>
                    <?php while (have_rows('')):
                        the_row(); ?>

                        <?php if (!empty(get_field(''))) { ?>

                            <li class="splide__slide">
                                
                            </li>

                        <?php } ?>

                    <?php endwhile; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</section>