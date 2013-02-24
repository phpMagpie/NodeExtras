# NodeExtras v0.1 #

Croogo plugin which adds some handy features to core Nodes, such as:

- Makes full use of Tree behaviour for pages
    - Adds new index for viewing pages using Tree ordering
    - Adds moveup/down actions
- Navigation
    - Breadcrumbs
    - Submenus
    - Childmenus
    - Archives: by month with count
- Images/Thumbs
    - Link a Croogo attachment to a node
    - Use SLIR (needs installing in webroot) to generate resized/cropped thumbs

## Install ##
1. Clone plugin to /*app*/Plugin/NodeNavigation folder
2. Login to Croogo admin
3. Goto Extensions > Plugins
4. Activate NodeNavigation plugin

## What the plugin does ##
1. A new admin link is added under Content > List > Pages (by tree order)
2. When following the link above you'll see an index that looks similar to Menu > Links
3. NodeNavigationComponent and NodeNavigationHelper are attached to NodesController
4. NodeNavigationComponent::beforeRender() sets a nodeNavigation array containing __path__, __children__ and __submenu__ arrays
5. NodeNavigationHelper::breadcrumbs($nodeNavigation['path']) uses CakePHP's HTML::getCrumbs to output basic breadcrumbs (I placed this in /MyTheme/Elements/Nodes/view_page.ctp).
6. NodeNavigationHelper::submenu($nodeNavigation['submenu']) outputs a UL with links to the 
7. NodeNavigationHelper::childmenu($nodeNavigation['children']) __not yet coded__

## Home page as Root ##
I always include the Home page as my root, making all sections of a site a child of Home.  For example:

1. Home
    1. About
        1. History
        1. Team
        1. History
    1. Services
        1. Hosting
        1. Design
        1. Development
    2. Portfolio
    3. Contact

This structure means you get full breadcrumbs from the nodes and it is currently used to work out when to show a submenu (only when viewing a third level page or deeper) and what links will be in the submenu.

## What should be improved ##
1. After editing/deleting a page, would be nice if it came back to the plugin index
2. Similarly, after processing pages, would be nice if it came back to the plugin index
3. Still loads to do with regards to HTML output and related options
4. Probably coded for my specific use-case at present, needs to be more flexible for use with any site
5. Childmenu helper not yet coded

## Disclaimer ##
This is my first ever plugin, and the first time I have released anything publicly so expect there to be things that could be improved.  Give me honest feedback and I will try and resolve any issues you may have.
