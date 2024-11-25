<style>
    :root {
        --header-height: 6.25rem;
        --marker-height: 2.5rem;
        --submenu-offset: 0.7rem;
    }

    header {
        box-sizing: border-box;
        position: fixed;
        display: flex;
        top: 0;
        z-index: 1000;
        width: 100%;
        max-height: var(--header-height);
        height: 100%;
        transition: var(--anim-low);

        &::before {
            content: '';
            width: 100%;
            height: 100%;
            position: absolute;
            background: var(--gr-header);
            opacity: 1;
            transition: var(--anim-low);
        }

        &::after {
            z-index: -1;
            content: '';
            width: 100%;
            height: 100%;
            position: absolute;
            background: var(--gr-white);
            opacity: 0;
            transition: var(--anim-low);
        }

        &.blank {
            box-shadow: 0 0.25rem 0.25rem 0 rgba(0, 0, 0, 0.25);

            &::before {
                opacity: 0;
            }

            &::after {
                opacity: 1;
            }
        }

        &.scrolled {
            box-shadow: 0 0.25rem 0.25rem 0 rgba(0, 0, 0, 0.25);

            &::before {
                opacity: 0;
            }

            &::after {
                opacity: 1;
            }
        }

        a {
            justify-content: center;
            align-items: center;
            gap: 0.2rem;
            display: flex;
            text-decoration: none;
        }

        .header {
            display: flex;
            position: relative;
            gap: 4rem;
            justify-content: space-between;
            width: 100%;
            margin: 0 auto;
            padding: 0 2rem;

            .logo-header-container {
                display: flex;
                justify-content: center;
                align-items: center;

                .logo-header {
                    width: 4.45rem;
                    position: relative;
                    display: flex;

                    img {
                        width: 100%;
                        height: auto;
                        display: block;
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
                    justify-content: flex-end;
                    gap: 1rem;
                    list-style: none;
                    margin: 0;
                    padding: 0;

                    >li {
                        justify-content: center;
                        align-items: center;
                        display: flex;
                        position: relative;

                        >a {
                            position: relative;
                            text-align: center;
                            justify-content: center;
                            align-items: center;
                            display: flex;
                            font-size: 0.938rem;
                            line-height: 0.938rem;
                            font-family: var(--co-medium);
                            color: var(--black);
                            padding: 0.5rem 0.8rem;
                            overflow: hidden;
                            text-wrap: wrap;
                            z-index: 1;
                            transition: var(--anim-low);

                            &::before {
                                content: '';
                                position: absolute;
                                background-color: var(--purple-cold);
                                border-radius: 0.5rem;
                                transform-origin: center;
                                height: 100%;
                                width: 0%;
                                z-index: -1;
                                transition: var(--anim-low);
                            }

                            &:hover {
                                font-family: var(--co-bold);
                                color: var(--white);

                                &::before {
                                    width: 100%;
                                }
                            }
                        }

                        &.has-submenu {
                            position: relative;

                            >span {
                                position: relative;
                                text-align: center;
                                justify-content: center;
                                align-items: center;
                                display: flex;
                                font-size: 0.938rem;
                                line-height: 0.938rem;
                                font-family: var(--co-medium);
                                color: var(--black);
                                padding: 0.5rem 0.8rem;
                                overflow: hidden;
                                text-wrap: wrap;
                                z-index: 1;
                                transition: var(--anim-low);
                                cursor: pointer;

                                &::before {
                                    content: '';
                                    position: absolute;
                                    background-color: var(--purple-cold);
                                    border-radius: 0.5rem;
                                    transform-origin: center;
                                    height: 100%;
                                    width: 0%;
                                    z-index: -1;
                                    transition: var(--anim-low);
                                }
                            }

                            .divider {
                                padding: 2rem 0;
                                background-color: var(--white);
                                justify-content: center;
                                align-items: center;
                                display: flex;
                                width: 100%;
                                position: fixed;
                                left: 0;
                                border-radius: 1rem;
                                opacity: 0;
                                visibility: hidden;
                                z-index: 999;
                                box-shadow: 0 0.25rem 0.25rem 0 rgba(0, 0, 0, 0);
                                top: 8rem;
                                transition: var(--anim-low);

                                &::before {
                                    content: '';
                                    position: fixed;
                                    width: var(--marker-height);
                                    height: var(--marker-height);
                                    top: -1.6rem;
                                    left: var(--indicator-left, 50%);
                                    background-image: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzNCIgaGVpZ2h0PSIzMSIgdmlld0JveD0iMCAwIDM0IDMxIiBmaWxsPSJub25lIj4KPHBhdGggZD0iTTkuNDAxMzMgNS4xNjEyOUMxMi43Nzg1IC0wLjY4ODE3MiAyMS4yMjE1IC0wLjY4ODE3MiAyNC41OTg3IDUuMTYxMjlMMzEuOTE4IDE3LjgzODdDMzUuMjk1MiAyMy42ODgyIDMxLjA3MzcgMzEgMjQuMzE5MyAzMUg5LjY4MDY5QzIuOTI2MzEgMzEgLTEuMjk1MTcgMjMuNjg4MiAyLjA4MjAxIDE3LjgzODdMOS40MDEzMyA1LjE2MTI5WiIgZmlsbD0id2hpdGUiLz4KPC9zdmc+);
                                    background-size: contain;
                                    background-repeat: no-repeat;
                                    background-position: center;
                                    transition: var(--anim-low);
                                    opacity: 0;
                                    visibility: hidden;
                                }

                                &.active {
                                    &::before {
                                        opacity: 1;
                                        visibility: visible;
                                    }
                                }

                                .submenu-container {
                                    flex-basis: 80%;
                                    padding: 0 2rem;
                                    display: flex;
                                    gap: 2rem;
                                    align-items: flex-start;

                                    .header-level-2 {
                                        flex: 1;
                                        display: grid;
                                        grid-template-columns: repeat(4, 1fr);
                                        gap: 1.5rem;
                                        list-style: none;
                                        margin: 0;
                                        padding: 0;

                                        >li {
                                            display: flex;

                                            a {
                                                width: 100%;
                                                justify-content: start;
                                                align-items: center;
                                                gap: 1rem;
                                                padding: 1rem;
                                                border-radius: 1rem;
                                                color: var(--black);
                                                font-family: var(--co-medium);
                                                background-color: var(--gray-clear);
                                                position: relative;
                                                transition: var(--anim-low);

                                                &::after {
                                                    position: relative;
                                                    opacity: 0;
                                                    width: 1.5rem;
                                                    height: 1.5rem;
                                                    left: -0.4rem;
                                                    content: '';
                                                    background-image: url("data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNCIgaGVpZ2h0PSIyMyIgdmlld0JveD0iMCAwIDE0IDIzIiBmaWxsPSJub25lIj4KPHBhdGggZD0iTTcuMTU4MDQgMTEuNDIwMkM2LjMzNDczIDEwLjU4MyA1LjY0MDU3IDkuODgyNTIgNC45NjI1NSA5LjE2NDk0QzMuNzUxNzkgNy44ODM1NSAyLjU0MTA0IDYuNjAyMTYgMS4zMzAyOSA1LjMyMDc3QzAuMjgwOTY5IDQuMTkzMTUgMC4yODA5NjkgMi41MDE3MSAxLjMzMDI5IDEuNDI1MzVDMi4zNDczMiAwLjM2NjA2NCAzLjkxMzIzIDAuMzY2MDYyIDQuOTYyNTQgMS40NzY2QzcuNDQ4NjIgNC4wOTA2MyA5LjkxODU2IDYuNzA0NjcgMTIuMzg4NSA5LjMzNTc5QzEzLjU2NyAxMC41ODMgMTMuNTY3IDEyLjE3MTkgMTIuNDA0NiAxMy40MDIxQzkuOTM0NyAxNi4wMzMyIDcuNDY0NzYgMTguNjY0MyA0Ljk3ODY5IDIxLjI3ODNDMy45MTMyMiAyMi40MDYgMi4zMzExOCAyMi40MjMxIDEuMjk4IDIxLjM2MzhDMC4yNjQ4MjQgMjAuMjg3NCAwLjI2NDgyMyAxOC41NjE4IDEuMzYyNTcgMTcuNDE3MUMzLjI1MTM1IDE1LjQ1MjMgNS4xNTYyNiAxMy41MDQ2IDcuMTU4MDQgMTEuNDIwMloiIGZpbGw9IiNFNEFDNUIiLz4KPC9zdmc+");
                                                    background-position: center;
                                                    background-repeat: no-repeat;
                                                    background-size: contain;
                                                    transition: var(--anim-low);
                                                }

                                                &:hover {
                                                    background-color: var(--purple-clear);

                                                    &::after {
                                                        left: 0rem;
                                                        opacity: 1;

                                                    }
                                                }

                                                .icon-cat {
                                                    background-color: var(--white);
                                                    width: 2.5rem;
                                                    height: auto;
                                                    display: flex;
                                                    align-items: center;
                                                    justify-content: center;
                                                    border-radius: 50%;
                                                    overflow: hidden;

                                                    img {
                                                        width: 100%;
                                                        object-fit: cover;
                                                        object-position: center;
                                                    }
                                                }

                                                .info-cat {
                                                    display: flex;
                                                    flex-direction: column;
                                                    color: var(--purple-cold);
                                                    font-family: var(--nu-bold);


                                                    .category-description {
                                                        display: flex;

                                                        >p {
                                                            color: var(--gray);
                                                            font-family: var(--nu-regular);
                                                            font-size: 0.825rem;
                                                            white-space: nowrap;
                                                            display: -webkit-box;
                                                            -webkit-line-clamp: 1;
                                                            -webkit-box-orient: vertical;
                                                            overflow: hidden;
                                                            text-overflow: ellipsis;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }

                                .cat-container {
                                    display: flex;
                                    flex-basis: 20%;
                                    justify-content: center;
                                    align-items: center;

                                    .purple-btn {
                                        font-size: 1rem !important;
                                        font-family: var(--nu-regular);
                                        transition: var(--anim-low);

                                        &:hover {
                                            font-family: var(--nu-bold)
                                        }
                                    }
                                }
                            }

                            &:hover,
                            &.active {
                                >span {
                                    font-family: var(--co-bold);
                                    color: var(--white);

                                    &::before {
                                        width: 100%;
                                    }
                                }

                                .divider {
                                    opacity: 1;
                                    visibility: visible;
                                    transform: translateY(0);
                                    box-shadow: 0 0.25rem 0.25rem 0 rgba(0, 0, 0, 0.1);

                                    &::before {
                                        opacity: 1;
                                        visibility: visible;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    /* Animaciones */
    .divider,
    .divider::before {
        transition-property: opacity, visibility, transform, box-shadow;
        transition-duration: 0.3s;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Media Queries */
    @media (max-width: 1200px) {
        .header-level-2 {
            grid-template-columns: repeat(3, 1fr) !important;
        }
    }

    @media (max-width: 992px) {
        .header-level-2 {
            grid-template-columns: repeat(2, 1fr) !important;
        }
    }
</style>
<?php include(get_template_directory() . '/components/sidebar/sidebar.php'); ?>
<header <?php echo !empty($args['class']) ? 'class="' . esc_attr($args['class']) . '"' : ''; ?>>
    <div class="header margin">
        <div class="logo-header-container">
            <a class="logo-header" href="<?php echo home_url('/') ?>">
                <img src="<?php echo ASSETS ?>/img/logo/logo-sf.png" alt="">
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
<script>
    jQuery(document).ready(function ($) {
        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('header').addClass('scrolled');
            } else {
                $('header').removeClass('scrolled');
            }
        });

        $('header nav').stylingNavOnHover('.has-submenu', '.divider');
    });

    jQuery(document).ready(function ($) {
        $('.has-submenu').on('mouseenter', function () {
            const $item = $(this);
            const itemRect = $item.get(0).getBoundingClientRect();
            const markerWidth = 28;
            const indicatorLeft = itemRect.left + (itemRect.width - markerWidth) / 2;

            $item.find('.divider').css('--indicator-left', `${indicatorLeft}px`);
        });
    });
</script>