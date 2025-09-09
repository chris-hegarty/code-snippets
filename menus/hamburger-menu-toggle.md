# Hamburger Menu code examples

Example One:

```html
<button class="btn-menu" type="button">
    <i class="btn-menu__bars" aria-hidden="true"></i>
    <span class="visually-hidden">Menu</span>
</button>
```

```css
.btn-menu {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 30px;
    padding-left: 0;
    padding-right: 0;
    border: none;
    background-color: transparent;
    color: inherit;
    cursor: pointer;
    transition: .3s ease;

    &:focus {
        outline: none;
    }

    &__text {
        margin-left: 10px;
        font-size: 1.125rem;
        font-weight: 700;
        line-height: 1;
    }

    &__bars {
        display: block;
        position: relative;
        width: 40px;
        height: 4px;
        background-color: $primary;
        transition: .3s;

        &:before, &:after {
            content: "";
            display: block;
            position: absolute;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: $primary;
            transition: .3s;
        }

        &:before {
            transform: translate(0, -13px);
        }

        &:after {
            transform: translate(0, 13px);
        }
    }

    .menu-open & {

        .btn-menu__bars {
            background-color: transparent;

            &:before {
                transform: rotate(45deg);
            }

            &:after {
                transform: rotate(-45deg);
            }
        }
    }
}

```

```javascript
//Vanilla:
var btnMenu = document.getElementsByClassName("btn-menu");
var body = document.body
for (var i = 0; i < btnMenu.length; i++) {
  btnMenu[i].addEventListener('click', function () {
    body.classList.toggle('menu-open');
  });
}

//jQuery

$('.btn-menu').on('click', function() {
  $('body').toggleClass('menu-open');
});


```