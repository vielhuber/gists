- flexbox: one dimension, grid: two dimensions
- grid is container-based (you beforehand define the dimensions), flexbox is content-based (the content defines the dimensions)
- grid always applies to one container element and to direct childs; if you go deeper, the grid is useless
 -"grid system: you do not need a grid framework; your browser is the framework!"
- browser support: available, but ie11 only supports the basics (autoprefixer need to be configured to target ie11)
- nomenclature: container, item, line, rows, columns, cells, gaps, area
- new unit: 1fr. must not be used, but can be (instead of 33.33 33.33% 33.33% simply use 1fr 1fr 1fr)
- explicit vs implicit style: I prefer to be explicit and define every cell, even for default values
- units can be mixed (fr, px, em, ...)
- repeat-function: Helper function to shorten 1fr 1fr 1fr to repeat(3, 1fr)
- media queries: normally usable, simply change grid-template at another breakpoint
- minmax-function: constraint approach, saves some media queries but is more advanced to write
- areas: special "ascii drawing syntax". give names to parts of the layout. apply those names inside your css classes
- free cells can also be defined in the areas syntax
- overlapping cells is also not a problem
- css grids have limits: always then, when you cannot "think in grids"
- with grid-auto-rows you can: same height all rows, flexbox: only same height one row possible