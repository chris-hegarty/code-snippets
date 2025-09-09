# Buttons

```scss

button,
input[type="button"],
input[type="reset"],
input[type="submit"] {
	border: 1px solid $color__brand-yellow;
	border-radius: 0;
	background: $color__brand-yellow;
	color: $color__black;
	font-size: 1em;
	font-family: acumin-pro-condensed, sans-serif;
	font-weight: 700;
	letter-spacing: 0.125em;
	text-transform: uppercase;
	line-height: 1;
	padding: 0.9375em 1.75em;
	transition: background-color 0.25s, border-color 0.25s;
	cursor: pointer;

	&:hover {
		background-color: $color__light-yellow;
		border-color: $color__light-yellow;
	}

	&:active,
	&:focus {
		border-color: $color__gray;
	}
}

```