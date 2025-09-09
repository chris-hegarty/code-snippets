### Working with the $_SESSION superglobal

`session_start()`

This function initializes a session, or resumes it.

It does three important things:

1) It created a unique session ID for the user.
2) It stores the session ID in a cookie.
3) Then, it creates or resumes a session file on the server.

The $_SESSION superglobal then becomes an associatve array that persists across page requests from the same user.

### Working with the $_COOKIE superglobal

$_COOKIE contains all cookies sent by the client in the current request.
The values persist based on cookie expiration settings.
Cookies are stored on the client; sessions store data on the server.

#### When working with sessions, PHP automatically creates a cookie called `PHPSESSID` to track session data.

Here is a code snippet to see what each is doing:

```php

echo '<pre>';

echo "SESSION data:\n";
var_dump($_SESSION);

echo "\nCOOKIE data:\n";
var_dump($_COOKIE);

echo '</pre>';


```