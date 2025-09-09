# FETCH

### Retrieving data:

```js

async function getData(){
  const response = await fetch('/some-api-endpoint/data');
  const json = await response.json();
}

```

### POST

You can send data with a 2nd parameter to "fetch".
It's an object where you tell it it's a POST method:

```jsx

async function submitData(){
  const response = await fetch('/some-api-endpoint/data', {
    method: 'POST',
  });
  const json = await response.json();
}
```

### Query and body params:

WHen making network requests, we often need to send along some data.

This is typically done with query params:

For query params you can use them right in the URL:

```js

async function search( {name, city} ) {
  
  const url = `/api/search?name=${name}&city=${city}`;
  
  const response = await fetch(url);
  const json = await response.json();
}

```

If they are body params in a POST request:

```jsx

async function login({ username, password }) {
  
  const response = await fetch('/api/login', {
    method: 'POST',
    //you have to stringify before sending:
      body: JSON.stringify({
        username, 
        password,
    }),
  });
  
  const json = await response.json();
  
}

```