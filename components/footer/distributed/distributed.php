<style>
    footer {
        background-color: transparent;

        &.blank {
            background-color: var(--white);
        }

        .main-container {
            background: var(--gr-purple);
            border-top-left-radius: 4rem;
            border-top-right-radius: 4rem;

            .footer {
                display: flex;
                flex-direction: column;
                padding: 4rem 4rem;
                padding-bottom: 1.5rem;

                .top {
                    display: flex;
                    padding-block: 1.5rem;
                    gap: 3rem;

                    .container {
                        display: flex;
                        flex-direction: column;
                        height: 100%;
                        flex-basis: 20%;

                        .logo-footer {
                            display: flex;
                            width: 5.645rem;
                            height: 5.625rem;
                            overflow: hidden;

                            img {
                                width: 100%;
                                height: 100%;
                                object-fit: cover;
                                object-position: center;
                            }
                        }

                        .description {
                            display: flex;
                            padding-block: 0.5rem 1.5rem;

                            p {
                                font-size: 1rem;
                                color: var(--white);
                                font-family: var(--co-book);
                            }
                        }

                        .socials {
                            display: flex;
                            flex-wrap: wrap;
                            gap: 1rem;

                            .social-link {
                                display: flex;
                                width: 3rem;
                                height: 3rem;
                                overflow: hidden;
                                cursor: pointer;

                                img {
                                    width: 100%;
                                    height: 100%;
                                    object-position: center;
                                    object-fit: contain;
                                }
                            }
                        }

                        .footer-menu {
                            display: flex;
                            flex-direction: column;

                            .title-nav {
                                width: 100%;
                                display: flex;
                                border-bottom: 2px solid #D9D9D9;
                            }

                            h4 {
                                font-size: 1.125rem;
                                color: var(--white);
                                font-family: var(--co-bold);
                                padding-bottom: 0.8rem;
                                width: 100%;
                            }

                            >nav {
                                padding-top: 0.5rem;

                                ul {
                                    display: flex;
                                    flex-direction: column;

                                    li {
                                        display: flex;

                                        a {
                                            padding-top: 0.4rem;
                                            color: var(--white);
                                            font-family: var(--co-book);
                                            line-height: normal;
                                        }

                                        &.yellow {

                                            a {
                                                font-family: var(--nu-regular);
                                                color: var(--yellow);
                                                font-size: 1rem;
                                                display: flex;
                                                justify-content: center;
                                                align-items: center;
                                                line-height: normal;
                                                gap: 3px;

                                                &::after {
                                                    display: flex;
                                                    content: '';
                                                    width: 8px;
                                                    height: 8px;
                                                    background-size: contain;
                                                    background-position: center;
                                                    background-repeat: no-repeat;
                                                    background-image: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI2IiBoZWlnaHQ9IjkiIHZpZXdCb3g9IjAgMCA2IDkiIGZpbGw9Im5vbmUiPgo8cGF0aCBkPSJNMi45MzMyNiA0LjUxODA0QzIuNTY4ODUgNC4xNjgwNyAyLjI2MTYgMy44NzUyMyAxLjk2MTQ5IDMuNTc1MjZDMS40MjU1OSAzLjAzOTU5IDAuODg5NjgyIDIuNTAzOTIgMC4zNTM3NzkgMS45NjgyNUMtMC4xMTA2NzEgMS40OTY4NiAtMC4xMTA2NzIgMC43ODk3NzMgMC4zNTM3NzggMC4zMzk4MUMwLjgwMzkzOCAtMC4xMDMwMSAxLjQ5NzA0IC0wLjEwMzAxMSAxLjk2MTQ5IDAuMzYxMjM2QzMuMDYxODggMS40NTQgNC4xNTUxMiAyLjU0Njc3IDUuMjQ4MzcgMy42NDY2OEM1Ljc2OTk4IDQuMTY4MDcgNS43Njk5OCA0LjgzMjMgNS4yNTU1MSA1LjM0NjU0QzQuMTYyMjcgNi40NDY0NSAzLjA2OTAyIDcuNTQ2MzYgMS45Njg2MyA4LjYzOTEzQzEuNDk3MDQgOS4xMTA1MiAwLjc5Njc5MiA5LjExNzY2IDAuMzM5NDg3IDguNjc0ODRDLTAuMTE3ODE3IDguMjI0ODggLTAuMTE3ODE4IDcuNTAzNTEgMC4zNjgwNjggNy4wMjQ5N0MxLjIwNDA4IDYuMjAzNjEgMi4wNDcyMyA1LjM4OTM5IDIuOTMzMjYgNC41MTgwNFoiIGZpbGw9IiNFNEFDNUIiLz4KPC9zdmc+');
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }

                        &:nth-child(4) {
                            height: 50%;
                            gap: 2rem;
                        }

                        &:nth-child(5) {
                            height: 50%;
                            gap: 2rem;

                            .footer-menu {

                                >p {
                                    padding-top: 0.5rem;
                                    color: var(--white);
                                    font-family: var(--co-book);
                                }
                            }
                        }
                    }
                }

                .bottom {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    padding-top: 1rem;
                    border-top: 2px solid #D9D9D9;

                    .disclaimer {
                        display: flex;
                        justify-content: center;
                        align-items: center;

                        span {
                            color: var(--white);
                            font-size: 1rem;
                            font-family: var(--co-book);
                        }
                    }
                }
            }
        }

    }
</style>
<footer <?php echo !empty($args['class']) ? 'class="' . esc_attr($args['class']) . '"' : ''; ?>>
    <div class="main-container">
        <div class="footer">
            <div class="top">
                <div class="container">
                    <div class="logo-footer">
                        <img src="<?php echo ASSETS ?>/img/logo/logo-sf-footer.svg" alt="">
                    </div>
                    <div class="description">
                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor
                        </p>
                    </div>
                    <div class="socials">
                        <a class="social-link">
                            <img src="<?php echo ASSETS ?>/icons/svg/tiktok.svg" alt="">
                        </a>
                        <a class="social-link">
                            <img src="<?php echo ASSETS ?>/icons/svg/instagram.svg" alt="">
                        </a>
                        <a class="social-link">
                            <img src="<?php echo ASSETS ?>/icons/svg/facebook.svg" alt="">
                        </a>
                        <a class="social-link">
                            <img src="<?php echo ASSETS ?>/icons/svg/linkedin.svg" alt="">
                        </a>
                        <a class="social-link">
                            <img src="<?php echo ASSETS ?>/icons/svg/youtube.svg" alt="">
                        </a>
                    </div>
                </div>

                <!-- Menu General -->
                <div class="container">
                    <div class="footer-menu generals">
                        <div class="title-nav">
                            <h4 class="submenu-title"><?php echo __('Menú'); ?></h4>
                        </div>
                        <?php if (has_nav_menu('generals')) {
                            wp_nav_menu(array(
                                'theme_location' => 'generals',
                                'container' => 'nav',
                                'container_class' => 'footer-nav generals',
                                'menu_class' => 'footer-menu-list',
                                'fallback_cb' => false,
                            ));
                        } ?>
                    </div>
                </div>

                <!-- Menu Support -->
                <div class="container">
                    <div class="footer-menu support">
                        <div class="title-nav">
                            <h4 class="submenu-title"><?php echo __('Enlaces de ayuda'); ?></h4>
                        </div>
                        <?php if (has_nav_menu('support')) {
                            wp_nav_menu(array(
                                'theme_location' => 'support',
                                'container' => 'nav',
                                'container_class' => 'footer-nav support',
                                'menu_class' => 'footer-menu-list',
                                'fallback_cb' => false,
                            ));
                        } ?>
                    </div>
                </div>


                <div class="container">
                    <!-- Menu Cursos -->
                    <div class="footer-menu cursos">
                        <div class="title-nav">
                            <h4 class="submenu-title"><?php echo __('Cursos'); ?></h4>
                        </div>
                        <?php if (has_nav_menu('cursos')) {
                            wp_nav_menu(array(
                                'theme_location' => 'cursos',
                                'container' => 'nav',
                                'container_class' => 'footer-nav cursos',
                                'menu_class' => 'footer-menu-list',
                                'fallback_cb' => false,
                            ));
                        } ?>
                    </div>

                    <!-- Menu Diplomados -->
                    <div class="footer-menu diplomados">
                        <div class="title-nav">
                            <h4 class="submenu-title"><?php echo __('Diplomados'); ?></h4>
                        </div>
                        <?php if (has_nav_menu('diplomados')) {
                            wp_nav_menu(array(
                                'theme_location' => 'diplomados',
                                'container' => 'nav',
                                'container_class' => 'footer-nav diplomados',
                                'menu_class' => 'footer-menu-list',
                                'fallback_cb' => false,
                            ));
                        } ?>
                    </div>
                </div>
                <div class="container">
                    <!-- Menu Certificados -->
                    <div class="footer-menu Certificados">
                        <div class="title-nav">
                            <h4 class="submenu-title">Certificados</h4>
                        </div>
                        <p>Valida el certificado Lorem Ipsum ingresando el código único:</p>
                        <a class="yellow-btn" href="" target="_blank">Verificar Certificado</a>
                    </div>
                </div>
            </div>

            <div class="bottom">
                <div class="disclaimer">
                    <span>©San Fernando 2024</span>
                </div>
            </div>
        </div>
    </div>
</footer>