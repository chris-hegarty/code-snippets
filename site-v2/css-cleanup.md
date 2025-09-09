# CSS inventory

carousel-cpthero
-on single-article and single-project

```css

.carousel__item span {
    position: relative;
    color: #fff;
    text-transform: uppercase;
    font-family: "Industry",serif;
    font-size: .9rem;
    letter-spacing: .15rem;

.carousel__item span::after {
    content: "";
    position: absolute;
    bottom: -6px;
    left: 0;
    width: 0;
    height: .15rem;
    background-color: #ffd200;
    animation: underline 2s ease-in;
    animation-fill-mode: none;
    animation-fill-mode: forwards;

@media screen and (min-width: 992px) {
  .carousel__item h1.cpt-heading {
    max-width: 75%;
  }
}

.carousel__item h1 {
    color: #fff;
    font-size: 4rem;
    font-family: "Industry",serif;
    font-size: clamp(3rem,2.286rem + 2.286vw,4rem);
    font-weight: bold;
}

.carousel__container .container p.cpt-location {
    font-size: 1.625rem;
}
.carousel__container .container p {
    color: #fff;
    font-family: "acumin-pro",sans-serif;
    font-weight: 300;
    font-style: normal;
    font-size: 18px;
    line-height: 20px;
}


```