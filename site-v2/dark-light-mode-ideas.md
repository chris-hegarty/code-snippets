```scss

.module {
    --text-primary: var(--theme-text-primary);
    --button-background: var(--theme-button-bg);
    --button-text: var(--theme-button-text);
    --button-hover: var(--theme-button-hover);
    --border-color: var(--theme-border-color);

    &.ktg-dark-mode {
        --text-primary: #fff;
        --button-background: $transparent;
        --button-text: #fff;
        --button-hover: var(--theme-button-hover);
        --border-color: #fff;
    }

    &.ktg-light-mode {
        --text-primary: #000;
        --button-background: $transparent;
        --button-text: #000;
        --button-hover: var(--theme-button-hover);
        --border-color: #000;
    }
}

```
