## Block templates live in two different places

Because the user can edit block templates in the UI, you end up with two files: 
-the original template file in the theme folder
-a "forked" version of that file, saved to the wp_template Custom Post Type.

WordPress uses an algorithm to sync the two files.

## From block.json settings to CSS rules

From the settings section, all the values of any given presets will be converted to a CSS Custom Property.

It follows this naming structure: `--wp--preset--<category>-<slug>`

Example:

Here are colors set in theme.json, then what they end up as.

JSON:

```json
{
    "settings": {
        "color": {
            "palette": {
                "default": [
                    {
                        "slug": "vivid-red",
                        "value": "#cf2e2e",
                        "name": "Vivid Red"
                    }
                ],
                "theme": [
                    {
                        "slug": "foreground",
                        "value": "#000",
                        "name": "Foreground"
                    }
                ]
            }
        },
        "blocks": {
            "core/site-title": {
                "color": {
                    "palette": {
                        "theme": [
                            {
                                "slug": "foreground",
                                "value": "#1a4548",
                                "name": "Foreground"
                            }
                        ]
                    }
                }
            }
        }
    }
}
```
CSS

```CSS

body {
  --wp--preset--color--vivid-red: #cf2e2e;
  --wp--preset--color--foreground: #000;
}

.wp-block-site-title {
  --wp--preset--color--foreground: #1a4548;
}

```