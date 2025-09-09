# Fetch

## Fetch current user

Need the following files: App.js, UserCard.js, Spinner.js, Spinner.module.css

Spinner.module.css
```css
@keyframes spin {
  from {
    transform: rotate(0deg);
  }
  to {
    
    transform: rotate(360deg);
  }
}

.spinner {
  display: block;
  width: max-content;
  margin: auto;
  color: #fff;
  animation: spin 1000ms linear infinite;
}

.spinner svg {
  display: block;
}


```
Spinner.js:

```jsx
import {Loader} from 'react-feather';
import VisuallyHidden from './VisuallyHidden';
import styles from './Spinner.module.css';

function Spinner({ size = 32 }){
  return(
    <span className={styles.spinner}>
      <Loader size={size} />
      <VisuallyHidden>Loading...</VisuallyHidden>
    </span>
  );
}
export default Spinner;
```

UserCard.js

```jsx
import React from 'react';

function UserCard({ name, email }){
  return(
    <article className="user-card">
      <p className="name">{name}</p>
      <p className="email">{email}</p>
    </article>
  );
}

export default UserCard;
```

App.js:

```jsx
import React from 'react';
import useSWR from 'swr';
import UserCard from './UserCard.js';
import Spinner from './Spinner';

const ENDPOINT = '/api/get-current-user';

async function fetcher(endpoint){
  const response = await fetch(endpoint);
  const json = await response.json;
  if(!json.ok){
    throw json;
  }
  return json;
}

function App(){
  const { data,error } = useSWR(ENDPOINT, fetcher);
  //check what we're getting:
  console.log(data, error);
  
  const isLoading = !data && !error;
  
  if(isLoading){
    return <Spinner />
  }
  
  if(error){
    return <p>Something went wrong,</p>;
  }
  
  if(data?.user) {
    return (
      <UserCard name={data.user.name} email={data.user.email}/>
    );
  }
}

export default App;
```