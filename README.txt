=== WordPress Download Manager and File Sharing Plugin with frontend file upload – a better Media Library — Shared Files ===
Contributors: anssilaitila, freemius
Tags: download manager, file sharing, file upload, download monitor, file manager, document management, download, downloads, monitor, frontend file upload, onedrive, google drive, media library
Requires at least: 4.0.0
Tested up to: 5.7
Stable tag: 1.6.40
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A download manager plugin to share files like on Dropbox, Google Drive or OneDrive! Featuring frontend file upload, FTP upload, download counter, better media library, file explorer and more...

== Description ==
= The best WordPress file sharing plugin on the market =
This <strong>download manager</strong> allows you to list and manage downloadable files on your site easily. Just add the files using the file manager in the admin area and insert the shortcode to the page you wish to list the files. Front-end file upload allows users and visitor to upload their own files.

Very easy to use and no complex settings to mind on, but also very scalable for a large group of files. Many options for different layouts. Can be used as a substitute to media library to manage files and share files for visitors.

**7-day free trial available for Pro version, no credit card required.**

See live demos at [sharedfilespro.com](https://www.sharedfilespro.com/shared-files/).

= An easy to use download manager with file upload =
* Store files using this download manager plugin instead of media library
* Open images and YouTube-videos in a lightbox
* Allow users and/or visitors to upload files
* File manager allows administrators to upload files using FTP or single/multi-file uploader
* FTP upload and multi-file upload are features of the Pro version
* Alternative to WP media library
* Free version to use as a free file manager and download manager
* More advanced file manager in the Pro version
* Share folders and files

= Key Features in Shared Files Free: =
* <strong>Front-end file upload with support for tags, logged-in users can also delete their uploaded files</strong>
* Share a folder of downloadable files like using Dropbox, Google Drive or OneDrive
* Preview certain file types in the browser
* YouTube-videos and images are opened in a lightbox
* Open local video files using a video player in a lightbox (mp4, webm, ogg, mov)
* Files separated from the media library
* High quality SVG icons for 25 different file types
* Use as an internet download manager, file explorer and file manager
* Custom images/icons for many file types
* A free download manager
* Add tags to files

= Key Features in Shared Files Pro: =
* List any number of files and keep statistics on downloads
* Upload files using FTP and activate them for the plugin with a single click
* FTP file upload allows you to upload any number of files easily
* Activate files from Media Library
* Front-end file upload with support for categories
* Custom fields for the front-end file uploader
* Multiple different shortcodes/views for various use cases
* Receive a notification when a file is downloaded
* Collect also YouTube video URLs using the front end file uploader
* Sort files and documents to multiple categories
* Fast search targeting file names and descriptions
* Add a single file to any article/post using a simple shortcode
* Download counter
* Bandwidth usage estimate
* Alternatively, define an external URL for file and track those loads
* Optionally receive an email notification when a file is downloaded
* Password protected files
* Set expiration date to a file
* Limit number of downloads per file
* Multi-file upload to a specific category
* A full-featured download manager plugin
* More features on the way based on user feedback

Contact the author [here](https://www.sharedfilespro.com/support/).

Thanks to Luciano Del Fico for translating the Italian version.

== Installation ==

1. Activate the plugin from WordPress plugin directory or manually upload it to your site
2. See the Help / Support page for further instructions

== Frequently Asked Questions ==

= What happens to WordPress Media Library? =

Nothing. The Shared Files plugin works completely outside WP media library and they do not have any kind of connection.

= Can I use the plugin to share files? =

Yes! The plugin's is main idea is to share files on your site. You can list files on any of your site's article or page by adding the appropriate shortcode there.

= Do I have to pay for using the plugin? =

The Pro version of Shared Files has many features that might interest you, but you can use the Free version without restrictions as long as you want.

= Do you offer support? =

Of course! We offer support in the forums here on WordPress.org and if you have a paid subscription we offer priority email support.

= Does Shared Files Free or Shared Files Pro work with some other plugin? =

You may contact us directly [here](https://www.sharedfilespro.com/support/) if there's any kind of compatibility issue with some other plugin. We will then do our best to solve that issue.

= Is this a download manager, file sharing plugin, media library or what? =

You can use the Shared Files plugin for any purpose that suits your needs. The basic idea is to present a user friendly list of downloadable files. :)

= Can the visitors or logged in users upload files? =

File upload is possible for any visitor or logged in user in the Pro version.

= Can I use FTP to upload files? =

You can use FTP in the Pro version. There is a feature that allows you to FTP upload files and then activate them for the plugin with a single click.

= Can I use the plugin as a file manager? =

Yes, you can use it as a file manager. You don't necessarily have to add any publicly available list of files on your site, you can just use the admin tools to manage files.

== Screenshots ==

1. List of files on your site
2. Front-end file upload
3. Files listed in 2 columns (more layout options available)
4. File management in admin area
5. Edit a single file
6. Search from all files (Pro)
7. Display only 1 specific file on page, using shortcode in post content (Pro)
8. Opening a password protected file (Pro)
9. Opening a file that's download limit has been reached (Pro)
10. List files by category (Pro)

== Changelog ==

= 1.6.40 - 2021-03-27 =
* New parameter [shared_files hide_files_first=1]: Hide files first (files are shown when searched or category/tag is selected)
* New parameter [shared_files file_upload=1 tag_dropdown=1]: Show tag dropdown for the uploader
* New parameter [shared_files categories__and="category-1,category-2"]: Show files that belong to all of these categories
* New setting: "Show tag dropdown for front-end file uploader"
* New setting: "Bypass the preview service when previewing PDF files. The file is opened in the browser directly."
* Fix: password autofill is now disabled when adding a new file
* Fix: file urls (using the default method) now continue to work normally when the site is moved to a different location and paths are different on the server
* Fix: front end file uploader now works correctly when the WordPress is installed in a subdirectory

= 1.6.39 - 2021-03-21 =
* Bug fixes

= 1.6.38 - 2021-03-21 =
* File uploader user name is now displayed on the file card when logged in (if uploaded using the front end file upload)
* New setting for the frontend file upload: "Hide file uploader info"
* New setting for the frontend file upload: "Show category and tag checkboxes on multiple columns"
* New setting for the frontend file upload: "Enable featured image (a separate file can be added)"
* New feature for the frontend file upload: if a category checkbox is checked, all checkboxes of possible parent categories are also checked (and unchecked)
* Bug fixes

= 1.6.37 - 2021-03-14 =
* CSS fixes & minor improvements

= 1.6.36 - 2021-03-14 =
* (Free and Pro) New setting: "Always show preview button for PDF files (the preview service is Google)"
* (Free and Pro) More debug data added to debug info section
* (Pro) It is now possible for the uploader to select a parent category for the new category to be created
* (Pro) New setting for the front end file uploader: "Allow the uploader to define a password for the file"
* (Pro) New setting: "Enable the use of the preview service for password protected files"
* (Pro) New setting: "Show featured image for password protected files"
* (Pro) New setting: "Use a larger, non-cropped version of the featured image"
* (Pro) New settings: "Featured image container width (px)" and "Featured image container height (px)"

= 1.6.35 - 2021-03-13 =
* (Pro) 3 custom fields added to the front end uploader (see settings / file upload tab)
* (Pro) New settings for the frontend file uploader: "Restrict accepted file types" and "Restrict accepted file extensions"
* Bug fix: files available for media library sync are no more limited to image files
* Bug fix: redirect method now uses only the file path for opening files (no more issues if the domain or protocol is changed after adding the files)

= 1.6.34 - 2021-02-22 =
* (Pro) New setting: "Send and email notify when a file is uploaded" (using the frontend upload)
* (Pro) New setting: "Allow the uploader to create a new category". This allows the file uploader to create a new category and assign the file to it.
* (Pro) New parameter for file upload shortcode (allow the uploader to create a new category): [shared_files file_upload=1 new_category=1]
* Bug fixes

= 1.6.33 - 2021-02-21 =
* The free version has now support for front-end file uploader, can be used with the shortcode [shared_files file_upload=1]. More features coming in the next update for the Pro version of frontend upload.

= 1.6.32 - 2021-02-20 =
* Pagination now works normally when there are multiple instances of [shared_files] on the same page. You should give a unique embed id for each one: [shared_files embed_id="my-files"]
* Fix regarding the "WordPress location" setting: it's now possible that the location url has more than 1 part i.e. /clients/company/ or /clients/a/abc-company/
* New setting: "Maximum size of uploaded file" (you can change the default text for maximum file size using this, not the actual file size)
* Freemius SDK updated to 2.4.2

= 1.6.31 - 2021-02-10 =
* (Free and Pro) Fixed some issues regarding opening files
* (Pro) New setting: Define folder for new files (see settings, first tab)

= 1.6.30 - 2021-01-31 =
* (Free and Pro) Fix: pagination now works normally
* (Free and Pro) Pagination added to Simple List
* (Free and Pro) Download button now works also when file opening method is "Redirect"
* (Pro) New parameter for shortcode [shared_files], exclude categories (by slug): [shared_files exclude_cat="category-1,category-2"]
* (Pro) New general setting: Show tag dropdown
* (Pro) New shortcode parameter to show the tag dropdown: [shared_files show_tag_dropdown=1]
* (Pro) New feature: Sync files from the media library (see the new page under Sync files in the WP admin area)
* Bug fixes

= 1.6.29 - 2021-01-21 =
* (Free and Pro) Fix to the download button: now the file is always downloaded rather than opened in the browser (unless "Redirect" is chosen for file opening method)

= 1.6.28 - 2021-01-20 =
* (Free and Pro) Affiliation program introduced. Also a new setting (Pro): "Hide affiliation link"
* (Free and Pro) Added notification / information regarding maximum file size
* (Pro) Bug fixes regarding multi-file upload

= 1.6.27 - 2021-01-14 =
* CSS & bug fixes
* New setting: Order by (category list)

= 1.6.26 - 2021-01-11 =
* Lightbox now supports video files (mp4, ogg, webm, mov)
* External URL / YouTube URL can now be activated to the file upload form from the settings
* Title field added to file upload form
* There is now a separate Shortcodes page in the WP admin area
* CSS & bug fixes

= 1.6.25 - 2021-01-01 =
* New feature: Image modal/lightbox. Image files can now be viewed using a lightbox view and there's a separate "Download original"-button.
* New feature: YouTube modal/lightbox. YouTube-videos are now opened in a lightbox rather than in a separate tab.
* (Pro) New option: 'Uncheck "Hide from other pages" for uploaded files'
* (Pro) New parameter "hide_file_list" to be used with [shared_files file_upload=1] like so: [shared_files file_upload=1 hide_file_list=1]
* Various minor improvements
* Bug fixes

= 1.6.24 - 2020-12-20 =
* Pro: You can now check many categories and tags when uploading a file using the front-end file upload. See settings, Help / Support -page and demo: https://www.sharedfilespro.com/shared-files/file-upload-2/
* Pro: You can now change the contents of the message that is displayed when the download limit has been reached (see the settings)
* Added support for https://youtu.be -links (when the YouTube icon is displayed)
* Bug fixes

= 1.6.23 - 2020-12-02 =
* New feature (Pro): Sync Files — you can now upload files directly using FTP and activate the files for the plugin from the Sync Files page.
* New option (Free and Pro): "File opening method"
* New option (Free and Pro): "Preview service"
* Show-button added next to file password

= 1.6.22 =
* Some modifications made to the file opening process to solve issues on certain server configurations
* New option: "WP Engine compatibility mode" (if you're using WP Engine to host your site, check this)

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

= 1.4.9 =
* A new option added to optionally define WP location

= 1.4.8 =
* The plugin now supports the case when WP is installed in a subdirectory

= 1.4.7 =
* A few more texts made translatable

= 1.4.6 =
* New parameter for shortcode [shared_files] to hide search: "hide_search". Can be used like so: [shared_files hide_search=1]
* Settings page added. You may now define an email address and when a file is downloaded, an email notify is sent to that email.

= 1.4.5 =
* Bug fix to enable use with ie. Elementor

= 1.4.4 =
* Bug fix for deleting file

= 1.4.3 =
* Bug fix for displaying files from specific category
* Date added to the file list (item created)

= 1.4.2 =
* Donation links added

= 1.4.1 =
* Bug fix for pagination

= 1.4.0 =
* Added pagination to all files view (20 files per page). The search still targets all files.

= 1.3.0 =
* Added feedback form to Help / Support page

= 1.2.9 =
* Shortcode for displaying a single file added. Using this you can insert a file to e.g. a post or a page.

= 1.2.8 =
* File description field converted to wysiwyg editor

= 1.2.7 =
* Missing strings made translatable

= 1.2.6 =
* Translation support added

= 1.2.5 =
* New feature: External URL. Instead of adding a locally hosted file, you may now add an external URL.

= 1.1.5 =
* Categories added. A category can now be assigned to a file and it's possible to list files from a certain category.

= 1.0.5 =
* Support page updated

= 1.0.4 =
* Bug fixes
* Housekeeping
* Testing on Gutenberg

= 1.0.3 =
* File type icons added

= 1.0.2 =
* CSS fix

= 1.0.1 =
* Minor fixes

= 1.0.0 =
* Initial release / 2018-07-15
