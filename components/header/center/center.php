<script>
    jQuery(document).ready(function (jQuery) {
        jQuery.fn.dynamicTop('header', 'header .divider');
        jQuery('header nav').stylingNavOnHover('.has-submenu', '.divider');
    });
</script>
<style>
    header {
        box-sizing: border-box;
        position: fixed;
        display: flex;
        top: 0;
        z-index: 1000;
        width: 100%;
        max-height: 5rem;
        height: 100%;
        background-color: var(--blank);


        a {
            justify-content: center;
            align-items: center;
            gap: 0.2rem;

            .private {

                svg {

                    path {
                        fill: var(--gray-letter);
                    }
                }
            }

            &:hover {
                .private {

                    svg {

                        path {
                            fill: var(--owl);
                        }
                    }
                }
            }
        }

        .header {
            display: flex;
            position: relative;
            gap: 4rem;
            justify-content: space-between;

            .logo-header-container {

                .logo-header {
                    width: 8.5rem;
                    position: relative;
                    display: flex;

                    img {
                        width: 100%;
                    }
                }
            }

            nav {
                width: 100%;
                position: relative;
                display: flex;
                padding-block: 0.4rem;
                box-sizing: border-box;

                @media (max-width: 1000px) {
                    display: none;
                }


                .header-level-1 {
                    width: 100%;
                    display: flex;
                    justify-content: space-between;
                    gap: 1rem;

                    >li {
                        justify-content: center;
                        align-items: center;
                        display: flex;
                        position: relative;

                        a {
                            height: 100%;
                            text-align: center;
                            justify-content: center;
                            align-items: center;
                            display: flex;
                            font-size: 0.938rem;
                            font-family: var(--s-light);
                            text-wrap: wrap;

                            &:hover {
                                color: var(--owl);
                            }
                        }

                        >.divider {
                            padding: 2rem 0rem;
                            background-color: var(--cream);
                            justify-content: center;
                            align-items: center;
                            display: flex;
                            width: 100%;
                            opacity: 0;
                            left: 0;
                            visibility: hidden;
                            position: fixed;
                            transition: var(--anim-low);

                            .header-level-2 {
                                background-color: var(--cream);
                                width: 70%;
                                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                                grid-template-rows: auto;
                                place-items: start center;
                                gap: 1rem;
                                display: grid;

                                >li {
                                    display: flex;

                                    a {
                                        color: var(--gray-letter);
                                        height: 100%;
                                        font-size: 0.938rem;
                                        font-family: var(--s-light);
                                        text-wrap: wrap;

                                        &:hover {
                                            color: var(--owl);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }


            }
        }
    }
</style>
<?php include(get_template_directory() . '/components/sidebar/sidebar.php'); ?>
<header>
    <div class="header margin">
        <div class="logo-header-container">
            <a class="logo-header" href="<?php echo home_url('/') ?>">
                <img src="<?php echo ASSETS ?>/img/logo/logo-colors.webp" alt="">
            </a>
        </div>
        <nav>
            <?php
            // Especifica la ubicación del menú y el nombre del menú
            $menu_location = 'header-menu';
            $menu_name = 'header';

            // Llama a la función para mostrar el menú
            display_custom_menu($menu_location, $menu_name);
            ?>
        </nav>
    </div>
</header>
