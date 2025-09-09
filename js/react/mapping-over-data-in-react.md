# Mapping over data in React

Here is an example of data stored in an array:

```js
const employees = [
  {
    id: 'sunita-abc123',
    name: 'Sunita Kumar',
    job: 'Electrical Engineer',
    email: 'sunita.kumar@acme.co',
  },
  {
    id: 'henderson-def456',
    name: 'Henderson G. Sterling II',
    job: 'Receptionist',
    email: 'henderson-the-second@acme.co',
  },
  {
    id: 'aio-ghi789',
    name: 'Aoi Kobayashi',
    job: 'President',
    email: 'kobayashi.aoi@acme.co',
  },
]
```

Now, the goal is to create a ContactCard component for each person.

```jsx

function App() {
  //This way is OK:
  const employees = employees.map((employee) => {

    <ContactCard
      name={employee.name}
      job={employee.job}
      email={employee.email}
    />

    return (
      <ul>{employees}</ul>
    );
  });
}
  
  //The preferred way. 
  //Drop the component in the return statement.
  //Then map over the component.
//Note: You have to return the component in the map function,

function preferredWay() {
    return(
      <ul>
        {employees.map( (employee, index) => {
          return(
              <ContactCard
                name={employee.name}
                job={employee.job}
                email={employee.email}
              />
          )
        })}
      </ul>
    );
}
   
    //Totally wrong:
  // return(
  //   <ul>
      {/*{employees.map( (employee, i) => {*/}
      {/*  return(*/}
      {/*    <ContactCard*/}
      {/*      name*/}
      {/*      job*/}
      {/*      email*/}
      {/*    />*/}
      {/*  );*/}
      {/*})}*/}

  {/*  </ul>*/}
  {/*);*/}
}
```

Another really common pattern.
Note the use of parens instead of curly braces

```jsx
<ul>
  {items.map(item => (
    <li>{item}</li>
    )
  )
}
</ul>
```

# Keys

Keys are separate and different from props!

This is how it looks in Vanilla JS:

```javascript
const element = {
  type: ContactCard,
  key: 'sunita-abc123',
  props: {
    name: 'Sunita Kumar',
    job: 'Electrical Engineer',
    email: 'sunita.kumar@acme.co',
  }
}

```

### Takeaways:

-Keys are TOP-LEVEL properties in React elements.
-They IDENTIFY a particular React element.
-They are properties of the element itself... NOT part of the "props" object.

### Use

Put the key directly in the element you are mapping over:

```jsx
function NavigationLinks({ links }) {
  return (
    <ul>
      {links.map(item => (
        <li key={item.id}>
          <a href={item.href}>
            {item.text}
          </a>
        </li>
      ))}
    </ul>
  );
}
```

If you need to include the other parameters, you need the 2nd set of parens. It looks like this:

```jsx
function NavigationLinks({ links }) {
  return (
    <ul>
      {links.map( (item, index) => (
        <li key={item.id}>
          <a href={item.href}>
            {item.text}
          </a>
        </li>
      ))}
    </ul>
  );
}

//Keep in mind, for dynamic data, try to use a unique identifier from your data.
```

You can also use array destructuring here when mapping over an array:

```jsx

import Avatar from './Avatar';

const data = [
  {
    id: '001',
    alt: 'person with curly hair and a black T-shirt',
  },
  {
    id: '002',
    alt: 'person wearing a hijab and glasses',
  },
  {
    id: '003',
    alt: 'person with short hair wearing a blue hoodie',
  },
  {
    id: '004',
    alt: 'person with a pink mohawk and a raised eyebrow',
  },
];

function App() {
  return (
    <div className="avatar-set">
      {data.map(({ id, alt }) => (
        <Avatar
          key={id}
          src={`https://sandpack-bundler.vercel.app/img/avatars/${id}.png`}
          alt={alt}
        />
      ))}
    </div>
  );
}

export default App;


```

