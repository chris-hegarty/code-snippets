# Animated Search Bar

```html

<div class="navbar__search search collapse navbar-collapse dual-collapse">
    <div class="search__button">
        <button>
            <i class="fa fa-search"></i>
        </button>
    </div>
    <div class="search__form" style="display:none;">
        <?php get_search_form(); ?>
    </div>
</div>

```

```javascript

const $searchForm = $( '.search__form input[type=search]' );
const $searchWidth = '155px';

$( '.search__button button' ).on( 'click', function( e ) {
    e.preventDefault();
    $( this ).parent().hide();
    $( '.search__form' ).show();
    $( '.search__form fieldset' ).animate(
        {
            width: '+=' + $searchWidth,
        }
    ).delay( 800 );
    $searchForm.focus();
    return false;
} );

$searchForm.blur( function() {
    $( '.search__form fieldset' ).animate(
        {
            width: '-=' + $searchWidth,
        },
        {
            complete() {
                $( '.search__form' ).hide();
                $( '.search__button' ).show();
            },
        }
    );
} );

```

```css

.search-input {
  border: none;
}

input[type="search"] {
  border: none;
  width: 100%;
}

.search-field {
  position: relative;
  width: 40px;
  border: none;
  transition: all 300ms;

  ::placeholder {
    opacity: 0;
  }

  &.open {
    width: 200px;

    .input-group {
      input {
        border: 1px solid #bbb;
        border-radius: 20px !important;

        &::placeholder {
          opacity: 0;
        }
      }
    }
  }

  .search-icon-desktop {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
  }
}

::-webkit-input-placeholder {
  /* WebKit browsers */
  color: transparent;
}

:-moz-placeholder {
  /* Mozilla Firefox 4 to 18 */
  color: transparent;
}

::-moz-placeholder {
  /* Mozilla Firefox 19+ */
  color: transparent;
}

:-ms-input-placeholder {
  /* Internet Explorer 10+ */
  color: transparent;
}

@media screen and (min-width: 992px) {
  .search-field {
    &.mobile {
      display: none;
    }
    .search-icon-mobile {
      display: none;
    }
  }
}
@media screen and (max-width: 991px) {
  .search-field {
    &.mobile {
      width: 100%;
      border-bottom: 1px solid #000;

      .input-group {
        margin-bottom: 10px;
      }

      input {
        border: 1px solid #bbb;
        border-radius: 0;
        height: 40px;
        padding-left: 30px;
      }

      ::placeholder {
        margin-left: 20px;
        opacity: 1;
      }

      .search-icon-desktop {
        display: none;
      }

      .search-icon-mobile {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        z-index: 10;

        .fa {
          font-size: .75rem;
          font-weight: 700;
        }
      }

      button {
        background: #bbb;
        color: #fff;
      }
    }

    &.desktop {
      display: none;
    }
  }
}

```css



```