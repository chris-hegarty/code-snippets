# Fetching data on mount

This comes with a lot of pitfalls...there are libraries with built-in custom hooks that can help.

This example uses SWR. It allows you to input the API url, and a callback "fetcher" function.

The component mounts, we call the SWR hook:

```jsx

import React from 'react';
import useSWR from 'swr';

// Remove "?simulatedError=true" to see the success state:
const ENDPOINT =
  '/api/get-temperature?simulatedError=true';

async function fetcher(endpoint) {
  const response = await fetch(endpoint);
  const json = await response.json();

  if (!json.ok) {
    throw json;
  }

  return json;
}

function App() {
  const { data, isLoading, error } = useSWR(ENDPOINT, fetcher);

  if (isLoading) {
    return <p>Loading…</p>;
  }

  if (error) {
    return <p>Something's gone wrong</p>;
  }

  return (
    <p>
      Current temperature:
      {typeof data?.temperature === 'number' && (
        <span className="temperature">
          {data.temperature}°C
        </span>
      )}
    </p>
  );
}

```

---------------------------------------------------

Here is an example...a book searching app.

We need App.js, SearchResult.js and TextInput.js.

-Write a "handleSearch" function in App.js and immediately prevent default behavior.

### App.js:

```jsx

import React, {useState} from 'react';
import TextInput from './TextInput';
import SearchResult from './SearchResult';

function App() {
  const ENDPOINT = 'https://jor-test-api.vercel.app/api/book-search';
  
  const[searchTerm, setSearchTerm] = useState('');
  const[searchResults, setSearchResults] = useState(null);
  const [status, setStatus] = useState('idle');
  
  async function handleSearch(e){
    e.preventDefault();
    //begin setting up statuses: loading, success, error
    setStatus('loading');
    const url = `${ENDPOINT}?searchTerm=${searchTerm}`;
    const response = await fetch(url);
    const json = await response.json();
    
    if(json.ok) {
      setSearchResults(json.results);
      setStatus('success');
    } else {
      setStatus('error');
    }
    
    
  }
  return(
    <>
        <header>
          <form onSubmit={handleSearch}>
            <TextInput 
              required={true}
              label="Search"
              placeholder="Placeholder Text"
              value={searchTerm}
              onChange={()=>{
                setSearchTerm(e.target.value);
              }}
            />
            <button>
              GO!
            </button>
          </form>
        </header>
      
        <main>
          {status === 'idle' && (
            <p>Welcome to Book Search!</p>
          )}
          {status === 'loading' && (
            <p>Results loading...</p>
          )}
          {status === 'error' && (
            <p>Something went wrong.</p>
          )}
          {status === 'success' && (
            <div className="search-results">
              <h2>Results:</h2>  
              <SearchResultList searchResults={searchResults} />
            </div>
          )}
        </main>
    </>
  );
}

function SearchResultList({ searchResults }){
  //return early if no results.
  if(searchResults.length === 0){
    return <p>No results found.</p>;
  }
  return (
    <div className="search-results">
      <h2>Search Results</h2>
      {searchResults.map((result)=>(
        <SearchResult
          key={result.isbn}
          result={result}
        />
      ))}
    </div>
  );
}

const EXAMPLE = {
  isbn: '9781473621442',
  name: 'A Closed and Common Orbit',
  author: 'Becky Chambers',
  coverSrc: 'https://sandpack-bundler.vercel.app/img/book-covers/common-orbit.jpg',
  abstract:
    "Lovelace was once merely a ship's artificial intelligence. When she wakes up in an new body, following a total system shut-down and reboot, she has no memory of what came before. As Lovelace learns to negotiate the universe and discover who she is, she makes friends with Pepper, an excitable engineer, who's determined to help her learn and grow.",
};

export default App;

```
### TextInput.js

```jsx
import React, {useId} from 'react';

function TextInput({ id, label, ...delegated }) {
  
  let generatedId = useId();
  let appliedId = id || generatedId;
  
  return(
    <>
      <label htmlFor=""></label>
      <input 
        id={appliedId}
        type="text"
        {...delegated}
      />
    </>
  );
}

export default TextInput;
```

SearchResult.js

```jsx

import React from 'react';

function SearchResult({ searchResult }){
  
  return(
    <article className="search-result">
      <div className="image-container">
        <img 
          src="" 
          alt=""
        />
      </div>
      <div className="description">
        <p className="name">
          
        </p>
        <p className="author">
          
        </p>
        <p className="abstract">
          
        </p>
      </div>
    </article>
  );
}
export default SearchResult;
```

