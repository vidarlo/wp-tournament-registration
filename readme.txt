=== WP Tournament Registration ===
Contributors: archaeopath
Tags: events, registration, event registration, tournament, tournaments, competition, competitions, sport, chess, hobby sport
Requires at least: 5.3
Tested up to: 5.4.1
Requires PHP: 7.2
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A simple but highly configurable tournament registration form providing shortcodes for form, list, editor and export views. It is mainly intended for registering players with hobby sport events.

== Description ==
WP Tournament Registration is a plugin that provides shortcodes intended for registering players with hobby sport events. As a matter of fact, it was made for the championship of my [local chess club](https://schach-goettingen.de/).There are four shortcodes for different views:

* `[wptournregedit tournament_id=\"myID\" /]` is an editor for the players\' data.
* `[wptournregexport tournament_id=\"myID\"]...[/wptournregexport]` is a plain text export filter
* `[wptournregform tournament_id=\"myID\"]...[/wptournregform]` is a form where people can register with the competition. It covers some `[wptournregfield field=\"fieldname\" /]` shortcodes which customize the desired inputs.
*` [wptournreglist tournament_id=\"myID\" /]` is a sortable list view of all approved participants.

All these shortcodes are customizable through a set of optional attributes. 

= Available fields =
* `address` [text]: self-explanatory.
* `affiliation` [text]: club or association.
* `approved` [checkbox]: entries become visible in in the list view or through the export filter only afer approved was checked.
* `birthyear` [integer]: self-explanatory
* `city` [text]: self-explanatory.
* `custom1`, `custom2`, `custom3`, `custom4`, `custom5` [text]: if anything is missing.
* `email` [text]: self-explanatory.
* `fee_is_paid` [checkbox]:  self-explanatory.
* `firstname` [text]: self-explanatory.
* `id` [read-only]: an integer that serves as primary key and is incremented with every registration. Use it do separate entries if people register twice.
* `lastname` [text]: self-explanatory.
* `message` [textarea]: self-explanatory
* `phone1` [text]: self-explanatory
* `phone2` [text]: self-explanatory
* `postcode` [integer]: self-explanatory
* `protected` [checkbox]:  if checked, all contact data of the particiapant are suppressed in list view.
* `rating1` [integer]: a rating that is used to calculate ranking lists.
* `rating2` [integer]: another rating that is used to calculate ranking lists.
* `time` [read-only]: a timestamp that records the exact date and time of submitting.
It is advisable not to misuse fields since there are some internal checks on the values. Use the custom fields instead. It is hard to say how what the length of input fields is as this depends on what is going to. But all are of reasonable length for their purpose.

= Attributes =
`wptournregedit`:
*`tournament_id` (required).
*`display_fields` a comma-separated list of field names in the order of view.

`wptournregexport`:
*`tournament_id` (required).
*`class` adds a space separated list of custom CSS classes to the form.
*`css` adds a style attribute with custom CSS to the form.
*`id` adds a custom CSS id to the form.
*`fields_set` a comma-separated list of fields which get ignored if empty.
*`filename` the name of the export file.
*`format` a plain text string where all field names get replaced by the respective values.

`wptournregform`:
*`tournament_id` (required).
*`backlink` adds a backlink to the plugin\'s project page.
*`class` adds a space separated list of custom CSS classes to the form.
*`css` adds a style attribute with custom CSS to the form.
*`id` adds a custom CSS id to the form.
*`disabled` submit and reset buttons are disabled if set to any value.
*`email` a comma-separated list of login names who get an E-mail notification if somebody registeres.

`wptournreglist`:
*`tournament_id` (required).
*`backlink` adds a backlink to the plugin\'s project page if set to any value.
*`class` adds a space separated list of custom CSS classes to the form.
*`css` adds a style attribute with custom CSS to the form.
*`id` adds a custom CSS id to the list.
*`display_fields` a comma-separated list of fields on view in that particular order.
*`headings` a comma-separated list of column headings in that particular order.
*`protected_fields` a comma-separated list of fields that are suppressed if the `protected` flag is set in the database for a certain user.
*`notsortable` the columns are sorttable by default. This is suppressed if set to any value.

`wptournregfield`:
*`checked` checks a checkbox if set to any value.
*`class` adds a space separated list of custom CSS classes to the form.
*`css` adds a style attribute with custom CSS to the form.
*`id` adds a custom CSS id to the form.
*`disabled` disables the field if set to any value.
*`field` one of the field names (cf. list above).
*`label` the label of the field.
*`placeholder` the placeholder is shown in an empty field.
*`required` if set to any value the field is marked as required.

= Usage =


== Installation ==
1. In your wp-admin (WordPress dashboard), go to Plugins Menu > Add New
2. Search for \'wp-tournament-registration\' in search field on top right.
3. In the search results, click on \'Install Now\' button next to WP Tournament Registration.
4. Once the installation is complete, click Activate button.

You can also install the plugin manually by following these steps:
1. Download the plugin zip file from https://wordpress.org/plugins/wp-tournament-registration/
2. In your wp-admin (WordPress dashboard), go to Plugins Menu > Add New
3. Click the \'Upload Plugin\' button at the top.
4. Upload the zip file you downloaded in Step 1.
5. Once the upload is finish, click on Activate.

== Frequently Asked Questions ==
= Where is the settings page? =

No settings page at all! Everything is done with shortcodes.

= How about multisite? =

WP Tournament Registration employs a single database table on multisite installs. This is
desired behaviour. Fi., if a multisite provides different language versions of the same site, 
then you can provide a registration form in every language for the same tournament. For protecting
a site against others it is probably a good idea to namespace your tournament IDs somehow, eg. 
`mysite_mytournamentid` 



== Changelog ==
= 1.0.0 =
* Initial Public Release