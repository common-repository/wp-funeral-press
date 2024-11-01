=== Plugin Name ===
Contributors: smartypants
Donate link: http://wpfuneralpress.com
Tags: Funeral Home Obituaries, Online Website GuestBook, Cemetery Industry Internet Rememberance Software
Requires at least: 2.0.2
Tested up to: 3.8.1
Stable tag: 1.5.5

FuneralPress is an online website obituary management and guest book program for funeral homes and cemeteries.

== Description ==

FuneralPress is an online website obituary management and guest book program for funeral homes and cemeteries, FuneralPress allows funeral and cemetery owners to display online obituaries and guestbooks on their website and allow loved ones to register on their site and post moderated guestbook comments. This plugin has many features and settings you can modify to make this plugin work for your website. We also offer a premium version with ehanced features which can be found on our website.

Now works with WordPress Multi Site!

**[Click here to try out a demo](http://free.wpfuneralpress.com/ "Click here to try out a demo")**
**[View Our website](http://wpfuneralpress.com/ "View Our website")**
Login with:  user: test   password: test

**Obituary - Guestbook Features**

* Manage Online Obituaries - The administrator can view, modify, and delete any obituaries that have been created under their Funeral Press account.
* Guestbook user's receive confirmation emails on posting and approval.
* Facebook Integration - Clients can incorporate a Facebook link from WP Funeral Press to share obituary details, funeral information, or Guest Book comments.
* Guestbook Comments - Family and friends of loved ones may post comments and remembrances beneath the obituary in the Guest Book.
* User login and registration
* Ability to translate plugin to multiple languages using the .po files.
* Allow users to either register for an account(this will have many helpful features in the future such as my account page, save obits etc)
* Disable or enable registration
* Built in support for recaptcha so the guest comment box does not get spammed

**Video Demo**

[youtube http://www.youtube.com/watch?v=1Zf2LIGr5iY]

**Premium Features**


* Obituary QR Code - QR bar code will be automatically generated and printed out for display at funeral home wake. Loved Ones can scan the code with any Smart Phone to view further obituary details on late loved one.
* Location Maps - Provides a quick view of the funeral home, cemetery, and church location via Google maps.
* Guestbook Photos - Family and friends of late loved ones can add photos alongside the Guest Book comments.
* Guestbook Videos - Family and friends of late loved ones can add YouTube video links alongside the Guest Book comments.
* Guestbook Approval - Guest Book Approval ensures that the remembrances of loved ones maintain within a respectable environment for grieving families, friends, and future potential clients. Comments, photos, and videos 
* Import Churches (USA Only) - View the latest list of U.S. churches to import and apply within the administrator's specific area. Within the list, the administrator can search through the churches by geographic location, city, state, or religion.
* Import Funeral Homes (USA Only) - View the latest list of U.S. funeral homes to import and apply within the administrator's specific area.
* Import Cemeteries (USA Only) - View the latest list of U.S. cemeteries to import and apply within the administrator's specific area.
* Manage/Assign Sections - Administrator will remain in control of the assignment and management of funeral home locations, remembrances, and the Guest Book.
* Manage location - Management of this list, and the particular location to be highlighted, is also available.
* Support - WP Funeral Home Press will always be available for support and further software questions Monday thru Thursday 10am - 4pm EST - Non-USA Holidays. This feature is accessible with all versions of the plug-in.

**[Click here to try out a demo](http://demo.wpfuneralpress.com/ "Click here to try out a demo")**
**[Check out the premium features](http://wpfuneralpress.com/pricing/ "Check out the premium features")**

**Video Demo**

[youtube http://www.youtube.com/watch?v=JC1mYgOtXqw]

**Current Languages**

* English

== Installation ==

* Install from the wordpress plugin manager or upload the directory to your plugins folder
* Activate
* Navigate to FuneralPress and fill in the required settings

= Shortcode =
The main shortcode for the obit page is [funeralpress]. You need to add this shortcode to one page to make the obits work. Make sure it is only listed on one page, multiple pages will cause errors. Also make sure that the shortcode is not on your home page, it should be installed on its own specific page. If you need the latest obits on your home page you can use the shortcode listed below [fp_latest_obits]

There is a shortcode available to use to display latest obits and this can be used on as many pages as you want

Shortcode: [fp_latest_obits style="x" howmany="x" search="x"]

** Configuration for shortcode **

* style: Choose one of the following (list,thumbnails,block)
* howmany: type how many obits you want to display (defaults to your paging setting in admin if not set)
* search:  change to "1" if you want to display the search box.
* Example: [fp_latest_obits style="thumbnails" howmany="5" search="1"]

= Widget =

* To use the widget drag the "Funeral Press Obits" widget into your sidebar, set the settings for the widget to display obits.

= Custom CSS =

* If you want to change the css of the plugin its recommended that you create a css file by the name of obit.css in your template directory. This ensures that any css changes will not get overwritten in future. This is explained more if you go to settings->Custom CSS

== Frequently Asked Questions ==

= I'm using the premium version but not seeing the funeralpress tab in wordpress =

Premium users must have free + premium version installed. The premium extends the free version. Once you install the free version you will see the tab, from there put in your serial code.
== Changelog ==

= 1.0.0 =
* Created first version

= 1.0.1 =
*Added widget, shortcode and custom css.
*Fixed install bug

= 1.0.2 =
* Fixed issue with post excerpts displaying html and wordpress auto format issues
* Fixed the problem with redirections when not using permalinks.
* Requires theme my login

= 1.0.3 =
* Added a po translation file so you can translate to your own language
* Fixed a few layout problems
* Added a new search widget to search obits, ability to change title, add text before the form and the ability to turn off and on first name, last name and burial date.
* Translated 100+ terms
* Made CSS Updates, Noted in style.css under 1.0.3
* Added an error if search does not find any obits.

= 1.0.9 = 

* There a now guest mode, registration is no longer a requirement.  You can turn guests on or off with a setting in admin
* Enable or disable registration, if you want people to log into your installation then you will need to enable registration. (this enables registration for the whole wordpress install)
* reCaptcha integration for guest userse so you dont wind up with allot of spam
* These are some major updates please report back with any issues
* Better validation for the posts form

== Screenshots ==

1. Obit edit view in admin panel
2. Example obit page
3. Example guestbook page
4. Guestbook edit page for admin
5. Import funeral homes and churches for premium users
6. Google map integration for premium users

== Upgrade Notice ==

= 1.0.1 =
*Added widget, shortcode and custom css.
*Fixed install bug

= 1.0.2 =
* Fixed issue with post excerpts displaying html and wordpress auto format issues
* Fixed the problem with redirections when not using permalinks.
* Requires theme my login

= 1.0.3 =
* Added a po translation file so you can translate to your own language
* Fixed a few layout problems
* Added a new search widget to search obits, ability to change title, add text before the form and the ability to turn off and on first name, last name and burial date.
* Translated 100+ terms
* Made CSS Updates, Noted in style.css under 1.0.3
* Added an error if search does not find any obits.

= 1.0.4 =
* Added the ability to turn off the guestbook

= 1.0.5 =

* You can now turn off facebook sharing
* Fixed dates not showing properly

= 1.0.7 = 

* Disabled requirement for theme my login
* Removed birth and death dates when not entered
* Fixed a guestbook redirection error
* Changed the way the login works
* Fixed sanitization bugs

= 1.0.9 = 

* There a now guest mode, registration is no longer a requirement.  You can turn guests on or off with a setting in admin
* Enable or disable registration, if you want people to log into your installation then you will need to enable registration. (this enables registration for the whole wordpress install)
* reCaptcha integration for guest userse so you dont wind up with allot of spam
* These are some major updates please report back with any issues
* Better validation for the posts form

= 1.1.0 =

* Fixed a slow loading css bug
* Fixed a bug that was not allow premium members to save phone numbers for funeral homes (must update premium for this fix)
* Fixed css conflicts

= 1.1.2 = 

* You can now add the shortcode on the home page, there was a variable problem that was not allowing you before. note to self: wordpress reserved variables.

= 1.1.3 =

* Released an addon that allows integration with gravityforms for obit submissions by users, this required a free version update for hooks.

= 1.1.4 = 

* Fixed an issue with the captcha code, it was checking for captcha if enabled even if you are logged in. Removed that and it is working again.

= 1.1.6 =

= 1.1.6 =

* You can now change the name of churches and funeral homes in the settings page
* Created filters for the topmenu 
* Fixed the email URL 
* Restuctured some of the menus for new filters and hooks
* If you are using premium please update both premium and free versions to avoid any errors.

= 1.2.0 = 

* Fixed formatting on the obit page

== Changelog ==

= 1.0.1 =
*Added widget, shortcode and custom css.
*Fixed install bug

= 1.0.2 =
* Fixed issue with post excerpts displaying html and wordpress auto format issues
* Fixed the problem with redirections when not using permalinks.
* Requires theme my login

= 1.0.3 =
* Added a po translation file so you can translate to your own language
* Fixed a few layout problems
* Added a new search widget to search obits, ability to change title, add text before the form and the ability to turn off and on first name, last name and burial date.
* Translated 100+ terms
* Made CSS Updates, Noted in style.css under 1.0.3
* Added an error if search does not find any obits.

= 1.0.4 =
* Added the ability to turn off the guestbook

= 1.0.5 =

* You can now turn off facebook sharing
* Fixed dates not showing properly

= 1.0.7 = 

* Disabled requirement for theme my login
* Removed birth and death dates when not entered
* Fixed a guestbook redirection error
* Changed the way the login works
* Fixed sanitization bugs

= 1.0.9 = 

* There a now guest mode, registration is no longer a requirement.  You can turn guests on or off with a setting in admin
* Enable or disable registration, if you want people to log into your installation then you will need to enable registration. (this enables registration for the whole wordpress install)
* reCaptcha integration for guest userse so you dont wind up with allot of spam
* These are some major updates please report back with any issues
* Better validation for the posts form

= 1.1.0 =

* Fixed a slow loading css bug
* Fixed a bug that was not allow premium members to save phone numbers for funeral homes (must update premium for this fix)
* Fixed css conflicts

= 1.1.2 = 

* You can now add the shortcode on the home page, there was a variable problem that was not allowing you before. note to self: wordpress reserved variables.

= 1.1.3 =

* Released an addon that allows integration with gravityforms for obit submissions by users, this required a free version update for hooks.

= 1.1.4 = 

* Fixed an issue with the captcha code, it was checking for captcha if enabled even if you are logged in. Removed that and it is working again.

= 1.1.6 =

* You can now change the name of churches and funeral homes in the settings page
* Created filters for the topmenu 
* Fixed the email URL 
* Restuctured some of the menus for new filters and hooks
* If you are using premium please update both premium and free versions to avoid any errors.

= 1.1.7 =

* Fixed XSS Issues brough up by wordpress

= 1.1.8 =

* fixed URL bug when not using permalinks

= 1.1.9 =

* Added ability to change thumbnail size for all images
* fixd a small html bug in block list view mode
* Added option to disable share facebook
* Added option to disable breadcrumbs

= 1.2.0 = 

* Fixed formatting on the obit page

= 1.2.1 =

* Fixed custom css link reference

= 1.2.2 =

* Fixed issues with premium that were slowing down the script
* Added a bunch of new hooks and actions to make wp funeralpress look the way you want. http://wpfuneralpress.com/faqs/

= 1.2.3 =

* Fixed a small bug which redirected users to the obit page when clicking on a widget.

= 1.2.4 =

* Another small issue with linking while pagination is enabled

= 1.2.5 =

* Gave the ability to set a cemetery and funeral home for premium users.
* Ability to change the name of obits,guestbook,cemetery,church and funeral homes.

= 1.2.7 =

* New facebook share which allows you to share photo and obit with the name instead of just the url
* Print button added for obits
* Ability to turn print on and off
* Bug fixes

= 1.2.8 =

* Update to fix a print obit bug

= 1.2.9 =

* Disabled auto popup on google map frame
* Removed names from the guestbook posting
* Fixed minor bugs

= 1.3.1 =

* Fixed minor bugs
* Fixed issue with thumbs
* Fixed spam issue when guestbook is turned off

= 1.3.2 =

* Added new hook  wpfh_insert_obit,$insert_id - fires when inserting new obit
* Added new hook wpfh_update_obit,$insert_id - fires when updating new obit
* Added created date for obit when inserting 
* Fixed a few bugs
* Added premium: Ability to post linkns
* Added premium: more hooks.

= 1.3.3 = 

* Added back the add funeral home and add church to top nav
* updated jqueryui to latest version fixing the missing x button
* updated compatibility with 3.6

= 1.3.5 =

* Fixed custom css files, was not working  correctly linking to the wrong css file.
* Added  "Edit Obituaries" in Admin Bar
* Added "Edit This Obituary" to Admin Bar if on an obit page and have permissions to edit obits
* Added  "X Pending Guestbook Posts" to Admin Bar if any posts are pending and user has the permission to approve posts
* Added 3 new capabilities wpfh_manage_obits, wpfh_manage_settings, wpfh_manage_settings to be used for future development permissions model.

= 1.3.6 =

* Changed date from modified date to created date.
* Added optional post count to guestbook tab
* Small bugfix on postings page

= 1.3.7 =

* Fixed a bug in search pagination

= 1.3.8 =

* Changed the created date to a timestamp for more accurate organization
* Changed the date format to use the format you specify in the settings area of wordpress, now any date format is possibile with built in localization

= 1.3.9 =

* Fix to the editor

= 1.4.1 =

* Using the  updated widget API
* You can now drag multiple widgets into sidebars

= 1.4.2 =

* Broken div fix

= 1.4.3 =

* Fixed a quote link on view more
* Added support for 3.8

= 1.4.5 =

* Fixed the facebook sharer button by adding the new meta og tags

= 1.4.7 =

* Fix to the url structure in premium

= 1.5.4 = 

* Moved recaptcha inclusion to load after themes and plugins have been loaded just in case there are other plugins that dont check.

= 1.5.5 =

* Fixed cemeteries and funeral home maps
* Changed menu icon
* Add subnavs to wordpress admin nav