 === WP CleanFix ===
Contributors: Giovambattista Fazioli
Donate link: http://labs.saidmade.com
Tags: Manage, Clean, Repair, Optimize, Fix
Requires at least: 2.9.1
Tested up to: 2.9.2
Stable tag: 1.3.4

WP CleanFix, all in one tool for check, repair, fix and optimize your Wordpress blog.

== Description ==

WP CleanFix is a management tool for for check, repair, fix and optimize your Wordpress blog.

**FEATURES**

* Database Tables optimization
* Check/Remove for unused UserMeta
* Check/Remove for Post Revision and Trash
* Check/Remove for unused Post Meta
* Check/Remove for unused Tags
* Check/Remove/Relink for Posts without Authors
* Check/Remove/Relink for Pages without Authors
* Check/Remove for Attachments without Post/Page
* Check/Remove for unused Categories
* Check/Remove for unlink Categories (terms)
* Check/Remove for unlink Categories Taxonomy
* Check/Remove for unapproved and Trash comments
* Check/Remove for spam comments
* Find & Replace on Posts Content
* Find & Replace on Comments Content
* Wordpress MU compatibility
* English/Italian Localizzation

**LAST IMPROVE**

* Check/Remove Comments in Trash

See [ChangeLog](http://wordpress.org/extend/plugins/wp-cleanfix/changelog/ "ChangeLog") for full history version

**HOW TO**

Check Dashboard

= Related Links =

* [Labs Saidmade](http://labs.saidmade.com/ "Labs Saidmade")
* [Undolog](http://www.undolog.com/ "Author's Web")

For more information on the roadmap for future improvements please e-mail: g.fazioli@saidmade.com

== Screenshots ==

1. Dashboard Summary Report
2. Options

== Changelog ==

= 1.3.4 =
* Fix bugs on comments

= 1.3.3 =
* Add Dashboard Widget for Administrator only

= 1.3.2 =
* Fix bugs on Find & Replace (Post and comments)

= 1.3.1 =
* Fix remove private category with ID 1

= 1.3.0 =
* Add Check/Remove Comments in Trash
* Fix decimal point in Optimize Table list

= 1.2.5 =
* Fix load new class module in Ajax gateway

= 1.2.4 =
* Introducing module class/rev some class
* Fix "nowrap" in UI
* Fix string length in comment/span preview
* Fix undefined function in Wordpress 2.9 previous version

= 1.2.0 =
* Add Show Post/Page title in Combo Menu for Post Revision/Trash
* Fix localization files

= 1.1.1 =
* Fix Administrator permission warning

= 1.1.0 =
* Check/Remove for Post Trash

= 1.0.0 =
* Exit from beta
* Add Dashboard Widget Report Summary
* Add Remove/Relink to Posts without Author
* Add Remove/Relink to Pages without Author
* Add Remove Attachments without Post/Page
* Add "Refresh All" on single panel UI
* Improve styles and script loading
* Rewrite all modules in Class Object
* Improve User Interface
* Improve Ajax
* Rewrite label, message and localizzation
* Fix minor bugs

= 0.5.31 =
* Fix Ajax Loader on Database Optimize
* Change Plugin Blog address

= 0.5.2 =
* Fix Find & Replace on quote and slash

= 0.5.0 =
* Add Find & Replace on Comments Content
* Fix minor bugs

= 0.4.5 =
* Add Find & Replace on Posts Content

= 0.4.2 =
* Add Secure Layer on Ajax Gateway
* Fix Minor refuse on code and documentation

= 0.4.0 =
* Add Check for Pages without Authors
* Add Check for Attachments without Post/Page
* Fix comment code and minor bug fix
* Rev code

= 0.3.6 =
* Fix Ajax gateway Locallizzation

= 0.3.5 =
* Add UserMeta Unlink Remove
* Auto Check Database Optimizzation after any action
* Fix spam comment localizzation refuse

= 0.3.0 =
* Set standard localization in English
* Add Check for unused UserMeta
* Add Check/Remove for unlink Categories (terms)
* Add Check/Remove for unlink Categories Taxonomy
* Fix minor bugs
* Add some catch error
* Improve code and style

= 0.2.0 =
* Add Check on Categories
* Fix localizzation file
* Fix some localizzation wrong missing setting
* Fix minor bugs
* Improve SPAM comment preview


= 0.1.5 =
* Fix bugs on Meta Tag checking
* Fix bugs on jQuery click event
* Improve Ajax gateway
* Improve Javascript function

= 0.1.1 =
* Add localizzazion (English + generic POT file)

= 0.1.0 =
* First beta/preview release


== Upgrade Notice ==

= 1.3.2 =
Fix bugs. Upgrade immediately

= 1.3.0 =
Major "stable" release. Upgrade immediately

= 1.0.0 =
Major "stable" release. Upgrade immediately

= 0.1.0 =
Please download and support :)


== Installation ==

1. Upload the entire content of plugin archive to your `/wp-content/plugins/` directory,
   so that everything will remain in a `/wp-content/plugins/wp-cleanfix/` folder
2. Activate the plugin through the 'Plugins' menu in WordPress (deactivate and reactivate if you're upgrading).
3. Done. Enjoy. See Wordpress Dashboard


== Thanks ==

* [Lazy79](http://wordpress.org/support/profile/231784 "Lazy79") for beta testing

== Frequently Asked Questions ==

= Is this Plugin Dangerous? =

Could be. Be sure to backup all data from Wordpress database before execute any functions.

= Can I translate Plugin interface? =

Yes, just edit .POT file in `localizzation` folder