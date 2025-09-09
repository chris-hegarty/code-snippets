# Use block props for wrapper elements

Here is an example of an edit.js file where we 

-import "useBlockProps" from the @wordpress/block-editor pkg
-export default function Edit
-pass an object into useBlockProps() function
-return the destructured "blockProps" object in the top-most element.

------------------
NOTE: The docs say you -cannot-use a React fragment as your outer element.
-------------------

The Block Editor is a React SPA.

### Every block in the editor is displayed by a React component. 

------------------------

Step One: Use `register_block_type()` in the main php file.

For a plugin, it looks like:

```jsx

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function create_block_ktg_blocks_init() {
	register_block_type( __DIR__ . '/build/generic-hero' );
	register_block_type( __DIR__ . '/build/additional-block' );
	register_block_type( __DIR__ . '/build/third-block' );
	register_block_type( __DIR__ . '/build/content-media' );
}
add_action( 'init', 'create_block_ktg_blocks_init' );
```
The function's 2nd param is the settings object.

It has several properties but the two most important are "Edit" and "Save".


The props object contains:
-attributes
-setAttributes
-isSelected




```jsx
/**
 * WordPress Dependencies
 */
import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';

/**
 * Internal Dependencies
 */
import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
export default function Edit() {
	const customStyleUnderline = {
		textDecoration: 'green wavy underline',
	};

	const blockProps = useBlockProps( {
		style: customStyleUnderline,
		className: 'hasPerspective',
	} );

	return (
		<p { ...blockProps }>
			{ __(
				'Hello World, step 2 (from the editor, in green).',
				'block-development-examples'
			) }
		</p>
	);
}
```