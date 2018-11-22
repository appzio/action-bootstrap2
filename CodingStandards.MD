## General Coding Practices

1. Parameters and logic set at the beginning of the function.
2. At most 3 tabs of indentation.
3. Keep line widths to a sensible maximum.

## Components

1. If you need more than two parameters for a component function better use a params array and document it.
2. Every component should be described as a set of functions
3. Every function should be no longer than a 100 lines, better to be less. 
4. Component functions should be as pure as possible - take an input and return an object (with few exceptions).
5. Name of the trait should be the same as the name of the function - remove “get” prefix
6. Take away view logic as components if there is a chance for them to be reused or to abstract complex view logic

## Styles

1. Inline styles only for development when they need to be dynamic (rely on screen width for example)
2. Unique identifiers for the styles or prefixes
3. Put any component styles into it’s own style file where the name of the file is the same as the name of the component

## Most common problems

1. Not using isset is the most common reason for errors.
2. Make sure that none of the objects are sent null values. 
3. Namespaces
