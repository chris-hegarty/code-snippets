# React's Core Loop

## mount | trigger | render | commit

### Mount: 

When we render the component for the first time, there is no previous snapshot to compare to. 

And so, React will create all of the necessary DOM nodes from scratch, and inject them into the page.

### Trigger:

Eventually, something happens that triggers a state change, invoking the “set X” function (eg. setCount). 

We're telling React that the value of a state variable has just been updated.

### Render:

Because the state changed, we need to generate a new description of the UI! React will invoke our component function again, producing a new set of React elements.

With this new snapshot in hand, React will reconcile it, comparing it to the previous snapshot, and figuring out what needs to happen in order for the DOM to match this latest snapshot.

### Commit:

If any DOM updates are required, React will perform those mutations (eg. changing the text content of a DOM node, creating new nodes, deleting removed nodes, etc).

Once the changes have been committed, React goes idle, and waits for the next trigger, the next state change.

----------------

## Why React re-renders

Reminder: each render is like a snapshot/photo that tells us what the UI should look like, based on current 
application state.

Every re-render starts with a state change.

When a component re-renders, it also re-renders -all- its descendants.

A component won't necessarily re-render because its props change.  

It re-renders because one of its state variables has been updated.

That re-render will cascade all the way down the tree, in order for React to figure out what the new snapshot 
should look like.

This can lead to performance problems in larger apps where a single state change could re-render dozens or even 
hundreds of components.

Memoization can help with this.

You wrap the component function like this:

```jsx

function Decoration() {
  return (
    <div className="decoration">
      ⛵️
    </div>
  );
}

const PureDecoration = React.memo(Decoration);
```

