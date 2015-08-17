=== Plugin Name ===
Contributors: ReadyMadeWeb
Donate link:
Tags: importer, wordpress, typepad, movabletype, attachments, import, uploads, transfer
Requires at least: 3.0
Tested up to: 3.0
Stable tag: 0.6.10

Import posts, pages, comments, custom fields, categories, tags and more from a WordPress export file.

== Description ==

NOTE: This plugin has been superseded by the [TP2WP Importer](https://wordpress.org/plugins/tp2wp-importer/). 

For more information visit [TP2WP.com](http://tp2wp.com)

== Changelog ==

NOTE: This plugin has been superseded by the [TP2WP Importer](https://wordpress.org/plugins/tp2wp-importer/).

For more information visit [TP2WP.com](http://tp2wp.com)

= 0.6.10 =
* Fix fallback for when we can't rely on ReadyMadeWeb to provide global DNS resolution

= 0.6.9 =
* Update post GUIDs post import to reflect currently set domain name, not example.org
* Correct URL of plugin on wordpress.org
* Fix issues with escaped file names as attachments

= 0.6.8 =
* Fix issue with posts and tags being added multiple times (original importer bug)

= 0.6.7 =
* Snap bug fix for tag replacement issues introduced in 0.6.6

= 0.6.6 =
* Also rewrite attachment and post URLs in post excerpts (previously only did so in post content and metadata)

= 0.6.5 =
* Better handling for file names with url-unfriendly characters

= 0.6.4 =
* Usage of ssl when doing global host name resolution (when finding where to fetch and attachment from)
* Bug fix for issue when URLs wouldn't be rewritten for attachments without an extension

= 0.6.3 =
* Adds site IP address verification through third-party lookup to stop self-referencing server setups from preventing importation of files.

= 0.6.2 =
* Reads MIME type for files without proper file extensions.