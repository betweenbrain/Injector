# Injector

A simple, multi-purpose set of plugins to easily inject Joomla articles, modules, K2 and Zoo items into virtually any place in the Joomla CMS. Beyond the flexibility provided by the core functionality, template overrides are fully supported allowing you to customize how each item is rendered.

## Usage

The core usage is based on the presence of content extension specific shortcodes following the syntax of:

 `{[component]-item [item number] [optional: template]}`

 For example, to insert a Joomla article that has an ID of 7, use `{content-item 7}` as the core Joomla content component is named `com_content`. Inserting a K2 item is as simple as inserting `{k2-item 42}`.

## Template Support

Every supported component will have a unique base template included with this solution and additionally supports template overrides.

The path that Injector looks for is `/templates/[current template]/html/plg_injector/[component]/[template]/default.php`

*  `[current template]` the name of the site template assigned to the page currently being viewed.
*  `[component]` the name of the component item type being injected into the page.
*  `[template]` the name of your custom template.

For example, when using the shortcode of `{k2-item 42 foo}` Injector will load the template located at `/templates/[current template]/html/plg_injector/k2/foo/default.php`

### Creating a template

Use the provided base templates located at `/plugins/system/injector/tmpl`

## Modules
In the case of injecting a module, the optional template parameter is used for style of module chrome to apply to the module being rendered.

## Available Item Properties
Each item type has a unique set of properties, as defined by its corresponding component. Below is un-exhaustive list of properties available, by item type, when using Injector.

Most properties are available via the `$item` object (e.g. `$item->title`).

Some properties are JSON encoded, as noted below, and require you to use `json_decode` to access their nested properties.

### Joomla core content
*  id
* asset_id
* title
* alias
* introtext
* fulltext
* state
* catid
* created
* created_by
* created_by_alias
* modified
* modified_by
* checked_out
* checked_out_time
* publish_up
* publish_down
* images [JSON]
* urls [JSON]
* attribs [JSON]
* version
* ordering
* metakey
* metadesc
* access
* hits
* metadata [JSON]
* featured
* language
* xreference
* category_title
* category_alias
* category_access
* author
* parent_title
* parent_id
* parent_route
* parent_alias
* rating
* rating_count
* params [JSON]

### K2 Item
* id
* title
* alias
* catid
* published
* introtext
* fulltext
* video
* gallery
* extra_fields
* extra_fields_search
* created
* created_by
* created_by_alias
* checked_out
* checked_out_time
* modified
* modified_by
* publish_up
* publish_down
* trash
* access
* ordering
* featured
* featured_ordering
* image_caption
* image_credits
* video_caption
* video_credits
* hits
* params [JSON]
* metadesc
* metadata
* metakey
* plugins
* language
* extraFields

### ZOO Item
* id
* application_id
* type
* name
* alias
* created
* modified
* modified_by
* publish_up
* publish_down
* priority
* hits
* state
* searchable
* access
* created_by
* created_by_alias
* params
* elements
* app

## Requirements
* Joomla 3.2 or later
* K2 v2.6.8 or later
* ZOO v3.1.6 or later
