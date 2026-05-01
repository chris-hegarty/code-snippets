# Subsites updates

## Working example with TICUS

### Creating initial working branches 

Context: In late 2024, we transitioned dozens of sites into KTG Dev Ops. Many of which are still at their first 
commit.

These notes are for when you might need to work on these sites, but the system of working branches has not 
been set up yet

From our READ.Me file: 

"All development branches will branch off development/main as well, and should be named development for consistency and clarity." 

The initial push of TICUS into the repo is on development/main.

For previous projects, we have created a shared development branch from development/main, like "development/story/{name of site}."

-From development/main, create "development/story/ticus"

-Then, from "development/story/ticus", developers can create working branches. From the documentation: 

"When you're creating a branch for a new feature, bug fix, or task, you should name it based on the DevOps story you're working on."

-So, for an update on Ticus, we would create a branch called  "ticus/task/{dev ops ticket number}" from "development/story/ticus".

When the work is ready for review, create a pull request to merge your working branch into "development/story/ticus"

------

-Download copy of site from WP Engine

-------

- Should the subsites all be on a common theme for bulk updates that can be done via CI/CD pipeline?
- Or should all the functionality be bundled in a plugin?
- If so, in either case, how/where do we handle any unique aspects of the theme/site?
- The plugin + parent/child theme setup ended up being a mess at Prox. 