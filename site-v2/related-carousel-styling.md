```scss


.carousel-related {

    .section-top {

        h3 {
            color: $black;
            font-family: $industry;
            font-size: 40px;
            line-height: 1.5;
            font-weight: 300;
        }

        .section-content p {
            font-family: $acumin-pro;
            font-weight: 400;
            font-style: normal;
            font-size: 20px;
            line-height: 1.7;
        }
    

        &.content-container {
            display: flex;
            flex-direction: column;
            gap: .5rem;
            margin-bottom: 20px;

            .section-content {
                max-width: 75%;
            }

            span {
                position: relative;

                &::after {
                    content: "";
                    position: absolute;
                    bottom: 12px;
                    left: 0;
                    width: 125px;
                    height: 3px;
                    background-color: $yellow;
                }
            }
        }
    }

    .related-nav {
        display: flex;
        flex-direction: column;
        justify-content: end;

        .button-container {
            display: flex;
            justify-content: end;
            gap: 12px;
            padding-bottom: 25px;
            padding-right: 25px;
            ;

            .swiper-button-prev {
                position: static;
                border: 1px solid #231F20;
                color: #231f20;
                border-radius: 50%;
                padding: 1.5rem;
                transition: background-color .3s, border .3s;

                &:hover {
                    background-color: $yellow;
                    border: 1px solid $yellow;
                }

                &::after {
                    font-size: 1.5rem;
                }
            }

            .swiper-button-next {
                position: static;
                border: 1px solid #231F20;
                color: #231f20;
                border-radius: 50%;
                padding: 1.5rem;
                background-color: transparent;
                transition: background-color .3s, border .3s;

                &:hover {
                    background-color: $yellow;
                    border: 1px solid $yellow;
                }

                &::after {
                    font-size: 1.5rem;
                }
            }
        }
    }

    .swiper {
        width: 100vw;
        height: 100%;
        margin-right: 0;
        overflow: visible;

        &-slide {
            border-radius: 12px;
            transition: transform 0.2s, box-shadow 0.3s;

            &:hover {
                box-shadow: 0px 10px 20px 0px #747474;
                transform: scale(1.04);
            }

            &-active {
                img {
                    animation: none;
                }
            }

            &-next {
                transition: transform 0.4s ease;
                // transform: scale(1.1);
                z-index: 2;
                // &:hover {
                //     transform: scale(1.05);
                // }
                    .background {
                        &::before {
                            border-bottom: 10px inset #ffd200;
                            padding-bottom: 3px;
                        }
                    }
              
            }

            .related {
                display: grid;
                grid-template-areas: "stack";

                > * {
                    grid-area: stack;
                }

                picture {
                    &.background {
                        position: relative;

                    &::before {
                        content: '';
                        position: absolute;
                        inset: 0;
                        border-radius: 12px;
                        background: linear-gradient(0deg, rgb(0, 0, 0) 0%, rgba(0, 0, 0, 0.7) 20%, rgba(60, 60, 60, 0) 40%)
                        }
                    }

                    .related-image {
                        display: block;
                        width: 100%;
                        height: 100%;
                        aspect-ratio: 3 / 2;
                        object-fit: cover;
                        object-position: center;
                        border-radius: 12px;
                    }
                }
            }

            .slide-content {
                position: relative;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                padding: 1rem;

                .cpt-info {
                    display: flex;
                    flex-direction: column;
                    align-items: flex-start;
                }

                .cpt-taxonomy {
                    display: flex;
                    justify-content: flex-end;

                    p {
                        font-family: $industry;
                        font-size: .75rem;
                        font-weight: 700;
                        text-transform: uppercase;
                        color: $white;
                        border: 1px solid $white;
                        border-radius: 40px;
                        padding: 6px 18px;
                        letter-spacing: .15em;
                        line-height: 1.5;
                    }
                }

                h4 {
                    font-family: $industry;
                    font-size: 22px;
                    font-weight: 700;
                    color: #fff;
                    display: -webkit-box;
                    -webkit-box-orient: vertical;
                    -webkit-line-clamp: 2;
                    line-clamp: 2;
                    overflow: hidden;
                }

                a {
                    color: #fff;
                    font-size: 20px;
                    font-family: "acumin-pro-condensed", sans-serif;
                    font-weight: 500;
                    font-style: normal;
                    text-decoration: none;
                    gap: 0px;
                }

                i {
                    color: $yellow;
                    font-size: 2.5rem;
                }
            }
        }
    }   
}


```