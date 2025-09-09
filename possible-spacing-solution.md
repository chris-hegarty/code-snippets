```css

/* provide default spacing for all blocks */
.site-content > * {
	margin-top: var(--wp--custom--spacing--m);
}

/* increase top spacing of align wide blocks  */
.site-content > .alignwide {
	margin-top: var(--wp--custom--spacing--l);
}

/* increase top spacing of blocks following align wide blocks  */
.site-content > .alignwide + * {
	margin-top: var(--wp--custom--spacing--l);
}

/* increase top spacing of all align full blocks */
.site-content > .alignfull {
	margin-top: var(--wp--custom--spacing--xl);
}

/* increase top spacing of all blocks following align full blocks */
.site-content > .alignfull + * {
	margin-top: var(--wp--custom--spacing--xl);
}

/* remove spacing between two adjacent align full blocks */
.site-content > .alignfull + .alignfull {
	margin-top: 0;
}

/* add extra spacing for the last block on the page */
.site-content > :last-child {
	margin-bottom: var(--wp--custom--spacing--xl);
}

/*
 * remove bottom spacing from the last block
 * on the page if it is align full
 */
.site-content > :last-child.alignfull {
	margin-bottom: 0;
}
```