# AJAX in WordPress
“Because AJAX is already used in WordPress’ back end, it has been basically implemented for you. All you need to do is use the functions available. “

## STEPS

-Define a trigger for AJAX request in JavaScript. (onclick, onchange, etc…). 

### JS
```js


const myButton = document.querySelector(".my-button");
myButton.addEventListener('click', e => {
    // our request will be here
});

```

#### Create the AJAX request in JavaScript. 

In WP, using jQuery is common but we could also reach for axios.
This code is your event listener callback function:

```js



jQuery.ajax({
    type: "post",
    url: `${window.location.origin}/wp-admin/admin-ajax.php`,
    data: {
      action: "my_action",  // the action to fire in the server
      data: myData,         // any JS object
    },
    complete: function (response) {
      console.log(JSON.parse(response.responseText).data);
    },
});

```

#### What’s happening here:

type: It’s a POST request.

url: where to send the request. In WP, it’s usually going to be "/wp-admin/admin-ajax.php"

data: This is a JS  object. Its’ the data TO SEND in the request.

-One of the properties MUST be “action” – it tells WP the name of the hook to fire on the server.



beforeSend: This is a good place to show something like”Loading…” or a spinner. Example:

beforeSend: function() { $("div#loading").show(); },
complete: function() { $("div#loading").hide(); },

complete: A function that takes the “response” param. 

This usually comes in JSON format, so you’ll end up using JSON.parse

-Handle the request on the server.

In WordPress, you send the request to admin-ajax.php.

You can then retrieve the data in functions.php. (See create_select_dropdowns() in brand locations function.php file.)
The admin.ajax file creates two hooks for you to use. 
--wp_ajax_nameofaction
--wp_ajax_nopriv_nameofaction

***The nameofaction needs to match the action key defined in the JS ajax call from above.***
Then, you send the data back to the client with wp_send_json_success();
That makes the data available in the ajax “complete” method.
Super basic example of what goes in functions.php.
The data is available in the $_POST variable.
It looks like it is INSIDE this function that we’ll get the list of state or county pages.
<?php
function do_this_on_trigger_like_button_on_click() {
    $data = $_POST['data'];
    wp_send_json_success($data);
}
add_action('wp_ajax_my_action', ‘do_this_on_trigger_like_button_on_click’);
add_action('wp_ajax_nopriv_my_action', do_this_on_trigger_like_button_on_click);

-Go back to the JavaScript/jQuery ajax code and handle the response (with complete, success, error, etc)

(Here is where you update the DOM?)

Say you have this code. 

With Ajax, we can now replace the “content” of the <div> with anjy kind of event. (Like having the user click a “Load More” button, or changing the selection in a dropdown list.)

In essence a small amount JavaScript can load the file we dedicated to the fresh data <table> into the <div>, as the replacement of content of the <div>.

<div id="mydiv">
  <table>
    <tr>
      <td>Server</td>
      <td>Status</td>
    </tr>
    <tr>
      <td>1</td>
      <td>OK</td>
    </tr>
    <tr>
      <td>2</td>
      <td>Down</td>
    </tr>
  </table>
</div>




