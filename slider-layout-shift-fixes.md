# How to fix layout shift in various sliders.

Source: Blaze Slider benchmarks: https://github.com/blaze-slider/blaze-slider/blob/main/benchmark/src/layout-shift-fixes.css

```css

/* blaze  */
.blaze-slider {
/* API */
--slides-to-show: 3;
--slide-gap: 20px;
}

/* glide */
.glide .glide__slide {
/* manual fix  */
width: calc((100% - 40px) / 3);
margin-left: 10px;
margin-right: 10px;
}

/* swiper */
.swiper .swiper-slide {
/* manual fix  */
width: calc((100% - 40px) / 3);
margin-right: 20px;
}

/* slick */
.my-slick-slider .my-slick-slide {
width: calc((100% - 40px) / 3);
margin: 0 10px;
}

.slick-slider {
margin: 0 -10px;
}

.my-slick-slider {
display: flex;
overflow: hidden;
}

.my-slick-slide {
flex-shrink: 0;
width: 100%;
}
/* flickity */
.main-carousel:not(.flickity-enabled) {
overflow: hidden;
display: flex;
}

```