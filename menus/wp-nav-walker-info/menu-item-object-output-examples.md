# Menu item object examples

Here are some samples of what we get with the $item object in the `start_el()` method of a custom Walker_Nav_Menu class.

Three examples below:

* -a top-level item with no children
* -a top-level item with a child (sublink)
* -a child item

----------------------------------------------------------------
## Top-level item, no children:

object(WP_Post)#1800 (40) {
["ID"]=>
int(139)
["post_author"]=>
string(1) "2"
["post_date"]=>
string(19) "2025-03-27 15:39:11"
["post_date_gmt"]=>
string(19) "2025-03-18 17:00:26"
["post_content"]=>
string(1) " "
["post_title"]=>
string(0) ""
["post_excerpt"]=>
string(0) ""
["post_status"]=>
string(7) "publish"
["comment_status"]=>
string(6) "closed"
["ping_status"]=>
string(6) "closed"
["post_password"]=>
string(0) ""
["post_name"]=>
string(3) "139"
["to_ping"]=>
string(0) ""
["pinged"]=>
string(0) ""
["post_modified"]=>
string(19) "2025-03-27 15:39:11"
["post_modified_gmt"]=>
string(19) "2025-03-27 15:39:11"
["post_content_filtered"]=>
string(0) ""
["post_parent"]=>
int(0)
["guid"]=>
string(30) "https://safetycon.local/?p=139"
["menu_order"]=>
int(1)
["post_type"]=>
string(13) "nav_menu_item"
["post_mime_type"]=>
string(0) ""
["comment_count"]=>
string(1) "0"
["filter"]=>
string(3) "raw"
["db_id"]=>
int(139)
["menu_item_parent"]=>
string(1) "0"
["object_id"]=>
string(1) "2"
["object"]=>
string(4) "page"
["type"]=>
string(9) "post_type"
["type_label"]=>
string(4) "Page"
["url"]=>
string(24) "https://safetycon.local/"
["title"]=>
string(11) "Sample Page"
["target"]=>
string(0) ""
["attr_title"]=>
string(0) ""
["description"]=>
string(0) ""
["classes"]=>
array(9) {
[0]=>
string(0) ""
[1]=>
string(9) "menu-item"
[2]=>
string(24) "menu-item-type-post_type"
[3]=>
string(21) "menu-item-object-page"
[4]=>
string(14) "menu-item-home"
[5]=>
string(17) "current-menu-item"
[6]=>
string(9) "page_item"
[7]=>
string(11) "page-item-2"
[8]=>
string(17) "current_page_item"
}
["xfn"]=>
string(0) ""
["current"]=>
bool(true)
["current_item_ancestor"]=>
bool(false)
["current_item_parent"]=>
bool(false)
}

------------------------------
## Top-level item with children (sublink)

object(WP_Post)#1799 (40) {
["ID"]=>
int(140)
["post_author"]=>
string(1) "2"
["post_date"]=>
string(19) "2025-03-27 15:39:11"
["post_date_gmt"]=>
string(19) "2025-03-18 17:00:26"
["post_content"]=>
string(0) ""
["post_title"]=>
string(13) "Top Level One"
["post_excerpt"]=>
string(0) ""
["post_status"]=>
string(7) "publish"
["comment_status"]=>
string(6) "closed"
["ping_status"]=>
string(6) "closed"
["post_password"]=>
string(0) ""
["post_name"]=>
string(8) "link-one"
["to_ping"]=>
string(0) ""
["pinged"]=>
string(0) ""
["post_modified"]=>
string(19) "2025-03-27 15:39:11"
["post_modified_gmt"]=>
string(19) "2025-03-27 15:39:11"
["post_content_filtered"]=>
string(0) ""
["post_parent"]=>
int(0)
["guid"]=>
string(30) "https://safetycon.local/?p=140"
["menu_order"]=>
int(2)
["post_type"]=>
string(13) "nav_menu_item"
["post_mime_type"]=>
string(0) ""
["comment_count"]=>
string(1) "0"
["filter"]=>
string(3) "raw"
["db_id"]=>
int(140)
["menu_item_parent"]=>
string(1) "0"
["object_id"]=>
string(3) "140"
["object"]=>
string(6) "custom"
["type"]=>
string(6) "custom"
["type_label"]=>
string(11) "Custom Link"
["title"]=>
string(13) "Top Level One"
["url"]=>
string(1) "/"
["target"]=>
string(0) ""
["attr_title"]=>
string(0) ""
["description"]=>
string(0) ""
["classes"]=>
array(9) {
[0]=>
string(0) ""
[1]=>
string(9) "menu-item"
[2]=>
string(21) "menu-item-type-custom"
[3]=>
string(23) "menu-item-object-custom"
[4]=>
string(17) "current-menu-item"
[5]=>
string(17) "current_page_item"
[6]=>
string(21) "current-menu-ancestor"
[7]=>
string(19) "current-menu-parent"
[8]=>
string(22) "menu-item-has-children"
}
["xfn"]=>
string(0) ""
["current"]=>
bool(true)
["current_item_ancestor"]=>
bool(true)
["current_item_parent"]=>
bool(true)
}

--------------------------------
## Child item:

object(WP_Post)#1798 (40) {
["ID"]=>
int(150)
["post_author"]=>
string(1) "2"
["post_date"]=>
string(19) "2025-03-27 15:39:11"
["post_date_gmt"]=>
string(19) "2025-03-26 15:20:27"
["post_content"]=>
string(0) ""
["post_title"]=>
string(11) "Sublink One"
["post_excerpt"]=>
string(0) ""
["post_status"]=>
string(7) "publish"
["comment_status"]=>
string(6) "closed"
["ping_status"]=>
string(6) "closed"
["post_password"]=>
string(0) ""
["post_name"]=>
string(11) "sublink-one"
["to_ping"]=>
string(0) ""
["pinged"]=>
string(0) ""
["post_modified"]=>
string(19) "2025-03-27 15:39:11"
["post_modified_gmt"]=>
string(19) "2025-03-27 15:39:11"
["post_content_filtered"]=>
string(0) ""
["post_parent"]=>
int(0)
["guid"]=>
string(30) "https://safetycon.local/?p=150"
["menu_order"]=>
int(3)
["post_type"]=>
string(13) "nav_menu_item"
["post_mime_type"]=>
string(0) ""
["comment_count"]=>
string(1) "0"
["filter"]=>
string(3) "raw"
["db_id"]=>
int(150)
["menu_item_parent"]=>
string(3) "140"
["object_id"]=>
string(3) "150"
["object"]=>
string(6) "custom"
["type"]=>
string(6) "custom"
["type_label"]=>
string(11) "Custom Link"
["title"]=>
string(11) "Sublink One"
["url"]=>
string(1) "/"
["target"]=>
string(0) ""
["attr_title"]=>
string(0) ""
["description"]=>
string(0) ""
["classes"]=>
array(6) {
[0]=>
string(0) ""
[1]=>
string(9) "menu-item"
[2]=>
string(21) "menu-item-type-custom"
[3]=>
string(23) "menu-item-object-custom"
[4]=>
string(17) "current-menu-item"
[5]=>
string(17) "current_page_item"
}
["xfn"]=>
string(0) ""
["current"]=>
bool(true)
["current_item_ancestor"]=>
bool(false)
["current_item_parent"]=>
bool(false)
}
