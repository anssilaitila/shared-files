=== WordPress File Sharing Plugin and Download Manager – Shared Files ===
Contributors: anssilaitila, freemius
Tags: google drive, sharing, downloads, file manager, dropbox
Requires at least: 4.0.0
Tested up to: 5.5
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Share files like on Dropbox or Google Drive! Track file downloads, receive email notifications and more!

== Description ==
= The Best WordPress file sharing plugin on the market =
The Shared Files plugin allows you to list and manage downloadable files on your site easily. Just add the files in the admin area and insert the shortcode to the page you wish to list the files.

Very easy to use and no complex settings to mind on, but also very scalable for a large group of files. Many options for different layouts.

**14 days free trial available for Pro version, no credit card required.**

See live demos at [sharedfilespro.com](https://www.sharedfilespro.com/shared-files/).

= Some use cases for this plugin: =
* List any number of files and keep statistics on downloads
* Share downloadable files like using Dropbox or Google Drive
* Add a single file to any article/post using a simple shortcode
* Receive a notification when a file is downloaded
* Sort files and documents to multiple categories

= Features in Free version: =
* Files separated from the media library
* High quality SVG icons for 25 different file types
* Custom images/icons for many file types
* Add tags to files

= Additional features in Pro version: =
* Multiple different shortcodes/views for various use cases
* Sort files into categories
* Fast search targeting file names and descriptions
* File load counter
* Bandwidth usage estimate
* Alternatively, define an external URL for file and track those loads
* Optionally receive an email notification when a file is downloaded
* Password protected files
* Set expiration date to a file
* Limit number of downloads per file
* Front-end file uploader, logged-in users can also delete their uploaded files
* Multi-file upload to a specific category
* More features on the way based on user feedback

Contact the author [here](https://www.sharedfilespro.com/support/).

Thanks to Luciano Del Fico for translating the Italian version.

== Installation ==

1. Activate the plugin from WordPress plugin directory or manually upload it to your site
2. See the Help / Support page for further instructions

== Screenshots ==

1. List of files on your site
2. Files listed in 3 columns (more layout options available)
3. Search from all files
4. Display only 1 specific file on page, using shortcode in post content
5. Opening a password protected file
6. Opening a file that's download limit has been reached
7. File management in admin area
8. Edit a single file

== Changelog ==

= 1.6.21 =
* Fixed [shared-files] -> [shared_files] on Help / Support -page

= 1.6.20 =
* (Free and Pro) New option: "Show download button on card"
* (Pro) New option: "Align elements vertically and centered (inside card)" (this is useful when using the 3 or 4 cards layout and space is limited)
* (Pro) New parameter for shortcode [shared_files]: [shared_files limit=5] (limit the number of files and hide pagination)
* (Pro) New parameter for shortcode [shared_files]: [shared_files file_upload=1 category=CATEGORY_SLUG] (pre-define the category and hide category dropdown)

= 1.6.19 =
* Free and Pro: Completely new icon set, high quality SVG icons for 25 different file types. You can still use the old ones if you wish, the set can be changed from the settings.

= 1.6.18 =
* New shortcode (Free and Pro): [shared_files_simple] (See https://www.sharedfilespro.com/shared-files/simple-list/)
* New feature (Free and Pro): Tags. You can now add tag(s) to a file. (See https://www.sharedfilespro.com/shared-files/)
* New feature (Free and Pro): Preview various file types. You can hide the button from the settings. (See https://www.sharedfilespro.com/shared-files/)
* Copy to clipboard -buttons added to Help / Support -page, file management and category management
* Category name(s) added to file card
* New option (Pro): Hide category name(s) from card

= 1.6.17 =
* New option (Pro): Only logged in users can add files using the front-end uploader
* New option (Free and Pro): Use textarea for file description (instead of rich text editor)
* Freemius SDK updated to 2.4.1 (https://github.com/Freemius/wordpress-sdk/releases/tag/2.4.1)

= 1.6.16 =
* New feature (Pro): multi-file upload. You may now upload multiple files at once (there is a new button on the File Management page).
* New feature (Pro): if a file is added from the front-end by a logged-in user, that particular user can delete the very same files.
* New option: featured image can now be displayed on either left or right side of the file description.
* Bug fix: pagination is now active also when using shortcode [shared_files category=category-slug]

= 1.6.15 =
* CSS fixes

= 1.6.14 =
* Bug fix: autofill is now disabled for file's password and notification email
* New feature: custom number for pagination

= 1.6.13 =
* Bug fix: irrelevant alert dialog removed when saving a file
* Folder icons added to [shared_files_categories]
* CSS compatibility fixes

= 1.6.12 =
* Free: fixed a bug, which caused the browser to constantly ask "Leave site? Changes that you made may not be saved." when adding a new file

= 1.6.11 =
* New settings: order and order by. You can now define the order of the files in the file list. These can be defined from the settings or directly using shortcode parameters.
* Categories' description field can now be used to sort the categories in [shared_files_categories]-shortcode.

= 1.6.10 =
* Bug fix: hide empty dropdown when there are no subcategories present (for shortcode [shared_files])
* New parameter: hide_category_dropdown (for [shared_files])
* New parameter: not_sorted_by_categories (for [shared_files_search])
* New option: "Show featured image in addition to file type icon"

= 1.6.9 =
* New feature: custom file type icons. You can now set icons for all files with specific filename extensions (see the "Custom file types"-tab in settings).
* New feature: file-specific icons. You can now define a custom file type icon for a single file by adding a featured image.
* New settings: "Hide file size from card" and "Hide file type icon from card"

= 1.6.8 =
* Bug fixes

= 1.6.7 =
* Freemius SDK update
* Tested up to: WP 5.5

= 1.6.6 =
* New feature: front-end file uploader (see Help / Support page and live demo at https://www.sharedfilespro.com/shared-files/file-upload-1/)
* Missing translatable terms added

= 1.6.5 =
* Adding new file was broken in the last update, this is now fixed

= 1.6.4 =
* Settings made more usable

= 1.6.3 =
* Bug fix: there are now several different ways to detect a file type, which means no more crashes on certain server configurations when opening a file

= 1.6.2 =
* Custom color option for card background
* File list is now reloaded using ajax request when choosing category
* Bug fixes

= 1.6.1 =
* New feature: file has got a new date field, which is displayed instead of the publish date
* New option: hide file date / publish date from file list item
* Debug info -section added to Help / Support -page

= 1.6.0 =
* Custom icons can now be added for .ppt(x), .indd, .psd and .svg files.
* Bug fixed: file description can now be emptied
* Some issues regarding displaying correct file type icon fixed

= 1.5.10 =
* Category made sortable in the admin list

= 1.5.9 =
* More columns made sortable in the admin list
* Files can now be filtered by a category in the admin list
* Mail delivery is now handled locally by WordPress
* Bug fixes

= 1.5.8 =
* Search form is now visible when a category is defined for shortcode, and the dropdown contains only the subcategories of the defined category.
  You may hide the search using the hide_search=1 parameter with the shortcode. (Pro)
* Custom icon for YouTube-links (Free)

= 1.5.7 =
* New feature (Free and Pro): options to set custom images for file type icons (see settings)
* New feature (Pro): a new view to list categories / list files by category (see Help / Support -page)
* Column made sortable: Expiration date

= 1.5.6 =
* New feature (Pro): Password protected files
* New feature (Pro): Set expiration date to a file
* New feature (Pro): Limit number of downloads per file
* More options

= 1.5.5 =
* Bug fixes

= 1.5.4 =
* New feature (Pro): A new shortcode [shared_files_search] that displays only a search form, that targets all files from all categories

= 1.5.3 =
* Free and Pro: New settings for file list layout

= 1.5.2 =
* Minor improvements

= 1.5.1 =
* Bug fixes

= 1.5.0 =
* New licensing model / 2019-12-09

= 1.0.0 =
* Initial release / 2018-07-15
