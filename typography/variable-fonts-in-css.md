# Loading variable font files

link: https://web.dev/articles/variable-fonts

Find variable fonts on Google Fonts:
https://fonts.google.com/?vfonly=true

Variable fonts are loaded though the same @font-face mechanism as traditional static web fonts, but with two new enhancements:


@font-face {
font-family: 'Roboto Flex';
src: url('RobotoFlex-VF.woff2') format('woff2-variations');
src: url('RobotoFlex-VF.woff2') format('woff2') tech('variations');
font-weight: 100 1000;
font-stretch: 25% 151%;
}
1. Source Formats: We don't want the browser to download the font if it doesn't support variable fonts, so we add format and tech descriptions: once in the future syntax (format('woff2') tech('variations')), once in the deprecated but supported among browsers syntax (format('woff2-variations')). If the browser supports variable fonts and supports the upcoming syntax, it will use the first declaration. If it supports variable fonts and the current syntax, it will use the second declaration. They both point to the same font file.

2. Style Ranges: You'll notice we're supplying two values for font-weight and font-stretch. Instead of telling the browser which specific weight this font provides (for example font-weight: 500;), we now give it the range of weights supported by the font. For Roboto Flex, the Weight axis ranges from 100 to 1000, and CSS directly maps the axis range to the font-weight style property. By specifying the range in @font-face, any value outside this range will be "capped" to the nearest valid value. The Width axis range is mapped in the same way to the font-stretch property.

If you're using the Google Fonts API, this will all be taken care of. Not only will the CSS contain the proper source formats and ranges, Google Fonts will also send static fallback fonts in case variable fonts aren't supported.