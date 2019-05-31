=== WP-FormAssembly ===
Contributors: FormAssembly / Drew Buschhorn
Tags: forms
Requires at least: 4.0.0
Tested up to: 4.9.7
Stable tag: 2.0.4

Quickly embed FormAssembly web forms with the FormAssembly WordPress Plugin! Create contact forms, applications, payment forms, & surveys.

== Description ==

Quickly embed FormAssembly web forms into your website with the FormAssembly WordPress Plugin! Create contact forms, applications, payment forms and surveys.

Build powerful forms that integrate with Salesforce, PayPal, Google Apps and more.

Sign up for a free trial on FormAssembly.com to start building your form, then use the plugin and shortcode to embed onto your WordPress site.

Shortcodes

Replace 123456 with your form ID. Learn more: https://help.formassembly.com/knowledgebase/articles/340363-wordpress

Example shortcode for Basic, Professional, & Premier Plans:
[formassembly formid=123456] 

Shortcode for Enterprise: 
[formassembly formid=123456 server="https://your.server.tld"]

To use this plugin, you will need a FormAssembly account.

= Example Shortcodes =

FormAssembly Professional, Premier, & Basic Plans - (tfaforms.com):
[formassembly formid=123456]


FormAssembly Enterprise Cloud Edition - (Most commonly: organization.tfaforms.net):
[formassembly formid=123456 server="https://your.server.tld"]

Publish with an iframe - (Inline Frame):

If you'd rather display the form in an inline frame, or if your server doesn't support the default publishing method, add the iframe attribute to your tag.

For instance, a benefit to using an iframe would be to avoid conflicting CSS rules between the parent site and the embedded form.
[formassembly formid=123456 iframe=1]

OR

[formassembly formid=123456 server="https://your.server.tld" iframe=1]

Publish a Workflow:

[formassembly workflowid=1234]

Add Style:

It is possible to add CSS to your shortcode to control the size of the form/iframe in the page. For example, you can define the width:
[formassembly formid=123456 iframe=1 style="width: 300px !important;"]

https://help.formassembly.com/knowledgebase/articles/340363-wordpress

== Installation ==

1. Upload wp_formassembly.zip to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place [formassembly formid=NNNN] shortcode in your post.

== Changelog ==

= 2.0.4 =
*   Update formatting and tested compatibility version.
= 2.0.3 =
*   Update contributor name.
= 2.0.2 =
*   Defaults to https, not http.
= 2.0.1 =
*   Updated plugin description with single bracket shortcode example.
= 2.0 =
*   Updated release for WordPress shortcodes.
*   Uses single bracket, but try to keep backwards compatibility with double bracket notation for now.
= 1.0 =
*   Initial release.
*   Uses double bracket notation.