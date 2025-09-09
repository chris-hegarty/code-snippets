# Spectrum of components

At one end: low-level, primitive, generic: Buttons, Modals, inputs, etc

Further along - Components tied into the application: LoginForm, UserProfileCard, etc..

The other end - Components specific to an app: Dashboard, root level App component.

Important to separate concerns. For example, you could have a banner that checks if someone is logged in. It's 
probbaly better to have a "Logged In" banner that checks the user status, then pulls in a separate Banner component 
that exists with or without the user status.

The goasl is to keep components relatively simple.

### Atomic Design

This theory puts components in five categories, from smallest to largest:

Atoms - Super re-usable primitives. Buttons, Inputs, etc.
Molecules
Organisms
Templates
Pages

Example - Product Card - Could be one component but would be dealing with multiple concerns.

Star rating | Photo Toggle 




