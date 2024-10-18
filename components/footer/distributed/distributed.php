<style>
    footer {
        width: 100%;
        bottom: 0;
        position: relative;
        display: flex;
        flex-direction: column;

        .footer {
            height: 100%;
            display: flex;
            padding-block: 3rem;
            background-color: var(--gray-btm);

            nav {
                display: flex;

                .footer-level-1 {
                    display: grid;
                    grid-template-columns: repeat(4, 1fr);
                    grid-template-rows: repeat(4, auto);
                    column-gap: 3.5rem;
                    width: 100%;

                    >li {

                        >a {
                            width: 100%;
                            font-family: var(--s-light);
                            color: var(--owl);
                            text-decoration: underline;
                            text-underline-offset: 3px;
                            display: flex;
                            gap: 0.3rem;

                            &:hover {}
                        }

                        >.divider {
                            display: flex;
                            height: 100%;

                            .footer-level-2 {
                                display: flex;
                                flex-direction: column;
                                justify-content: start;

                                >li {
                                    padding-block: 0.4rem;
                                    left: 0rem;
                                    transition: var(--anim-low);

                                    a {
                                        font-family: var(--s-light);
                                        color: var(--gray-letter);
                                        display: flex;
                                        gap: 0.3rem;

                                        &:hover {
                                            color: var(--owl);
                                        }
                                    }

                                    &:hover {
                                        position: relative;
                                        left: 1rem;
                                    }
                                }
                            }
                        }

                        &:nth-child(1),
                        &:nth-child(2) {
                            grid-column: span 1;
                            grid-row: span 4;
                        }

                        &:nth-child(3),
                        &:nth-child(4),
                        &:nth-child(5) {
                            grid-column: span 1;
                            grid-row: span 2;
                        }

                        &:nth-child(6),
                        &:nth-child(7) {
                            align-self: center;
                            height: min-content;
                            grid-column: span 1;
                            grid-row: span 1;
                        }

                    }
                }
            }
        }

        .sub-footer {
            background: var(--gr-owl);
            display: flex;

            .margin {
                display: flex;
                flex-direction: column;
                padding-block: 3rem;
                justify-content: space-between;
                gap: 3rem;

                .top {
                    display: flex;
                    width: 100%;

                    .subfooter-container-left {
                        display: flex;
                        width: 100%;
                        gap: 2rem;


                        .subfooter-logo {
                            width: 214px;

                            img {
                                object-fit: contain;
                                object-position: center;
                                width: 100%;
                            }
                        }

                        nav {
                            display: flex;
                            justify-content: center;
                            align-items: flex-end;
                            width: 100%;

                            .subfooter-level-1 {
                                padding-block: 0.3rem;
                                display: flex;
                                width: 100%;

                                >li {
                                    display: flex;
                                    align-items: center;
                                    padding-inline: 3rem;

                                    >a {
                                        font-family: var(--s-light);
                                        color: var(--blank);
                                    }
                                }
                            }

                        }
                    }

                    .subfooter-container-right {
                        display: flex;
                        flex-basis: 20%;
                        justify-content: center;

                        .subfooter-socials {
                            display: flex;
                            width: 100%;

                            .icons-social {
                                width: 100%;
                                display: flex;
                                gap: 0.6rem;
                                justify-content: center;
                                align-items: flex-end;

                                img {
                                    width: 28px;
                                    object-fit: contain;
                                }
                            }
                        }
                    }
                }

                .bottom {
                    width: 100%;
                    display: flex;

                    span {
                        font-size: 0.875rem;
                        font-family: var(--s-light);
                        color: var(--blank);
                    }
                }
            }
        }
    }
</style>
<footer>
    <div class="footer">
        <nav class="margin">
            <?php
            $menu_location = 'footer-menu';
            $menu_name = 'footer';

            display_custom_menu($menu_location, $menu_name);
            ?>
        </nav>
    </div>
</footer>