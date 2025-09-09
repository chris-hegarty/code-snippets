# Working with cards

## Various tricks/snippets

Slight zoom in on image when hovered:

```html

<div class="image-container">
    <img class="img-fluid" src="<?php echo esc_url( $src ); ?>" alt="">
</div>

```

```scss

    .image-container {
        border-radius: 15px;
        overflow: hidden;
        aspect-ratio: 1.70 / 1;

        img {
            aspect-ratio: 1.70 / 1;
            object-fit: cover;
            border-radius: 15px;
            position: relative;
            transition: transform 0.3s linear;
            max-width: 100%;
            height: 100%;
        }
    }
    
    // The hover state can go on the entire card like:

    .card {
        border: transparent;
        border-radius: 15px;

        &:hover img {
            transform: scale3d(1.1, 1.1, 1.1);
        }
        
        // here is a gradient for text at the bottom of a full-image card:

        &::after {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: 15px;
            height: 100%;
            width: 100%;
            background: linear-gradient(to bottom, rgba(0,0,0,.8) 0%, rgba(0,0,0,0.4) 20%, rgba(60,60,60,0) 40% );
        }
    }

```