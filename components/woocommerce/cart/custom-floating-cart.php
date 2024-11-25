<style>
    .custom-floating-cart {
        margin-block: auto;
        display: flex;
        position: fixed;
        top: 0;
        bottom: 0;
        right: 0;
        align-items: center;
        height: 100%;
        width: 100%;
        z-index: 1000000;

        &::before {
            content: '';
            width: 100%;
            height: 100%;
            position: fixed;
            background-color: var(--purple-cold);
            opacity: 0.6;
            z-index: -1;
            left: 0;
        }

        .main-container {
            display: flex;
            flex-direction: column;
            background-color: var(--purple-warm);
            height: 80%;
            justify-content: center;
            padding: 2.5rem;
            border-top-left-radius: 3rem;
            border-bottom-left-radius: 3rem;
            max-width: 30rem;
            width: 100%;
            right: 0;
            position: relative;
            margin-left: auto;
            gap: 1rem;

            .close-cart {
                display: flex;
                aspect-ratio: 1 / 1;
                width: 3.5rem;
                height: 3.5rem;
                background-position: center;
                background-size: contain;
                background-repeat: no-repeat;
                background-image: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1NiIgaGVpZ2h0PSI1NiIgdmlld0JveD0iMCAwIDU2IDU2IiBmaWxsPSJub25lIj4KPGNpcmNsZSBjeD0iMjgiIGN5PSIyOCIgcj0iMjgiIGZpbGw9IiNFNEFDNUIiLz4KPHJlY3QgeD0iMTYuNjI1IiB5PSIzNy43MTU5IiB3aWR0aD0iMjguNjM2NiIgaGVpZ2h0PSI4LjM1MjM1IiByeD0iMy41Nzk1OCIgdHJhbnNmb3JtPSJyb3RhdGUoLTU1LjkxMSAxNi42MjUgMzcuNzE1OSkiIGZpbGw9IndoaXRlIi8+CjxyZWN0IHdpZHRoPSIyOC42MzY2IiBoZWlnaHQ9IjguMzUyMzUiIHJ4PSIzLjU3OTU4IiB0cmFuc2Zvcm09Im1hdHJpeCgtMC41NjA0OCAtMC44MjgxNjggLTAuODI4MTY4IDAuNTYwNDggMzkuNTkzOCAzNy43MTU5KSIgZmlsbD0id2hpdGUiLz4KPC9zdmc+);
                position: absolute;
                left: -1.7rem;
            }

            .content {
                display: flex;
                width: 100%;
                height: 100%;
                flex-direction: column;
                justify-content: center;

                .title {
                    display: flex;

                    h4 {
                        font-size: 1.563rem;
                        color: var(--yellow);
                        font-family: var(--co-bold);
                    }
                }

                .items {
                    display: flex;
                    flex-direction: column;
                    height: 50%;
                    overflow: hidden;
                    overflow-y: auto;
                    gap: 1rem;
                    padding-right: 0.5rem;
                    padding-block: 0.5rem;

                    &::-webkit-scrollbar {
                        width: 0.7vw;
                    }

                    &::-webkit-scrollbar-track {
                        background-color: transparent;
                    }

                    &::-webkit-scrollbar-thumb {
                        background-color: var(--purple-warm);
                        border-radius: 3px;
                        border: 1px solid white;
                    }


                    .mini-card {
                        display: flex;
                        box-shadow: 0px 4px 11px 0px rgba(0, 0, 0, 0.15);
                        border-radius: 1rem;
                        background-color: var(--white);

                        .item {
                            display: flex;
                            width: 100%;
                            height: 100%;
                            padding: 1.2rem 1rem;
                            gap: 1rem;

                            .left {
                                display: flex;
                                flex-basis: 30%;

                                .prod-preview {
                                    aspect-ratio: 1 / 1;
                                    overflow: hidden;
                                    display: flex;
                                    border-radius: 0.8rem;
                                    width: 100%;

                                    img {
                                        width: 100%;
                                        height: 100%;
                                        object-fit: cover;
                                        object-position: center;
                                    }
                                }
                            }

                            .right {
                                display: flex;
                                flex-basis: 70%;

                                .prod-data {
                                    display: flex;
                                    flex-direction: column;
                                    width: 100%;
                                    justify-content: center;
                                    gap: 0.2rem;

                                    .prod-cat {
                                        display: flex;
                                        background-color: var(--purple-warm);
                                        padding: 0.2rem 0.6rem;
                                        width: max-content;
                                        color: var(--white);
                                        font-family: var(--co-bold);
                                        border-radius: .5rem;
                                        font-size: 0.938rem;
                                    }

                                    .prod-name {
                                        display: flex;
                                        color: var(--purple-cold);
                                        font-size: 1.125rem;
                                        font-family: var(--co-bold);
                                        line-height: normal;
                                    }

                                    .prices {
                                        display: flex;
                                        gap: 0.4rem;
                                        align-items: baseline;

                                        .sale-price {
                                            font-size: 1.25rem;
                                            color: var(--yellow);
                                            font-family: var(--co-bold);
                                            line-height: normal;
                                        }

                                        .regular-price {
                                            font-family: var(--co-medium);
                                            font-size: 0.938rem;
                                            line-height: normal;
                                            color: var(--purple-warm);
                                            opacity: 0.6;
                                            text-decoration: line-through;
                                        }
                                    }
                                }

                                .delete-button-container {
                                    display: flex;
                                    width: max-content;
                                    align-items: center;
                                    padding-inline: 0.5rem;

                                    #delete-button {
                                        cursor: pointer;
                                        width: 2rem;
                                        height: 2rem;
                                        background-color: transparent;
                                        background-repeat: no-repeat;
                                        background-position: center;
                                        background-position: center;
                                        background-image: url("data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyMiIgaGVpZ2h0PSIyNSIgdmlld0JveD0iMCAwIDIyIDI1IiBmaWxsPSJub25lIj4KPHBhdGggZD0iTTcuMDA4OTcgMS44MTE3Nkw2LjczOTkxIDIuNDQzMTRIMi40MzQ5OEMxLjYyNzggMi40NDMxNCAxIDMuMDc0NTEgMSAzLjg4NjI3QzEgNC42OTgwNCAxLjYyNzggNS4zMjk0MSAyLjQzNDk4IDUuMzI5NDFIMTkuNTY1QzIwLjM3MjIgNS4zMjk0MSAyMSA0LjY5ODA0IDIxIDMuODg2MjdDMjEgMy4wNzQ1MSAyMC4zNzIyIDIuNDQzMTQgMTkuNTY1IDIuNDQzMTRIMTUuMjYwMUwxNC45MDEzIDEuODExNzZDMTQuNjMyMyAxLjM2MDc4IDE0LjE4MzkgMSAxMy42NDU3IDFIOC4yNjQ1N0M3LjgxNjE0IDEgNy4yNzgwMyAxLjI3MDU5IDcuMDA4OTcgMS44MTE3NlpNMTkuNTY1IDYuNzcyNTVIMi40MzQ5OEwzLjQyMTUyIDIyLjAxNTdDMy40MjE1MiAyMy4wOTggNC40MDgwNyAyNCA1LjQ4NDMxIDI0SDE2LjUxNTdDMTcuNjgxNiAyNCAxOC41Nzg1IDIzLjA5OCAxOC42NjgyIDIyLjAxNTdMMTkuNTY1IDYuNzcyNTVaIiBzdHJva2U9IiM2MTMyODQiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLW1pdGVybGltaXQ9IjEwIi8+Cjwvc3ZnPg==");
                                    }
                                }
                            }
                        }
                    }
                }

                .resume {
                    display: flex;
                    width: 100%;
                    padding-block: 1rem 0.6rem;
                    border-top: 2px solid #ffffffd6;

                    .total {
                        width: 100%;
                        display: flex;
                        justify-content: space-between;
                        font-size: 1.125rem;
                        font-family: var(--nu-bold);
                        color: var(--white);

                        >span {

                            &.total-price {}
                        }
                    }
                }

                .buttons {
                    justify-self: center;
                    align-items: center;
                    width: 100%;
                    display: flex;
                    flex-direction: column;
                    gap: 0.6rem;

                    .buy-now {
                        display: flex;
                        text-align: center;
                        align-items: center;
                        justify-content: center;
                        color: var(--white);
                        background-color: var(--yellow);
                        border-radius: 0.625rem;
                        width: max-content;
                        padding: 0.6rem 1rem;
                        font-family: var(--nu-semibold);
                        font-size: 1.428rem;
                        cursor: pointer;
                        transition: var(--anim-low);

                        &:hover {
                            color: var(--yellow);
                            background-color: var(--yellow-clear);
                        }
                    }

                    .pay-later {
                        font-family: var(--nu-regular);
                        color: var(--white);
                        font-size: 1.188rem;
                        padding-block: 0.8rem;
                    }
                }
            }
        }

        &.visible {
            transform: translateX(100%);
            /* Lo mueve fuera de la vista */
            opacity: 0;
            /* Lo hace invisible */
            pointer-events: none;
            /* Desactiva la interacción mientras está oculto */
        }
    }
