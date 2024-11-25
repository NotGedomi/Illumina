<section class="agreements margin">
    <div class="title">
        <h2>Convenios</h2>
    </div>
    <div class="cards-container">
        <?php for ($i = 0; $i < 4; $i++): ?>
            <div class="container">
                <div class="custom-shape">
                    <div class="content">
                        <div class="entity">
                            <h3>Entidad</h3>
                        </div>
                        <div class="collection">
                            <div class="splide entitys-collection" role="group">
                                <div class="splide__track">
                                    <ul class="splide__list">
                                        <?php for ($j = 0; $j < 10; $j++): ?>
                                            <li class="splide__slide">
                                                <div class="entity-img">
                                                    <img src="<?php echo ASSETS ?>/img/entitys/demo-entity.png" alt="">
                                                </div>
                                            </li>
                                        <?php endfor; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endfor; ?>
    </div>
</section>