# Immutability Notes - Part 2
 
_Understanding mutability, and how data is passed through "snapshots"._ 

Reference: "State as a snapshot" - React docs
https://react.dev/learn/state-as-a-snapshot

---------------------

Setting a state variable doesn't change it right away, it triggers a re-render.

Setting state only changes things for the NEXT render.

When React re-renders a component:

* It calls the component function again
* The function returns a new JSX "snapshot"
* React then updates the screen to match the snapshot returned by the component function.

-----------------

Remember: You don't want to mutate state. 

In plain Javascript, you can update an object. React needs/wants a new object.

It's why we have the "set" part.

When you set state and create a new object, the new one and the previous one exist at the same time.

That is, until the component references the new object and "de-references" the old one.

Changing state is like painting a new picture with a new value...even when the new thing contains the same values.

### When you call the set function, you create a new object.

Important to understand the difference:

**-Two things can be the same, but "referentially" different**

VERSUS

The same reference that is being "threaded" through

(It is possible to generate a new variable for each React "snapshot" of state that points to the same underlying
reference. Different variables can point to the same entity.)

------------

### Components, Instances and "Snapshots"

INSTANCE - An instance of a component is a JavaScript object that is the "source of truth" for everything related to 
that component.

It is created when the component is mounted, and persists until it is unmounted.

SNAPSHOT - Refers to the data available at a particular moment in time.

An INSTANCE holds the true value of a piece of state.

But when that state changes, it creates a SNAPSHOT that captures the current value of that state variable.

----------------

_Quick React Loop reminder:_

Mount->Trigger->Render->Commit

TRIGGER: Invoking the set function will "trigger" a state change, and let React know that the value of a state 
variable has just been updated.

RENDER: React invokes the component function, produces a new set of React elements and reconciles them with current 
elements. It figures out what needs to happen to make the DOM match the new "snapshot"

COMMIT: React performs any necessary DOM updates.

------------------