</style>
<aside class="custom-floating-cart">
    <div class="main-container">
        <button class="close-cart"></button>
        <div class="content">
            <div class="title">
                <h4>Mi carrito de compras</h4>
            </div>
            <div class="items">
                <div class="mini-card">
                    <div class="item">
                        <div class="left">
                            <div class="prod-preview">
                                <img src="https://fastly.picsum.photos/id/237/536/354.jpg?hmac=i0yVXW1ORpyCZpQ-CknuyV-jbtU7_x9EBQVhvT5aRr0"
                                    alt="">
                            </div>
                        </div>
                        <div class="right">
                            <div class="prod-data">
                                <span class="prod-cat">Categoría</span>
                                <span class="prod-name">Curso 1</span>
                                <div class="prices">
                                    <span class="sale-price">s/.300.00</span>
                                    <span class="regular-price">s/.400.00</span>
                                </div>
                            </div>
                            <div class="delete-button-container">
                                <button id="delete-button"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="resume">
                <div class="total">
                    <span>Total estimado</span>
                    <span class="total-price">S/. 300.00</span>
                </div>
            </div>
            <div class="buttons">
                <button class="buy-now">Comprar ahora</button>
                <button class="pay-later">Seguir Comprando </button>
            </div>
        </div>
    </div>
</aside>