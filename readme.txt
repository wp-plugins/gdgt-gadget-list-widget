=== gdgt gadget list widget ===
Contributors: Mark Rebec
Tags: gdgt, widget, widgets, sidebar, gadget, gadgets, list
Tested up to: 3.0
Stable tag: 1.0.3

Show off your gadgets! This widget displays your gdgt Have, Want, and Had lists. For more, visit http://gdgt.com/widgets/

== Installation ==

Obviously, you'll want to start by installing and activating the widget!

= Sidebar =
1. Drag the widget into your sidebar.
1. Enter your gdgt username (if you don't have one, sign up here: http://gdgt.com/register/ ).
1. Specify the size of your widget.
1. That's it!

= Template =
If you'd like to add the widget directly to your template, call the widget using the `<?php gdgt_gadget_list_widget('USERNAME', array('OPTION'=>VALUE)); ?>` template tag. The username is required, while options are an optional array allowing you to control the following:

* width (number of pixels, default 300, minimum 180, maximum 500)
* height (number of pixels, default 265, minimum 200, maximum 500)
* showcount (toggles display of list counts, true or false, default true)

Example: `<?php gdgt_gadget_list_widget('ryan', array('width'=>300, 'height'=>350, 'showcount'=>true)); ?>`

== Frequently Asked Questions ==

= Is there a minimum and maximum size for the widget? =

Yes. The widget can scale between 180-500 pixels wide, and 200-500 pixels tall.

= The list count is set to yes, why isn't it showing? =

If you've set the width to lower than 200 pixels, the widget's list count is disabled.