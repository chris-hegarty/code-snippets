# Output a CSV file from WP Data

### Example: custom-post-filters.pgp in brand.com

brand.com has a function to export Projects data into a CSV file.

It uses a couple of interesting functions.

It starts with the WP `head()` function

```php
            header('Content-type: text/csv');
            header('Content-Disposition: attachment; filename="projects.csv"');
            header('Pragma: no-cache');
            header('Expires: 0');
```

Document what this is doing
```php
			$bom = chr( 0xEF ) . chr( 0xBB ) . chr( 0xBF );
 			fputs($file, $bom);
```

The chr() function returns a character from the specified ASCII value.

The ASCII value can be specified in decimal, octal, or hex values. 

Octal values are defined by a leading 0, while hex values are defined by a leading 0x.

======

The `fputcsv()` function formats a line as CSV and writes it to an open file.

```php
            fputcsv($file, array(
				'Project ID', 
				'Name',
				'Description',
				'City',
				'State',
                'Country',
				'Market',
				'Submarket',
                'Procurement Method',
				'Services',
                'Callout',
                'Details',
				'Photos',
				'Status',
                'Link'
			));

```