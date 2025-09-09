-From builder sass
carousel-cards.scss
```scss

.carousel-cards {
  background: #fff;
  padding: 60px 0 100px;

  .container {
    opacity: 1;
  }

  .section-top {

    span {
      position: relative;
      color: #fff;
      text-transform: uppercase;
      font-family: $industry;
      font-size: .9rem;
      letter-spacing: .15rem;
      padding: 0 4.5rem .15rem .5rem;

      &::after{
        content: "";
        position: absolute;
        bottom: 5px;
        left: 0;
        width: 125px;
        height: 3px;
        background-color: #ffd200;
      }
    }



    p {
      color: #000;
      font-family: $acumin-pro;
      font-weight: 300;
      font-style: normal;
      line-height: 34px;
      font-size: 20px;
      margin-bottom: 0 !important;
      padding-bottom: 25px;
    }
    h2{
      color: #000;
      font-family: $industry;
      font-size: 50px;
    }
  }

  .cards {
    display: flex;
    flex-direction: row;
    position: relative;
    z-index: -1;
    width: 340px !important;;
    height: 385px;
    left: 50px;

  }

  .card {
    background-repeat: no-repeat;
    background-position: center top;
    background-size: cover;
    display: flex;
    flex-direction: column;
    aspect-ratio: 4 / 3;
    position: relative;
    z-index: -1;
    border-radius: 15px;

    &::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      height: 100%;
      width: 100%;
      border-radius: 15px;
    }

    &::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      height: 100%;
      width: 100%;
      border-radius: 15px;
      background: linear-gradient(0deg, rgba(0, 0, 0, 1) 0%, rgba(0, 0, 0, .7) 20%, rgba(60, 60, 60, 0) 40%);
    }

    &__market {
      display: flex;
      justify-content: flex-end;
      align-items: center;
      padding: 10px;
      z-index: 10;

      svg {
        height: 2rem;
        width: auto;
        fill: #fff;
      }

      .market-text {
        color: #fff;
        text-transform: uppercase;
        font-family: myriad-pro-semi-condensed, sans-serif;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 2.2px;
      }
    }

    &__content {
      margin-top: auto;
      padding: 0px 20px 20px;
      z-index: 10;

      &--headings {
        padding: 10px;
      }

      &--title {
        font-weight: 700;
        font-style: normal;
        margin-bottom: 0;
        font-size: 25px;
        color: #fff;
        line-height: 27px;
        font-family: $industry;
        z-index: 10;
      }

      &--link {
        color: #fff;
        font-size: 12px;
        margin-bottom: 0;
        line-height: .7;
          a {
            color: #fff;
            font-size: 20px;
            font-family: "acumin-pro-condensed", sans-serif;
            font-weight: 500;
            font-style: normal;
            text-decoration: none;

            i {
               color: #ffd200;
               font-size: 2.5rem; 
            }
        }
        .bi {
            flex-shrink: 0;
            width: 1em;
            height: 1em;
            fill: currentcolor;
            transition: .2s ease-in-out transform;
        }

      }

      &--description {
        padding: 10px;

        p {
          color: #fff;
          font-size: 12px;
        }
      }
    }
  }


  ul {
    margin: 0 0 1rem 0;
  }
}

```