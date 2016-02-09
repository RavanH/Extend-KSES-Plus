=== Extend KSES + ===
Contributors: tierrainnovation, ravanh
Tags: kses,tiny mce, 
Requires at least: 2.7
Tested up to: 4.4
Stable tag: 3.4

This plugin extends the HTML functionality of the kses.php file inside wp-includes by allowing additional html tags.

== Description ==

This is a modified version (under the MIT License) of a plugin originally developed by **[Tierra Innovation](http://www.tierra-innovation.com/)** for **[WNET.org](http://www.wnet.org/)**.

This plugin extends the HTML functionalify of the Wordpress kses.php file, which states the allowable HTML that the post/page content editor will accept.  It allows the site administrator to check pre-defined HTML tags that can also be allowed via the editor.  Tags include: `object`, `embed`, `param`, `iframe`, `map` and extensions have been added to the `div` and `img` tags.

Keep in mind, that by checking a tag, you are making it acceptable to post said HTML and save it.  If your users also post content, it is important that you make sure you are not enabling any malicious HTML from wreaking havoc to your environment.  If there is a tag that is missing or that you would like us to add and support, feel free to leave a comment in our **[support](http://tierra-innovation.com/wordpress-cms/plugins/extend-kses/#respond)** area for this plugin.

== Changelog ==

= 3.5 =

Added microdata support

= 3.4 =



= 2.3 = 

Added additional image map support

== Installation ==

1. Upload `extend-kses` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Check the boxes next to the HTML tag you wish to enable and click `save options`
1. Paste HTML code into the HTML version - NOT the visual version - of the post/page editor and save.

== Frequently Asked Questions ==

= What tags are currently supported? =

1. `div` tag extended to allow for the attributes `id`, `itemscope`, `itemtype` and `itemprop`.
1. `embed` tag is now fully supported, including the attributes `style`, `type`, `id`, `height`, `width`, `src` and `itemprop`.
1. `iframe` tag is now fully supported, including the attributes `width`, `height`, `frameborder`, `scrolling`, `marginheight`, `marginwidth`, `src`, `itemscope`, `itemtype` and `itemprop`.
1. `img` tag extended to allow for `usemap` and `itemprop` attributes.
1. `map` tag is now fully supported, including the attributes `name`, `id`, `itemscope`, `itemtype` and `itemprop`. 
1. `object` tag is now fully supported, including the attributes `style`, `height`, `width` and `itemprop` plus the `param` tag including including the attributes `name` and `value`.
1. `pre` tag now fully supports Google Syntax Highlighter, including the attributes `style`, 'name', 'class', 'lang', 'width'  and `itemprop`.
1. `script` tag now supported, including the attributes `type`, `async`, `charset`, `defer` and `src` plus the `noscript` tag.


Need more help?  **[Support](http://tierra-innovation.com/wordpress-cms/plugins/extend-kses/#respond)**
