# Transferring data

(src: https://support.advancedcustomfields.com/forums/topic/resolving-lost-data-when-moving-field-to-group/)

When I make interface changes of this nature I do the following
(this is a quick explanation as there is a lot of code that would be involved)

    Create new field(s) – group and sub fields

    add an acf/prepare_field filter for the new sub field. 
    (If the new field does not have value (NULL) then populate the value with the old field value.)

    add an acf/save_post action that deletes the old value when a post us updated using the new field(s).

    add an acf/prepare_field filter to the old field that returns false to hide the old field but keep it definition 
intact.

    In the template code where the field is used, get the new field value, if the value is NULL (never updated) then get the value from the old field

    This allows you to alter the field setup without needing to alter all of the existing data and will transition the fields from old to new as a post is updated. If a post is never updated then it will continue to work indefinitely.