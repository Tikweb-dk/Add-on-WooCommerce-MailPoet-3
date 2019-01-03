=== Add-on WooCommerce - MailPoet 3 ===
Contributors: kasperta, sebd86
Tags: mailpoet, wysija, woocommerce, e-commerce, mail, email, e-mail, extension, add-on, newsletter, newsletters, subscription, checkout, list, lists, double opt-in, form
Donate link: http://www.tikweb.dk/donate/
Requires at least: 4.6
Tested up to: 4.9
Requires PHP: 5.3
Stable tag: 1.1.0

Let your customers subscribe to your MailPoet 3 newsletter as they checkout from WooCommerce with their purchase.

== Description ==

> #### Requirements
> [MailPoet 3](https://wordpress.org/plugins/mailpoet/)<br />
> [WooCommerce](http://wordpress.org/plugins/woocommerce/)

Let your customers subscribe to your newsletter/s as they checkout with their purchase.

= Features =

* If you have more than one newsletter list, customers can select which list to subscribe when making a purchase.
* Double Opt-in.
* Decide if the checkbox/s to subscribe is checked or un-checked.
* Place the subscription fields on the checkout page where you want them to be.
* Custom checkbox label.

= Setting up the Plugin =

To setup this plugin, go to "WooCommerce -> Settings" and then the MailPoet tab. The settings are in two sections. 'General | Available Lists'

"General" contains the main settings for the plugin.

"Available Lists" contains a table listing of all your created lists. Select the lists you want your customers to subscribe to by ticking the checkbox next to the list and press 'Save changes'.

That's it, now when your customers tick the subscribe checkbox on the checkout page, they will be subscribed to the newsletter/s you selected when processing an order.

== <a name="how-to-translate"></a>How to translate? ==

We use the official WordPress Polyglots translation team and online translation system - which is not very common among plugin authors, and therefore we would like to explain why this is both easier and better for all than the common .pot/.po/.mo files.

= Online web translation =
To make it short, you simply use the online system at <https://translate.wordpress.org/projects/wp-plugins/add-on-woocommerce-mailpoet> to translate both "Development" and "Development Readme" into your language. And when a translation editor have approved the translations, a language pack will automatically be generated for all websites using our plugin and the language you translated. No need to work with any files at all, WordPress will automatically load the translation, when it is approved by an editor.

= .pot/.po/.mo files =
If you need to have your own texts and translations, you can off course still use Poedit or a plugin like Loco Translate with your own .po files. You can export and download a translation to a .po file from
<https://translate.wordpress.org/projects/wp-plugins/add-on-woocommerce-mailpoet> -> Choose language -> Choose Development -> Export (at the bottom)
If you add new translations, please consider using the import button at the same place, to import your .po file translations into the online system so everyone may benefit from your translations :-)

= Online web translation: Editors and approval =
Everyone can edit and add translations for our plugin using the online system at <https://translate.wordpress.org/projects/wp-plugins/add-on-woocommerce-mailpoet> - this only require that you are logged in with your wordpress.org user name. But only editors may approve translations. So after adding translations for a new language, you should apply to become the Project Translation Editor (PTE) for your language for our plugin, then you may approve your own translations.

Only members of the WordPress Polyglots team can approve new PTEs, which they usually do pretty fast when you have added a full language of translations. To approve a new PTE, the polyglots team member must be a General Translation Editor (GTE) for the language, meaning one that have access to all plugins for the specific language, since the one approving you off course needs to be fluent in your language to be able to read your first translations and check that they are of good quality.

To become PTE, you simply request it at the Polyglots forum.
We suggest you use the example below - exchange xx_XX with your locale (ex. da_DK for danish in Denmark) and XXXXX with your wordpress.org username (ex. mine is kasperta). If your language have several different locales, add an extra line with that locale.
So copy and paste the text below to a new post at <https://make.wordpress.org/polyglots/> - and edit locale + user name, and soon you may approve your own translations :-)
---beginning of forum post---
	Hello Polyglots, I have added translations for "Add-on WooCommerce – MailPoet 3" (&lt;a href="https://wordpress.org/plugins/add-on-woocommerce-mailpoet/">Add-on WooCommerce – MailPoet 3&lt;/a>) and would like to become the Project Translation Editor (PTE) for my language.
	Please add my WordPress.org user as Project Translation Editor (PTE) for the respective locales:
	o #xx_XX – @XXXXX
	If you have any questions, just comment here. Thank you!
	#editor-requests
---end of forum post---

= Translations and editors =

See the current translation contributors and editors for our plugin for the different languages at:
<https://translate.wordpress.org/projects/wp-plugins/add-on-woocommerce-mailpoet/contributors>

See the generated language packs at:
<https://translate.wordpress.org/projects/wp-plugins/add-on-woocommerce-mailpoet/language-packs>

If the online system have not generated a language pack for your language, it is because:

1. Your texts are not approved, check if they are still in the "waiting" column. If they are, then check if there is an [editor](https://translate.wordpress.org/projects/wp-plugins/add-on-woocommerce-mailpoet/contributors) for your language, if not, then request to become an editor.
2. There are not enough texts translated, you need about 90% translated before a translation pack is generated.
3. You have only translated the plugin strings and not the readme. You need above 90% for "Development" and "Development Readme" together, check the percentage of both columns for your language at <https://translate.wordpress.org/projects/wp-plugins/add-on-woocommerce-mailpoet>



== Installation ==

There are 3 ways to install this plugin:

= 1. The super easy way =
1. In your WordPress dashboard, navigate to Plugins > Add New
2. Search for `Add-on WooCommerce MailPoet 3`
3. Click on "install now" under "Add-on WooCommerce MailPoet 3 "
4. Activate the plugin

= 2. The easy way =
1. Download the plugin (.zip file) by using the blue "download" button underneath the plugin banner at the top
2. In your WordPress dashboard, navigate to Plugins > Add New
3. Click on "Upload Plugin"
4. Upload the .zip file
5. Activate the plugin

= 3. The old-fashioned and reliable way (FTP) =
1. Download the plugin (.zip file) by using the blue "download" button underneath the plugin banner at the top
2. Extract the archive and then upload, via FTP, the `woocommerce-add-on-mailpoet-3` folder to the `<WP install folder>/wp-content/plugins/` folder on your host
3. Activate the plugin

= Setting up the Plugin =

To setup this plugin, go to "WooCommerce -> Settings" and then the MailPoet tab. The settings are in two sections. 'General | Available Lists'

"General" contains the main settings for the plugin.

"Available Lists" contains a table listing of all your created lists. Select the lists you want your customers to subscribe to by ticking the checkbox next to the list and press 'Save changes'.

That's it, now when your customers tick the subscribe checkbox on the checkout page, they will be subscribed to the newsletter/s you selected when processing an order.

== Screenshots ==

1. Single checkbox subscribe field on the checkout page.
2. Multi checkbox subscribe fields on the checkout page.
3. General plugin settings.

== Changelog ==

= 1.1.0 – 2018-06-28 =
* Added a new option for ‘Privacy Policy Notice Page’ that is for the GDPR compliance and ask for allow consent in the subscription form.

* Added a new settings for the 'GDPR'.

* Settings for the display GDPR Subscription consent Text.

* Set Privacy Page

* Display Subscribe/Unsubscribe options

* Added changelog.txt file

[Changelog](https://plugins.svn.wordpress.org/add-on-woocommerce-mailpoet/trunk/changelog.txt)

== Upgrade Notice ==

= 1.0.1 =
* Fixed all the text domain: mailpoet-woocommerce-add-on to add-on-mailpoet-woocommerce

= 1.0.0 =
* Initial release.

== Credits ==

This plugin was based on the WooCommerce plugin originally created by @sebd86
