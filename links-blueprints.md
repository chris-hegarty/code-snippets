Links

```css

a {
	color: $color__link;
	transition: color 0.25s;
	text-decoration: none;
	font-family: inherit;
	font-weight: 700;

	&:visited {
		color: $color__link;
	}
	&:hover,
	&:focus,
	&:active {
		color: $color__link-hover;
	}
	&:focus {
		outline: 0;
	}
	&:hover,
	&:active {
		outline: 0;
	}
}


```