# Joomla Injector

A simple, multi-purpose set of plugins to easily inject Joomla articles and K2 content items into virtually any place in the Joomla CMS. Beyond the flexibility provided by the core functionality, template overrides are fully supported allowing you to customize how each item is rendered.

 ## Usage
 The core usage is based on the presence of content extension specific shortcodes following the syntax of:

 `{[component]Item [item number]}`

 For example, to insert a Joomla article that has an ID of 7, use `{contentItem 7}` as the core Joomla content component is named `com_content`.