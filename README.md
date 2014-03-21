# Injector

A simple, multi-purpose set of plugins to easily inject Joomla articles and K2 content items into virtually any place in the Joomla CMS. Beyond the flexibility provided by the core functionality, template overrides are fully supported allowing you to customize how each item is rendered.

## Usage

The core usage is based on the presence of content extension specific shortcodes following the syntax of:

 `{[component]-item [item number] [optional: template]}`

 For example, to insert a Joomla article that has an ID of 7, use `{content-item 7}` as the core Joomla content component is named `com_content`. Inserting a K2 item is as simple as inserting `{k2-item 42}`.

## Template Support

Every supported component will have a unique base template included with this solution and additionally supports template overrides.

The path that Injector looks for is `/templates/[current template]/html/plg_injector/[component]/[template]/default.php`

* `[current template]` the name of the site template assigned to the page currently being viewed.
* `[component]` the name of the component item type being injected into the page.
* `[template]` the name of your custom template.

For example, when using the shortcode of `{k2-item 42 foo}` Injector will load the template located at `/templates/[current template]/html/plg_injector/k2/foo/default.php`

### Creating a template

Use the provided base templates located at `/plugins/system/injector/tmpl`

## Requirements
* Joomla 3.2 or later
* K2 v2.6.8 or later
