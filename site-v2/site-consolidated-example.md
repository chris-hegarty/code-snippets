    
# Site-Consolidated.js

## General pattern:

```js


    // ========================================================================
    // HEADER SEARCH
    // ========================================================================

    Site.HeaderSearch = {
        $container: null,
        $button: null,
        $buttonSearchIcon: null,
        $buttonClose: null,
        $buttonWrapper: null,
        $form: null,
        $formFieldset: null,
        $searchInput: null,
        $navUl: null,
        $logo: null,

        expandedWidth: 300,
        animationSpeed: Site.Config.ANIMATION_SPEED,
        isExpanded: false,
        isAnimating: false,

        /**
         * Expand search form with animation
         */
        expandSearch: function() {
            var self = this;
            if (self.isExpanded || self.isAnimating) return;

            self.isAnimating = true;
            self.isExpanded = true;

            self.expandedWidth = self.$navUl.outerWidth(true);
            var logoWidth = self.$logo.outerWidth();

            self.$buttonWrapper.hide();
            self.$navUl.removeClass("d-flex").addClass("d-none");

            self.$logo.css({
                "flex-shrink": "0",
                "flex-grow": "0",
                "min-width": logoWidth + "px"
            });

            self.$form.show();

            self.$formFieldset.animate(
                { width: self.expandedWidth + "px" },
                self.animationSpeed,
                function() {
                    self.isAnimating = false;
                    self.$searchInput.focus();
                    self.$buttonSearchIcon.hide();
                    self.$buttonClose.show();
                }
            );
        },

        /**
         * Collapse search form with animation
         */
        collapseSearch: function() {
            var self = this;
            if (!self.isExpanded || self.isAnimating) return;

            self.isAnimating = true;
            self.isExpanded = false;

            self.$buttonClose.hide();
            self.$buttonSearchIcon.show();

            self.$formFieldset.animate(
                { width: "40px" },
                self.animationSpeed,
                function() {
                    self.isAnimating = false;
                    self.resetSearch();
                }
            );
        },

        /**
         * Reset search to initial state
         */
        resetSearch: function() {
            var self = this;
            self.$form.hide();
            self.$navUl.removeClass("d-none").addClass("d-flex");
            self.$logo.css({
                "flex-shrink": "",
                "flex-grow": "",
                "min-width": ""
            });
            self.$buttonWrapper.show();
            self.$searchInput.val("");
        },

        /**
         * Handle button click
         */
        handleButtonClick: function(e) {
            e.preventDefault();
            Site.HeaderSearch.expandSearch();
        },

        /**
         * Handle close button click
         */
        handleCloseClick: function(e) {
            e.preventDefault();
            Site.HeaderSearch.collapseSearch();
        },

        /**
         * Handle input blur
         */
        handleInputBlur: function() {
            setTimeout(function() {
                Site.HeaderSearch.collapseSearch();
            }, 150);
        },

        /**
         * Handle keydown (Escape key)
         */
        handleKeyDown: function(e) {
            if (e.keyCode === 27 && Site.HeaderSearch.isExpanded) {
                e.preventDefault();
                Site.HeaderSearch.$searchInput.blur();
                Site.HeaderSearch.collapseSearch();
            }
        },

        /**
         * Handle form submission
         */
        handleFormSubmit: function(e) {
            e.stopPropagation();
        },

        /**
         * Bind all event listeners
         */
        bindEvents: function() {
            var self = this;
            if (self.$button && self.$button.length) {
                self.$button.on("click.headerSearch", self.handleButtonClick);
            }
            if (self.$buttonClose && self.$buttonClose.length) {
                self.$buttonClose.on("click.headerSearch", self.handleCloseClick);
            }
            if (self.$searchInput && self.$searchInput.length) {
                self.$searchInput.on("blur.headerSearch", self.handleInputBlur);
                self.$searchInput.on("keydown.headerSearch", self.handleKeyDown);
            }
            if (self.$form && self.$form.length) {
                self.$form.on("submit.headerSearch", self.handleFormSubmit);
            }
        },

        /**
         * Unbind all event listeners
         */
        unbindEvents: function() {
            var self = this;
            if (self.$button && self.$button.length) {
                self.$button.off(".headerSearch");
            }
            if (self.$buttonClose && self.$buttonClose.length) {
                self.$buttonClose.off(".headerSearch");
            }
            if (self.$searchInput && self.$searchInput.length) {
                self.$searchInput.off(".headerSearch");
            }
            if (self.$form && self.$form.length) {
                self.$form.off(".headerSearch");
            }
        },

        /**
         * Cache jQuery selectors
         */
        cacheElements: function() {
            var self = this;
            self.$button = $('.search-component__button button');
            self.$buttonClose = $('.search-component__form button.search-close');
            self.$buttonSearchIcon = $('.search-component__form button.search-icon');
            self.$buttonWrapper = $('.search-component__button');
            self.$form = $('.search-component__form');
            self.$formFieldset = self.$form.find("fieldset");
            self.$searchInput = self.$form.find('input[type="search"]');
            self.$navUl = $("nav.header__navigation");
            self.$logo = $("div.header__logo");
        },

        /**
         * Validate required elements exist
         */
        validateElements: function() {
            var self = this;
            if (!self.$button.length) {
                console.warn("HeaderSearch: Button element not found");
                return false;
            }
            if (!self.$searchInput.length) {
                console.warn("HeaderSearch: Search input element not found");
                return false;
            }
            if (!self.$formFieldset.length) {
                console.warn("HeaderSearch: Fieldset element not found");
                return false;
            }
            return true;
        },

        /**
         * Initialize module
         */
        init: function() {
            var self = this;
            self.cacheElements();
            if (!self.validateElements()) return;
            self.resetSearch();
            self.bindEvents();
        },

        /**
         * Cleanup module
         */
        destroy: function() {
            var self = this;
            self.unbindEvents();
            self.resetSearch();
        },

        /**
         * Reinitialize module
         */
        reinit: function() {
            var self = this;
            self.destroy();
            self.init();
        }
```
    };