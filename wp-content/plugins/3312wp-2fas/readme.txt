=== WP 2FA - Two-factor Authentication for WordPress===
Contributors: WPWhiteSecurity, robert681
Plugin URI: https://www.wpwhitesecurity.com/wordpress-plugins/wp-2fa/
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl.html
Tags: 2FA, two-factor authentication, multi step authentication, 2-factor authentication, WordPress authentication, two step authentication
Requires at least: 4.5
Tested up to: 5.5
Stable tag: 1.4.2
Requires PHP: 5.6.20

Harden your website login page; add two-factor authentication (2FA) for all your users with this easy to use plugin.

== Description ==

<strong>A FREE & EASY TO USE TWO-FACTOR AUTHENTICATION PLUGIN FOR WORDPRESS</strong><br />

Add an extra layer of security to your WordPress website login page and its users. Enable [two-factor authentication (2FA)](https://www.wpwhitesecurity.com/two-factor-authentication-wordpress/?utm_source=wordpress.org&utm_medium=referral&utm_campaign=all+plugins&utm_content=plugin+repos+description), the best protection against users using weak passwords, and automated password guessing and brute force attacks.

Use the [WP 2FA plugin](https://www.wpwhitesecurity.com/wordpress-plugins/wp-2fa/?utm_source=wordpress.org&utm_medium=referral&utm_campaign=WP2FA&utm_content=plugin+repos+description) to enable two-factor authentication for your WordPress administrator user, and to enforce your website users, or some of them to use 2FA. This plugin is very easy to use. It has wizards with clear instructions, so even non technical users can setup 2FA without requiring technical assistance.

### Maintained & Supported by WP White Security

WP White Security builds high-quality niche WordPress security & admin plugins such as [Password Policy Manager](https://www.wpwhitesecurity.com/wordpress-plugins/password-policy-manager-wordpress/?utm_source=wordpress.org&utm_medium=referral&utm_campaign=PPMWP&utm_content=plugin+repos+description), a plugin with which you can ensure all your users use strong passwords.

Browse our list of [WordPress plugins](https://www.wpwhitesecurity.com/wordpress-plugins/?utm_source=wordpress.org&utm_medium=referral&utm_campaign=all+plugins&utm_content=plugin+repos+description) that can help you better manage and improve the security of your WordPress websites and users.

####WP 2FA Key plugin features & capabilities

* Free Two-factor authentication (2FA) for all users
* Supports TOTP (code from [2FA apps](https://www.wpwhitesecurity.com/support/kb/configuring-2fa-apps/) like Google Authenticator and Authy) and OTP (email based codes)
* Supports [2FA backup codes](https://www.wpwhitesecurity.com/2fa-backup-codes/?utm_source=wordpress.org&utm_medium=referral&utm_campaign=WP2FA&utm_content=plugin%20repos%20description)
* Very easy to use and wizard driven
* Use [policies to enforce 2FA with a grace period](https://www.wpwhitesecurity.com/support/kb/configure-2fa-policies-enforce/?utm_source=wordpress.org&utm_medium=referral&utm_campaign=WP2FA&utm_content=plugin%20repos%20description) or require your users to instantly setup 2FA upon login
* Protection against automated password guessing and dictionary attacks

### FREE Plugin Support
Support for the WP 2FA plugin is available for free via:

* [forums](https://wordpress.org/support/plugins/wp-2fa/)

* [email](https://www.wpwhitesecurity.com/support/?utm_source=wordpress.org&utm_medium=referral&utm_campaign=WP2FA&utm_content=plugin+repos+description)

* [knowledge base](https://www.wpwhitesecurity.com/support/kb/?utm_source=wordpress.org&utm_medium=referral&utm_campaign=WP2FA&utm_content=plugin+repos+description)

For any other queries, feedback, or if you simply want to get in touch with us please use our [contact form](https://www.wpwhitesecurity.com/contact-wp-white-security/?utm_source=wordpress.org&utm_medium=referral&utm_campaign=WP2FA&utm_content=plugin+repos+description).

#### Related Links and Documentation

* [What is Two-factor authentication](https://www.wpwhitesecurity.com/two-factor-authentication-wordpress/?utm_source=wordpress.org&utm_medium=referral&utm_campaign=WP2FA&utm_content=plugin+repos+description)
* [Why you need both 2FA & strong passwords](https://www.wpwhitesecurity.com/two-factor-authentication-strong-passwords-wordpress/?utm_source=wordpress.org&utm_medium=referral&utm_campaign=WP2FA&utm_content=plugin+repos+description)
* [Setting up Google authenticator for WordPress 2FA](https://www.wpwhitesecurity.com/google-authenticator-app-wordpress-2fa/?utm_source=wordpress.org&utm_medium=referral&utm_campaign=WP2FA&utm_content=plugin+repos+description)
* List of [supported 2FA apps](https://www.wpwhitesecurity.com/support/kb/configuring-2fa-apps/)
* [Prevention is the way to go in WordPress Security](https://www.wpwhitesecurity.com/prevention-better-cure-ways-wordpress-security/?utm_source=wordpress.org&utm_medium=referral&utm_campaign=WP2FA&utm_content=plugin+repos+description)
* [Official WP 2FA plugin page](https://www.wpwhitesecurity.com/wordpress-plugins/wp-2fa/?utm_source=wordpress.org&utm_medium=referral&utm_campaign=WP2FA&utm_content=plugin+repos+description)

== Installation ==

=== From within WordPress ===

1. Visit 'Plugins > Add New'
1. Search for 'WP 2FA'
1. Install & activate the WP 2FA from your Plugins page.

=== Manually ===

1. Download the plugin from the [WordPress plugins repository](https://wordpress.org/plugins/wp-2fa/)
1. Unzip the zip file and upload the `wp-2fa` folder to the `/wp-content/plugins/` directory
1. Activate the WWP 2FA plugin through the 'Plugins' menu in WordPress

== Screenshots ==

1. The first-time install wizard allows you to setup 2FA on your website and for your user within seconds.
2. The wizards make setting up 2FA very easy, so even non technical users can setup 2FA without requiring help.
3. You can require users to enable 2FA and also give them a grace period to do so.
4. Users can also use one-time codes via email as a two-factor authentication method.
5. You can use policies to require users to instantly set up and use 2FA, so the next time they login they will be prompted with this.
6. It is recommended for all users to also generate backup codes, in case they cannot access the primary device.
7. In the user profile users only have a few 2FA options, so it is not confusing for them and everything is self explanatory.
8. The plugin blocks the accounts of users who are required to have 2FA but fail to enable it within the grace period, so they do not jeopardize the security of your website.

== Changelog ==

= 1.4.2 (2020-09-02) =

* **New features**
	* Policy to enforce [2FA policies](https://www.wpwhitesecurity.com/support/kb/configure-2fa-policies-enforce/) on superadmins only on a multisite network.
	* Setting to [restrict other site admins from accessing the 2FA settings and policies](https://www.wpwhitesecurity.com/support/kb/restrict-access-2fa-settings/).
	* Support for Okta Verify 2FA app.
	* Added new test buttons to test the email delivery system and individual email templates.
	* Support for custom user roles with multiple words (such as "shop manager").

* **Improvements**
	* Users can setup 2FA via their smart device without the need to scan the QR code.
	* When instant 2FA is required, existing user sessions are not terminated. Instead they are redirected to the 2FA wizard.
	* The dates and times used in emails and notifications have the same format as that configured in WordPress.
	* The dates and times strings used in the plugin and emails are fully translatable.
	* Added a subject to the login confirmation code email.
	* Better error reporting when required settings are missing.
	* Removed all reference to the Google Authenticator app. Now all messages are generic for all 2FA apps.
	* Standardized the order of placeholders in 2FA wizard.
	
* **Bug fixes**
	* Users unable to setup 2FA in some edge cases because of a HTTP 400 error response during the wizard.
	* Grace period settings hid unexpectedly upon changing the settings.
	* The wrong grace period was being added to the user emails.
	* Wrong grace period shown in user email when users are required to instantly setup 2FA.
	* Users were able to disable 2FA after setting it up, even when 2FA is enforced.

Refer to the complete [plugin changelog](https://www.wpwhitesecurity.com/support/kb/wp-2fa-changelog/) for more detailed information about what was new, improved and fixed in previous version updates of WP 2FA.
