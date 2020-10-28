�h�_<?php exit; ?>a:1:{s:7:"content";a:4:{s:5:"child";a:1:{s:0:"";a:1:{s:3:"rss";a:1:{i:0;a:6:{s:4:"data";s:3:"


";s:7:"attribs";a:1:{s:0:"";a:1:{s:7:"version";s:3:"2.0";}}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:1:{s:0:"";a:1:{s:7:"channel";a:1:{i:0;a:6:{s:4:"data";s:61:"
	
	
	
	




















































";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:1:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:16:"WordPress Planet";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:28:"http://planet.wordpress.org/";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:8:"language";a:1:{i:0;a:5:{s:4:"data";s:2:"en";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:47:"WordPress Planet - http://planet.wordpress.org/";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"item";a:50:{i:0;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:82:"WPTavern: Dragging and Dropping Meta Boxes Might Not Be So Simple in WordPress 5.6";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:30:"https://wptavern.com/?p=106675";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:209:"https://wptavern.com/dragging-and-dropping-meta-boxes-might-not-be-so-simple-in-wordpress-5-6?utm_source=rss&utm_medium=rss&utm_campaign=dragging-and-dropping-meta-boxes-might-not-be-so-simple-in-wordpress-5-6";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:6168:"<p class="has-drop-cap">If you have been testing the latest development version of WordPress in the past week or so, you may have noticed that the ability to drag and drop meta boxes seemingly disappeared. This is not a bug. Nine days ago, lead developer Andrew Ozz <a href="https://core.trac.wordpress.org/changeset/49179">committed a change</a> that requires end-users to click the &ldquo;screen options&rdquo; tab to expose the ability to rearrange meta boxes.</p>



<p>Ozz opened the <a href="https://core.trac.wordpress.org/ticket/50699">original ticket</a> and has spearheaded the effort to change how users interact with meta boxes. The issue he would like to solve stems from a change in WordPress 5.5. WordPress&rsquo;s last major release <a href="https://core.trac.wordpress.org/ticket/49288">introduced visible &ldquo;drop zones&rdquo;</a> in cases where a meta box container did not contain any meta boxes. These zones let users know that they can move meta boxes into those areas. This change was to fix a regression from a previous release. Needless to say, it was a rabbit hole of changes to chase down. Nevertheless, the problems with meta boxes were presumably fixed in WordPress 5.5.</p>



<img />Empty meta box holder on Dashboard screen.



<p>Ozz opened the ticket to remove the always-visible drop zones when no meta boxes were present. The argument is that the ability to move meta boxes around the screen is technically a &ldquo;screen option.&rdquo; Thus, it should only be triggered when the end-user has opened the screen options tab.</p>



<p>Another side issue is that he wanted to address accidental dragging, which he described as more common on laptops with trackpads than other devices.</p>



<p>Some readers may be thinking that meta boxes are going the way of the dinosaur. For those users who have migrated to 100% usage of the block editor, there is a good chance that their only interaction with meta boxes is on the Dashboard admin screen. For users on the classic editor, meta boxes are tightly interwoven into their day-to-day workflow. Many plugins also use the meta box system on custom admin screens.</p>



<p>The biggest counter-argument is that, because meta boxes look and feel like draggable elements, the ability to do so should be active at all times.</p>



<p>The point of contention is primarily about whether dragging and dropping meta boxes is technically a screen option. One side sees the WordPress 5.5 implementation as a broken user experience. The other side sees the new method as broken.</p>



<p>Without user data to back it up, no one can say which method is truly the best option. However, changes to a standard user experience that is more than a decade old are likely to be problematic for a large number of users.</p>



<p>This seems like one of those if-it-ain&rsquo;t-broke-don&rsquo;t-fix-it situations. With years of muscle memory for existing users and an expectation for how meta boxes should work, relegating the ability to drag them around the interface to the little-used screen options tab is a regression. At the very least, it is a major change that needs heavy discussion and testing before going forward.</p>



<p>&ldquo;Nothing breaks, per se,&rdquo; said John James Jacoby, the lead developer for BuddyPress and bbPress. &ldquo;Nothing fatal errors. Nothing visually looks different. Yet, a critical user interface function has now gone missing. In my WP User Profiles plugin, for example, there are 15 registered meta boxes. Previous to this change, users with the device and dexterity to use a mouse/pointer/cursor could rearrange those meta boxes with simple dragging and dropping. After this change, no user can rearrange them without first discovering how to unlock the interface to enable rearranging.&rdquo;</p>



<p>The problem is illustrated by the following screenshot from the <a href="https://wordpress.org/plugins/wp-user-profiles/">WP User Profiles</a> plugin. Each of the highlighted boxes represents areas where end-users would typically be able to click to drag a meta box around the screen. If the current change is not reverted, many users may believe the plugin is broken when they upgrade to WordPress 5.6.</p>



<img />Meta boxes from the WP User Profiles plugin.



<p>&ldquo;Is there a plan for letting existing users know that moving metaboxes is now only when Screen Options is open?&rdquo; <a href="https://core.trac.wordpress.org/ticket/50699#comment:20">asked Helen Hou-Sand&igrave;</a>, the core tech lead for 5.6, in the ticket. &ldquo;I&rsquo;m not sure I would ever discover that as an existing user and would be convinced everything was broken if I updated with no context.&rdquo;</p>



<p>The current solution is to drop a note in the &ldquo;What&rsquo;s New&rdquo; section of the WordPress 5.6 release notes to let users know of the change, which may not be visible enough for most users to see. If it does go through, ideally, users would be welcomed with an admin pointer that describe the change directly in their WordPress admin interface.</p>



<p>There are also <a href="https://core.trac.wordpress.org/ticket/50699#comment:37">accessibility impacts to consider</a>. Joe Dolson, a core WordPress committer and member of the accessibility team, said the user experience for keyboard users would become difficult and that the feature would be harder to discover.</p>



<p>&ldquo;I can&rsquo;t see a way in which this change, as currently implemented, improves the experience for anybody,&rdquo; he said. &ldquo;The proposal from the accessibility team is how we could compromise to reduce the visual impact of the movers without compromising the usability of the system at this extreme level; but just <em>not</em> doing this would be something I&rsquo;d find entirely acceptable, as well.&rdquo;</p>



<p>So far, most people who have chimed in on the ticket have given numerous reasons for why this is not a good idea. There is almost no public support for it at this time. However, it currently remains in the latest development/trunk version of WordPress. If not reverted in the coming weeks, it will land in WordPress 5.6.</p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Mon, 26 Oct 2020 20:43:24 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:14:"Justin Tadlock";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:1;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:114:"WPTavern: WordPress Contributors Explore Adding Dark Mode Support to Upcoming Twenty Twenty-One Theme via a Plugin";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:30:"https://wptavern.com/?p=106593";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:273:"https://wptavern.com/wordpress-contributors-explore-adding-dark-mode-support-to-upcoming-twenty-twenty-one-theme-via-a-plugin?utm_source=rss&utm_medium=rss&utm_campaign=wordpress-contributors-explore-adding-dark-mode-support-to-upcoming-twenty-twenty-one-theme-via-a-plugin";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:5322:"<p>WordPress 5.6 is set to include a new default theme, <a href="https://wptavern.com/first-look-at-twenty-twenty-one-wordpresss-upcoming-default-theme">Twenty Twenty-One</a>, designed to give users a blank canvas for the block editor. The theme doesn&rsquo;t fall under any particular category and is meant to be suitable for use across different types of websites. One new feature that has very recently come under consideration is <a href="https://make.wordpress.org/core/2020/10/22/twenty-twenty-one-dark-mode-discussion/">support for a dark mode that can be toggled on or off</a>.</p>



<p>Contributors have raised the possibility of including a dark mode in several <a href="https://github.com/WordPress/twentytwentyone/labels/%5BComponent%5D%20Dark%20Mode">issues</a> while the theme has been in development. Mel Choyce, who is leading the design on the default theme, <a href="https://make.wordpress.org/core/2020/10/22/twenty-twenty-one-dark-mode-discussion/">published a summary</a> of the team&rsquo;s recent discussions about which options the theme should make available for site owners and viewers in support of dark mode, or if the feature should simply be scrapped. </p>



<p>&ldquo;We&rsquo;ve built in a&nbsp;Customizer&nbsp;setting that lets site owners opt their sites out of supporting Dark Mode, for greater design control,&rdquo; Choyce said. &ldquo;Additionally, we&rsquo;re considering adding a front-end toggle so site viewers can turn Dark Mode on/off, regardless of their OS/Browser preference. This setting would only show if a site allows Dark Mode support.&rdquo;</p>



<div class="wp-block-image"><img />Twenty Twenty-One Light and Dark Modes</div>



<p>Choyce outlined five different combinations of options for supporting it, including two options that allow site owners to disable it, regardless of the user&rsquo;s selection in their OS/browser. Two other options require the site to support dark mode but differ in whether or not the visitor is allowed to toggle it on or off. </p>



<h2>Does Twenty Twenty-One Need a Dark Mode?</h2>



<p>Dark mode was a late addition to the default theme&rsquo;s development. Choyce <a href="https://make.wordpress.org/core/2020/10/22/twenty-twenty-one-dark-mode-discussion/#comment-40111">said</a> the idea seems like a good opportunity to explore but ideally the team would have intentionally designed the feature before development started. </p>



<p>In the comments of the post, contributors are discussing the many intricacies of adding this feature to a theme that will be on by default for new WordPress sites. A few commenters noted there might be issues and surprises with logos and transparent images. For this reason, several made the case for shipping it as an opt-in feature and not on by default.</p>



<p>Others did not see the need for users to be able to toggle dark mode on/off for individual websites when they already have controls available through their system or browser preferences.</p>



<p>Kjell Reigstad contends that users&rsquo; expectations have not yet translated into demand for this feature. </p>



<p>&ldquo;As much as I&rsquo;m a fan of dark mode in general (I use it on all my devices and it definitely helps to reduce eye strain), I think the general public views it as &lsquo;a thing that apps do&rsquo; &mdash; not something that websites do yet,&rdquo; Reigstad said. &ldquo;As mentioned above, this theme could be a step towards changing that perception, but the feature&rsquo;s novelty is something to keep in mind.&rdquo;</p>



<p>WordPress 5.6 core tech lead Helen Hou-Sand&iacute; suggested it might be better to develop the feature as a plugin, instead of pushing for it to be ready in a short time frame.</p>



<p>&ldquo;My instinct right now is that it would be best to split dark mode for Twenty Twenty-One out into a&nbsp;plugin&nbsp;as a form of opt-in, primarily because I think that will both ease the burden for meeting the bar for&nbsp;core&nbsp;ship and also gives space for the feature to be iterated on outside of the core development cycle,&rdquo; Hou-Sand&iacute; said. She also noted that users will be doing things with the theme that core contributors cannot anticipate and a plugin is an easier route for responding to those needs.</p>



<p>&ldquo;By separating it out, I think it has a better chance of reaching a point where it encompasses enough by default to be a theme setting without too much futzing on the user&rsquo;s part, or even enough of a thing to be a feature for all themes at large,&rdquo; Hou-Sand&iacute; said.</p>



<p>Choyce and Carolina Nymark agreed with this suggestion and <a href="https://wordpress.slack.com/archives/C02RP4VMP/p1603724762267800">announced</a> a decision in the WordPress Slack #core-themes channel this morning, based on feedback on the post.</p>



<p>&ldquo;Carolina Nymark and I made the decision to move Dark Mode out into a plugin,&rdquo; Choyce said. &ldquo;This will allow us to better address all of the edge cases we&rsquo;ve been encountering without slowing down the progress of bug fixing within the core theme.&rdquo;</p>



<p>The plugin is being <a href="https://github.com/WordPress/twentytwentyone-dark-mode">developed on GitHub</a> where contributors will explore how to support the feature moving forward.</p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Mon, 26 Oct 2020 18:47:53 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:13:"Sarah Gooding";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:2;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:66:"WordCamp Central: Get your free ticket to WordCamp Finland Online!";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:39:"https://central.wordcamp.org/?p=3130035";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:93:"https://central.wordcamp.org/news/2020/10/26/get-your-free-ticket-to-wordcamp-finland-online/";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:1395:"<p>WordCamp Finland 2020 is just right around the corner and speaker announcements have started to roll out! The online event with two session tracks takes place <strong>November 12 at 12-17 <a href="https://time.is/compare/12_12_Nov_2020_in_Helsinki/UTC">UTC+2</a></strong>. Our organizing team is super excited about the event and upcoming content!</p>
<p>Tickets for WordCamp Finland Online 2020 are absolutely free! We strongly recommend registering for a ticket, as this will give you the full WordCamp experience. This will give you access to Q&amp;A sessions, networking opportunities with speakers, sponsors and other attendees. If you would rather not register, you will still be able to watch the talks.</p>
<p><a href="https://finland.wordcamp.org/2020/tickets/">Register free for the WordCamp Finland Online</a>.</p>
<p>First speakers have been announced and more speakers as well as the full schedule will be announced shortly! Make sure to <a href="https://twitter.com/wordcampfinland">follow us on Twitter</a> to get the news about new announcements.</p>
<p>There&#8217;s also still open <a href="https://finland.wordcamp.org/2020/call-for-volunteers/">call for volunteers</a> to help us during the event day. Being a volunteer is more than lending a hand, it is the secret sauce that makes a wordcamp a WordCamp! Make sure to apply if you&#8217;d like to help make the event.</p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Mon, 26 Oct 2020 15:00:49 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:14:"Timi Wahalahti";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:3;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:31:"Akismet: Happy Birthday Akismet";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:31:"http://blog.akismet.com/?p=2093";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:59:"https://blog.akismet.com/2020/10/25/happy-birthday-akismet/";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:1848:"<p></p>


</p>
<img />
<p>


<p> </p>
<p>Akismet was launched 15 years ago today, when Automattic founder <a href="https://ma.tt/2005/10/akismet-stops-spam/">Matt Mullenweg announced it on his blog</a> in a post describing what Akismet was and what it could become. Given how much the world has changed in the last decade and a half (back then spammers were pushing cheap flip phones and counterfeit Livestrong bracelets), we thought it would be fun to see whether Akismet succeeded in meeting the hopes and dreams that Matt laid out back in October 2005.</p>
<blockquote>
<p>&#8220;Akismet is a new web service that stops comment and trackback spam. (Or at least tries really hard to.)&#8221;</p>
</blockquote>
<p>Fact check: true! Akismet has stopped 500,000,000,000 pieces of comment and trackback spam since October 2005. That&#8217;s an average of a thousand spam per second, every second, since before Twitter existed. Plus another thousand in the time it took you to read that sentence. And this one. (And this one.)</p>
<blockquote>
<p>&#8220;The service is usable immediately as a WordPress plugin and the API could also be adapted for other systems.&#8221;</p>
</blockquote>
<p>Akismet is still usable as a WordPress plugin, and there are now dozens of Akismet clients for non-WordPress systems, plus countless other implementations for custom platforms. Some people say that Akismet is the most open anti-spam API on the Web. Some people are right.</p>
<blockquote>
<p>&#8220;If nothing else, I hope this makes blogging more joyful for at least one person.&#8221;</p>
</blockquote>
<p>According to an informal survey we just performed, Akismet has made blogging more joyful for multiple people. If you&#8217;re one of those people, put on a party hat, grab a piece of cake, and join us in wishing Akismet a very happy 15th birthday.</p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Sun, 25 Oct 2020 07:00:00 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:17:"Christopher Finke";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:4;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:77:"WPTavern: Yext Launches a WordPress Plugin To Connect To Its Answers Platform";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:30:"https://wptavern.com/?p=106325";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:199:"https://wptavern.com/yext-launches-a-wordpress-plugin-to-connect-to-its-answers-platform?utm_source=rss&utm_medium=rss&utm_campaign=yext-launches-a-wordpress-plugin-to-connect-to-its-answers-platform";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:6220:"<p class="has-drop-cap">Last week, Yext launched its <a href="https://wordpress.org/plugins/yext-answers/">Yext Answers plugin</a> to the WordPress community. The goal was to bring a platform that won the Best Software Innovation category of the <a href="https://globalsearchawards.net/2020-winners/">2020 Global Search Awards</a> to WordPress. However, my experience was far from satisfactory.</p>



<p>&ldquo;For people searching on a WordPress website, the Answers Connector provides a seamless search experience,&rdquo; said Alexandra Allegra, the Senior Product Marketing Manager at Yext. &ldquo;For businesses and organizations that integrate it, it drives higher rates of conversion, which generates more revenue. It helps lower support costs because when businesses can deliver detailed, official answers, customers don&rsquo;t have to call customer service. And finally, it unveils valuable customer insights, because businesses can see new questions coming in &mdash; in real-time.&rdquo;</p>



<p>Yext Answers is essentially trialware. Technically, the plugin itself is free. However, Yext is currently running a 90-day free trial for access to its <a href="https://www.yext.com/products/answers/">Answers platform</a>. The website does not seem to provide an easy way to find what the true cost will be after that initial 90 days. To upgrade, users must contact the Yext team via email or phone.</p>



<p>The website does provide an estimated cost calculator. The lowest tier available via this calculator is for 20,000 searches per month at $5,000. It is unclear if there are lower pricing options. The Yext team provided no further details when asked about billing.</p>



<p>The plugin is marketing itself primarily toward business users. It can replace a WordPress site&rsquo;s traditional search, which is customizable to suit various site owner&rsquo;s needs, according to the Yext team.</p>



<p>Over the past week, I have discussed this plugin with a representative from the company, watched demo videos, and attempted to test the plugin. Thus far, it has been a subpar experience. I typically forgo writing about plugins that do not pan out. However, after the initial investment into what looked to be an interesting project, I wanted to share my experience, and my hope is that it helps the team build a better product in the long term.</p>



<p>I have yet to get the Yext Answers plugin to work. It requires an account with the Yext website. It also requires that end-users enter multiple fields on the plugin settings screen in WordPress. Unfortunately, after a frustrating amount of searching, I was never able to successfully find all of the correct information or get the information I did have to work. I gave up on the endeavor.</p>



<p>The demo video does show the promise of a somewhat interesting plugin:</p>



<div class="wp-block-embed__wrapper">
<div class="embed-vimeo"></div>
</div>



<p>Perhaps people who are already familiar with the Yext platform may have better luck. However, I would not recommend it to anyone new, at least in its current state.</p>



<p>There are far better options for connecting via third-party APIs that would be simpler for the average end-user (or even a developer of 15+ years such as myself). The one-click login process provided via the MakeStories plugin, <a href="https://wptavern.com/makestories-2-0-launches-editor-for-wordpress-rivaling-googles-official-web-stories-plugin">which I covered recently</a>, is a prime example of how to do things right.</p>



<p>We are at a point in the internet era in which end-users should have simple, no-fuss connections between sites. Entering IDs, keys, and other complex fields should be tucked under an &ldquo;advanced&rdquo; section of the options screen, not as part of the default experience.  Or, they should be so easily available that no one should have trouble finding them.</p>



<h2>Launching with Shortcodes Instead of Blocks</h2>



<p class="has-drop-cap">Two years after the integration of the block editor into WordPress, the Yext team is launching its Yext Answers plugin with shortcodes, which require manual entrance by end-users. Currently, the plugin does not have block equivalents for its shortcodes.</p>



<p>The team was either unwilling or unable to answer even the most fundamental questions about their decision to use shortcodes rather than launching their plugin &mdash; in the year 2020 &mdash; with at least block alternatives. At points, they even seemed confused about the subject altogether.</p>



<p>The closest the team came to providing feedback after a lengthy discussion was the following, attributed to Rose Grant, the Associate Product Manager:</p>



<blockquote class="wp-block-quote"><p>We&rsquo;re looking forward to feedback on the initial release of our plugin before iterating further on it, including introducing custom blocks. For this version of the plugin, we wanted to prioritize supporting clients who are using older versions of WordPress.</p></blockquote>



<p>Packaging a set of shortcodes within a plugin is still a good practice, even for plugin developers who have transitioned fully to supporting the block editor. It allows them to support users who are still working with the classic editor. However, at this point, developers should be building from a block-first mindset. Blocks do not require that users remember specific shortcode names. They provide instant, visual feedback to users in the editor. And, block options (as opposed to shortcode arguments) do not rely on the oftentimes faulty input of user typing.</p>



<p>At this point, all plugin developers should consider shortcodes a legacy feature and useful only as a backward-compatible option for users on the classic editor.</p>



<p>The Communications Strategist for the company pointed out that this is Yext&rsquo;s first venture into WordPress plugins and that the team may not be able to provide perspective or commentary on such questions related to blocks and shortcodes. However, this is the <a href="https://profiles.wordpress.org/thundersnow/#content-plugins">third Yext-related plugin</a> associated with the plugin author account on WordPress.org.</p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Fri, 23 Oct 2020 20:17:34 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:14:"Justin Tadlock";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:5;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:83:"WPTavern: Gutenberg 9.2 Adds Video Tracks, Improvements to Columns and Cover Blocks";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:30:"https://wptavern.com/?p=106638";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:209:"https://wptavern.com/gutenberg-9-2-adds-video-tracks-improvements-to-columns-and-cover-blocks?utm_source=rss&utm_medium=rss&utm_campaign=gutenberg-9-2-adds-video-tracks-improvements-to-columns-and-cover-blocks";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:4029:"<p><a href="https://make.wordpress.org/core/2020/10/21/whats-new-in-gutenberg-21-october/">Gutenberg 9.2</a> was released this week and is the last release of the plugin to be rolled into WordPress 5.6. It features the long-awaited video tracks functionality, closing a <a href="https://github.com/WordPress/gutenberg/issues/7673">ticket</a> that has been open for more than two years under development. </p>



<p>Video tracks includes things like subtitles, captions, descriptions, chapters, and metadata. This update introduces a UI for adding video tags, which can contain multiple track elements using the following four attributes: </p>



<ul><li><code>srclang</code>&nbsp;(Valid BCP 47 language tag)</li><li><code>label</code>&nbsp;(Title for player UI)</li><li><code>kind</code>&nbsp;(Captions, Chapters, Descriptions, Metadata or Subtitles)</li><li><code>src</code>&nbsp;(URL of the text file)</li></ul>



<p>The ability to edit tracks is exposed in the video block&rsquo;s toolbar:</p>



<div class="wp-block-image"><img /></div>



<p>This update closes a major gap in video accessibility and greatly improves the user experience of videos.</p>



<p>Gutenberg 9.2 also introduces the ability to transform multiple selected blocks into a Columns block. For example, users can select three image blocks and instantly change them into a three-column section. Columns can be created from any kind of block, including InnerBlocks. The transform option will appear if the number of selected blocks falls between 2-6. (The maximum number is derived from the maximum number of columns allowed by the Columns block.)</p>



<div class="wp-block-image"><img />Transform multiple blocks into Columns block</div>



<p>Another notable feature in 9.2 is the expansion of Cover blocks to support repeated background patterns. This gives users more flexibility in their designs, opening up a new set of possibilities.</p>



<div class="wp-block-embed__wrapper">
https://cloudup.com/cArDykzhpYZ
</div>



<p>This release brings in more than a dozen improvements to the new Widgets screen, as well as updates to the Query Block and Site Editor experiments. The most notable smaller enhancements to existing features include the following: </p>



<ul><li>Add dropdown button to view templates in&nbsp;sidebar. (<a href="https://github.com/WordPress/gutenberg/pull/26132">26132</a>)</li><li>Gallery block: Use image caption as fallback for alt text. (<a href="https://github.com/WordPress/gutenberg/pull/26082">26082</a>)</li><li>Table block: Use&nbsp;hooks&nbsp;+&nbsp;API&nbsp;v2. (<a href="https://github.com/WordPress/gutenberg/pull/26065">26065</a>)</li><li>Refactor document actions to handle template part titles. (<a href="https://github.com/WordPress/gutenberg/pull/26043">26043</a>)</li><li>Info panel layout improvement. (<a href="https://github.com/WordPress/gutenberg/pull/26017">26017</a>)</li><li>Remove non-core&nbsp;blocks from default editor content. (<a href="https://github.com/WordPress/gutenberg/pull/25844">25844</a>)</li><li>Add very basic template information dropdown. (<a href="https://github.com/WordPress/gutenberg/pull/25757">25757</a>)</li><li>Rename &ldquo;Options&rdquo; modal to &ldquo;Preferences&rdquo;. (<a href="https://github.com/WordPress/gutenberg/pull/25683">25683</a>)</li><li>Add single column functionality to the Columns block. (<a href="https://github.com/WordPress/gutenberg/pull/24065">24065</a>)</li><li>Add more writing flow options: Reduced&nbsp;UI, theme styles, spotlight. (<a href="https://github.com/WordPress/gutenberg/pull/22494">22494</a>)</li><li>Add option to make Post&nbsp;Featured Image&nbsp;a link. (<a href="https://github.com/WordPress/gutenberg/pull/25714">25714</a>)</li></ul>



<p>Since the Gutenberg 9.2 release was delayed by a week, it includes many more bug fixes and code quality improvements than most releases. Check out the full <a href="https://make.wordpress.org/core/2020/10/21/whats-new-in-gutenberg-21-october/">changelog</a> for more details.</p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Fri, 23 Oct 2020 15:59:36 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:13:"Sarah Gooding";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:6;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:98:"WPTavern: ESLint Maintainers Share Challenges of Funding Open Source Utilities through Sponsorship";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:30:"https://wptavern.com/?p=106411";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:241:"https://wptavern.com/eslint-maintainers-share-challenges-of-funding-open-source-utilities-through-sponsorship?utm_source=rss&utm_medium=rss&utm_campaign=eslint-maintainers-share-challenges-of-funding-open-source-utilities-through-sponsorship";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:8517:"<p><a href="https://eslint.org/">ESLint</a>, one of the most popular JavaScript linting utilities, quickly eclipsed more established early competitors, <a href="https://wptavern.com/jshint-is-now-free-software-after-updating-license-to-mit-expat">thanks to its open source license</a>. The clear licensing enabled the project to become widely used but did not immediately translate into funds for its ongoing development. Despite being &nbsp;downloaded more than 13 million times each week, its maintainers still struggle to support the utility.</p>



<p>A little over a year since launching&nbsp;<a href="https://eslint.org/blog/2019/02/funding-eslint-future">ESLint Collective</a>&nbsp;to fund contributors&rsquo; efforts, the project&rsquo;s leadership <a href="https://eslint.org/blog/2020/10/year-paying-contributors-review">shared</a> some of the successes and challenges of pursuing the sponsorship model. One effort that didn&rsquo;t pan out was hiring a dedicated maintainer:</p>



<blockquote class="wp-block-quote"><p>This was a difficult thing for the team to work through, and we think there&rsquo;s an important lesson about open source sustainability: even though we receive donations, ESLint doesn&rsquo;t bring in enough to pay maintainers full-time. When that happens, maintainers face a difficult decision: we can try to make part-time development work, but it&rsquo;s hard to find other part-time work to make up the monthly income we need to make it worthwhile. In some cases, doing the part-time work makes it more difficult to find other work because you are time-constrained in a way that other freelancers are not.</p></blockquote>



<p>One somewhat successful experiment ESLint explored is paying its five-person Technical Steering Committee (TSC), the project leadership responsible for managing releases, issues, and pull requests. Members receive $50/hour for contributions and time spent on the project, capped at a maximum of $1,000/month. The cap prevents TSC members from spending too much time on the project in addition to their day job so they don&rsquo;t get burned out.</p>



<p>The team reports that this stipend arrangement has worked &ldquo;exceedingly well&rdquo; and contributions have slowly increased: &ldquo;There is something to be said for paying people for valuable work: when the work is explicitly valued, people are more willing to do it.&rdquo; </p>



<p>On larger projects like WordPress, corporate contributions are critical to its ongoing development. In recent years, the <a href="https://wordpress.org/five-for-the-future/">Five for the Future</a> campaign has helped compensate many contributors as their employers pay them a salary while donating their time to work on WordPress. </p>



<p>Some of the major advancements in WordPress require an immense investment of time and expertise. It&rsquo;s problem solving that requires working across teams for months to build complex solutions that will work for millions of users. That&rsquo;s why you don&rsquo;t see armies of people building Gutenberg for free. Much of the development is driven by paid employees and might not otherwise have happened without corporate donations of employee time. Automattic, Google, Yoast SEO, 10up, GoDaddy, Human Made, WebDevStudios, WP Engine, and many other companies have collectively <a href="https://wordpress.org/five-for-the-future/pledges/">pledged</a> thousands of hours worth of labor per month. The diversity of companies and individuals supporting WordPress helps the project maintain stability and weather the storms of life better. </p>



<p>Smaller open source projects like ESLint rarely have the same resources at their disposal and have to experiment. Summarizing the one-year review of paying contributors from sponsorships, the team states: <em>&ldquo;Maintaining a project like ESLint takes a lot of work and a lot of contributions from a lot of people. The only way for that to continue is to pay people for their time.&rdquo;</em></p>



<p>When even the most popular utilities struggle to gain enough sponsorships, what hope is there for smaller projects? Many utilities that have become indispensable in developers&rsquo; workflows are on a trajectory towards becoming unsustainable.  </p>



<p>&ldquo;Unfortunately, utilities like these rarely bring in any meaningful amount of money from donations, no matter how widely used or beloved they are,&rdquo; OSS engineer Colin McDonnell said in his proposal for a new funding model. &ldquo;Consider&nbsp;<a href="https://github.com/ReactTraining/react-router">react-router</a>. Even with 41.3k stars on GitHub, 3M weekly downloads from NPM, and nearly universal adoption in React-based single-page applications, it only brings in&nbsp;<a href="https://opencollective.com/react-router">~$17k</a>&nbsp;of donations annually.&rdquo;</p>



<p>McDonnell proposed the concept of &ldquo;<a href="https://vriad.com/essays/a-new-funding-model-for-open-source-software">sponsor pools</a>,&rdquo; to fund smaller projects that are unable to benefit from existing open-source funding models.&nbsp;Instead of making donations on a per-project basis, open source supporters could donate a set amount into a &ldquo;wallet&rdquo; every month and then distribute those funds to projects they select for their sponsor pools. The key part of the implementation is that adding new projects to the pool should only take one click, reducing the psychological friction associated with supporting additional projects.</p>



<p>McDonnell suggested that GitHub is the only organization with the infrastructure to implement this model as an extension of GitHub Sponsors. One commenter on <a href="https://news.ycombinator.com/item?id=23981563">Hacker News</a> proposes that Sponsors and the idea of &ldquo;sponsors pool&rdquo; could exist in parallel.</p>



<p>&ldquo;I believe that there&rsquo;s a meaningful difference between being the patron of a developer and feeling like you&rsquo;re backing a creator with feelings and a story and a family&hellip; and wanting to be a good citizen that has an approved list of projects that I benefit from and want to support,&rdquo; Pete Forde said.</p>



<p>&ldquo;I can sponsor Matz, get his updates and feel good about knowing I am counted as a supporter AND set aside $$$ per month to contribute to all of the tools I use in my projects simply because it&rsquo;s the right thing to do and I want those projects to exist for the long term. They are completely different initiatives. Patreon vs Humble Bundle, if you will.&rdquo;</p>



<p><a href="https://www.tidelift.com/">Tidelift</a> is another concept that was highlighted in the HN discussion. It has a different, unique approach to funding open source work. Tidelift pools funds from the organizations using the software to support the maintainers. </p>



<p>&ldquo;I maintain <a href="https://github.com/ruby-grape/grape">ruby grape</a>, a mid-sized project,&rdquo; Daniel Doubrovkine said. &ldquo;We get $144/month from Tidelift. As more companies signup for corporate sponsorship the dollar amount increases. It&rsquo;s a pool.&rdquo;</p>



<p><a href="https://snowdrift.coop/">Snowdrift</a> takes a more unusual approach to pooling sponsorships where patrons &ldquo;crowdmatch&rdquo; each others donations to fund public goods. It runs as a non-profit co-op to fund free and open projects that serve the public interest.  </p>



<p><a href="https://flossbank.com/">Flossbank</a> is more specifically targeted at funding open source projects and takes technical approach to ensuring equitable contributions to the the&nbsp;entire dependency tree&nbsp;of your installed open source packages. The organization claims to provide &ldquo;a free and frictionless&rdquo; way to give back to maintainers. Developers can opt into curated, tech-focused ads in the terminal when installing open source packages. As an alternative, they can set a monthly donation amount to be spread across the packages they install.</p>



<p>No single funding model is suitable for all projects but the experiments that pool sponsorships in various ways seem to be trending, especially for supporting maintainers who may not be as skilled in marketing their efforts. The conversation around supporting utilities <a href="https://news.ycombinator.com/item?id=23981563">continues on Hacker News</a>. WordPress developers who depend on some of these utilities may want to join in and share their experiences in funding small projects.</p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Thu, 22 Oct 2020 20:26:55 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:13:"Sarah Gooding";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:7;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:71:"Akismet: Version 4.1.7 of the Akismet WordPress Plugin is Now Available";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:31:"http://blog.akismet.com/?p=2104";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:99:"https://blog.akismet.com/2020/10/22/version-4-1-7-of-the-akismet-wordpress-plugin-is-now-available/";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:882:"Version 4.1.7 of <a href="http://wordpress.org/plugins/akismet/">the Akismet plugin for WordPress</a> is now available. It contains the following changes:

<!-- /wp:paragraph -->

<!-- wp:list -->
<ul>
 	<li>Stops using the deprecated <code>wp_blacklist_check</code> function in favor of the new <code>wp_check_comment_disallowed_list</code> function.</li>
 	<li>Shows the &#8220;Set Up Akismet&#8221; banner on the comments dashboard page, where it&#8217;s appropriate to mention if Akismet has not yet been configured.</li>
 	<li>Miscellaneous text changes.</li>
</ul>
<!-- /wp:list -->

<!-- wp:paragraph -->

To upgrade, visit the Updates page of your WordPress dashboard and follow the instructions. If you need to download the plugin zip file directly, links to all versions are available in <a href="http://wordpress.org/plugins/akismet/">the WordPress plugins directory</a>.";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Thu, 22 Oct 2020 19:23:31 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:17:"Christopher Finke";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:8;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:47:"WPTavern: Q: First FSE WordPress Theme Now Live";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:30:"https://wptavern.com/?p=106388";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:137:"https://wptavern.com/q-first-fse-wordpress-theme-now-live?utm_source=rss&utm_medium=rss&utm_campaign=q-first-fse-wordpress-theme-now-live";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:7929:"<img />Q WordPress theme screenshot.



<p class="has-drop-cap">Themes Team representative Ari Stathopoulos is now officially the first theme author to have a theme in the directory that supports full-site editing (FSE). With a slimmed-down beta release of FSE shipping in WordPress 5.6 this December, someone had to be the first to take the plunge. It made sense for someone intimately familiar with theme development and the directory guidelines to step up.</p>



<p>In many ways, it is a huge responsibility that Stathopoulos has taken on. Until one of the default Twenty* themes handles FSE, the <a href="https://wordpress.org/themes/q/">Q theme</a> will likely be one of the primary examples that other theme authors will follow as they begin learning how to build block-based themes.</p>



<p>Earlier this month, I used <a href="https://wptavern.com/exploring-full-site-editing-with-the-q-wordpress-theme">Q to test FSE</a> and determine how much it had advanced. It is at least months away from being ready for use in production. The beta release in 5.6 is more or less just to get more people testing.</p>



<p>Stathopoulos has no plans to make Q much more than a bare-bones starter or experimental theme. It is almost a playground to see what is possible.</p>



<p>&ldquo;Q was born out of necessity,&rdquo; he said. &ldquo;I couldn&rsquo;t work on full-site editing or global styles without having a base theme for them, so for a while, I had it in a GitHub repository. I decided to release it to the WordPress.org repository because I think I might not be the only one with those issues. Downloading a theme in the dashboard is easier than cloning a repository for most people.&rdquo;</p>



<p>Existing block-based themes are few and far between. Automattic and some of its employees have some experimental projects, but none of those are in the official directory for anyone to test. Stathopoulos wanted a base theme that was unopinionated in terms of design that would allow him to work on FSE, test pull requests, and experiment with various ideas.</p>



<p>&ldquo;It has some ideas for things that ultimately I&rsquo;d like to see implemented in FSE, and it&rsquo;s a playground,&rdquo; he said. &ldquo;For example, the addition of a skip-link for accessibility in the theme, an implementation for responsive/adaptive typography, and conditional loading of block styles only when they are used/needed. These are things that I hope will be part of WordPress Core at some point, and the Q theme explores ideas on how to implement them.&rdquo;</p>



<p>He began work on the theme over a year ago and continues working on it as a side project. He said Yoast, his employer, fully supports the idea of creating things that are beneficial for other theme designers and WordPress core.</p>



<h2>Developing an FSE-Capable Theme</h2>



<img />Editing the Q theme single post template in the site editor.



<p class="has-drop-cap">End-users must install the Gutenberg plugin and activate the experimental FSE feature to use the theme or any similar theme. Currently, FSE is missing many key features that make it viable for most real-world projects. However, theme developers who plan to work with WordPress over the next several years will need to begin testing and experimenting. Q makes for a good starting point to simply get a feel for what themes will look like.</p>



<p>&ldquo;The biggest issue was &mdash; and still is &mdash; keeping up with Gutenberg development,&rdquo; said Stathopoulos. &ldquo;Many things are currently fluid, and they happen at a very high pace. The reason I created the theme was because other themes I was testing, as part of my contribution to the Themes Team, were not properly maintained or updated. I wanted to create a starter theme that can be used as a starting point for others as well.&rdquo;</p>



<p>One of the biggest questions still hanging in the air is what the timeline will look like for publicly-available, block-based themes. <em>Will 2021 be the year they take over?</em> That is unlikely given the feature&rsquo;s current state. However, there will be a point where developers are no longer building classic or traditional themes.</p>



<p>&ldquo;I think we&rsquo;re going to see a lot more FSE themes in 2021,&rdquo; said Stathopoulos. &ldquo;It might take a couple of years before they become the standard, but after the release of WordPress 5.6, I hope there will be a lot more development and focus on FSE and global styles. Whether we see more FSE themes or not depends on when some things get merged in WordPress core.&rdquo;</p>



<p>He pointed out some critical missing features from Gutenberg at the moment. The big one is that the Query block, which is the block that displays posts on the front end, does not inherit its options from the global query. Essentially, this means that, regardless of what URL a visitor is on, it displays the latest posts.</p>



<p>&ldquo;Once these things are addressed, and blockers for theme builders get resolved, I expect we&rsquo;ll see an explosion of good FSE themes being built,&rdquo; he said.</p>



<p>Stathopoulos is most excited about the prospect of seeing more design standards come to core. Currently, there is no consistency between themes. Theme authors can use any markup they want. Switching themes affects a site&rsquo;s structure, SEO, accessibility, speed, and many other things.</p>



<p>&ldquo;My advice to theme developers who want to start tinkering would be to start with something simple,&rdquo; he said. &ldquo;It&rsquo;s tempting to add extremely opinionated styles, for buttons for example, but more and more things get added every day to the editor like a border-radius setting for buttons. Theme authors should avoid the trap of designing an FSE theme having in mind what the editor currently does. Instead, theme authors should strive to build something having in mind a vision of what the editor will eventually become.&rdquo;</p>



<h2>The Future of Theme Reviews</h2>



<p class="has-drop-cap">Because Stathopoulos is a representative of the Themes Team, he also has some insight into the shift in the coming years for guidelines and what steps authors might need to take. While it is too early for the team to begin making decisions, its members are already thinking about forthcoming changes.</p>



<p>&ldquo;Change is always difficult, especially when it&rsquo;s for something this big,&rdquo; said Stathopoulos. &ldquo;It will be a bumpy ride, and it will take time. WordPress theming is a huge industry. For a while, &lsquo;classic&rsquo; (for lack of a better word) themes will continue to be a viable solution for theme developers who didn&rsquo;t have time to catch up. But not forever.&rdquo;</p>



<p>Some may look back at previous major shifts and worry about what the future theme directory guidelines may ask. In 2015, the team <a href="https://wptavern.com/wordpress-org-now-requires-theme-authors-to-use-the-customizer-to-build-theme-options">required all theme options to use the customizer</a>. This was after a three-year wait for theme authors to organically make the switch. Given that FSE will be a much larger departure from norms and dislike of the Gutenberg  project from segments of the development community, it could be a rough transition.</p>



<p>&ldquo;At some point, FSE themes will become the industry standard and what the users want,&rdquo; said Stathopoulos. &ldquo;Personally, I hope no one will want to upload a classic theme in the w.org repository in 2025 when the industry has moved on. It would be like uploading today a theme that is using tables and iframes for layouts.&rdquo;</p>



<p>He said that sufficient time would be given for the eventual transition.  However, the team will likely prioritize FSE-based themes. They are cognizant of how much of a shift this will be and will plan accordingly when the time comes.</p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Thu, 22 Oct 2020 18:48:49 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:14:"Justin Tadlock";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:9;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:100:"WPTavern: Loginizer Plugin Gets Forced Security Update for Vulnerabilities Affecting 1 Million Users";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:30:"https://wptavern.com/?p=106557";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:245:"https://wptavern.com/loginizer-plugin-gets-forced-security-update-for-vulnerabilities-affecting-1-million-users?utm_source=rss&utm_medium=rss&utm_campaign=loginizer-plugin-gets-forced-security-update-for-vulnerabilities-affecting-1-million-users";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:5484:"<p>WordPress.org has pushed out a forced security update for the <a href="https://wordpress.org/plugins/loginizer/">Loginizer</a> plugin, which is active on more than 1 million websites. The plugin offers brute force protection in its free version, along with other security features like two-factor auth, reCAPTCHA, and PasswordLess login in its commercial upgrade. </p>



<p>Last week security researcher Slavco Mihajloski <a href="https://wpdeeply.com/loginizer-before-1-6-4-sqli-injection/">discovered</a> an unauthenticated SQL injection vulnerability, and an XSS vulnerability, that he disclosed to the plugin&rsquo;s authors. Loginizer version 1.6.4 was released on October 16, 2020, with patches for the two issues, summarized on the plugin&rsquo;s blog: </p>



<blockquote class="wp-block-quote"><p>1) [Security Fix] : A properly crafted username used to login could lead to SQL injection. This has been fixed by using the prepare function in PHP which prepares the SQL query for safe execution.</p><p>2) [Security Fix] : If the IP HTTP header was modified to have a null byte it could lead to stored XSS. This has been fixed by properly sanitizing the IP HTTP header before using the same.</p></blockquote>



<p>Loginizer did not disclose the vulnerability until today in order to give users the time to upgrade. Given the severity of the vulnerability, the plugins team at WordPress.org pushed out the security update to all sites running Loginizer on WordPress 3.7+. </p>



<p>In July, 2020, Loginizer was <a href="https://loginizer.com/blog/loginizer-has-been-acquired-by-softaculous/">acquired by Softaculous</a>, so the company was also able to automatically upgrade any WordPress installations with Loginizer that had been created using Softaculous. This effort, combined with the updates from WordPress.org, covered a large portion of Loginizer&rsquo;s user base.</p>



<div class="wp-block-embed__wrapper">
<blockquote class="twitter-tweet"><p lang="en" dir="ltr">Any <a href="https://twitter.com/hashtag/WordPress?src=hash&ref_src=twsrc%5Etfw">#WordPress</a> install with <a href="https://twitter.com/loginizer?ref_src=twsrc%5Etfw">@loginizer</a> probably isn't using another WAF solution. As you can notice from the graph 600k+500k active installs were updated upside down, so &hellip; Preauth SQLi in it, reported by me. Update! Crunching write up :) <a href="https://t.co/gkEVWun9wt">https://t.co/gkEVWun9wt</a> <a href="https://t.co/XWXVMYO1ED">pic.twitter.com/XWXVMYO1ED</a></p>&mdash; mslavco (@mslavco) <a href="https://twitter.com/mslavco/status/1318059239332601856?ref_src=twsrc%5Etfw">October 19, 2020</a></blockquote>
</div>



<p>The automatic update took some of the plugin&rsquo;s users by surprise, since they had not initiated it themselves and had not activated automatic updates for plugins. After several users <a href="https://wordpress.org/support/topic/automatic-update-33/">posted</a> on the plugin&rsquo;s support forum, plugin team member Samuel Wood said that &ldquo;WordPress.org has the ability to turn on auto-updates for security issues in plugins&rdquo; and has used this capability many times.</p>



<p>Mihajloski <a href="https://wpdeeply.com/loginizer-before-1-6-4-sqli-injection/">published</a> a more detailed proof-of-concept on his blog earlier today. He also highlighted some concerns regarding the systems WordPress has in place that allowed this kind of of severe vulnerability to slip through the cracks. He claims the issue could have easily been prevented by the plugin review team since the plugin wasn&rsquo;t using the prepare function for safe execution of SQL queries. Mihajloski also recommended recurring code audits for plugins in the official directory.</p>



<p>&ldquo;When a plugin gets into the repository, it must be reviewed, but when is it reviewed again?&rdquo; Mihajloski said. &ldquo;Everyone starts with 0 active installs, but what happens on 1k, 10k, 50k, 100k, 500k, 1mil+ active installs?&rdquo;</p>



<p>Mihajloski was at puzzled how such a glaring security issue could remain in the plugin&rsquo;s code so long, given that it is a security plugin with an active install count that is more than many well known CMS&rsquo;s. The plugin also recently changed hands when it was acquired by Softaculus and had been audited by multiple security organizations, including <a href="https://blog.wpsec.com/sql-injection-and-csrf-security-vulnerability-in-loginizer/">WPSec</a> and <a href="https://blog.dewhurstsecurity.com/2018/05/22/loginizer-wordpress-plugin-xss-vulnerability.html">Dewhurst Security</a>.</p>



<p>Mihajloski also recommends that WordPress improve the transparency around <a href="https://wordpress.org/about/security/">security</a>, as some site owners and closed communities may not be comfortable with having their assets administered by unknown people at WordPress.org.</p>



<p>&ldquo;WordPress.org in general is transparent, but there isn&rsquo;t any statement or document about who, how and when decides about and performs automatic updates,&rdquo; Mihajloski said. &ldquo;It is kind of [like] holding all your eggs in one basket.</p>



<p>&ldquo;I think those are the crucial points that WP.org should focus on and everything will came into place in a short time: complete WordPress tech documentation for security warnings, a guide for disclosure of the bugs (from researchers, but also from a vendor aspect), and recurring code audits for popular plugins.&rdquo;</p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Thu, 22 Oct 2020 03:47:22 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:13:"Sarah Gooding";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:10;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:65:"Post Status: Joe Casabona on creating quality content and courses";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:31:"https://poststatus.com/?p=80099";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:76:"https://poststatus.com/joe-casabona-on-creating-quality-content-and-courses/";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:1407:"<p>David Bisset interviews Joe Casabona, an independent creator and teacher, and discusses what it's like to be a creator as his job, plus some news topics.</p>







<h3 id="h-links">Links</h3>



<ul><li>W3C <a href="https://wptavern.com/w3c-drops-wordpress-from-consideration-for-redesign-narrows-cms-shortlist-to-statamic-and-craft">drops WordPress</a> from consideration for its redesign</li><li>W3c <a href="https://wptavern.com/w3c-selects-craft-cms-for-redesign-project">selects Craft</a> and <a href="https://w3c.studio24.net/docs/cms-selection-report/">selection report</a></li><li><a href="https://www.youtube.com/watch?v=14RcHPfStA0">Disabling full screen mode</a></li><li><a href="https://creatorcourses.com/shop/">Creator Courses</a></li><li>How I Built It <a href="https://howibuilt.it/recording-notes/">recording notes</a></li><li><a href="https://reincubate.com/camo/">Camo</a></li></ul>



<h3>Partner: <a href="https://poststatus.com/sandhills">Sandhills Development</a></h3>



<p><a href="https://poststatus.com/sandhills">Sandhills Development</a> crafts ingenuity, developed with care:</p>



<ul><li>Easy Digital Downloads – Sell digital products with WordPress</li><li>AffiliateWP – A full-featured affiliate marketing solution</li><li>Sugar Calendar – WordPress event management made simple</li><li>WP Simple Pay – A lightweight Stripe payments plugin</li></ul>



<p></p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Wed, 21 Oct 2020 21:17:13 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:15:"Brian Krogsgard";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:11;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:104:"WPTavern: MakeStories 2.0 Launches Editor for WordPress, Rivaling Google’s Official Web Stories Plugin";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:30:"https://wptavern.com/?p=106327";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:245:"https://wptavern.com/makestories-2-0-launches-editor-for-wordpress-rivaling-googles-official-web-stories-plugin?utm_source=rss&utm_medium=rss&utm_campaign=makestories-2-0-launches-editor-for-wordpress-rivaling-googles-official-web-stories-plugin";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:8860:"<img />Recipe slide from the MakeStories WordPress plugin.



<p class="has-drop-cap">Earlier today, <a href="https://wordpress.org/plugins/makestories-helper/">MakeStories launched version 2.0</a> of its plugin for creating Web Stories with WordPress. In many ways, this is a new plugin launch. The previous version simply allowed users to connect their WordPress installs to the <a href="https://makestories.io/">MakeStories site</a>. With the new version, users can build and edit their stories directly from the WordPress admin.</p>



<p>Version 2.0 of the plugin still requires an account and a connection with the MakeStories.io website. However, it is simple to set up. Users can log in without leaving their WordPress admin interface. This API connection means that user-created Stories are stored on the MakeStories servers. If an end-user wanted to jump platforms from WordPress to something else, this would allow them to take their Stories with them.</p>



<p>&ldquo;One of the things we would like to assure is your content is still yours, and none of the user data is being consumed or analyzed by us,&rdquo; said Pratik Ghela, the founder and product manager at MakeStories. &ldquo;We only take enough data to help serve you better.&rdquo;</p>



<p>The plugin is a competing solution to the official <a href="https://wptavern.com/google-officially-releases-its-web-stories-for-wordpress-plugin">Web Stories plugin by Google</a>. While the two share similarities in the final output (they are built to utilize the same front-end format for creating Stories on the web), they take different paths to get there.</p>



<p>The two share similarities on the backend too. However, MakeStories may be more polished in some areas. For example, it allows users to zoom in on the small canvas area. Having the ability to reorder slides from the grid view also feels more intuitive.</p>



<p>&ldquo;The main unique selling proposition of our plugin is that it comes with a guarantee of the MakeStories team,&rdquo; said Ghela. &ldquo;We as a team have been building this for over two years, and we are proud to be one of the tools that has stood the test of time, and competition and is still growing at a very fast pace.&rdquo;</p>



<p>The team also wants to make the Story-creating process faster, safer, and rewarding. The goal is to cater to designers, developers, and content creators. Ghela also feels like his team&rsquo;s support turnaround time of a few hours will be the key to success and is a good reason for users to give this plugin a try before settling on something else.</p>



<p>&ldquo;We feel that our goal is to see Web Stories flourish,&rdquo; he said. &ldquo;And we may have different types of users looking out for various options. So, the official plugin from Google and the one from MakeStories at least opens up the options for users to choose from. And we feel that the folks at Google are also building a great editor, and, at the end of the day, it&rsquo;s up to the user to select what they feel is the best.</p>



<p>Technically, MakeStories is a SaaS (software as a service) product. Even though it is a free plugin, there will eventually be a commercial component to it. Currently, it is free at least until the first quarter of 2021, which may be extended based on various factors. There is no word on what pricing tiers may be available after that.</p>



<p>&ldquo;There will always be a free tier, and we have always stood for it that your data belongs to you,&rdquo; said Ghela. &ldquo;In case you do not like the pricing, we will personally assist you to port out from using our editor and still keep the data and everything totally intact.&rdquo;</p>



<h2>Diving Into the Plugin</h2>



<img />Story management screen.



<p class="has-drop-cap">MakeStories is a drag-and-drop editor for building Web Stories. It works and feels much like typical design editors like Gimp or Photoshop. It shares similarities with QuarkXPress or InDesign, for those familiar with page layout programs. In some ways, it feels a lot like a light-colored version of Google&rsquo;s Web Stories plugin with more features and a slightly more intuitive interface.</p>



<p>The end goal is simple: create a Story through designing slides/pages that site visitors will click through as the narrative unfolds.</p>



<p>The plugin provides a plethora of shapes, textures, and animations. These features are easy to find and implement. It also includes free access to images, GIFs, and videos. These are made possible via API integrations with Unsplash, Tenor, and Pexels.</p>



<p>MakeStories includes access to 10 templates at the moment. However, what makes this feature stand out is that end-users can create and save custom templates for reuse down the road.</p>



<img />Editing a Story from a predesigned template.



<p>One of the more interesting, almost hidden, features is the available text patterns. The plugin allows users to insert these patterns from a couple of dozen choices. This makes it easier to visualize a design without having to build everything from scratch.</p>



<img />Inserting a text pattern and adjusting its size.



<p>While the editing process is a carefully-crafted experience that makes the plugin worth a look, it is the actual publishing aspect of the workflow that is a bit painful. Traditional publishing in WordPress means hitting the &ldquo;publish&rdquo; button to make content live. This is not the case with the MakeStories plugin. It takes you through a four-step process of entering various publisher details, setting up metadata and SEO, validating the Story content, and analytics. It is not that these steps are necessarily bad. For example, MakeStories lets you know when images are missing alt text, which is needed information screen readers. The problem is that it feels out of place to go through all of these details when I, as a user, simply want my content published. And, many of these details, such as the publisher (author), should be automatically filled in.</p>



<p>Updating a Story is not as simple as hitting an &ldquo;update&rdquo; button either. The system needs to run through some of the same steps too.</p>



<p>Ghela said the publishing process might be a bit tough but will prove fruitful in the end. The plugin takes care of the technical aspects of adding title tags, meta, and other data on the front end after the user fills in the form fields.</p>



<p>&ldquo;We will definitely work on improving the flow as the community evolves and improve it a lot to be easier, faster, and, most importantly, still very customizable,&rdquo; he said.</p>



<p>The MakeStories team has no plans of stopping at its current point on the roadmap. Ghela sounded excited about some of the upcoming additions they are planning, including features like teams, branding, easy template customization, polls, and quizzes.</p>



<h2>On the Web Stories Format</h2>



<img /><a href="https://feature.undp.org/covid-and-poverty/">UN report on COVID-19 and poverty</a> published with MakeStories.



<p class="has-drop-cap">Many will ultimately hesitate to use any plugin that implements Web Stories given Google&rsquo;s history of dropping projects. There is also a feeling that the format is a bit of a fad and will not stand the test of time.</p>



<p>&ldquo;We greatly believe in AMP and Web Stories as a content format,&rdquo; said Ghela. &ldquo;We, as an agency, have been involved a lot in AMP and have done a lot of experiments with it, including a totally custom WooCommerce site in fully-native, valid AMP with support for variable products, subscriptions, and other functionalities.&rdquo;</p>



<p>The company is all-in on the format and feels like it will be around for the long term, particularly if there is a good ecosystem around monetization.</p>



<p>&ldquo;We think that the initial reactions are because there are not enough proven results and because we never imagined the story format to come to the web,&rdquo; said Ghela. &ldquo;There were definitely plugins that did this. Few folks tried to build stories using good ol&rsquo; HTML, CSS, and JavaScript. But, the performance and UX were not that great. On the other hand, the engineers at the AMP Team are making sure that everything is just perfect. The UX, load time, WCV Score, just everything.&rdquo;</p>



<p>He feels that some of the early criticisms are unwarranted and that the web development community should give the format a try and provide feedback.</p>



<p>&ldquo;The more data we all get, actually gives the AMP team a clear idea of what&rsquo;s needed, and they can design the roadmap accordingly,&rdquo; he said. &ldquo;So, just giving out early reactions won&rsquo;t help, but constructive criticism and getting back to the AMP team with what you are doing will.&rdquo;</p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Wed, 21 Oct 2020 21:12:31 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:14:"Justin Tadlock";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:12;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:40:"WordPress.org blog: WordPress 5.6 Beta 1";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:34:"https://wordpress.org/news/?p=9085";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:56:"https://wordpress.org/news/2020/10/wordpress-5-6-beta-1/";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:7956:"<p>WordPress 5.6 Beta 1 is now available for testing!</p>



<p><strong>This software is still in development,</strong>&nbsp;so we recommend that you run this version on a test site.</p>



<p>You can test the WordPress 5.6 beta in two ways:</p>



<ul><li>Try the&nbsp;<a href="https://wordpress.org/plugins/wordpress-beta-tester/">WordPress Beta Tester</a>&nbsp;plugin (choose the “bleeding edge nightlies” option).</li><li>Or&nbsp;<a href="https://wordpress.org/wordpress-5.6-beta1.zip">download the beta here&nbsp;(zip)</a>.</li></ul>



<p>The current target for final release is December 8, 2020. This is just&nbsp;<strong>seven weeks away</strong>, so your help is needed to ensure this release is tested properly.</p>



<h2><strong>Improvements in the Editor</strong></h2>



<p>WordPress 5.6 includes seven Gutenberg plugin releases. Here are a few highlighted enhancements:</p>



<ul><li>Improved support for video positioning in cover blocks.</li><li>Enhancements to Block Patterns including translatable strings.</li><li>Character counts in the information panel, improved keyboard navigation, and other adjustments to help users find their way better. </li><li>Improved UI for drag and drop functionality, as well as block movers.</li></ul>



<p>To see all of the features for each release in detail check out the release posts: <a href="https://make.wordpress.org/core/2020/07/22/whats-new-in-gutenberg-july-22/">8.6</a>, <a href="https://make.wordpress.org/core/2020/08/05/whats-new-in-gutenberg-august-5/">8.7</a>, <a href="https://make.wordpress.org/core/2020/08/19/whats-new-in-gutenberg-august-19/">8.8</a>, <a href="https://make.wordpress.org/core/2020/09/03/whats-new-in-gutenberg-2-september/">8.9</a>, <a href="https://make.wordpress.org/core/2020/09/16/whats-new-in-gutenberg-16-september/">9.0</a>, <a href="https://make.wordpress.org/core/2020/10/01/whats-new-in-gutenberg-30-september/">9.1</a>, and 9.2 <em>(link forthcoming)</em>.</p>



<h2><strong>Improvements in Core</strong></h2>



<h3><strong>A new default theme</strong></h3>



<p>The default theme is making its annual return with<a href="https://make.wordpress.org/core/2020/09/23/introducing-twenty-twenty-one/"> Twenty Twenty-One</a>. This theme features a streamlined and elegant design, which aims to be <a href="https://www.w3.org/TR/UNDERSTANDING-WCAG20/conformance.html#uc-levels-head">AAA ready</a>. </p>



<h3><strong>Auto-update option for major releases</strong></h3>



<p>The much anticipated opt-in for major releases of WordPress Core will ship in this release. With this functionality, you can elect to have major releases of the WordPress software update in the background with no additional fuss for your users. </p>



<h3><strong>Increased support for PHP 8</strong></h3>



<p>The next major version release of PHP, 8.0.0, is scheduled for release just a few days prior to WordPress 5.6. The WordPress project has a long history of being compatible with new versions of PHP as soon as possible, and this release is no different.</p>



<p>Because PHP 8 is a major version release, changes that break backward compatibility or compatibility for various APIs are allowed. Contributors have been hard at work <a href="https://make.wordpress.org/core/2020/10/06/call-for-testing-php-8-0/">fixing the known incompatibilities with PHP 8</a> in WordPress during the 5.6 release cycle.</p>



<p>While all of the detectable issues in WordPress can be fixed, you will need to verify that all of your plugins and themes are also compatible with PHP 8 prior to upgrading. Keep an eye on the <a href="https://make.wordpress.org/core/">Making WordPress Core blog</a> in the coming weeks for more detailed information about what to look for.</p>



<h3>Application Passwords for REST API Authentication</h3>



<p>Since the REST API was merged into Core, only cookie &amp; nonce based authentication has been available (without the use of a plugin). This authentication method can be a frustrating experience for developers, often limiting how applications can interact with protected endpoints.</p>



<p>With the introduction of <a href="https://make.wordpress.org/core/2020/09/23/proposal-rest-api-authentication-application-passwords/">Application Password</a> in WordPress 5.6, gone is this frustration and the need to jump through hoops to re-authenticate when cookies expire. But don&#8217;t worry, cookie and nonce authentication will remain in WordPress as-is if you&#8217;re not ready to change.</p>



<p>Application Passwords are user specific, making it easy to grant or revoke access to specific users or applications (individually or wholesale). Because information like &#8220;Last Used&#8221; is logged, it&#8217;s also easy to track down inactive credentials or bad actors from unexpected locations.</p>



<h3><strong>Better accessibility</strong></h3>



<p>With every release, WordPress works hard to improve accessibility. Version 5.6 is no exception and will ship with a number of accessibility fixes and enhancements. Take a look:</p>



<ul><li>Announce block selection changes manually on windows.</li><li>Avoid focusing the block selection button on each render.</li><li>Avoid rendering the clipboard textarea inside the button</li><li>Fix dropdown menu focus loss when using arrow keys with Safari and Voiceover</li><li>Fix dragging multiple blocks downwards, which resulted in blocks inserted in wrong position.</li><li>Fix incorrect aria description in the Block List View.</li><li>Add arrow navigation in Preview menu.</li><li>Prevent links from being focusable inside the Disabled component.</li></ul>



<h2><strong>How You Can Help</strong></h2>



<p>Keep your eyes on the&nbsp;<a href="https://make.wordpress.org/core/">Make WordPress Core blog</a>&nbsp;for&nbsp;<a href="https://make.wordpress.org/core/tag/5-6+dev-notes/">5.6-related developer notes</a>&nbsp;in the coming weeks, breaking down these and other changes in greater detail.</p>



<p>So far, contributors have fixed&nbsp;<a href="https://core.trac.wordpress.org/query?status=closed&milestone=5.6&group=component&max=500&col=id&col=summary&col=owner&col=type&col=priority&col=component&col=version&order=priority">188 tickets in WordPress 5.6</a>, including&nbsp;<a href="https://core.trac.wordpress.org/query?status=closed&status=reopened&type=enhancement&milestone=5.6&or&status=closed&status=reopened&type=feature+request&milestone=5.6&col=id&col=summary&col=type&col=status&col=milestone&col=owner&col=priority&col=changetime&col=keywords&order=changetime">82 new features and enhancements</a>, and more bug fixes are on the way.</p>



<h3>Do some testing!</h3>



<p>Testing for bugs is an important part of polishing the release during the beta stage and a great way to contribute.</p>



<p>If you think you’ve found a bug, please post to the&nbsp;<a href="https://wordpress.org/support/forum/alphabeta/">Alpha/Beta area</a>&nbsp;in the support forums. We would love to hear from you! If you’re comfortable writing a reproducible bug report,&nbsp;<a href="https://core.trac.wordpress.org/newticket">file one on WordPress Trac</a>. That’s also where you can find a list of&nbsp;<a href="https://core.trac.wordpress.org/tickets/major">known bugs</a>.</p>



<p><span><i>Props to&nbsp;</i><a href="https://profiles.wordpress.org/webcommsat/">@webcommsat</a><i>,&nbsp;</i><a href="https://profiles.wordpress.org/yvettesonneveld/">@yvettesonneveld</a><i>,&nbsp;</i><a href="https://profiles.wordpress.org/estelaris/">@estelaris</a><i>, </i><a href="https://profiles.wordpress.org/cguntur/">@cguntur</a><i>, <em><a href="https://profiles.wordpress.org/desrosj/">@desrosj</a></em>, and&nbsp;</i><a href="https://profiles.wordpress.org/marybaum/">@marybaum</a><i>&nbsp;for </i><em>editing/proof reading</em></span><em> this post, and&nbsp;<a href="https://profiles.wordpress.org/davidbaumwald/">@davidbaumwald</a>&nbsp;for final review.</em></p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Tue, 20 Oct 2020 22:14:22 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:7:"Josepha";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:13;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:74:"WPTavern: WordPress 5.6 Release Team Pulls the Plug on Block-Based Widgets";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:30:"https://wptavern.com/?p=106466";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:193:"https://wptavern.com/wordpress-5-6-release-team-pulls-the-plug-on-block-based-widgets?utm_source=rss&utm_medium=rss&utm_campaign=wordpress-5-6-release-team-pulls-the-plug-on-block-based-widgets";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:8762:"<img />Current block-based widgets admin screen design.



<p class="has-drop-cap">I was wrong. I assured our readers that &ldquo;the block-based widget system will be ready for prime time when WordPress 5.6 lands&rdquo; in my previous <a href="https://wptavern.com/are-block-based-widgets-ready-to-land-in-wordpress-5-6">post on the new feature&rsquo;s readiness</a>. I also said that was on the condition of not trying to make it work with the customizer &mdash; that experience was still broken. However, the 5.6 team pulled the plug on block-based widgets for the second time this year.</p>



<p>One week ago, WordPress 5.6 release lead Josepha Haden <a href="https://twitter.com/JosephaHaden/status/1316131424466952192">seemed to agree</a> that it would be ready. However, things can change quickly in a development cycle, and tough decisions have to be made with beta release deadlines.</p>



<p>This is not the first feature the team has punted to a future release. Two weeks ago, they dropped <a href="https://wptavern.com/navigation-screen-sidelined-for-wordpress-5-6-full-site-editing-edges-closer-to-public-beta">block-based nav menus </a>from the 5.6 feature list. Both features were <a href="https://wptavern.com/new-block-based-navigation-and-widgets-screens-sidelined-for-wordpress-5-5">originally planned for WordPress 5.5</a>.</p>



<p>A new Widgets admin screen has been under development <a href="https://github.com/WordPress/gutenberg/issues/13204">since January 2019</a>, which was not long after the initial launch of the block editor in WordPress 5.0. For now, the block-based widgets feature has been <a href="https://core.trac.wordpress.org/ticket/51506">punted to WordPress 5.7</a>. It has also been given the &ldquo;early&rdquo; tag, which means it should go into core WordPress soon after the 5.7 release cycle begins. This will give it more time to mature and more people an opportunity to test it.</p>



<p>Helen Hou-Sand&igrave;, the core tech lead for 5.6, <a href="https://core.trac.wordpress.org/ticket/51506#comment:15">provided a historical account</a> of the decision and why it was not ready for inclusion in the new ticket:</p>



<blockquote class="wp-block-quote"><p>My question for features that affect the front-end is &ldquo;can I try out this new thing without the penalty of messing up my site?&rdquo; &mdash; that is, user trust. At this current moment, given that widget areas are not displayed anything like what you see on your site without themes really putting effort into it and that you have to save your changes live without revisions to get an actual contextual view, widget area blocks do not allow you to try this new feature without penalizing you for experimenting.</p></blockquote>



<p>She went on to say that the current experience is subpar at the moment. Problems related to the customizer experience, which I <a href="https://wptavern.com/gutenberg-8-9-brings-block-based-widgets-out-of-the-experimental-stage">covered in detail</a> over a month ago, were also mentioned.</p>



<p>&ldquo;So, when we come back to this again, let&rsquo;s keep sight of what it means to keep users feeling secure that they can get their site looking the way they want with WordPress, and not like they are having to work around what we&rsquo;ve given them,&rdquo; said Hou-Sand&igrave;.</p>



<p>This is a hopeful outlook despite the tough decision. Sometimes, these types of calls need to be made for the good of the project in the long term. Pushing back a feature to a future version for a better user experience can be better than launching early with a subpar experience.</p>



<p>&ldquo;The good part of this is that now widgets can continue to be &lsquo;re-imagined&rsquo; for 5.7, and get even more enhancements,&rdquo; <a href="https://core.trac.wordpress.org/ticket/51506#comment:17">said lead WordPress developer Andrew Ozz</a> in the ticket. &ldquo;Not sure how many people have tested this for a bit longer but having blocks in the widgets areas (a.k.a. sidebars) opens up many new possibilities and makes a lot of the old, limited widgets obsolete. The &lsquo;widget areas&rsquo; become something like &lsquo;specialized posts with more dynamic content,&rsquo; letting users (and designers) do a lot of stuff that was either hard or impossible with the old widgets.&rdquo;</p>



<p>After the letdown of seeing one of my most anticipated features of 5.6 being dropped, it is encouraging to see the positive outlook from community leaders on the project.</p>



<p>&ldquo;You know, I was really hopeful for it too, and that last-minute call was one I labored over,&rdquo; said Haden. &ldquo;When I last looked, it did seem close to ready, but then more focused testing was done and there were some interactions that are a little rough for users. I&rsquo;m grateful for that because the time to discover painful user experiences is before launch rather than after!&rdquo;</p>



<p>Despite dropping its second major feature, WordPress 5.6 still has some big highlights that will be shipping in less than two months. The new <a href="https://wptavern.com/first-look-at-twenty-twenty-one-wordpresss-upcoming-default-theme">Twenty Twenty-One theme</a> looks to be a breath of fresh air and will explore block-related features not seen in previous default themes. Haden also pointed out auto-updates for major releases, <a href="https://wptavern.com/wordpress-5-6-to-introduce-application-passwords-for-rest-api-authentication">application passwords support</a> for the REST API, and accessibility improvements as features to look forward to.</p>



<p>WordPress 5.6 Beta 1 is expected to ship today.</p>



<h2>Adding New Features To an Old Project</h2>



<p class="has-drop-cap">At times, it feels like the Gutenberg project has bitten off more than it can chew. Many of the big feature plans continually miss projections. Between full-site editing, global styles, widgets, nav menus, and much more, it is tough to get hyper-focused on one feature and have it ready to ship. On the other hand, too much focus one way can be to the detriment to other features in the long run. All of these pieces must eventually come together to create a more cohesive whole.</p>



<p>WordPress is also <a href="https://wptavern.com/happy-17th-wordpress">17 years old</a>. Any new feature could affect legacy features or code. The goal for block-based widgets is to transition an existing feature to work within a new system without breaking millions of websites in the process. Twenty-one months of work on a single feature shows that it is not an easy problem to solve.</p>



<p>&ldquo;You are so right about complex engineering problems!&rdquo; said Haden. &ldquo;We are now at a point in the history of the project where connecting all of the pieces can have us facing unforeseen complications.&rdquo;</p>



<p>The project also needs to think about how it can address some of the issues it has faced with not quite getting major features to completion. Is the team stretched too thin to focus on all the parts? Are there areas we can improve to push features forward?</p>



<p>&ldquo;There will be a retrospective where we can identify what parts of our process can be improved in the future, but I also feel like setting stretch goals is good for any software project,&rdquo; said Haden. &ldquo;Many contributors have a sense of urgency around bringing the power of blocks to more spaces in WordPress, which I share, but when it&rsquo;s time to ship, we have to balance that with our deep commitment to usability.&rdquo;</p>



<p>One problem that has become increasingly obvious is that front-end editing has become tougher over the years. Currently, widgets and nav menus can be edited in two places in WordPress with wildly different interfaces. Full-site editing stands to add an entirely new interface to the mix.</p>



<p>&ldquo;I think one of the problems that we&rsquo;re trying to solve with Gutenberg has always been a more consistent experience for editing elements across the WordPress interface,&rdquo; said Haden. &ldquo;No user should have to learn five different workflows to make sure their page looks the way they imagined it when it&rsquo;s published.&rdquo;</p>



<p>In the meantime, which may be numbered in years, end-users will likely have these multiple interfaces to deal with &mdash; overlap while new features are being developed. This may simply be a necessary growing pain of an aging project, one that is trying to lead the pack of hungry competitors in the CMS space.</p>



<p>&ldquo;There&rsquo;s a lot of interest in reducing the number of workflows, and I&rsquo;m hopeful that we can consolidate down to just one beautiful, intuitive interface,&rdquo; said Haden.</p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Tue, 20 Oct 2020 21:16:23 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:14:"Justin Tadlock";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:14;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:87:"WPTavern: WooCommerce Tests New Instagram Shopping Checkout Feature, Now in Closed Beta";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:30:"https://wptavern.com/?p=106398";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:217:"https://wptavern.com/woocommerce-tests-new-instagram-shopping-checkout-feature-now-in-closed-beta?utm_source=rss&utm_medium=rss&utm_campaign=woocommerce-tests-new-instagram-shopping-checkout-feature-now-in-closed-beta";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:2878:"<p>Instagram&rsquo;s checkout feature, which allows users to purchase products without leaving the app, has become an even more important part of Facebook&rsquo;s long-term investment in e-commerce now that the pandemic has so heavily skewed consumer behavior towards online shopping. When Instagram <a href="https://business.instagram.com/blog/new-to-instagram-shopping-checkout">introduced</a> checkout in 2019, it reported that 130 million users were tapping to reveal product tags in shopping posts every month.</p>



<img />image credit: Instagram



<p>Business owners who operate an existing store can extend their audience to Instagram by funneling orders from the social network into their own stores, without shoppers having to leave Instagram. Checkout supports integration with several e-commerce platform partners, including Shopify and BigCommerce, and will soon be available for WooCommerce merchants.</p>



<p>WooCommerce is testing a new Instagram Shopping Checkout feature for its <a href="https://woocommerce.com/products/facebook/">Facebook for WooCommerce</a> plugin. The free extension is used on more than 900,000 websites and will provide the bridge for store owners who want to tap into Instagram&rsquo;s market. The checkout capabilities are currently in closed beta. Anyone interested to test the feature can <a href="https://docs.google.com/forms/d/e/1FAIpQLSfHwcCJf1UYi_7PGmFSXJXPfhdM8rkVlXAKub1qD5EBT9dFWw/viewform">sign up</a> for consideration. Businesses registered in the USA that meet certain other requirements may be selected to participate, and the beta is also expanding to other regions soon.</p>



<p>WooCommerce currently supports <a href="https://woocommerce.com/posts/instagram-shopping/">shoppable posts</a>, which are essentially products sourced from a product catalog created on Facebook that are then linked to the live store through an Instagram business account. Instagram&rsquo;s checkout takes it one step further to provide a native checkout experience inside the app. Merchants pay no selling fees&nbsp;until December 31, 2020. After that time, the fee is <a href="https://www.facebook.com/business/help/223030991929920?id=533228987210412">5% per shipment</a> or a flat fee of $0.40 for shipments of $8.00 or less.&nbsp;</p>



<p>On the customer side, shoppers only have to enter their information once and thereafter it is stored for future Instagram purchases. Instagram also pushes shipment and delivery notifications inside the app. Store owners will need to weigh whether the convenience of the in-app checkout experience is worth forking over 5% to Facebook, or if they prefer funneling users over to the live store instead.</p>



<p>Instagram Shopping Checkout is coming to WooCommerce in the near future but the company has not yet announced a launch date, as the feature is just now entering closed beta. </p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Tue, 20 Oct 2020 04:13:28 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:13:"Sarah Gooding";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:15;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:65:"WPTavern: Past Twenty* WordPress Themes To Get New Block Patterns";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:30:"https://wptavern.com/?p=106396";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:173:"https://wptavern.com/past-twenty-wordpress-themes-to-get-new-block-patterns?utm_source=rss&utm_medium=rss&utm_campaign=past-twenty-wordpress-themes-to-get-new-block-patterns";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:6608:"<p class="has-drop-cap">Mel Choyce-Dwan, the Default Theme Design Lead for WordPress 5.6, kick-started 10 tickets around two months ago that would bring new features to the old default WordPress themes. The proposal is to add unique block patterns, a feature added to WordPress 5.5, to all of the previous 10 Twenty* themes. It is a lofty goal that could breathe some new life into old work from the previous decade.</p>



<p>Currently, only the last four themes are marked for an update by the time WordPress 5.6 lands. Previous themes are on the list to receive their block patterns in a future release. For developers and designers interested in getting involved, the following is a list of the Trac tickets for each theme:</p>



<ul><li><a href="https://core.trac.wordpress.org/ticket/51098">Twenty Twenty</a> &ndash; 5.6</li><li><a href="https://core.trac.wordpress.org/ticket/51099">Twenty Nineteen</a> &ndash; 5.6</li><li><a href="https://core.trac.wordpress.org/ticket/51100">Twenty Seventeen</a> &ndash; 5.6</li><li><a href="https://core.trac.wordpress.org/ticket/51101">Twenty Sixteen</a> &ndash; 5.6</li><li><a href="https://core.trac.wordpress.org/ticket/51102">Twenty Fifteen</a> &ndash; Future release</li><li><a href="https://core.trac.wordpress.org/ticket/51103">Twenty Fourteen</a> &ndash; Future release</li><li><a href="https://core.trac.wordpress.org/ticket/51104">Twenty Thirteen</a> &ndash; Future release</li><li><a href="https://core.trac.wordpress.org/ticket/51105">Twenty Twelve</a> &ndash; Future release</li><li><a href="https://core.trac.wordpress.org/ticket/51106">Twenty Eleven</a> &ndash; Future release</li><li><a href="https://core.trac.wordpress.org/ticket/51107">Twenty Ten</a> &ndash; Future release</li></ul>



<p>If you are wondering where Twenty Eighteen is in that list, that theme does not actually exist. It is the one missing year the WordPress community has had since the one-default-theme-per-year era began with Twenty Ten. It is easy to forget that we did not get a new theme for the 2017-2018 season. With all that has happened in the world this year, we should count ourselves fortunate to see a <a href="https://wptavern.com/first-look-at-twenty-twenty-one-wordpresss-upcoming-default-theme">new default theme land for WordPress</a> this December. WordPress updates and its upcoming default theme are at least one consistency that we have had in an otherwise chaotic time.</p>



<p>More than anything, it is nice to see some work going toward older themes &mdash; not just in terms of bug fixes but feature updates. The older defaults are still a part of the face of WordPress. Twenty Twenty and Twenty Seventeen each have over one million active installs. Twenty Nineteen has over half a million. The other default themes also have significant user bases in the hundreds of thousands &mdash; still some of the most-used themes in the directory. We owe it to those themes&rsquo; users to keep them fresh, at least as long as they maintain such levels of popularity.</p>



<p>This is where the massive theme development community could pitch in. Do some testing of the existing patches. Write some code for missing patterns or introduce new ideas. This is the sort of low-hanging fruit that almost anyone could take some time to help with.</p>



<h2>First Look at the New Patterns</h2>



<p class="has-drop-cap">None of the proposed patterns have landed in trunk, the development version of WordPress, yet. However, several people have created mockups or added patches that could be committed soon.</p>



<p>One of my favorite patterns to emerge thus far is from Beatriz Fialho for the Twenty Nineteen theme. Fialho has created many of the pattern designs proposed thus far, but this one, in particular, stands out the most. It is a simple two-column, two-row pattern with a circular image, heading, and paragraph for each section. Its simplicity fits in well with the more elegant, business-friendly look of the Twenty Nineteen theme.</p>



<img />Services pattern for Twenty Nineteen.



<p>It is also fitting that Twenty Nineteen get a nice refresh with new patterns because it was the default theme to launch with the block editor. Ideally, it would continually be updated to showcase block-related features.</p>



<p>While many people will focus on some of the more recent default themes, perhaps the most interesting one is a bit more dated. Twenty Thirteen was meant to showcase the new post formats feature in WordPress 3.6. According to Joen Asmussen, the theme&rsquo;s primary designer, the original idea was for users to compose a ribbon of alternating colors as each post varied its colors.</p>



<p>&ldquo;The alternating ribbon of colors did not really come to pass because post formats were simply not used enough to create an interesting ribbon,&rdquo; he wrote in the Twenty Thirteen ticket. &ldquo;However, perhaps for block patterns, we have an opportunity to revisit those alternating ribbons of colors. In other words, I&rsquo;d love to see those warm bold colors used in big swathes that take up the whole pattern background.&rdquo;</p>



<ul><li class="blocks-gallery-item"><img /></li><li class="blocks-gallery-item"><img /></li><li class="blocks-gallery-item"><img /></li><li class="blocks-gallery-item"><img /></li></ul>Patterns designed to match post formats.



<p>This could be a fun update for end-users who are still using <s>that feature that shall not be named</s> post formats.</p>



<p>There is a lot to like about many of the pattern mockups so far. I look forward to seeing what lands along with WordPress 5.6 and in future updates.</p>



<h2>Establishing Pattern Category Standard</h2>



<p class="has-drop-cap">With the more recent Twenty Twenty-One theme&rsquo;s block patterns and the new patterns being added to some of the older default themes, it looks like a specific pattern category naming scheme is starting to become a standard. Of the patches thus far, each is creating a new pattern category named after the theme itself.</p>



<p>This makes sense. Allowing users to find all of their theme&rsquo;s patterns in one location means that they can differentiate between them and those from core or other plugins. Third-party theme authors should follow suit and stick with this convention for the same reason.</p>



<p>Developers can also define multiple categories for a single pattern. This allows theme authors to create a category that houses all of their patterns in one location. However, they can also split them into more appropriate context-specific categories for discoverability.</p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Mon, 19 Oct 2020 21:13:28 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:14:"Justin Tadlock";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:16;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:89:"WPTavern: Using the Web Stories for WordPress Plugin? You Better Play By Google’s Rules";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:30:"https://wptavern.com/?p=105848";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:215:"https://wptavern.com/using-the-web-stories-for-wordpress-plugin-you-better-play-by-googles-rules?utm_source=rss&utm_medium=rss&utm_campaign=using-the-web-stories-for-wordpress-plugin-you-better-play-by-googles-rules";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:4080:"<img />Web Stories dashboard screen in WordPress.



<p class="has-drop-cap">What comes as a surprise to few, Google has updated its <a href="https://developers.google.com/search/docs/guides/web-stories-content-policy">content guidelines</a> for its Web Stories format. For users of its recently-released <a href="https://wordpress.org/plugins/web-stories/">Web Stories for WordPress</a> plugin, they will want to follow the extended rules for their Stories to appear in the &ldquo;richer experiences&rdquo; across Google&rsquo;s services. This includes the grid view on Search, Google Images, and Google Discover&rsquo;s carousel.</p>



<p>Google <a href="https://wptavern.com/google-officially-releases-its-web-stories-for-wordpress-plugin">released its Web Stories plugin</a> in late September to the WordPress community. It is a drag-and-drop editor that allows end-users to create custom Stories from a custom screen in their WordPress admin.</p>



<div class="wp-block-image"><img />Visual Stories on Search.</div>



<p>The plugin does not directly link to Google&rsquo;s content guidelines anywhere. For users who do not do a little digging, they may be caught unaware if their stories are not surfaced in various Google services.</p>



<p>On top of the Discover and Webmaster guidelines, Web Stories have six additional restrictions related to the following:</p>



<ul><li>Copyrighted content</li><li>Text-heavy Web Stories</li><li>Low-quality assets</li><li>Lack of narrative</li><li>Incomplete stories</li><li>Overly commercial</li></ul>



<p>While not using copyrighted content is one of those reasonably-obvious guidelines, the others could trip up some users. Because Stories are meant to represent bite-sized bits of information on each page, they may become ineligible if most pages have more than 180 words of text. Videos should also be limited to fewer than 60 seconds on each page.</p>



<p>Low-quality media could be a flag for Stories too. Google&rsquo;s guidelines point toward &ldquo;stretched out or pixelated&rdquo; media that negatively impacts the reader&rsquo;s experience. They do not offer any specific resolution guidelines, but this should mostly be a non-issue today. The opposite issue is far more likely &mdash; users uploading media that is too large and not optimized for viewing on the web.</p>



<p>The &ldquo;lack of narrative&rdquo; guideline is perhaps the vaguest, and it is unclear how Google will monitor or police <em>narrative</em>. However, the Stories format is about storytelling.</p>



<p>&ldquo;Stories are the key here imo,&rdquo; wrote Jamie Marsland, founder of Pootlepress, in a <a href="https://twitter.com/pootlepress/status/1309020235102597122">Twitter thread</a>. &ldquo;Now we have an open format to tell Stories, and we have an open platform (WordPress) where those Stories can be told easily.&rdquo;</p>



<p>Google specifically states that Stories need a &ldquo;binding theme or narrative structure&rdquo; from one page to the next. Essentially, the company is telling users to use the format for the purpose it was created for. They also do not want users to create incomplete stories where readers must click a link to finish the Story or get information.</p>



<img /><a href="https://www.cnn.com/ampstories/entertainment/john-lennon-remembering-the-great-musician">CNN&rsquo;s Web Story on Remembering John Lennon.</a>



<p>Overly commercial Stories are frowned upon too. While Google will allow affiliate marketing links, they should be restricted to a minor part of the experience.</p>



<p>Closing his Twitter thread, Marsland seemed to hit the point. &ldquo;I&rsquo;ve seen some initial Google Web Stories where the platform is being used as a replacement for a brochure or website,&rdquo; he wrote. &ldquo;In my view that&rsquo;s a huge missed opportunity. If I was advising brands I would say &lsquo;Tell Stories&rsquo; this is a platform for Story Telling.&rdquo;</p>



<p>If users of the plugin follow this advice, their Stories should surface on Google&rsquo;s rich search experiences.</p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Fri, 16 Oct 2020 20:51:21 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:14:"Justin Tadlock";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:17;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:45:"WPTavern: Stripe Acquires Paystack for $200M+";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:30:"https://wptavern.com/?p=106269";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:131:"https://wptavern.com/stripe-acquires-paystack-for-200m?utm_source=rss&utm_medium=rss&utm_campaign=stripe-acquires-paystack-for-200m";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:3196:"<p>The big news in the world of e-commerce today is Stripe&rsquo;s acquisition of <a href="https://paystack.com/">Paystack</a>, a Nigeria-based payments system that is widely used throughout African markets. The company, which became informally known as &ldquo;<a href="https://techcrunch.com/2018/08/28/paystack-with-ambitions-to-become-the-stripe-of-africa-raises-8m-from-visa-tencent-and-stripe-itself/">the Stripe of Africa</a>&rdquo; picked up $8 million in Series A funding in 2018, led by Stripe, Y Combinator, and Tencent. Paystack has grown to power more than 60,000 businesses, including FedEx, UPS, MTN, the Lagos Internal Revenue Service, and AXA Mansar.</p>



<p>Stripe&rsquo;s acquisition of the company is rumored to be more than $200M, a small price to pay for a foothold in emerging African markets. In the company&rsquo;s <a href="https://stripe.com/newsroom/news/paystack-joining-stripe">announcement</a>, Stripe noted that African online commerce is growing 21% year-over-year, 75% faster than the global average. Paystack dominates among payment systems, accounting for more than half of all online transactions in Nigeria.  </p>



<p>&ldquo;In just five years, Paystack has done what many companies could not achieve in decades,&rdquo; Stripe EMEA business lead Matt Henderson said. &ldquo;Their tech-first approach, values, and ambition greatly align with our own. This acquisition will give Paystack resources to develop new products, support more businesses and consolidate the hyper-fragmented African payments market.&rdquo;</p>



<p>Long term, Stripe plans to embed Paystack&rsquo;s capabilities in its Global Payments and Treasury Network (GPTN), the company&rsquo;s programmable infrastructure for global money movement.</p>



<p>&ldquo;Paystack merchants and partners can look forward to more payment channels, more tools, accelerated geographic expansion, and deeper integrations with global platforms,&rdquo; Paystack CEO and co-founder Shola Akinlade said. He also assured customers that there&rsquo;s no need to make any changes to their technical integrations, as Paystack will continue expanding and operating independently in Africa.</p>



<p>Paystack is used as a payment gateway for thousands of WordPress-powered stores through plugins for WooCommerce, Easy Digital Downloads, Paid Membership Pro, Give, Contact Form 7, and an assortment of booking plugins. The company has an official WordPress plugin, <a href="https://wordpress.org/plugins/payment-forms-for-paystack/">Payment Forms for Paystack</a>, which is active on more than 6,000 sites, but most users come through the <a href="https://wordpress.org/plugins/woo-paystack/">Paystack WooCommerce Payment Gateway</a> (20,000+ active installations). </p>



<p>Stripe&rsquo;s acquisition was a bit of positive news during what is currently a turbulent time in Nigeria, as citizens are actively engaged in peaceful protests to end police brutality. Paystack&rsquo;s journey is an encouraging example of the flourishing Nigerian tech ecosystem and the possibilities available for smaller e-commerce companies that are solving problems and removing barriers for businesses in emerging markets. </p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Thu, 15 Oct 2020 22:26:04 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:13:"Sarah Gooding";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:18;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:50:"WPTavern: Diving Into the Book Review Block Plugin";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:30:"https://wptavern.com/?p=106273";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:145:"https://wptavern.com/diving-into-the-book-review-block-plugin?utm_source=rss&utm_medium=rss&utm_campaign=diving-into-the-book-review-block-plugin";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:6791:"<p class="has-drop-cap">Created by Donna Peplinskie, a Product Wrangler at Automattic, the <a href="https://wordpress.org/plugins/book-review-block">Book Review Block</a> plugin is nearly three years old. However, it only came to my attention during a recent excursion to find interesting block plugins.</p>



<p>The plugin does pretty much what it says on the cover. It is designed to review books. It generally has all the fields users might need to add to their reviews, such as a title, author, image, rating, and more. The interesting thing is that it can automatically fill in those details with a simple ISBN value. Plus, it supports Schema markup, which may help with SEO.</p>



<p>Rain or shine, sick or well, I read every day. I am currently a month and a half shy of a two-year reading streak. When the mood strikes, I even venture to write a book review. As much as I want to share interesting WordPress projects with the community, I sometimes have personal motives for testing and writing about plugins like Book Review Block. Anything that might help me or other avid readers share our thoughts on the world of literature with others is of interest.</p>



<p>Admittedly, I was excited as I plugged in the ISBN for <em>Rhthym of War</em>, the upcoming fourth book of my favorite fantasy series of all time, <em>The Stormlight Archive</em>. I merely needed to click the &ldquo;Get Book Details&rdquo; button.</p>



<p>Success! The plugin worked its magic and pulled in the necessary information. It had my favorite author&rsquo;s name, the publisher, the upcoming release date, and the page count. It even had a long description, which I could trim down in the editor.</p>



<img />Default output of the Book Review block.



<p>There was a little work to make this happen before the success. To automatically pull in the book details, end-users must have an <a href="https://console.developers.google.com/flows/enableapi?apiid=books.googleapis.com&keyType=CLIENT_SIDE&reusekey=true">API Key</a> from Google. It took me around a minute to set that up and enter it into the field available in the block options sidebar. The great thing about the plugin is that it saves this key so that users do not have to enter each time they want to review a book.</p>



<p>Book Review Block a good starting point. It is straightforward and simple to use. It is not yet at a point where I would call it a <em>great</em> plugin. However, it could be.</p>



<h2>Falling Short</h2>



<p class="has-drop-cap">The plugin&rsquo;s Book Review block should be taking its cues from the core Media &amp; Text block. When you get right down to it, the two are essentially doing the same thing visually. Both are blocks with an image and some content sitting next to each other.</p>



<p>The following is a list of items where it should be following core&rsquo;s lead:</p>



<ul><li>No way to edit alt text (book title is automatically used).</li><li>The image is always aligned left and the content to the right with no way to flip them.</li><li>The media and content are not stackable on mobile views.</li><li>Cannot adjust the size of the image or content columns.</li><li>While inline rich-text controls are supported, users cannot add Heading, List, or Paragraph blocks to the content area and use their associated block options.</li></ul>



<p>That is the shortlist that could offer some quick improvements to the user experience. Ultimately, the problems with the plugin essentially come down to not offering a way to customize the output.</p>



<p>One of the other consistent problems is that the book image the plugin loads is always a bit small. This seems to be more of an issue from the Google Books API than the plugin. Each time I tested a book, I opted to add a larger image &mdash; the plugin does allow you to replace the default.</p>



<p>The color settings are limited. The block only offers a background color option with no way to adjust the text color. A better option for plugin users is to wrap it in a Group block and adjust the background and text colors there.</p>



<img />Book Review block wrapped inside a Group block.



<p>It would also be nice to have wide and full-alignment options, which is an often-overlooked featured from many block plugin authors.</p>



<h2>Using the Media &amp; Text Block to Recreate the Book Review Block</h2>



<p class="has-drop-cap">The Book Review Block plugin has a lot of potential, and I want to see it evolve by providing more flexibility to end-users. Because the Media &amp; Text block is the closest core block to what the plugin offers, I decided to recreate a more visually-appealing design with it.</p>



<img />Book review section created with the Media &amp; Text block.



<p>I made some adjustments on the content side of things. I used the Heading block for the book title, a List block for the book metadata, and a Paragraph block for the description.</p>



<p>The Media &amp; Text block also provided me the freedom to adjust the alignment, stack the image and content on mobile views, and tinker with the size of the image. Plus, it has that all-important field for customizing the image alt attribute.</p>



<p>The Media &amp; Text block gave me much more design mileage.</p>



<p>However, there are limitations to the core block. It does not fully capture some of the features available via the Book Review block. The most obvious are the automatic book details via an ISBN and the Schema markup. Less obvious, there is no easy way to recreate the star rating &mdash; I used emoji stars &mdash; and long description text does not wrap under the image. To recreate that, you would have to opt to use a left-aligned image followed by content.</p>



<p>Overall, the Media &amp; Text block gives me the ability to better style the output, which is what I am more interested in as a user. I want to put my unique spin on things. That is where the Book Review Plugin misfires. It is also the sort of thing that the plugin author can iterate on, offering more flexibility in the future.</p>



<p>This is where many block plugins go wrong, particularly when there is more than one or two bits of data users should enter. Blocks represent freedom in many ways. However, when plugin developers stick to a rigid structure, users can sometimes lose that sense of freedom that they would otherwise have with building their pages.</p>



<p>One of the best blocks, hands down, that preserves that freedom is from the <a href="https://wptavern.com/start-a-recipe-blog-with-the-recipe-block-wordpress-plugin">Recipe Block plugin</a>. It has structured inputs and fields. However, it allows freeform content for end-users to make it their own.</p>



<p>When block authors push beyond this rigidness, users win.</p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Thu, 15 Oct 2020 20:44:04 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:14:"Justin Tadlock";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:19;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:87:"WPTavern: WooCommerce 4.6 Makes New Home Screen the Default for New and Existing Stores";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:30:"https://wptavern.com/?p=106242";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:219:"https://wptavern.com/woocommerce-4-6-makes-new-home-screen-the-default-for-new-and-existing-stores?utm_source=rss&utm_medium=rss&utm_campaign=woocommerce-4-6-makes-new-home-screen-the-default-for-new-and-existing-stores";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:3018:"<p><a href="https://developer.woocommerce.com/2020/10/14/woocommerce-4-6-is-now-available/">WooCommerce 4.6</a> was released today. The minor release dropped during <a href="https://woosesh.com/">WooSesh</a>, a global, virtual conference dedicated to WooCommerce and e-commerce topics. It features the new home screen as the default for all stores. Previously, the screen was only the default on new stores. Existing store owners had to turn the feature on in the settings.</p>



<div class="wp-block-image"><img /></div>



<p>The updated home screen, originally introduced in version 4.3, helps store admins see activity across the site at a glance and includes an inbox, quick access to store management links, and an overview of stats on sales, orders, and visitors. This redesigned virtual command center arrives not a moment too soon, as anything that makes order management more efficient is a welcome improvement, due to the sheer volume of sales increases that store owners have seen over the past eight months.</p>



<p>In stark contrast to industries like hospitality and entertainment that have proven to be more vulnerable during the pandemic, e-commerce has seen explosive growth. During the State of the Woo address at WooSesh 2020, the WooCommerce team shared that e-commerce is currently estimated to be a $4 trillion market that will grow to $4.5 trillion by 2021. WooCommerce accounts for a sizable chunk of that market with an estimated total payment volume for 2020 projected to reach $20.6 billion, a 74% increase compared to 2019.</p>



<p>The WooCommerce community is on the forefront of that growth and is deeply invested in the products that are driving stores&rsquo; success. The WooCommerce team shared that 75% of people who build extensions also build and maintain stores for merchants, and 70% of those who build stores for merchants also build and maintain extensions or plugins. In 2021, they plan to invest heavily in unlocking more features in more countries and will make WooCommerce Payments the native payment method for the global platform.</p>



<p>A new report from eMarketer shows that <a href="https://www.emarketer.com/content/us-ecommerce-growth-jumps-more-than-30-accelerating-online-shopping-shift-by-nearly-2-years">US e-commerce growth has jumped 32.4%</a>, accelerating the online shopping shift by nearly two years. Experts also predict the top 10 e-commerce players will swallow up more of US retail spending to account for 63.2% of all online sales this year, up from 57.9% in 2019. </p>



<p>The increase in e-commerce spending may not be entirely tied to the pandemic, as some experts believe this historic time will mark permanent changes in consumer spending habits. This is where independent stores, powered by WooCommerce and other technologies, have the opportunity to establish a strong reputation for themselves by providing quality products and reliable service, as well as by being more nimble in the face of pandemic-driven increases in volume.</p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Thu, 15 Oct 2020 03:48:32 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:13:"Sarah Gooding";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:20;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:101:"WPTavern: The Future of Starter Content: WordPress Themes Need a Modern Onboarding and Importing Tool";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:30:"https://wptavern.com/?p=106177";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:245:"https://wptavern.com/the-future-of-starter-content-wordpress-themes-need-a-modern-onboarding-and-importing-tool?utm_source=rss&utm_medium=rss&utm_campaign=the-future-of-starter-content-wordpress-themes-need-a-modern-onboarding-and-importing-tool";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:7385:"<img />Image credit: <a href="https://www.pexels.com/photo/notebook-beside-the-iphone-on-table-196644/">picjumbo.com on Pexels</a>.



<p class="has-drop-cap">Starter content. It was a grand idea, one of those big dreams of WordPress. It was the <a href="https://make.wordpress.org/core/2016/11/30/starter-content-for-themes-in-4-7/">new kid on the block in late 2016</a>. Like the introduction of post formats in 2011, the developer community was <em>all in</em> for at least that particular release version. Then, it was on to the next new thing, with the feature dropping off the radar for all but the most ardent evangelists. </p>



<p>Some of us were burned over the years, living and dying by the progress of features that we wanted most.</p>



<p>Released in WordPress 4.7, starter content has since seemed to be going the way of post formats. After four years, only <a href="https://wpdirectory.net/search/01EMM14PBRE6K8P1Z08KXQQ76D">141 themes</a> in the WordPress theme directory support the feature. There has been no movement to push it beyond its initial implementation. And, it never <em>really</em> covered the things that theme authors wanted in the first place. It was a start. But, themers were ultimately left to their own devices, rolling custom solutions for something that never panned out &mdash; fully-featured demo and imported content. Four years is an eternity in the web development world, and there is no sense in waiting around to see if WordPress would push forward.</p>



<p>Until Helen Hou-Sand&iacute; published <a href="https://make.wordpress.org/core/2020/10/06/revisiting-starter-content-on-org-and-beyond/">Revisiting Starter Content</a> last week, most would have likely assumed the feature would be relegated to legacy code used by old-school fans of the feature and those theme authors who consider themselves completionists.</p>



<p>&ldquo;Starter content in 4.7 was always meant to be a step one, not the end goal or even the resting point it&rsquo;s become,&rdquo; wrote Hou-Sand&iacute;. &ldquo;There are still two major things that need to be done: themes should have a unified way of showing users how best to put that theme to use in both the individual site and broader preview contexts, and sites with existing content should also be able to take advantage of these sort of &lsquo;ideal content&rsquo; definitions.&rdquo;</p>



<p>Step two should have been this <a href="https://core.trac.wordpress.org/ticket/38624">four-year-old accompanying ticket</a> to allow users to import starter content into existing, non-<em>fresh</em> sites.</p>



<p>Since the initial feature dropped, the theme landscape has changed. Let&rsquo;s face it. WordPress might simply not be able to compete with theme companies that are pushing the limits, creating experiences that users want at much swifter speeds.</p>



<p>Look at where the Brainstorm Force&rsquo;s <a href="https://wordpress.org/plugins/astra-sites/">Starter Templates</a> plugin for its <a href="https://wordpress.org/themes/astra/">Astra</a> theme is now. Users can click a button and import a full suite of content-filled pages or even individual templates. And, the Astra theme is not alone in this. It has become an increasingly-common standard to offer some sort of onboarding to users. GoDaddy&rsquo;s managed WordPress service <a href="https://wptavern.com/inside-look-at-godaddys-onboarding-process-for-managed-wordpress-hosting">fills a similar need</a> on the hosting end.</p>



<img />Astra&rsquo;s starter templates and content.



<p>As WordPress use becomes more widespread, the more it needs a way to onboard users.</p>



<p>This essentially boils down to the question: <em>how can I make it look like the demo?</em></p>



<p>Ah, the age-old question that theme authors have been trying to solve. Whether it has been limitations in the software or, perhaps, antiquated theme review guidelines related to demo and imported content, this has been a hurdle that has been tough to jump. But, some have sailed over it and moved on. While WordPress has seemingly been twiddling its thumbs for years, Brainstorm Force and other theme companies have solved this and continued to innovate.</p>



<p>This is not necessarily a bad thing. There are plenty of ideas to <s>steal</s> copy and pull into the core platform.</p>



<p>One of the other problems facing the WordPress starter content feature is that it is tied to the customizer. With the direction of the block system, it is easy to ask what the future holds. The customizer &mdash; originally named the <em><strong>theme</strong></em> customizer &mdash; was essentially a project to allow users to make front-end adjustments and watch those customizations happen in real time. However, new features like global styles and full-site editing are happening on their own admin screens. Most theme options will ultimately be relegated to global styles, custom templates, block styles, and block patterns. There may not be much left for the customizer to do.</p>



<p>Right now, there are too many places in WordPress to edit the front-end bits of a WordPress site. My hope is that all of these things are ultimately merged into one less-confusing interface. But, I digress&hellip;</p>



<p>Starter content should be rethought. Whoever takes the reins on this needs a fresh take that adopts modern methods from leading theme companies.</p>



<p>The ultimate goal should be to allow theme authors to create multiple sets of templates/content that end-users can preview and import. It should not be tied to whether it is a new site. Any site owner should be able to import content and have it <em>automagically</em> go live. It should also be extendable to allow themes to support page builders like Elementor, Beaver Builder, and many others.</p>



<p>This seems to be in line with Hou-Sand&iacute;&rsquo;s thoughts. &ldquo;For a future release, we should start exploring what it might look like to opt into importing starter content into existing sites, whether wholesale or piecewise,&rdquo; she wrote. &ldquo;Many of us who work in the WordPress development/consulting space tend not to ever deal in switching between public themes on our sites, but let&rsquo;s not forget that&rsquo;s a significant portion of our user audience and we want to continue to enable them to not just publish but also publish in a way that matches their vision.&rdquo;</p>



<p>Let&rsquo;s do it right this go-round, keep a broad vision, and provide an avenue for theme authors to adopt a standardized core WordPress method instead of having everyone build in-house solutions.</p>



<p>I haven&rsquo;t even touched on the <a href="https://meta.trac.wordpress.org/ticket/30#comment:66">recent call to use starter content</a> for WordPress.org theme previews. It will take more than ideas to excite many theme authors about the possibility. That ticket has sat for seven years with no progress, and most have had it on their wish list for much longer. It is an interesting proposal, one that has been tossed around in various team meetings for years.</p>



<p>Like so many other things, theme authors have either given up hope or moved onto doing their own thing. They need to be brought into the fold, not only as third parties who are building with core WordPress tools but as developers who are contributing to those features.</p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Wed, 14 Oct 2020 20:07:31 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:14:"Justin Tadlock";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:21;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:116:"WPTavern: Google Podcasts Manager Adds More Data from Search: Impressions, Top-Discovered Episodes, and Search Terms";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:30:"https://wptavern.com/?p=106191";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:271:"https://wptavern.com/google-podcasts-manager-adds-more-data-from-search-impressions-top-discovered-episodes-and-search-terms?utm_source=rss&utm_medium=rss&utm_campaign=google-podcasts-manager-adds-more-data-from-search-impressions-top-discovered-episodes-and-search-terms";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:2568:"<p>Google <a href="https://twitter.com/googlewmc/status/1316030688508825600">announced</a> an expansion of listener engagement metrics today for those using its Podcast Manager. Previously, audience insights included data about the types of devices listeners are using, where listeners tune in and drop off during a given episode, total number of listens, and listening duration, but the service lacked analytics regarding how visitors were discovering the podcast.</p>



<p>Google is remedying that today by expanding the dashboard to show impressions, clicks, top-discovered episodes, and search terms that brought listeners to the podcast. This information can help podcasters understand how their content is getting discovered so they can better tailor their episodes to attract more new listeners. </p>



<p>The podcasting industry has seen remarkable growth over the past five years, which previously led experts to project that marketers will spend&nbsp;<a href="https://www.searchenginejournal.com/marketers-will-spend-1-billion-on-podcast-advertising-by-2021-report/316499/#close">over $1 billion in advertising by 2021</a>. After the pandemic hit, podcast listening took a downturn in the U.S. but at the same time, podcast creators have found more time to <a href="https://wptavern.com/podcasting-during-the-pandemic-castos-sees-300-growth-in-new-podcasters">create new shows and episodes</a>. Businesses are turning to the medium to supplement traditional marketing methods that no longer have the same impact now that consumer spending habits heavily favor online products.</p>



<p>Along with the new metrics available inside Google Podcasts Manager, the company also published a <a href="https://support.google.com/podcast-publishers/thread/76595315">guide to optimizing podcasts</a> for Google Search. It highlights four important items for making sure a podcast can be found:</p>



<ul><li>Detailed show and episode metadata</li><li>Ensure the podcast&rsquo;s webpage and RSS data match</li><li>Include cover art</li><li>Ensure Googlebot can access your audio files </li></ul>



<p>A detailed breakdown of your audience&rsquo;s listening habits isn&rsquo;t worth much if you&rsquo;re having trouble getting your podcast discovered. Any podcasting plugin for WordPress should handle these basic optimization recommendations, but if you are still having trouble being found via Google, you can dig deeper into the <a href="https://support.google.com/podcast-publishers/answer/9889864">podcast setup guide</a> for more detailed recommendations. </p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Tue, 13 Oct 2020 22:57:22 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:13:"Sarah Gooding";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:22;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:65:"WPTavern: Are Block-Based Widgets Ready To Land in WordPress 5.6?";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:30:"https://wptavern.com/?p=106175";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:173:"https://wptavern.com/are-block-based-widgets-ready-to-land-in-wordpress-5-6?utm_source=rss&utm_medium=rss&utm_campaign=are-block-based-widgets-ready-to-land-in-wordpress-5-6";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:8214:"<p class="has-drop-cap">Two weeks ago, the Gutenberg team put out an <a href="https://make.wordpress.org/core/2020/09/30/call-for-testing-the-widgets-screen-in-gutenberg-9-1/">open call for block-based widgets feedback</a>. I had already written a <a href="https://wptavern.com/gutenberg-8-9-brings-block-based-widgets-out-of-the-experimental-stage">lengthy review</a> of the new system earlier in September but was asked by a member of the team to share my thoughts on the most recent iteration. With the upcoming freeze for WordPress 5.6 Beta 1 just a week away, I figured it would not hurt to do another deep dive.</p>



<p>For reference, my latest testing is against version 9.2.0-alpha-172f589 of the Gutenberg plugin, which was a build from earlier today. Gutenberg development moves fast, but everything should be accurate to that point.</p>



<p>Ultimately, many of the problems I pointed out over a month ago still exist. However, the team has cleaned most of the minor issues, such as pointing the open/close arrows for sidebars (block areas) in the correct direction and making it more consistent with the post-editing screen. The UI is much more polished.</p>



<p>Before I dive into all the problems, I want to answer the question I am proposing. Yes, the block-based widget system <em>will be</em> ready for prime time when WordPress 5.6 lands. It is not there yet, but it is at a point where there is a clear finish line that is reachable in the next two months.</p>



<p>I will ignore the failure of block-based widgets in the customizer, which landed in Gutenberg 8.9 and was <a href="https://wptavern.com/gutenberg-9-1-adds-patterns-category-dropdown-and-reverts-block-based-widgets-in-the-customizer">removed in 9.1</a>. I will also look past the recent proposal to <a href="https://github.com/WordPress/gutenberg/issues/26012">reconstruct the widgets screen</a> to use the Customize API, at least for now. There is a boatload of problems that block-based widgets present for the customizer, and those problems are insurmountable for WordPress 5.6. Long term, WordPress needs to have a single place for editing widget/block areas. Users will likely have to live with some inconsistencies for a while.</p>



<p>Assuming the team does not try to throw a last-minute Hail Mary and implement full editing of blocks in the customizer this round, it is safe to say that block-based widgets are well on their way toward a successful WordPress 5.6 debut.</p>



<h2>The User Experience</h2>



<img />Block-based widgets screen.



<p class="has-drop-cap">As a user, I genuinely enjoy using the new Widgets admin screen. The open-ended, free-form block areas create untold possibilities for designing my WordPress sites. Traditional widgets were limited in scope. Users were buckled down to a handful of core widgets, possibly some plugin widgets, and whatever their theme author offered up. However, with blocks, the pool of choices expands to at least triple the out-of-the-box options (I am not counting embed-type blocks individually). Plus, blocks provide a far more extensive set of design options than a traditional widget.</p>



<p>In comparison, traditional widgets are outdated. Blocks are superior in almost every way. However, there are still problems with this new system.</p>



<p>The biggest issue right now is that end-users can exit the Widgets screen without saving their changes. There is no warning to let them know that all their work is about to be lost in the ether. This is one of those <em>OMGBBQ</em>-level items that need to happen before WordPress 5.6 drops.</p>



<p>One nice-to-have-but-not-necessary feature would be the ability to drag blocks from one block area to another. In the old widgets system, users could move widgets from sidebar to sidebar. The current alternative is to copy a widget, paste it in a new block area, and remove the original.</p>



<p>I am also not a fan of not having an option for the top toolbar, which is available on the post-editing screen. One of the reasons for using this toolbar is because I dislike the default popup toolbar on individual blocks. It is distracting and often gets in the way of my work.</p>



<p>Legacy widgets seem to still be a work in progress. The Legacy Widget block did not work at all for me at times. Then, it magically began to work. However, Gutenberg does now automatically add registered third-party widgets to the block inserter just as if they were blocks.</p>



<img />Getting a plugin&rsquo;s widget to work.



<p>This presented its own problems. The only way I managed to make third-party plugin widgets work was to insert the widget, save, and refresh the widgets screen. At that point, the widgets appeared and became editable.</p>



<h2>The Theme Author Experience</h2>



<p class="has-drop-cap">One of my biggest concerns for theme authors right now is that there does not seem to be any documentation in the <a href="https://developer.wordpress.org/block-editor/developers/themes/">block editor handbook</a>. There is plenty of time to make that happen, but there are things theme authors need to be aware of. Having a centralized location, even while the feature is under development, would help them gear up for the 5.6 release.</p>



<p>Some of these questions, which may be answered in various Make blog posts, should exist on a dedicated documentation page:</p>



<ul><li>How can a theme opt out of block-based widgets?</li><li>What are the hooks to add custom styles for the Widgets screen?</li><li>Can themes target specific sidebar styles on the Widgets screen?</li><li>Is it possible to consistently style sections like traditional widgets on the front end?</li><li>Can themes opt into wide and full-alignment within block areas, which could essentially be used similarly to the post content area?</li></ul>



<p>These are some of the questions I would want to be answered as a former theme author. I am no longer in the thick of the theme design game and presume that those who are would have a larger list of questions.</p>



<p>One less-obvious piece of documentation should center on how to handle fallbacks or default <em>widgets</em>. Traditionally, themes that needed to show a default set of widgets would check if the sidebar has widgets and fall back to using <code>the_widget()</code> to output one or more defaults. While theme authors can still do that, we should start to transition them across the board to the block system.</p>



<p>Should theme authors copy/paste block HTML as a fallback? Would the starter content system be better for this, and can starter widget content handle blocks? What is the recommended method for widget fallbacks in WordPress 5.6?</p>



<p>There is still the <a href="https://github.com/WordPress/gutenberg/issues/25174">ongoing issue</a> of how theme authors should handle the traditional widget and widget title wrapper HTML in the new block paradigm. One patch added since the Gutenberg 9.1 release <a href="https://github.com/WordPress/gutenberg/pull/25693">wraps every top-level block</a> with the widget wrapper. If this lands in the 9.2 release, it will likely make the issue worse.</p>



<p>In the traditional system, both the widget title and content are wrapped within a container together. However, if a user adds a Heading block (widget title) and another block (widget content), each block is wrapped separately with the theme&rsquo;s widget wrappers. The only way to rectify the situation as it stands is for end-users to add a Group block for each &ldquo;widget&rdquo; they want, which would require an extensive amount of re-education for WordPress users. It is not an ideal scenario.</p>



<img />Each block is wrapped as an individual section.



<p>Instead of attempting to directly &ldquo;fix&rdquo; this issue, WordPress should instead do nothing to the output. Blocks and traditional widgets are fundamentally different.</p>



<p>Let theme authors take the reins on this one and explore possibilities. However, give them the tools to do so, such as <a href="https://wptavern.com/addressing-the-theme-design-problem-with-gutenbergs-new-block-based-widgets-system">supporting block patterns</a>.</p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Tue, 13 Oct 2020 21:35:39 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:14:"Justin Tadlock";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:23;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:91:"WPTavern: WordCamp Austin 2020 Finds Success with VR Experience for Sessions and Networking";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:30:"https://wptavern.com/?p=106119";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:227:"https://wptavern.com/wordcamp-austin-2020-finds-success-with-vr-experience-for-sessions-and-networking?utm_source=rss&utm_medium=rss&utm_campaign=wordcamp-austin-2020-finds-success-with-vr-experience-for-sessions-and-networking";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:7246:"<p><a href="https://austin.wordcamp.org/2020/">WordCamp Austin 2020</a> attendees are raving about their experiences attending the virtual event last Friday. It was no secret that the camp&rsquo;s organizers planned to use&nbsp;<a href="https://hubs.mozilla.com/">Hubs Virtual Rooms</a>&nbsp;by Mozilla to create a unique environment, but few could imagine how much more interactive and personalized the experience would be than a purely Zoom-based WordCamp.</p>



<p>After selecting a custom avatar, attendees entered the venue using a VR headset or the browser to check out sessions or network in the hallway track.</p>



<div class="wp-block-embed__wrapper">
<blockquote class="twitter-tweet"><p lang="en" dir="ltr">Here&rsquo;s a small taste of the experience at <a href="https://twitter.com/WordCampATX?ref_src=twsrc%5Etfw">@WordCampATX</a> today. <a href="https://twitter.com/hashtag/WordPress?src=hash&ref_src=twsrc%5Etfw">#WordPress</a> logos and no sponsor banners on any elevator doors. <a href="https://twitter.com/hashtag/WCATX?src=hash&ref_src=twsrc%5Etfw">#WCATX</a> <a href="https://t.co/Nv2p2VchXf">pic.twitter.com/Nv2p2VchXf</a></p>&mdash; David Bisset (@dimensionmedia) <a href="https://twitter.com/dimensionmedia/status/1314643915904086018?ref_src=twsrc%5Etfw">October 9, 2020</a></blockquote>
</div>



<p>Speaker and Q&amp;A sessions were broadcast through Zoom but organizers can also embed YouTube videos and streams within the standalone VR environment.</p>



<p>&ldquo;The VR experience was the most life-like WordCamp experience I&rsquo;ve had since the start of global lockdowns,&rdquo; attendee and speaker David Vogelpohl said. &ldquo;You could attend sessions in one of two virtual presentation halls depending on what track you wanted to see at that time. The speaker presented on a virtual stage and you could see the other attendees watching the presentation.&rdquo;</p>



<p>Vogelpohl said he enjoyed his experience getting to know others in the Slack and VR venue. Organizers preserved the general vibe of the &ldquo;hallway track&rdquo; to recreate what is arguably one of the most valuable aspects of in-person WordCamps.</p>



<div class="wp-block-embed__wrapper">
<blockquote class="twitter-tweet"><p lang="en" dir="ltr">So cool &ndash; checking out the Virtual Space of WordCamp Austin &ndash; love the background noise of people talking, ran into <a href="https://twitter.com/ChrisWiegman?ref_src=twsrc%5Etfw">@ChrisWiegman</a> and <a href="https://twitter.com/Josh412?ref_src=twsrc%5Etfw">@Josh412</a> <a href="https://twitter.com/hashtag/WCATX?src=hash&ref_src=twsrc%5Etfw">#WCATX</a> <a href="https://t.co/68EdgDN2Om">pic.twitter.com/68EdgDN2Om</a></p>&mdash; Birgit Pauli-Haack (@bph) <a href="https://twitter.com/bph/status/1314570573792632832?ref_src=twsrc%5Etfw">October 9, 2020</a></blockquote>
</div>



<p>&ldquo;In the hallway track between the virtual presentation halls was a large foyer where you could meet new people, spot a friend speaking with someone else, and virtually step aside from a group conversation to have a private conversation,&rdquo; Vogelpohl said.</p>



<p>&ldquo;It was great to see folks like Josepha circling around speaking with attendees, Josh Pollock nerding out in a corner with a group of advanced WP developers, and having random friends drop into a conversation I was having with a group of others. While VR WordCamp doesn&rsquo;t wholly&nbsp;replace the value of attending a WordCamp live, a lot of the best parts of meeting and collaborating with others was captured in the VR context.&rdquo;</p>



<p>The live music interludes, which showcased talents from around the community, also provided a way for virtual attendees to stay connected while waiting for the next session. </p>



<h2>Behind the Scenes with Anthony Burchell: Creative Director for WordCamp Austin&rsquo;s Virtual World</h2>



<p>WordPress core contributor Anthony Burchell, who started a <a href="https://broken.place/">company</a> dedicated to creating interactive XR sound and art experiences, was the creative director behind the WordCamp Austin&rsquo;s VR backdrop.</p>



<p>&ldquo;For WordCamp Austin we wanted to give folks something to be excited about outside of the typical webcam and chat networking,&rdquo; Burchell said. &ldquo;I feel that virtual events are not utilizing the networking layer nearly enough to make folks feel like they are really at an event. I&rsquo;ve seen many compelling formats for virtual events utilizing webcams and chat rooms, but in the end, it feels like there&rsquo;s been a missing element of presence; something video games and virtual reality excel at.&rdquo;</p>



<div class="wp-block-embed__wrapper">
<blockquote class="twitter-tweet"><p lang="en" dir="ltr">Virtual mission control for <a href="https://twitter.com/hashtag/WCATX?src=hash&ref_src=twsrc%5Etfw">#WCATX</a> <a href="https://t.co/WyrFkIsW2Q">pic.twitter.com/WyrFkIsW2Q</a></p>&mdash; Anthony Burchell (@antpb) <a href="https://twitter.com/antpb/status/1314592863569707008?ref_src=twsrc%5Etfw">October 9, 2020</a></blockquote>
</div>



<p>Setting up the virtual world involves spinning up a self-hosted instance of Hubs Cloud, which Burchell said is very similar to the complexity of making a WordPress site.</p>



<p>&ldquo;The most time consuming part of creating a 3D world for an event is making the 3D assets for the space,&rdquo; Burchell said. &ldquo;In total I streamed 11 hours of video leading up to the event to give a glimpse into the process.&rdquo;</p>



<p>Burchell&rsquo;s YouTube <a href="https://www.youtube.com/playlist?list=PLi1xKbv0cklpzJCgXyKi-pp3KANYJLqGk">playlist</a> documents the incredible amount of work that went into creating the WordCamp&rsquo;s virtual venue for attendees to enjoy. </p>



<p>&ldquo;While it took quite a bit of time to prepare, the code and assets are completely reusable for another event,&rdquo; Burchell said. &ldquo;A lot of the time was spent trying to make the space purpose built for the goals of the camp. Much like a real WordCamp, I found the majority of folks packing into the theater rooms for presentations and dipping out a little early to network with friends in the hallway area. That was very much by design!&rdquo;</p>



<p>Burchell and the other organizers were careful to ensure that the Hubs space was not the primary viewing experience of the camp but rather an extension of the networking activities that attendees could drop in on. The event had nearly identical numbers of attendees joining the virtual space as it did for those joining the video channels. At the end of the afterparty, Burchell turned on flying for all attendees to conclude the successful event:</p>



<div class="wp-block-embed__wrapper">

</div>



<p>&ldquo;With Hubs we were able to give attendees the ability to express themselves within a venue vs within a camera and chat box,&rdquo; Burchell said. &ldquo;It was incredible to see characteristics of folks in the community shine through a virtual avatar! Just the simple act of seeing your WordCamp friends in the hallway joking and chatting just as they would at a real life event was enough to make me feel like I was transported to a real WordCamp.&rdquo;</p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Mon, 12 Oct 2020 22:31:02 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:13:"Sarah Gooding";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:24;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:86:"WPTavern: Privacy-Conscious WordPress Plugin Caches and Serves Gravatar Images Locally";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:30:"https://wptavern.com/?p=105825";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:217:"https://wptavern.com/privacy-conscious-wordpress-plugin-caches-and-serves-gravatar-images-locally?utm_source=rss&utm_medium=rss&utm_campaign=privacy-conscious-wordpress-plugin-caches-and-serves-gravatar-images-locally";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:5285:"<p class="has-drop-cap">Ari Stathopoulos released his new <a href="https://wordpress.org/plugins/local-gravatars/">Local Gravatars</a> plugin last week. The goal of the plugin is to allow site owners to take advantage of the benefits of a global avatar system while mitigating privacy concerns by hosting the images locally.</p>



<p>In essence, it is a caching system that stores the images on the site owner&rsquo;s server. It is an idea that Peter Shaw <a href="https://wptavern.com/local-avatars-in-wordpress-yes-please#comment-338262">proposed in the comments</a> on an earlier Tavern article covering <a href="https://wptavern.com/local-avatars-in-wordpress-yes-please">local avatar upload</a>. It is a middle ground that may satisfy some users&rsquo; issues with how avatars currently work in WordPress.</p>



<p>&ldquo;I am one of the people that blocks analytics, uses private sessions when visiting social sites, I use DuckDuckGo instead of Google, and I don&rsquo;t like the &lsquo;implied&rsquo; consents,&rdquo; said Stathopoulos. &ldquo;I built the plugin for my own use because I don&rsquo;t know what Gravatar does, I don&rsquo;t understand the privacy policies, and I am too lazy to spend two hours analyzing them. It&rsquo;s faster for me to build something that is safe and doesn&rsquo;t leave any room for misunderstandings.&rdquo;</p>



<p>He is referring to Automattic&rsquo;s extensive <a href="https://automattic.com/privacy/">Privacy Policy</a>. He said it looks benign. However, he does not like the idea of any company being able to track what sites he visits without explicit consent.</p>



<p>&ldquo;And when I visit a site that uses Gravatar, some information is exposed to the site that serves them &mdash; including my IP,&rdquo; said Stathopoulos. &ldquo;Even if it&rsquo;s just for analytics purposes, I don&rsquo;t think the company should know that page A on site B got 1,000 visitors today with these IPs from these countries. There is absolutely no reason why any company not related to the page I&rsquo;m actually visiting should have any kind of information about my visit.&rdquo;</p>



<p>The Local Gravatars plugin must still connect to the Gravatar service. However, the connection is made on the server rather than the client. Stathopoulos explained that the only information exposed in this case is the server&rsquo;s IP and nothing from the client, which eliminates any potential privacy concerns.</p>



<h2>The Latest Plugin Update</h2>



<p class="has-drop-cap">Stathopoulos updated the plugin earlier today to address some performance concerns for pages that have hundreds or more Gravatar images. In the version 1.0.1 update, he added a maximum processing time of five seconds and changed the cache cleanup process from daily to weekly. Both of these are filterable via code.</p>



<p>&ldquo;Now, if there are Gravatars missing in a page request, it will get as many as it can, and, after five seconds, it will stop,&rdquo; said Stathopoulos. &ldquo;So if there are 100 Gravatars missing and it gets the first 20, the rest will be blank (can be filtered to use a fallback URL, or even fall back to the remote URL, though that would defeat the privacy improvement). The next page request will get the next 20, and so on. At some point, all will be there, and there will be no more delays.&rdquo;</p>



<p>He did point out that performance could temporarily suffer when installing it on a site that has individual posts with 1,000s of comments and a lot of traffic. However, nothing would crash on the site, and the plugin should eventually lead to a performance boost in this scenario. For such large sites, owners could use the existing filter hooks to tweak the settings.</p>



<p>Right now, the plugin is primarily an itch he wanted to scratch for his own purposes. However, if given enough usage and feedback, he may include a settings screen to allow users to control some of the currently-filterable defaults, such as the cleanup timeframe and the maximum process time allowed.</p>



<h2>The Growing List of Alternatives</h2>



<p class="has-drop-cap">With growing concerns around privacy in the modern world, Local Gravatars is another tool that end-users can employ if they have any concerns around the Gravatar service. For those who are OK with an auto-generated avatar, <a href="https://wptavern.com/privacy-first-gravatar-replacement-pixel-avatars-module-released-for-the-toolbelt-wordpress-plugin">Pixel Avatars</a> may be a solution.</p>



<p>&ldquo;I&rsquo;ve seen some of them, and they are wonderful!&rdquo; Stathopoulos said of alternatives for serving avatars. &ldquo;However, this plugin is slightly different in that the avatars the user already has on Gravatar.com are actually used. They can see the image they have uploaded. The user doesn&rsquo;t need to upload a separate avatar, and an automatic one is not used by default.&rdquo;</p>



<p>He would not mind using an auto-generated avatar when commenting on blogs or news sites at times. However, Stathopoulos prefers Gravatar for community-oriented sites.</p>



<p>&ldquo;My Gravatar is part of my online identity, and when I see, for example, a comment from someone on WordPress.org, I know who they are by their Gravatar,&rdquo; he said.</p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Mon, 12 Oct 2020 21:06:20 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:14:"Justin Tadlock";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:25;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:86:"WPTavern: WordPress 5.6 to Introduce Application Passwords for REST API Authentication";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:30:"https://wptavern.com/?p=105997";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:217:"https://wptavern.com/wordpress-5-6-to-introduce-application-passwords-for-rest-api-authentication?utm_source=rss&utm_medium=rss&utm_campaign=wordpress-5-6-to-introduce-application-passwords-for-rest-api-authentication";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:2604:"<p>In 2015, WordPress 4.4 introduced a REST API, but one thing that has severely limited its broader use is the lack of  authentication capabilities for third-party applications. After considering the benefits and drawbacks of many different types of authentication systems, George Stephanis published a <a href="https://make.wordpress.org/core/2020/09/23/proposal-rest-api-authentication-application-passwords/">proposal</a> for integrating <a href="https://github.com/WP-API/authentication/issues/13">Application Passwords</a>, into core. </p>



<p>Stephanis highlighted a few of the major benefit that were important factors in the decision to use Application Passwords: the ease of making API requests, ease of revoking credentials, and the ease of requesting API credentials. The project is available as a standalone <a href="https://wordpress.org/plugins/application-passwords/">feature plugin</a>, but Stephanis and his collaborators recommended WordPress merge a <a href="https://github.com/WordPress/wordpress-develop/pull/540">pull request</a> that is based off the feature plugin&rsquo;s codebase.</p>



<p>After WordPress 5.6 core tech lead Helen Hou-Sandi gave the green light for Application Passwords to be merged into core, the developer community responded enthusiastically to the news.</p>



<p>&ldquo;I am/we are 100% in favor of this,&rdquo; Joost deValk commented on the proposal. &ldquo;Opening this up is like opening the dawn of a new era of WordPress based web applications. Suddenly authentication is not something you need to fix when working with the&nbsp;API&nbsp;and you can just build awesome stuff.&rdquo;</p>



<p>Stephanis&rsquo; proposal also mentioned how beneficial a REST API authentication system would be for the <a href="https://make.wordpress.org/mobile/">Mobile teams</a>&lsquo; contributors who are relying on awkward workarounds while integrating Gutenberg support.</p>



<p>&ldquo;This would be a first step to replace the use of XMLRPC in the mobile apps and it would allow us to add more features for self hosted users,&rdquo; Automattic mobile engineer Maxime Biais said.</p>



<p>After the REST API was added to WordPress five years ago, many had the expectation that WordPress-based web applications would start popping up everywhere. Without a reliable authentication system, it wasn&rsquo;t easy for developers to just get inspired and build something quickly. Application Passwords in WordPress 5.6 will open up a lot of possibilities for those who were previously deterred by the lack of core methods for authenticating third-party access.</p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Fri, 09 Oct 2020 23:01:31 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:13:"Sarah Gooding";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:26;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:76:"WPTavern: WP Agency Summit Begins Its Second Annual Virtual Event October 12";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:30:"https://wptavern.com/?p=105160";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:197:"https://wptavern.com/wp-agency-summit-begins-its-second-annual-virtual-event-october-12?utm_source=rss&utm_medium=rss&utm_campaign=wp-agency-summit-begins-its-second-annual-virtual-event-october-12";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:6357:"<p class="has-drop-cap">Jan Koch, the founder and host of WP Agency Summit, is kicking off his <a href="https://wpagencysummit.com/">second annual event on October 12</a>. The five-day event will feature 37 speakers from a wide range of backgrounds across the WordPress industry. It is a free virtual event that anyone can attend.</p>



<p>&ldquo;The focus for the 2020 WP Agency Summit is showing attendees how to bring back the fun into scaling their agencies,&rdquo; said Koch. &ldquo;It is all about reducing the daily hustle by teaching how to successfully build and manage teams, how to work with enterprises (allowing for fewer customers but bigger projects), how to build sustainable recurring revenue, and how to position your agency to dominate your niche.&rdquo;</p>



<p>This year&rsquo;s event includes three major changes to make the content more accessible to a larger group of people. Each session will be available between October 12 &ndash; 16 instead of the previous 48-hour window that attendees had to find time for in 2019.</p>



<p>After the event has concluded, access to the content will be behind a paywall. Koch reduced the price to $77 for lifetime access for those who purchase pre-launch, which will increase to $127 during the event. Last year&rsquo;s prices ballooned to $497, which meant that it was simply not affordable for many who found it too late.</p>



<p>Some of the proceeds this year are going toward transcribing all the videos so that hearing-impaired users can enjoy the content.</p>



<p>This year&rsquo;s event will also focus on a virtual networking lounge for attendees. &ldquo;I&rsquo;ve seen how well it worked at the WP FeedBack Summit &mdash; we even had BobWP record a podcast episode on the fly in that lounge!&rdquo; said Koch. &ldquo;I&rsquo;ve seen many new friendships develop, people connecting with new suppliers or getting themselves booked on podcasts, and sharing experiences about their businesses.&rdquo;</p>



<p>The lounge will be open during the entirety of the summit, which will allow attendees to jump into the conversation on their own time.</p>



<h2>A More Diverse Speaker Lineup</h2>



<p class="has-drop-cap">Koch received some backlash for the lack of gender diversity last year. <a href="https://wptavern.com/wp-agency-summit-kicks-off-december-6">The 2019 event</a> had over 20 speakers from a diverse male lineup. However, only four women from our industry led sessions.</p>



<p>When asked about this issue in 2019, Koch responded, &ldquo;I recognize this as a problem with my event. The reason I have so much more male than female speakers is quite simple, the current speaker line-up is purely based on connections I had when I started planning for the event. It was a relatively short amount of time for me, so I wasn&rsquo;t able to build relationships with more female WP experts beforehand.&rdquo;</p>



<p>The host said he paid attention to the feedback he received. While not hitting the 50/50 split goal he had for 2020&rsquo;s event, 16 of the 37 speakers are women.</p>



<p>Koch said he strived to get speakers from a wider range of backgrounds. He wanted to bring in both freelancers and multi-million dollar agency owners. He also focused on getting people from multiple countries to represent WordPress agencies.</p>



<p>&ldquo;I did reach out to around 130 people four months before the event to make new connections,&rdquo; he said. &ldquo;The community around the Big Orange Heart (a non-profit for mental well-being) also helped a lot with introducing me to new members of the WP community.&rdquo;</p>



<p>Koch said he learned two valuable lessons when branching out beyond his existing connections for this year&rsquo;s event:</p>



<blockquote class="wp-block-quote"><p>Firstly, don&rsquo;t hesitate to reach out to people you think will never talk to you because they&rsquo;re running such big companies. For example, I immediately got confirmations from Mario Peshev from Devrix, Brad Touesnard from Delicious Brains, or Marieke van de Rakt from Yoast. When first messaging them, I had little hope they&rsquo;d set aside time to jump on an interview with me &ndash; but they were super supportive and accommodating! The WordPress community really is a welcoming environment if you approach people in a humble way.</p><p>Secondly, build connections with sincerity. Do not just focus on what you can get from that connection but how you can help the other person. I know this sounds cheesy and you&rsquo;ve heard this quite often &mdash; but it is true. Once I got the first response from new contacts and explained my goal of connecting fellow WordPress community members virtually, most immediately agreed because they also benefit from new connections and being positioned as a thought-leader in this event.</p></blockquote>



<h2>WP Agency Summit? WP FeedBack Summit?</h2>



<p class="has-drop-cap">For readers who recall the Tavern&rsquo;s coverage of the <a href="https://wptavern.com/wp-feedback-kicks-off-free-virtual-summit-for-wordpress-professionals-on-april-27">WP FeedBack Summit</a> earlier this year, the article specifically stated that the WP FeedBack Summit was a continuation of 2019&rsquo;s WP Agency Summit. The official word at the time from WP FeedBack&rsquo;s public relations team was the following:</p>



<blockquote class="wp-block-quote"><p>Last year&rsquo;s event, the WP Agency Summit has been rebranded under the umbrella of WP FeedBack&rsquo;s brand when Jan Koch the host of last&rsquo;s year WP Agency Summit joined WP FeedBack as CTO.</p></blockquote>



<p>Koch said that it was a standalone event and not directly connected to WP Agency Summit but had the same target audience. However, the WP FeedBack Summit did use the previous WP Agency Summit&rsquo;s stats and data to promote the event.</p>



<p>&ldquo;The WP FeedBack Summit was hosted under the WP FeedBack brand because I joined their team as CTO in March this year,&rdquo; he said. &ldquo;Vito [Peleg] and I had the idea to host a virtual conference around WordPress because of WordCamp Asia being canceled &mdash; we wanted to help connect the community online through our summit.</p>



<p>Koch left WP FeedBack soon after the summit ended and is currently back on his own and has a goal of making WP Agency Summit a yearly event.</p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Fri, 09 Oct 2020 17:01:24 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:14:"Justin Tadlock";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:27;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:102:"WPTavern: Navigation Screen Sidelined for WordPress 5.6, Full-Site Editing Edges Closer to Public Beta";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:30:"https://wptavern.com/?p=105839";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:247:"https://wptavern.com/navigation-screen-sidelined-for-wordpress-5-6-full-site-editing-edges-closer-to-public-beta?utm_source=rss&utm_medium=rss&utm_campaign=navigation-screen-sidelined-for-wordpress-5-6-full-site-editing-edges-closer-to-public-beta";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:4676:"<p>The new block-based navigation screen is once again delayed after it was originally <a href="https://wptavern.com/new-block-based-navigation-and-widgets-screens-sidelined-for-wordpress-5-5">slated for WordPress 5.5</a> and then put <a href="https://wptavern.com/wordpress-5-6-development-kicks-off-with-all-women-release-squad">on deck for 5.6</a>. Contributors have confirmed that it will not be landing in WordPress core until 2021 at the earliest.</p>



<p>&ldquo;The Navigation screen is still in experimental state in the&nbsp;Gutenberg&nbsp;plugin, so it hasn&rsquo;t had any significant real-world use and testing yet,&rdquo; Editor Tech Lead&nbsp;Isabel Brison said. She made the call to remove it from the 5.6 lineup after the feature missed the deadline for&nbsp;<a href="https://github.com/WordPress/gutenberg/issues/24683">bringing it out of the experimental state</a>. It still requires a substantial amount of development work and accessibility feedback before moving forward.  </p>



<p>Contributors will focus instead on making sure the Widgets screen gets out the door for 5.6 and plan to pick up again on Navigation towards the end of November. </p>



<p>WordPress 5.6 lead Josepha Haden gave an <a href="https://make.wordpress.org/core/2020/10/06/update-wordpress-5-6-release-progress/">update</a> this week on the progress of all the anticipated features, including the planned public beta for full-site editing (FSE).</p>



<p>&ldquo;I don&rsquo;t expect FSE to be feature complete by the time WP5.6 is released,&rdquo; Haden said. &ldquo;What I expect is that FSE will be functional for simple, routine user flows, which we can start testing and iterating on. That feedback will also help us more confidently design and build our complex user flows.&rdquo;</p>



<p>Frank Klein, an engineer at Human Made, asked in the <a href="https://make.wordpress.org/themes/2020/10/07/block-based-themes-and-wordpress-5-6/#comment-44126">comments</a> of another update why full-site editing is being tied to 5.6 progress in the first place, since it will still only be available in the plugin at the time of release. </p>



<p>&ldquo;The main value is that it provides a good checkpoint along the path of&nbsp;FSE&rsquo;s development,&rdquo; <a href="https://profiles.wordpress.org/kjellr/">Kjell Reigstad</a> said.&nbsp;&ldquo;Full-site editing is very much in progress. It is still experimental, but the general approach is coming into view, and becoming clearer with every plugin release.&rdquo;</p>



<p>Reigstad posted an update on what developers can expect regarding <a href="https://make.wordpress.org/themes/2020/10/07/block-based-themes-and-wordpress-5-6/">block-based theming and the upcoming release,</a> since the topic is closely tied to full-site editing. He emphasized that the infrastructure is already in place and that, despite it still being experimental, future block-based themes should work in a similar way to how they are working now.</p>



<p>&ldquo;The focus is now shifting towards polishing the user experience: using the site editor to create templates, using the query block, iterating on the post and site blocks, and implementing the Global Styles&nbsp;UI,&rdquo; Reigstad said.</p>



<p>&ldquo;The main takeaway is that when 5.6 is released, the full-site editing feature set will look similar to where it is today, with added polish to the UI, and additional features in the Query block.&rdquo;</p>



<p>Theme authors are entering a new time of uncertainty and transition, but Reigstad reassured the community that themes as we know them today are not on track to be phased out in the immediate future.</p>



<p>&ldquo;There is currently no plan to deprecate the way themes are built today,&rdquo; Reigstad said. &ldquo;Your existing themes will continue to work as they always have for the foreseeable future.&rdquo; He also encouraged contributors to get involved in an initiative to&nbsp;<a href="https://github.com/WordPress/gutenberg/issues/24803">help theme authors transition to block-based themes</a>. (This project is not targeted for the 5.6 release.)</p>



<p>Developers can follow important <a href="https://github.com/WordPress/gutenberg/issues/24551">FSE project milestones</a> on GitHub, and subscribe to the weekly&nbsp;<a href="https://make.wordpress.org/themes/tags/gutenberg-themes-roundup/">Gutenberg + Themes updates</a> to track progress on block-based theming. A block-based version of the&nbsp;<a href="https://make.wordpress.org/core/2020/09/23/introducing-twenty-twenty-one/">Twenty Twenty-One theme</a> is in the works and should pick up steam after 5.6 beta 1, expected on October 20.</p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Thu, 08 Oct 2020 22:57:37 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:13:"Sarah Gooding";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:28;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:68:"WPTavern: EditorPlus 1.9 Adds Animation Builder for the Block Editor";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:30:"https://wptavern.com/?p=105678";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:181:"https://wptavern.com/editorplus-1-9-adds-animation-builder-for-the-block-editor?utm_source=rss&utm_medium=rss&utm_campaign=editorplus-1-9-adds-animation-builder-for-the-block-editor";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:4535:"<p class="has-drop-cap">Munir Kamal shows no signs of slowing down. He continues to push forward with new features for his <a href="https://wordpress.org/plugins/editorplus/">EditorPlus plugin</a>, which allows end-users to customize the look of the blocks in their posts and pages. He calls it the &ldquo;no-code style editor for WordPress.&rdquo; </p>



<p><em>The latest addition to his plugin?</em> Animation styles for every core block.</p>



<p>My first thought was that this would bloat the plugin with large amounts of unnecessary CSS and JavaScript for what is essentially a few bells and whistles. However, Kamal pulled it off with minimal custom CSS.</p>



<p>Inspired by features from various website builders, he wanted to bring more and more of those things to the core block editor. The animations feature is just another ticked box on a seemingly never-ending checklist of features. And, so far, it&rsquo;s all still free.</p>



<p>Since we last <a href="https://wptavern.com/control-block-design-via-the-editorplus-wordpress-plugin">covered EditorPlus in June</a>, Kamal has added the ability to insert icons via any rich-text area (e.g., paragraphs, lists, etc.). He has also added shape divider, typography, style copying, and responsive editing options for the core WordPress blocks.</p>



<h2>How Do Animations Work?</h2>



<p class="has-drop-cap">In the version 1.9 release of EditorPlus, Kamal added &ldquo;entrance&rdquo; animations. These types of animations happen when a visitor sees the block for the first time on the screen. For example, users could set the Image block to fade into visibility as a reader views the block.</p>



<p>Currently, the plugin adds seven animations:</p>



<ul><li>Fade</li><li>Slide</li><li>Bounce</li><li>Zoom</li><li>Flip</li><li>Fold</li><li>Roll</li></ul>



<img />Adding a Slide animation for the Cover block text.



<p>Each animation has its own subset of options to control how it behaves on the page. The bounce animation, for example, allows users to select the bounce direction. Other options include duration, delay, speed curve, delay, and repeat. There are enough choices to spend an inordinate amount of time tinkering with the output.</p>



<p>One of the best features of this new feature is that Kamal has included an Animation Player under the block options. By clicking the play button, users can view the animation in action without previewing the post.</p>



<p>Watch a quick video of the Animations feature:</p>



<div class="wp-block-embed__wrapper">

</div>



<p>After testing and using each animation, everything seemed to work well. The one downside &mdash; and this is not limited to animations &mdash; is that applying styles on the block level sometimes does not make sense. In many cases, it would help users to have options to style or animate the items within the block, such as the images in the Gallery block. When I broached the subject with Kamal, he was open to the idea of finding a solution to this in the future.</p>



<h2>What Is Next for EditorPlus?</h2>



<p class="has-drop-cap">At a certain point, too many block options can almost feel like overkill and become unwieldy. EditorPlus does allow users to disable specific features from its settings screen, which can help get rid of some unwanted options. Kamal said he would like to continue making it more modular so that users can use only the features they need.</p>



<p>&ldquo;What I plan is to have micro-level feature control for this extension so that a user can switch off individual styling panels like, Typography, Background, etc.,&rdquo; he said. &ldquo;Even further, I plan to bring these controls based on the user role as well. So an admin can disable these features for the editor, author, etc.&rdquo;</p>



<p>That may be a bit down the road though. For now, he wants to focus on adding new features that he already has planned.</p>



<p>&ldquo;I do plan to add more animation features,&rdquo; said Kamal. &ldquo;I got too many ideas, such as scroll-controlled animation, hover animation, text animation, Lottie animation, background animation, animated shape dividers, and more. But, having said that, I will be careful adding only those features that don&rsquo;t affect page performance much.&rdquo;</p>



<p>Outside of extra styles and animations for existing blocks, he plans to jump on the block-building train in future releases. EditorPlus users could see accordion, toggle, slider, star rating, and other blocks in an upcoming release.</p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Thu, 08 Oct 2020 20:53:40 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:14:"Justin Tadlock";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:29;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:50:"Donncha: Hide featured image if it’s in the post";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:28:"https://odd.blog/?p=89503242";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:67:"https://odd.blog/2020/10/08/hide-featured-image-if-its-in-the-post/";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:3885:"<p>I&#8217;ve been running a photoblog at <a href="https://inphotos.org/">inphotos.org</a> since 2005 on WordPress. (And thanks to writing this I noticed it&#8217;s <a href="https://inphotos.org/2005/10/08/yellow-flower/">15 years old today</a>!)</p>



<div class="wp-block-image"><img /></div>



<p>In that time WordPress has changed dramatically. At first I used Flickr to host my images, but after a short time I hosted the images myself. (Good thing too since Flickr limited free user accounts to 1000 images, so I wrote <a href="https://github.com/donnchawp/bye-bye-flickr">a script to download</a> the Flickr images I used in posts.)</p>



<div class="wp-block-image"><img /></div>



<p>For quite a long time I used the featured image instead of inserting the image into the post content, but then about two years ago I went back to inserting the photo into the post. Unfortunately that meant the photo was shown twice, once as a featured image, and once in the post content.</p>



<p>The last theme I used supported custom post types, one of which was a photo type that displayed the featured image but hid the post content. It was an ok compromise, but not perfect.</p>



<div class="wp-block-image"><img /></div>



<p>Recently I started using Twenty Twenty, but after 15 years I had a mixture of posts with:</p>



<ul><li>Featured image with no image in the post.</li><li>Featured image with the same image in the post.</li></ul>



<p>I knew I needed something more flexible. I wanted to hide the featured image if it also appeared in the post content. I procrastinated and never got around to it until this evening when I discovered it was actually quite easy. </p>



<img />



<p>Copy the following code into the function.php of your child theme and you&#8217;ll be all set! It relies on you having unique filenames for your images. If you don&#8217;t then remove the call to <code>basename()</code>, and that may help.</p>


<pre class="brush: php; auto-links: false; gutter: false; title: ; notranslate">
function maybe_remove_featured_image( $html ) {
        if ( $html == '' ) {
                return '';
        }
        $post = get_post();
        $post_thumbnail_id = get_post_thumbnail_id( $post );
        if ( ! $post_thumbnail_id ) {
                return $html;
        }

        $image_url = wp_get_attachment_image_src( $post_thumbnail_id );
        if ( ! $image_url ) {
                return $html;
        }

        $image_filename = basename( parse_url( $image_url[0], PHP_URL_PATH ) );
        if ( strpos( $post-&gt;post_content, $image_filename ) ) {
                return '';
        } else {
                return $html;
        }
}
add_filter( 'post_thumbnail_html', 'maybe_remove_featured_image' );
</pre>


<p>The <code>post_thumbnail_html</code> filter acts on the html generated to display the featured image. My code above gets the filename of the featured image, checks if it&#8217;s in the current post and if it is returns a blank string. Feedback welcome if you have a better way of doing this!</p>



<div class="wp-block-image"><img /></div>



<p></p>

<p><strong>Related Posts</strong><ul><li> <a href="https://odd.blog/2007/07/09/around-ireland-in-80-links-on-july-9th-2007/" rel="bookmark" title="Permanent Link: Around Ireland in 80 links on July 9th 2007">Around Ireland in 80 links on July 9th 2007</a></li><li> <a href="https://odd.blog/2003/12/22/webalizer-hide-the-groups/" rel="bookmark" title="Permanent Link: Webalizer &#8211; hide the groups!">Webalizer &#8211; hide the groups!</a></li><li> <a href="https://odd.blog/2002/11/16/dvdrip-a-full-fe/" rel="bookmark" title="Permanent Link: dvd::rip &#8211; A full featured DVD &#8230;">dvd::rip &#8211; A full featured DVD &#8230;</a></li></ul></p>
<p><a href="https://odd.blog/2020/10/08/hide-featured-image-if-its-in-the-post/" rel="nofollow">Source</a></p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Thu, 08 Oct 2020 20:43:35 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:7:"Donncha";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:30;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:75:"WPTavern: Cloudflare Launches Automatic Platform Optimization for WordPress";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:30:"https://wptavern.com/?p=105641";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:195:"https://wptavern.com/cloudflare-launches-automatic-platform-optimization-for-wordpress?utm_source=rss&utm_medium=rss&utm_campaign=cloudflare-launches-automatic-platform-optimization-for-wordpress";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:6128:"<p>Just a day after launching its new <a href="https://wptavern.com/cloudflare-launches-new-web-analytics-product-focusing-on-privacy">privacy-first web analytics product</a> last week, Cloudflare announced Automatic Platform Optimization (APO) for WordPress. The new service boasts staggering performance improvements for sites that might otherwise be slowed down by shared hosting, slow database lookups, or sluggish plugins:</p>



<blockquote class="wp-block-quote"><p>Our testing&hellip; showed a 72% reduction in Time to First Byte (TTFB), 23% reduction to&nbsp;<a rel="noreferrer noopener" href="https://web.dev/fcp/" target="_blank">First Contentful Paint</a>, and 13% reduction in&nbsp;<a rel="noreferrer noopener" href="https://web.dev/speed-index/" target="_blank">Speed Index</a>&nbsp;for desktop users at the 90th percentile, by serving nearly all of your website&rsquo;s content from Cloudflare&rsquo;s network.&nbsp;</p></blockquote>



<p>APO uses Cloudflare Workers to cache dynamic content and serve the website from its <a href="https://www.cloudflare.com/learning/cdn/glossary/edge-server/">edge network</a>. In most cases this eliminates origin requests and origin processing time. That means visitors requesting your website will get near instant load times. Cloudflare reports that its testing shows APO delivers consistent load times of under 400ms for HTML Time to First Byte (TTFB).</p>



<p>The effects of using APO are similar to hosting static files on a CDN, but without the need to manage a complicated tech stack. Content creators retain their ability to create dynamic websites without any changes to their workflow for the sake of performance. </p>



<p>Version 3.8 of <a href="https://wordpress.org/plugins/cloudflare/">Cloudflare&rsquo;s official WordPress plugin</a> was recently updated to include support for APO. It detects when users make changes to their content and purges the content stored on Cloudflare&rsquo;s edge.</p>



<p>The new service is available to Cloudflare users with a single click of a button. APO is included at no cost for existing Cloudflare customers on the Professional, Business, and Enterprise plans. Users on the Free plan can add it to their sites for $5/month. The service is a flat fee and is not metered. </p>



<p>Cloudflare&rsquo;s announcement has so far been well-received by WordPress professionals and hosting companies and many have already begun testing it. </p>



<div class="wp-block-embed__wrapper">
<blockquote class="twitter-tweet"><p lang="en" dir="ltr">So the week after <a href="https://twitter.com/Cloudflare?ref_src=twsrc%5Etfw">@Cloudflare</a> Birthday Week I try and play with as many of the new products as possible. Today was the WordPress APO on my simple demo site. You can see TTFB dropped from ~350ms to ~75ms!  <a href="https://t.co/zg976EjrZI">https://t.co/zg976EjrZI</a> <a href="https://t.co/KuaHqtHLom">pic.twitter.com/KuaHqtHLom</a></p>&mdash; Matt Bullock (@mibullock) <a href="https://twitter.com/mibullock/status/1313478984534052865?ref_src=twsrc%5Etfw">October 6, 2020</a></blockquote>
</div>



<p>WordPress lead developer Mark Jaquith <a href="https://twitter.com/markjaquith/status/1312178973372157953">called</a> APO &ldquo;incredible news for the WordPress world.&rdquo;</p>



<p>&ldquo;On sites I manage this is going to lower hosting complexity and easily save hundreds of dollars a month in hosting costs,&rdquo; Jaquith said.</p>



<p>After running several speed tests from six different locations around the world, early testers at Kinsta got remarkable results using APO:</p>



<blockquote class="wp-block-quote"><p>&ldquo;By caching&nbsp;static HTML&nbsp;on Cloudflare&rsquo;s edge network, we saw a 70-300% performance increase. As expected, the testing locations furthest away from Tokyo saw the biggest reduction in&nbsp;load time.</p><p>&ldquo;If your WordPress site uses a traditional&nbsp;CDN&nbsp;that only caches CSS, JS, and images, upgrading to Cloudflare&rsquo;s WordPress APO is a no-brainer and will help you stay competitive with modern Jamstack and static sites that live on the edge by default.&rdquo;</p></blockquote>



<p>George Liu, a &ldquo;self-confessed page speed addict&rdquo; and Cloudflare Community MVP, performed a series of <a href="https://community.centminmod.com/threads/cloudflare-wordpress-plugin-automatic-platform-optimization.20486/">detailed tests</a> on the new APO product with his blog. After many comparisons, he found that Cloudoflare&rsquo;s WordPress plugin with APO turned on delivers results similar to his heavily optimized WordPress blog that uses a custom Cloudflare Worker caching configuration.</p>



<p>&ldquo;You&rsquo;ll find that Cloudflare WordPress plugin&rsquo;s one click Automatic Platform Optimization button does wonders for page speed for the average WordPress user not well versed in page speed optimizations,&rdquo; Liu said.</p>



<p>&ldquo;Cloudflare&rsquo;s WordPress plugin Automatic Platform Optimization will in theory beat all other WordPress caching solutions other than you rolling out your own Cloudflare Worker based caching like I did. So you get a good bang for your buck at US$5/month for Cloudflare&rsquo;s WordPress plugin APO.&rdquo;</p>



<p>Liu also warned of some speed bumps with the initial rollout, as Cloudflare&rsquo;s APO supports a limited set of WordPress cookies for bypassing the Cloudflare CDN cache, leaving certain use cases unsupported. APO does not seem to work on subdomains and users are also reporting that it&rsquo;s not compatible with other caching plugins. It also disables real visitor IP address detection. </p>



<p>Cloudflare is aware of many of these issues, which have been raised in the comments of the <a href="https://blog.cloudflare.com/automatic-platform-optimizations-starting-with-wordpress/">announcement</a>, and is in the process of adding more cookies to the list to bypass caching. Due to some plugin conflicts, APO may not be as plug-and-play as it sounds for some users right now, but the product is very promising and should improve over time with more feedback.</p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Thu, 08 Oct 2020 04:18:28 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:13:"Sarah Gooding";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:31;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:86:"WPTavern: Kick off Block-Based WordPress Theme Development With the Theme.json Creator";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:30:"https://wptavern.com/?p=105832";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:217:"https://wptavern.com/kick-off-block-based-wordpress-theme-development-with-the-theme-json-creator?utm_source=rss&utm_medium=rss&utm_campaign=kick-off-block-based-wordpress-theme-development-with-the-theme-json-creator";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:4674:"<p class="has-drop-cap">Gutenberg 9.1 made a backward-incompatible change to its <code>theme.json</code> file (<code>experimental-theme.json</code> while full-site editing is under the experimental flag). This is the configuration file that theme developers will need to create as part of their block-based themes. Staying up to date with such changes can be a challenge for theme authors, but Ari Stathopoulos, a Themes Team representative, wrote a <a href="https://make.wordpress.org/themes/2020/10/01/gutenberg-9-1-new-json-structure-for-fse-theme-json-files/">full guide for developers</a>.</p>



<p>Jon Quach, a Principal Designer at Automattic, has also been busy creating a tool to help theme authors transition to block-based themes. He recently built a UI-based project called <a href="https://gutenberg-theme.xyz/">Theme.json Creator</a> that builds out the JSON code for theme authors. Plus, it is up to date with the most recent changes in the Gutenberg plugin.</p>



<p>Tools like these will be what the development community needs as it gets over the inevitable hump of moving away from the traditional theme development paradigm and into a new era where themes are made almost entirely of blocks and a config file.</p>



<p>While plugin development is becoming more complex with the addition of JavaScript, theme development is taking a sharp turn toward its roots of HTML and CSS. We are barreling toward a future in which far more people will be able to create WordPress themes. Even the possibility of sharing pieces of themes (e.g., template parts and patterns) is on the table. This could not only empower theme designers by lowering the barrier to entry, it could also empower some end-users to make the jump into theme building.</p>



<p>However, the <code>theme.json</code> file is one aspect of future theme authorship that is extremely developer-oriented. JSON is a universal format shared between various programming languages. It is meant to be read by machines and is not quite as human-friendly as other formats. As the <code>theme.json</code> file grows to accommodate more configuration options over time, the less friendly it will become to simply typing keys and values in.</p>



<p>It makes sense to build tools to simplify this part of the theme building process.</p>



<p>That is where the Theme.json Creator tool comes in. Theme authors pick and choose the options they want to support and input custom values. Then, the tool spits out everything in properly-formatted JSON.</p>



<img />Using the Theme.json Creator tool.



<p>One big thing the tool does not yet cover is custom CSS variables. This feature is a recent addition to the <code>theme.json</code> specification. It allows theme authors to create any custom property that WordPress will automatically output as CSS. In his announcement post, Stathopoulos covered how to create a typographic scale with custom properties and use those variables for editor features, such as line-height and font-size values.</p>



<p>Currently, Theme.json Creator&rsquo;s primary focus is on global styles. However, Gutenberg allows theme authors to configure default styles on the block level. For example, theme designers can set the color or typography options for the core Heading block to be different from the default global styles. This provides theme authors with fine-tuned control over every block.</p>



<p>Theme.json Creator does not yet support configuration at this level. However, it would be interesting to see if Quach adds it in the future.</p>



<p>The focus on setting up global styles is a good start for now. This is still an experimental feature. The great thing about it is that it can help theme authors begin to see how one piece of the block-based themes puzzle fits in. It is a starting point for an entirely new method of adding theme support for features when most are accustomed to adding multiple <code>add_theme_support()</code> PHP function calls.</p>



<p>With the direction that theme development seems to be heading, it is easy to imagine that it could evolve into a completely UI-based affair at some point down the line. If templates are made up of blocks and patterns, which anyone can already build with the block editor, and if styles will essentially boil down to a config file, there will be little-to-no programming required to build a basic WordPress theme.</p>



<p>If someone is not already at least jotting down notes for a plugin that allows users to create and package a block-based theme, I would be surprised. For now, Theme.json Creator is removing the need to write code for at least one part of the theme design process.</p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Wed, 07 Oct 2020 20:53:06 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:14:"Justin Tadlock";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:32;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:104:"WPTavern: Jetpack 9.0 Introduces Loom Block, Twitter Threads Feature, and Facebook and Instagram oEmbeds";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:30:"https://wptavern.com/?p=105743";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:249:"https://wptavern.com/jetpack-9-0-introduces-loom-block-twitter-threads-feature-and-facebook-and-instagram-oembeds?utm_source=rss&utm_medium=rss&utm_campaign=jetpack-9-0-introduces-loom-block-twitter-threads-feature-and-facebook-and-instagram-oembeds";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:4033:"<div class="wp-block-image"><img /></div>



<p>Jetpack&rsquo;s highly anticipated <a href="https://jetpack.com/2020/10/06/jetpack-9-0-continue-sharing-facebook-and-instagram-posts-on-your-site/">9.0 release</a> has landed, introducing some of the new features the team has previewed over the past week. Users can now <a href="https://wptavern.com/jetpack-9-0-to-introduce-new-feature-for-publishing-wordpress-posts-to-twitter-as-threads">publish WordPress posts to Twitter as threads</a>. This new feature is available as part of the Publicize module when you have connected a Twitter account. </p>



<p>Posting Twitter threads is a feature that only works with the block editor, as it takes advantage of how content is naturally split into chunks (blocks). </p>



<p>In the comments on his <a href="https://pento.net/2020/09/29/more-than-280-characters/">demo post</a>, Automattic engineer Gary Pendergast gave a more detailed breakdown of the logic Jetpack uses to ensure full sentences aren&rsquo;t broken up in the tweets. </p>



<p>&ldquo;With the mental model now being focused on mapping blocks to tweets, it&rsquo;s much easier to make logical decisions about how to handle each block,&rdquo; Pendergast said. &ldquo;So, a paragraph block is the text of a tweet, if the paragraph is too long for a single tweet, it tries to split the paragraph up by sentences. If a sentence is too long, then it resorts to splitting by words. Then, if there&rsquo;s an embed/image/video/gallery block following that paragraph, we can attach it to the tweet containing that paragraph. There are additional rules for other blocks, but that&rsquo;s the basic process. It then just iterates over all of the supported blocks in the post.&rdquo;</p>



<p>Pendergast <a href="https://twitter.com/GaryPendergast/status/1310769596794908674">published his post as thread</a> to demonstrate the new feature in action. The advantage of posting a thread from your WordPress site is that it doesn&rsquo;t end up getting lost in Twitter&rsquo;s fast-moving timeline. Most important Twitter threads evaporate from public consciousness almost as soon as they are published. Publishing threads from your website ensures they are better indexed and easier to reference in the future.</p>



<h2>Jetpack Adds Loom Block for Embedding Screen Recordings </h2>



<p><a href="https://www.loom.com/">Loom</a> was <a href="https://github.com/Automattic/jetpack/pull/17137">added to Jetpack</a> as a new oEmbed provider three weeks ago. The video recording service allows for recording camera, microphone, and desktop simultaneously. The service is especially popular in educational settings. Jetpack 9.0 introduces a new Loom block for embedding recordings. </p>



<img />



<p>&ldquo;Loom is growing in popularity as it is being recommended more and more to assist in distance learning efforts,&rdquo; Jetpack Director of Innovation Jesse Friedman said. &ldquo;Now more than ever we want to be able to help those working, learning, and teaching from home. The Loom block was a natural addition to join the other Jetpack video blocks which now include YouTube, TikTok, DailyMotion, and Vimeo.&rdquo;</p>



<p>Loom&rsquo;s free tier allows users to record up to 25 videos, but the Pro plan is free for educators. Friedman confirmed that Jetpack does not have any kind of partnership with Loom. The team decided to support the product to assist professionals, educators, and students. Having it available as a block also makes it more convenient for those using <a href="https://wordpress.com/p2/">P2</a> for communication.</p>



<p>As anticipated, Jetpack 9.0 also provides a seamless transition necessary to ensure Instagram and Facebook embeds will continue working after Facebook drops <a href="https://developers.facebook.com/docs/plugins/oembed-legacy">unauthenticated oEmbed support</a> on October 24. The Jetpack team reports that it &ldquo;partnered with Facebook&rdquo; to make sure these embeds continue to work with the WordPress.com REST API.</p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Tue, 06 Oct 2020 23:28:38 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:13:"Sarah Gooding";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:33;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:51:"Post Status: Joost de Valk on WordPress marketshare";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:31:"https://poststatus.com/?p=79914";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:62:"https://poststatus.com/joost-de-valk-on-wordpress-marketshare/";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:1193:"<p>David Bisset makes his podcast debut for Post Status, as he interviews Joost de Valk, Founder and Chief Product Officer of Yoast, and discusses all things WordPress marketshare related.</p>







<h3 id="h-links">Links</h3>



<ul><li>His blog, <a href="https://joost.blog/">joost.blog</a></li><li><a href="https://yoast.com">Yoast</a></li><li>On Twitter <a href="https://twitter.com/jdevalk">@jdevalk</a></li><li>June 2020 <a href="https://joost.blog/cms-market-share-june-2020-analysis/">CMS marketshare report</a></li></ul>



<h3>Partner:&nbsp;<a href="https://jilt.com/?utm_source=Post+Status&utm_medium=banner&utm_campaign=Post+Status+Sponsorship">Jilt</a></h3>



<p><a href="https://jilt.com/?utm_source=Post+Status&utm_medium=banner&utm_campaign=Post+Status+Sponsorship">Jilt</a> offers powerful email marketing built for eCommerce. From newsletters to highly segmented automations, Jilt is your one-stop show for eCommerce email. Join thousands of stores that have already earned tens of millions of dollars in extra sales using Jilt. <a href="https://jilt.com/?utm_source=Post+Status&utm_medium=banner&utm_campaign=Post+Status+Sponsorship">Try Jilt for free</a></p>



<p></p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Tue, 06 Oct 2020 22:28:00 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:15:"Brian Krogsgard";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:34;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:92:"WPTavern: iThemes Buys WPComplete, Complementing Its Recent Restrict Content Pro Acquisition";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:30:"https://wptavern.com/?p=105631";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:227:"https://wptavern.com/ithemes-buys-wpcomplete-complementing-its-recent-restrict-content-pro-acquisition?utm_source=rss&utm_medium=rss&utm_campaign=ithemes-buys-wpcomplete-complementing-its-recent-restrict-content-pro-acquisition";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:4395:"<p class="has-drop-cap">Just one month after publicly announcing its <a href="https://wptavern.com/ithemes-enters-the-wordpress-membership-plugin-market-acquires-restrict-content-pro">acquisition of Restrict Content Pro</a> (RCP), iThemes <a href="https://ithemes.com/wpcomplete-joining-ithemes-family/">purchased WPComplete</a> for an undisclosed amount. The acquisition is for the product, website, and customers only.</p>



<p>Paul Jarvis and Zack Gilbert created the <a href="https://wordpress.org/plugins/wpcomplete/">WPComplete plugin</a> in 2016. However, it has outgrown what the duo could maintain and support alone. After the transition period in which the new owners take over, the two will step away from the project.</p>



<p>In essence, <a href="https://wpcomplete.co/">WPComplete</a> is a &ldquo;course completion&rdquo; plugin. Site owners can create online courses while allowing students/users to mark their work as completed. It also gives students a way to track their progress through courses, which can often boost the potential for them to finish.</p>



<p>&ldquo;Paul and Jack believe a key to their success has been their ability to keep their team small and manageable,&rdquo; wrote Matt Danner, the COO at iThemes, in the announcement. &ldquo;The growth of WPComplete has presented a number of challenges for a team of two people, so the decision was made to start looking towards alternative ownership solutions that could continue to grow WPComplete and provide it with a stable team. iThemes is a perfect fit.&rdquo;</p>



<p>iThemes customers who have a Plugin Suite or Toolkit membership will get automatic access to the pro version of the WPComplete plugin. For current WPComplete users, Danner said everything should be &ldquo;business as usual.&rdquo; However, iThemes has assigned a few of its team members to work on the product and site, so customers should see some new faces.</p>



<p>RCP and WPComplete are obviously complementary products. RCP is a membership plugin that allows site owners to restrict content based on that membership. WPComplete allows site members to mark lessons or coursework as completed. &ldquo;We&rsquo;ll be rolling out a new bundle later this month that combines both RCP and WPComplete for course and membership creators to take advantage of these two plugins,&rdquo; said AJ Morris, the Product Innovation and Marketing Manager at iThemes.</p>



<p>WPComplete is still a young product. The free version of the plugin currently has 2,000+ active installs and a solid 4.7 rating on WordPress.org. If marketed as an extension of the RCP plugin, it automatically puts it in front of the eyes of 1,000s of more potential customers. It should be much easier to grow the plugin as part of a membership bundle.</p>



<p>iThemes is making some bold moves in the membership space. It will be interesting to see if the company makes any other acquisitions that could strengthen its product line and help it become more dominant. There is still a ton of room for growth in the membership segment of the market. There is also the potential for integrations with other major plugins.</p>



<p>&ldquo;Adding WPComplete to the iThemes product lineup also allows us to move more quickly on some plans we have for Restrict Content Pro,&rdquo; said Danner in the initial announcement. He also vaguely mentioned a couple of ideas the team had in the works but did not go into detail.</p>



<p>With a little prodding, Morris provided some insight into what they are planning for the immediate future. The biggest first step is tackling integration with the block editor. Currently, WPComplete uses shortcodes. The team&rsquo;s next step is likely to begin with creating block equivalents for those shortcodes.</p>



<p>&ldquo;After that, we&rsquo;ve touched on a few deeper integrations with Restrict Content Pro, like the possibility to restrict courses to memberships,&rdquo; said Morris.</p>



<p>The iThemes team does not plan to stop with WPComplete as part of its product lineup. One of the goals is to use the plugin for the iThemes website itself.  </p>



<p>&ldquo;We always try to eat our own dogfood when we can,&rdquo; said Morris. &ldquo;You&rsquo;ll see that with RCP and WPComplete early next year as we look to integrate them into our <a href="https://training.ithemes.com">iThemes Training</a> membership.&rdquo;</p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Tue, 06 Oct 2020 20:59:25 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:14:"Justin Tadlock";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:35;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:64:"WPTavern: Exploring Full-Site Editing With the Q WordPress Theme";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:30:"https://wptavern.com/?p=105676";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:173:"https://wptavern.com/exploring-full-site-editing-with-the-q-wordpress-theme?utm_source=rss&utm_medium=rss&utm_campaign=exploring-full-site-editing-with-the-q-wordpress-theme";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:7492:"<p class="has-drop-cap">I have been eagerly awaiting the moment when I could install a theme and truly test Gutenberg&rsquo;s full-site editing feature. By and large, each time I have tested it over the past few months, the experience has felt utterly broken. This is why I have remained skeptical of seeing the feature land in WordPress 5.6 this December.</p>



<p>The <a href="https://github.com/aristath/q">Q theme</a> by Ari Stathopoulos is the first theme that seems to be a decent working example. Whether that is a stroke of luck with timing or that this particular theme is simply built correctly is hard to tell &mdash; Stathopoulos is a team rep for the Themes Team. <a href="https://wptavern.com/gutenberg-9-1-adds-patterns-category-dropdown-and-reverts-block-based-widgets-in-the-customizer">Gutenberg 9.1</a> dropped last week with continued work toward site editing.</p>



<p>Q is as experimental as it gets. The <a href="https://make.wordpress.org/themes/2020/03/01/call-for-experimental-themes/">Themes Team put out an open call</a> for experimental, block-based themes as far back as March this year. However, not many have taken the team up on this offer. If approved, Q stands to be the first block-based theme to go live in the official WordPress directory. It still has to work its way through the standard <a href="https://themes.trac.wordpress.org/ticket/90263">review process</a>, awaiting its turn in the coming weeks.</p>



<p>On the whole, full-site editing remains a frustrating and confusing experience. I still remain skeptical about its readiness, even in beta form, to show off to the world in WordPress 5.6.</p>



<p>However, Q is an interesting theme to explore at this point for both end-users and theme developers. Users can install it and start tinkering with the site editing screen via the Gutenberg plugin. Developers can learn how global styles, templates, and template parts fit together from a working theme.</p>



<h2>Using the Site Editor</h2>



<img />Editing a single post in the site editor.



<p class="has-drop-cap">The Q theme requires the Gutenberg plugin and its full-site editing mode to be enabled. Generally, requiring a plugin is not allowed for themes in the directory. However, experimental Gutenberg themes are allowed to bypass this guideline.</p>



<p>Stathopoulos pointed out that the theme is highly experimental and should not be used on a production site. However, he is hopeful that it will get more eyes focused on full-site editing.</p>



<p>He mentioned that several items are broken, such as category archives not showing the correct posts. This is a current limitation of the Query block in Gutenberg. However, one of the best ways to find and recognize these types of issues is to have a theme that stays up with the pace of development.</p>



<p>Currently, the site editor feels like it is biting off more than it can chew. Not only can users edit the layout and design of the page, but they can also directly edit existing post content &mdash; don&rsquo;t try this at home unless you are willing for your post titles to get switched to the hyphenated slug. Should the site editor be handling the double-duty of design and content editing? If so, should design and content editing be handled in separate locations in the long term or be merged into one feature?</p>



<p>It feels raw. It is not geared toward users at this point.</p>



<p>The bright spot with the site editor is the current progress on template parts in the editor. Template parts are essentially &ldquo;modules&rdquo; that handle one part of the page. For example, the typical theme will have a header and footer template part. Currently, end-users can insert custom template parts or switch one template part for another. This opens a world of possibilities, such as users choosing between multiple header designs (template parts) for their sites.</p>



<img />Switching the header template part.



<p>The downside to the entire template system is that it seems so divorced from the site editor that it is hard to believe the average user would understand what is going on. Templates and template parts reside under the Appearance menu in the admin. The Site Editor is a separate, top-level menu item. Without any preexisting knowledge of how these pieces work together, it can be confusing.</p>



<p>Template parts worked for me in the site editor from the outset. However, they did not work on the front end at first. I continually received the &ldquo;template part not found&rdquo; message for hours. Then, at some point &mdash; whether through magic or a random save that pulled everything together &mdash; the feature began to output the previously-<em>missing</em> header and footer template parts.</p>



<h2>Glimpse Into the Future of Theme Development</h2>



<p class="has-drop-cap is-style-default">The Q theme has a scant few style rules, which it loads directly in the <code>&lt;head&gt;</code> section of the site in lieu of adding an extra stylesheet. It relies on the stock Gutenberg block styles on the front end with a few minor overrides. Most other custom styles are handled via the global styles system, which pulls from the theme&rsquo;s <code>experimental-theme.json</code> config file (will be <code>theme.json</code> in the future).</p>



<p>It begs the question of whether themes will necessarily need much in the way of CSS when full-site editing lands.</p>



<p>If WordPress allows users to configure most styles via block options and global styles overrides, themes may not need much more than their config files. After that, it would come down to registering custom block styles and patterns.</p>



<p>If this is the future that we are headed toward, anyone could essentially create a WordPress theme. And, those pieces, such as template parts and patterns, could all be shared between any site. In that future, themes may simply not matter anymore.</p>



<p>Last year, Mike Schinkel proposed <a href="https://mikeschinkel.me/2019/wordpress-should-deprecate-themes/">deprecating the theme system</a> altogether and replacing it with web components.</p>



<p>&ldquo;Rather than look for a theme that has all the features one needs &mdash; which I have found always limits the choices to zero &mdash; a site owner could look for the components and modules they need and then assemble their site from those modules,&rdquo; he said. &ldquo;They could pick a header, a footer, a home-page hero, a set of article cards, a pricing module, and so on.&rdquo;</p>



<p>The more I tinker with full-site editing, the more it feels like that is the lane that it will ultimately merge into. Imagine a future where end-users could pick and choose the pieces they wanted and simply have it look right on the front end.</p>



<p>It is exciting to think about that possibility. Both Schinkel and I have more of a background in programming than we do in design. It makes sense from that sort of analytical mindset to put everything into neat, reusable <em>boxes</em> because reuse is a cornerstone of smart programming.</p>



<p>However, I worry about the state of design in such a system with so many replaceable parts. Will designers be able to take holistic approaches to theme development, creating truly intricate pieces of art? Will that system essentially create a web of cookie-cutter sites? Or, will designers simply find ways to think outside the box  while within the constraints of the block system?</p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Mon, 05 Oct 2020 21:21:13 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:14:"Justin Tadlock";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:36;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:105:"WPTavern: Virtual Jamstack Conf to Feature Fireside Chat with Matt Mullenweg and Matt Biilmann, October 6";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:30:"https://wptavern.com/?p=105680";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:253:"https://wptavern.com/virtual-jamstack-conf-to-feature-fireside-chat-with-matt-mullenweg-and-matt-biilmann-october-6?utm_source=rss&utm_medium=rss&utm_campaign=virtual-jamstack-conf-to-feature-fireside-chat-with-matt-mullenweg-and-matt-biilmann-october-6";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:2618:"<div class="wp-block-image"><img />image credit: <a href="https://jamstackconf.com/">Jamstack Conf</a></div>



<p>The greater Jamstack community is coming together on October 6-7, 2020, for a <a href="https://jamstackconf.com/virtual/">virtual conference</a>. Organizers expect more than 15,000 attendees from around the globe over a two-day span that includes keynotes, sessions, interactive topic tables, workshops, speaker Q&amp;As, and networking opportunities. </p>



<p>Matt Mullenweg will be joining Netlify CEO Matt Biilmann on <a href="https://jamstackconfvirtual2020.sched.com/event/eqVI">day 1 at 12PM PDT</a> for a fireside chat moderated by<a href="https://css-tricks.com/"> CSS-Tricks</a> Creator Chris Coyier. The chat will go deeper on recent topics of contention, including developer sentiment, complexity, security, and performance. Coyier also plans to discuss how the Jamstack and WordPress communities intersect through headless implementations of the CMS.</p>



<p>A provocative post from <a href="https://thenewstack.io/wordpress-co-founder-matt-mullenweg-is-not-a-fan-of-jamstack/">TheNewStack</a> at the end of August quoted Mullenweg as saying that &ldquo;JAMstack is a regression for the vast majority of the people adopting it.&rdquo; This sparked multiple heated exchanges across blogs and social media. Biilimann, who originally coined the term &ldquo;Jamstack,&rdquo; wrote a <a href="https://www.netlify.com/blog/2020/09/15/on-mullenweg-and-the-jamstack-regression-or-future/">response</a> to Mullenweg&rsquo;s remarks, hailing &ldquo;the end of the WordPress era.&rdquo; </p>



<p>Live conversations tend to be more cordial than shots fired across the blogosphere. It will be interesting to see if Biilimann cares to join <a href="https://www.stackbit.com/">Stackbit</a> CEO Ohad Eder-Pressman in his wager that Jamstack will become the <a href="https://wptavern.com/matt-mullenweg-and-jamstack-community-square-off-making-long-term-bets-on-the-predominant-architecture-for-the-web">predominant architecture for the web by 2025</a>. The fireside chat should be recorded, in case you cannot catch the live session. Recordings of talks from the previous virtual Jamstack event held in May are <a href="https://www.youtube.com/playlist?list=PL58Wk5g77lF8jzqp_1cViDf-WilJsAvqT">available on YouTube</a>.</p>



<p>Today is the last call for registration. Many of the workshops have already sold out, but tickets to the regular sessions on October 6 are still available. <a href="https://ti.to/netlify/jamstack_virtual_oct">Sign up</a> on the event website to get your free ticket. </p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Mon, 05 Oct 2020 20:12:50 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:13:"Sarah Gooding";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:37;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:105:"WPTavern: Gutenberg 9.1 Adds Patterns Category Dropdown and Reverts Block-Based Widgets in the Customizer";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:30:"https://wptavern.com/?p=105629";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:255:"https://wptavern.com/gutenberg-9-1-adds-patterns-category-dropdown-and-reverts-block-based-widgets-in-the-customizer?utm_source=rss&utm_medium=rss&utm_campaign=gutenberg-9-1-adds-patterns-category-dropdown-and-reverts-block-based-widgets-in-the-customizer";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:5615:"<p class="has-drop-cap">Gutenberg 9.1 was released to the public on Wednesday. The team announced over 200 commits from 77 contributors in its <a href="https://make.wordpress.org/core/2020/10/01/whats-new-in-gutenberg-30-september/">release post</a> yesterday. One of the biggest changes to the interface was the addition of a new dropdown selector for block pattern categories. The team also reverted the block-based widgets section in the customizer and added an image size control to the Media &amp; Text block.</p>



<p>One of the main focuses of this release was improving the block-based widgets editor. The feature was taken out of the experimental stage in Gutenberg 8.9 and continues to improve. The widgets screen now uses the <a href="https://github.com/WordPress/gutenberg/pull/25681">same inserter UI</a> as the post-editing screen. However, users can currently only insert regular blocks. Patterns and reusable blocks are still not included.</p>



<p>Theme authors can now <a href="https://github.com/WordPress/gutenberg/issues/20588">control aspects of the block editor</a> via a custom <code>theme.json</code> file. This is part of the ongoing Global Styles project, which will allow theme authors to configure features for their users.</p>



<p>The development team has also added an <a href="https://github.com/WordPress/gutenberg/pull/25115">explicit box-sizing style rule</a> to the Cover and Group blocks. This is to avoid any potential issues with the new padding/spacing options. Theme authors who rely on the block editor styles should test their themes to make sure this change does not break anything.</p>



<h2>Better Pattern Organization</h2>



<img />New block patterns UI in the inserter.



<p class="has-drop-cap">I have been calling for the return of the tabbed pattern categories since <a href="https://wptavern.com/gutenberg-8-0-merges-block-and-pattern-inserter-adds-inline-formats-and-updates-code-editor">Gutenberg 8.0</a>, which was a regression from previous versions. For 11 versions, users have had to scroll and scroll and scroll through every block pattern just to find the one they wanted. The development team has sought to address this issue by using a <a href="https://github.com/WordPress/gutenberg/pull/24954">category dropdown selector</a>. When selecting a specific category, its patterns will appear.</p>



<p>At first, I was unsure about this method over the old tabbed method. However, after some use, it feels like the right direction.</p>



<p>As more and more theme and plugin authors add block pattern categories to users&rsquo; sites, the dropdown is a more sensible route. Even tabs could become unwieldy over time. The dropdown better organizes the list of categories and makes the UI cleaner. More than anything, I am enjoying the experience and look forward to this eventually landing in WordPress 5.6 later this year.</p>



<h2>Customizer Widgets Reverted</h2>



<img />Reverted widgets panel in the customizer.



<p class="has-drop-cap">On the subject of WordPress 5.6, one of its flagship features has been hitting some roadblocks. Block-based widgets are expected to land in core with the December release, but the team just reverted part of the feature. They had to remove the widgets block editor from the customizer they added just two major releases ago.</p>



<p>It was for the best. The customizer&rsquo;s block-based widgets editor was <a href="https://wptavern.com/gutenberg-8-9-brings-block-based-widgets-out-of-the-experimental-stage">fundamentally broken</a>. It was not ready for primetime and should have remained in the experimental stage until it was somewhat usable.</p>



<p>&ldquo;I will approve this since the current state of the customizer in the Gutenberg plugin is broken, and there is no clear path forward about how to fix that,&rdquo; wrote Andrei Draganescu in the <a href="https://github.com/WordPress/gutenberg/pull/25626">reversion ticket</a>. &ldquo;With this patch, the normal widgets can still be edited in the customizer and the block ones don&rsquo;t break it anymore. This is NOT to mean that we won&rsquo;t proceed with fixing the block editor in the customizer, that is still an ongoing discussion.&rdquo;</p>



<p>The current state of editing widgets via the customizer is at least workable with this change. If end-users add a block via the admin-side widgets editor, it will merely appear as an uneditable, <em>faux</em> widget named &ldquo;Block&rdquo; in the customizer. They will need to edit blocks via the normal widgets screen.</p>



<p>There is no way that WordPress can ship the current solution when 5.6 rolls out. However, we are still two months out. This leaves plenty of time for a fix, but Draganescu&rsquo;s note that &ldquo;there is no clear path forward&rdquo; may make some people a bit uneasy at this stage of development.</p>



<h2>Control Image Size for Media &amp; Text</h2>



<img />Image size dropdown selector for the Media &amp; Text block.



<p class="has-drop-cap">One of the bright spots in this update is the addition of an <a href="https://github.com/WordPress/gutenberg/pull/24795">image size control</a> to the Media &amp; Text block. Like the normal Image block, end-users can choose from any registered image size created for their uploaded image.</p>



<p>This is a feature I have been looking forward to in particular. Previously, using the full-sized image often made the page weight a bit heftier than necessary. It is also nice to go along with themes that register sizes for both landscape and portrait orientations, giving users more options.</p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Fri, 02 Oct 2020 20:56:14 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:14:"Justin Tadlock";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:38;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:58:"WordPress.org blog: The Month in WordPress: September 2020";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:34:"https://wordpress.org/news/?p=9026";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:73:"https://wordpress.org/news/2020/10/the-month-in-wordpress-september-2020/";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:8711:"<p>This month was characterized by some exciting announcements from the WordPress core team! Read on to catch up with all the WordPress news and updates from September.&nbsp;</p>



<hr class="wp-block-separator" />



<h2>WordPress 5.5.1 Launch</h2>



<p>On September 1, the&nbsp; Core team released <a href="https://wordpress.org/news/2020/09/wordpress-5-5-1-maintenance-release/">WordPress 5.5.1</a>. This maintenance release included several bug fixes for both core and the editor, and many other enhancements. You can update to the latest version directly from your WordPress dashboard or <a href="https://wordpress.org/download/">download</a> it directly from WordPress.org. The next major release will be <a href="https://make.wordpress.org/core/5-6/">version 5.6</a>.</p>



<p>Want to be involved in the next release?&nbsp; You can help to build WordPress Core by following<a href="https://make.wordpress.org/core/"> the Core team blog</a>, and joining the #core channel in <a href="https://make.wordpress.org/chat/">the Making WordPress Slack group</a>.</p>



<h2>Gutenberg 9.1, 9.0, and 8.9 are out</h2>



<p>The core team launched <a href="https://make.wordpress.org/core/2020/09/16/whats-new-in-gutenberg-16-september/">version 9.0</a> of the Gutenberg plugin on September 16, and <a href="https://make.wordpress.org/core/2020/10/01/whats-new-in-gutenberg-30-september/">version 9.1</a> on September 30. <a href="https://make.wordpress.org/core/2020/09/16/whats-new-in-gutenberg-16-september/">Version 9.0</a> features some useful enhancements — like a new look for the navigation screen (with drag and drop support in the list view) and modifications to the query block (including search, filtering by author, and support for tags). <a href="https://make.wordpress.org/core/2020/10/01/whats-new-in-gutenberg-30-september/">Version 9.1</a> adds improvements to global styles, along with improvements for the UI and several blocks. <a href="https://make.wordpress.org/core/2020/09/03/whats-new-in-gutenberg-2-september/">Version 8.9</a> of Gutenberg, which came out earlier in September, enables the block-based widgets feature (also known as block areas, and was previously available in the experiments section) by default — replacing the default WordPress widgets to the plugin. You can find out more about the Gutenberg roadmap in the <a href="https://make.wordpress.org/core/2020/09/03/whats-next-in-gutenberg-september/">What’s next in Gutenberg blog post</a>.</p>



<p>Want to get involved in building Gutenberg? Follow <a href="https://make.wordpress.org/core/">the Core team blog</a>, contribute to <a href="https://github.com/WordPress/gutenberg/">Gutenberg on GitHub</a>, and join the #core-editor channel in <a href="https://make.wordpress.org/chat/">the Making WordPress Slack group</a>.</p>



<h2>Twenty Twenty One is the WordPress 5.6 default theme</h2>



<p><a href="https://make.wordpress.org/core/2020/09/23/introducing-twenty-twenty-one/">Twenty Twenty One</a>, the brand new default theme for <a href="https://make.wordpress.org/core/5-6/">WordPress 5.6</a>, has been announced! Twenty Twenty One is designed to be a blank canvas for the block editor, and will adopt a straightforward, yet refined, design. The theme has a limited color palette: a pastel green background color, two shades of dark grey for text, and a native set of system fonts. Twenty Twenty One will use a modified version of the <a href="https://wordpress.org/themes/seedlet/">Seedlet theme</a> as its base. It will have a comprehensive system of nested CSS variables to make child theming easier, a native support for global styles, and full site editing.&nbsp;</p>



<p>Follow the <a href="https://make.wordpress.org/core/">Make/Core</a> blog if you wish to contribute to Twenty Twenty One. There will be weekly meetings every Monday at 15:00 UTC and triage sessions every Friday at 15:00 UTC in the #core-themes Slack channel. Theme development will happen <a href="https://github.com/wordpress/twentytwentyone.">on GitHub</a>. </p>



<hr class="wp-block-separator" />



<h2>Further Reading:</h2>



<ul><li>WordPress plugin authors can now <a href="https://meta.trac.wordpress.org/changeset/10255">opt into confirming plugin updates via email</a>. This feature will allow plugin authors to approve any plugin updates over email before release.</li><li>September was the busiest month for online WordCamps so far, with seven events taking place: <a href="https://ogijima.wordcamp.org/2020/">WordCamp Ogijima Online</a>, <a href="https://colombia.wordcamp.org/2020/">WordCamp Colombia Online</a>, <a href="https://2020.asheville.wordcamp.org/2020/">WordCamp Asheville, NC USA</a>, <a href="https://saopaulo.wordcamp.org/2020/">WordCamp São Paulo, Brazil</a>, <a href="https://2020.virginiabeach.wordcamp.org/">WordCamp Virginia Beach</a>, <a href="https://2020.lima.wordcamp.org/">WordCamp Lima Peru</a>, and <a href="https://philadelphia.wordcamp.org/2020/">WordCamp Philadelphia, PA, USA</a>. You can find live stream recaps of these events on their websites. The camps are also in the process of uploading their videos to <a href="https://wordpress.tv/">WordPress.tv</a>. Check out the <a href="https://central.wordcamp.org/schedule/">WordCamp Schedule</a> to follow upcoming online WordCamps!</li><li>The Themes team has added a <a href="https://meta.trac.wordpress.org/changeset/10240">delist feature</a> to the themes directory. The feature will allow a theme to be temporarily hidden from search, while still making it available. The team may delist themes if they violate the <a href="https://make.wordpress.org/themes/handbook/review/required/">Theme Directory guidelines</a>. </li><li>The Themes Team has also released its <a href="https://make.wordpress.org/themes/2020/09/25/new-package-to-allow-locally-hosting-webfonts/">new web fonts Loader project</a>. The webfonts loader will allow theme developers to load web fonts from the user’s site, rather than through a third-party CDN. The project lives in the team’s <a href="https://github.com/WPTT/webfont-loader">GitHub repository</a>.</li><li>The Support team is discussing<a href="https://make.wordpress.org/support/2020/09/talking-point-allowing-self-archival-of-topics/"> the level of control users should have</a> over their support forum topics. The team is thinking of allowing users to archive their topics and lengthen time-to-edit to remove any semi-sensitive data. In a separate, but related, post, Support team members have started discussing <a href="https://make.wordpress.org/support/2020/09/talking-point-handling-support-for-commercial-users-on-the-wordpress-forums/">how to curb support requests for commercial products</a>.</li><li>The Mobile team <a href="https://make.wordpress.org/core/2020/09/21/proposal-dual-licensing-gutenberg-under-gpl-v2-0-and-mpl-v2-0/">came up with a proposal for dual licensing Gutenberg</a> under GPL 2.0 and MPL (Mozilla Public License) 2.0, so that non-WordPress software developers can potentially use it for their projects.  </li><li>Since Facebook and Instagram are deprecating oEmbeds, the Core Team <a href="https://make.wordpress.org/core/2020/09/22/facebook-and-instagram-embeds-to-be-deprecated-october-24th/">will be removing Facebook and Instagram’s oEmbed endpoints</a> from WordPress core code. </li><li>Following extensive discussion, the Documentation team <a href="https://make.wordpress.org/docs/2020/09/14/external-linking-policy-meeting-notes-august-25th/">has tentatively decided to allow external and commercial links in the WordPress documentation</a>. The team aims to publish a formal proposal that will be left open for feedback before finalizing it.</li><li>Members of the Polyglots and Marketing teams are celebrating the <a href="https://make.wordpress.org/polyglots/2020/09/09/lets-celebrate-international-translation-day-together/">International Translation Day</a> for WordPress over the week of September 28 &#8211; October 4! Community members can join or organize translation events, or contribute to WordPress core, theme, or plugin translations during this period. </li><li><a href="https://wpaccessibilityday.org/">WP Accessibility day</a> — a 24-hour global online event dedicated to addressing website accessibility in WordPress, is being held on October 2. The event is open for all and has <a href="https://wpaccessibilityday.org/#talk-time">experts from all over the world as speakers</a>.</li></ul>



<p><em>Have a story that we should include in the next “Month in WordPress” post? Please </em><a href="https://make.wordpress.org/community/month-in-wordpress-submissions/"><em>submit it here</em></a><em>.</em></p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Fri, 02 Oct 2020 09:34:04 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:14:"Hari Shanker R";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:39;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:75:"WPTavern: Cloudflare Launches New Web Analytics Product Focusing on Privacy";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:30:"https://wptavern.com/?p=105446";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:195:"https://wptavern.com/cloudflare-launches-new-web-analytics-product-focusing-on-privacy?utm_source=rss&utm_medium=rss&utm_campaign=cloudflare-launches-new-web-analytics-product-focusing-on-privacy";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:2448:"<p>In pursuit of &ldquo;<a href="https://www.cloudflare.com/web-analytics/">democratizing web analytics</a>,&rdquo; Cloudflare announced it is launching privacy-first analytics as a new standalone product. The company is entering a market that has been <a href="https://www.datanyze.com/market-share/web-analytics--1/Alexa%20top%201M">dominated by Google Analytics</a> for years but with a major differentiating feature &ndash; it will not track individual users by a cookie or IP address to show unique visits.</p>



<p>Cloudflare Web Analytics defines a visit as &ldquo;a successful page view that has an&nbsp;<a rel="noreferrer noopener" href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Referer" target="_blank">HTTP referer</a>&nbsp;that doesn&rsquo;t match the hostname of the request.&rdquo; It&rsquo;s not the same as Google&rsquo;s &ldquo;unique&rdquo; metric, and Cloudflare says it may differ from other reporting tools. Weeding out bots from the total traffic numbers is a nascent feature that Cloudflare is improving as part of its&nbsp;<a rel="noreferrer noopener" href="https://www.cloudflare.com/products/bot-management/" target="_blank">Bot Management product</a>.</p>



<div class="wp-block-image"><img /></div>



<p>Cloudflare Web Analytics is launching with features that are largely similar to Google Analytics but with some unique ways of zooming into different traffic segments and time ranges to see where traffic is originating from. </p>



<p>&ldquo;The most popular analytics services available were built to help ad-supported sites sell more ads,&rdquo; Cloudflare product manager Jon Levine said. &ldquo;But, a lot of websites don&rsquo;t have ads. So if you use those services, you&rsquo;re giving up the privacy of your users in order to understand how what you&rsquo;ve put online is performing.</p>



<p>&ldquo;Cloudflare&rsquo;s business has never been built around tracking users or selling advertising. We don&rsquo;t want to know what you do on the Internet &mdash; it&rsquo;s not our business.&rdquo;</p>



<p>Paying customers on the Pro, Biz, and Enterprise plans can access their analytics from their dashboards immediately. Cloudflare is also offering the product for free as JavaScript-based analytics for users who are not currently customers. Those who want access to the free plan can sign up for the <a href="https://www.cloudflare.com/web-analytics/">waitlist</a>. </p>



<p> </p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Fri, 02 Oct 2020 04:03:01 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:13:"Sarah Gooding";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:40;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:67:"WPTavern: Virtual WordPress Page Builder Summit Kicks Off October 5";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:30:"https://wptavern.com/?p=105570";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:179:"https://wptavern.com/virtual-wordpress-page-builder-summit-kicks-off-october-5?utm_source=rss&utm_medium=rss&utm_campaign=virtual-wordpress-page-builder-summit-kicks-off-october-5";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:6348:"<p class="has-drop-cap">From October 5 through October 9, the first <a href="https://summit.camp/">Page Builder Summit</a> will open its virtual doors to all attendees for free. Nathan Wrigley, the podcaster behind WP Builds, and Anchen le Roux, the founder and lead developer of Simply Digital Design, are hosting the five-day online event that focuses on the vast ecosystem of page builders for WordPress.</p>



<p>The summit will include 35 sessions spread out over the <a href="https://summit.camp/schedule/">event schedule</a>. Each session will last around 30 minutes, so it will be easy to pop in and watch one in your downtime. Sessions will cover a range of builders, including the default WordPress block editor, Elementor, Beaver Builder, Oxygen, Brizy, and Divi.</p>



<p>&ldquo;It&rsquo;s an event specifically for users of WordPress page builders, or those curious about what they can do,&rdquo; said Wrigley. &ldquo;I feel like a page builder style interface for creating websites is the future for our industry. WordPress itself is moving in this direction with the block editor (a.k.a. Gutenberg). With that in mind, it seemed like a good idea to create a dedicated event to share knowledge about this side of WordPress. We&rsquo;ve tried to include presentations from as many page builders as we could.&rdquo;</p>



<p>Wrigley made sure to point out that it is not all geared toward developers, discussing the inner-workings of builders. Some of the sessions focus on marketing, optimization, and conversion, which provides a wider range of topics for potential attendees.</p>



<p>The summit hosts created an <a href="https://summit.camp/page-builder-quiz/">online quiz</a> for those who are unsure about which sessions to watch.</p>



<p>There is a small catch. The sessions will be freely available only from the time they begin and the following 24 hours. After that, accessing the videos will come at a premium. Attendees can gain lifetime access to the PowerPack for $47 if they purchase within 15 minutes of signing up. Then, prices will rise to $97 until the event kicks off on October 5. Beyond, the price jumps to $147. The lifetime access includes access to the presentations, transcripts, a workbook, and other bonuses from the speakers.</p>



<p>For those unsure about forking over the cash, they can still watch the sessions during the 24-hour window.</p>



<p>The proceeds from the event will go out to paying affiliate commissions to speakers and partners. Some of it will go into planning and investing in a second summit down the road.</p>



<p>&ldquo;Both myself and Nathan have specific charities that we want to donate to after the event,&rdquo; said le Roux. &ldquo;It was part of our goals to be able to do this, but we didn&rsquo;t want to make this an <em>official contribution</em>.&rdquo;</p>



<h2>Why a Page Builder Summit?</h2>



<p class="has-drop-cap">Both Wrigley and le Roux have their preferred builders. But, the goal of the summit is to offer a wide look at the tools available and help freelancers and agencies better streamline their businesses and create happier clients.</p>



<p>&ldquo;I&rsquo;ve been a user of page builders for many years, but only at the point where they truly showed in the editing interface something that almost perfectly reflected what the end-user would see did I get really immersed,&rdquo; said Wrigley. &ldquo;Having come from a background in which I built entire websites from a collection of text files (HTML, CSS, PHP, etc.), I was fascinated that we&rsquo;d reached a point where the learning curve for building a good website was significantly reduced.&rdquo;</p>



<p>He pointed out that it is not always so simple though. While the same level of coding skills may not be necessary, people must figure out how to navigate their preferred page builder, which can come with its own learning curve.</p>



<p>&ldquo;You need to learn their way of doing things and how to achieve your design choices,&rdquo; he said. &ldquo;It&rsquo;s always going to work out better if you know the code, but the WordPress mission of democratizing publishing certainly seems to align quite nicely with the adoption of tools, like page builders, which mean that once-difficult tasks are now easier.&rdquo;</p>



<p>For le Roux, her interest in hosting the Page Builder Summit falls back to her design studio.</p>



<p>&ldquo;As a developer, my main reason for switching to page builders was around streamlining and creating more efficient but quality websites in the shortest amount of time,&rdquo; she said. &ldquo;Especially now that we focus on day rates, creating the best possible website that clients would love fast would not have been possible without page builders.&rdquo;</p>



<h2>The Hosts&rsquo; Go-To Builders</h2>



<p>&ldquo;We prefer using Beaver Builder with Themer at Simply Digital Design,&rdquo; said le Roux. &ldquo;We use Gutenberg for blog posts or where possible with custom post types or LMS software. However, we&rsquo;ve also taken on a few Elementor projects where that&rsquo;s the client&rsquo;s preferred option.&rdquo;</p>



<p>Wrigley uses some of the same tools. His main work is on the WP Builds website where he hosts podcasts.</p>



<p>&ldquo;I have used Beaver Builder&rsquo;s Themer to create templates for specific layouts, but for content creation within those layouts I&rsquo;m using the block editor,&rdquo; said Wrigley. &ldquo;My content is mainly text and the WordPress editor is utterly remarkable in this situation. I kept the classic editor installed for a few months after WordPress 5.0 came about, but I soon realized that this was folly and that the editing interface of Gutenberg is superior. The ability to insert and move text, buttons, etc. is such a joy to work with, and the iterations that have been made in the last two years make it, in my opinion, the best text editing experience on the web.&rdquo;</p>



<p>Wrigley sees a future in which the WordPress block editor takes over much of the work that page builders are currently handling. However, that future is &ldquo;still over the horizon.&rdquo;</p>



<p>&ldquo;I&rsquo;m excited about this future though, and we&rsquo;ve got a few crystal ball-gazing presentations; trying to work out what that future might look like,&rdquo; he said.</p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Thu, 01 Oct 2020 20:31:07 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:14:"Justin Tadlock";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:41;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:99:"WPTavern: Jetpack 9.0 to Introduce New Feature for Publishing WordPress Posts to Twitter as Threads";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:30:"https://wptavern.com/?p=105448";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:243:"https://wptavern.com/jetpack-9-0-to-introduce-new-feature-for-publishing-wordpress-posts-to-twitter-as-threads?utm_source=rss&utm_medium=rss&utm_campaign=jetpack-9-0-to-introduce-new-feature-for-publishing-wordpress-posts-to-twitter-as-threads";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:3318:"<p>Jetpack 9.0, coming on October 6, will debut a new feature that allows users to <a href="https://github.com/Automattic/jetpack/pull/16699">share blog posts as Twitter threads</a> in multiples tweets. A recent version of Jetpack introduced the ability to import and <a href="https://wptavern.com/jetpack-8-7-adds-new-tweetstorm-unroll-feature-improves-search-customization">unroll tweetstorms for publishing inside a post</a>. The 9.0 release will run it back the other way so the content originates in WordPress, yet still reaps all the same benefits of circulation on Twitter as a thread. </p>



<p>The new Twitter threads feature is being added as part of Jetpack&rsquo;s Publicize module under the Twitter settings.  After linking up a Twitter account, the Jetpack sidebar options for Publicize allow users to publish to Twitter as a link to the blog or a set of threaded tweets. It&rsquo;s not just limited to text content &ndash; the threads feature will also upload and attach any images and videos included in the post. </p>



<img />



<p>When first introduced to the idea of publishing a Twitter thread from WordPress, I wondered if threads might lose their trademark pithy punch, since users aren&rsquo;t forced to keep each segment to the standard length of a tweet. Would each tweet be separated in an odd, unreadable way? The Jetpack team anticipated this, so the thread option adds more information to the block editor to show where the paragraphs will be split into multiple tweets.</p>



<p>&ldquo;Threads are wildly underused on Twitter,&rdquo; Gary Pendergast said in a <a href="https://pento.net/2020/09/29/more-than-280-characters/">post</a> introducing the feature. &ldquo;I think a big part of that is the UI for writing threads: while it&rsquo;s suited to writing a thread as a series of related tweet-sized chunks, it doesn&rsquo;t lend itself to writing, revising, and editing anything more complex.&rdquo; The tool Pendergast has been working on for Jetpack gives users the best of both worlds.</p>



<p>In response to a comment requesting Automattic &ldquo;concentrate on tools to get people off social media,&rdquo; Pendergast said, &ldquo;If we&rsquo;re also able to improve the quality of conversations on social media, I think it&rsquo;d be remiss of us to not do so.&rdquo; He also credits IndieWeb discussions on&nbsp;<a href="https://indieweb.org/tweetstorm">Tweetstorms</a>&nbsp;and&nbsp;<a href="https://indieweb.org/POSSE">POSSE</a> (Publish (on your) Own Site,&nbsp;Syndicate&nbsp;Elsewhere) as inspirations for the feature.</p>



<p>For years, blogging advocates have tried to convince those who post lengthy tweetstorms to switch to a publishing medium that is more suitable to the length of their thoughts. The problem is that Twitter users lose so much of the immediate feedback and momentum that their thoughts would have generated when composed as a tweetstorm.</p>



<p>Instead of lecturing people about how they should really be blogging instead of tweetstorming, Jetpack is taking a fresh approach by enabling full content ownership with effortless social syndication. You can test out the experience for yourself by adding the <a href="https://jetpack.com/download-jetpack-beta/">Jetpack Beta Testers</a> plugin and running the 9.0 RC version on your site.</p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Thu, 01 Oct 2020 02:56:46 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:13:"Sarah Gooding";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:42;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:63:"WPTavern: Ask the Bartender: How To WordPress in a Block World?";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:30:"https://wptavern.com/?p=105491";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:167:"https://wptavern.com/ask-the-bartender-how-to-wordpress-in-a-block-world?utm_source=rss&utm_medium=rss&utm_campaign=ask-the-bartender-how-to-wordpress-in-a-block-world";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:9755:"<blockquote class="wp-block-quote"><p>I love your articles. And now, in the middle of the WordPress revolution, I realized I&rsquo;m constantly searching for an answer regarding WP these days.</p><p>So many things are being said, so many previsions of the future, problems, etc., but, right now, I think I, as a designer, just want to understand one thing that seemed answered already but it&rsquo;s never clear:</p><p>Is WordPress a good choice to build a client&rsquo;s template where he just has to insert the info that will show in the frontend where I want to? And he doesn&rsquo;t have to worry about formatting blocks? I love blocks, don&rsquo;t get me wrong, but will normal templating end?</p><p>I just think that having a super CMS, HTML, CSS, and being able to play with a database with ACF is so powerful, that I&rsquo;m wondering if it&rsquo;s lost. After so much reading, I still don&rsquo;t understand if this paradigm is going to disappear.</p><p>Right now, I don&rsquo;t know if it&rsquo;s best to stop making websites as I used to and adopt block patterns instead.</p><cite>Ricardo</cite></blockquote>



<p class="has-drop-cap">WordPress is definitely changing. Over the past two years, we have seen much of it reshaped into something different from the previous decade and more. However, this is not new. WordPress has always been a constantly-changing platform. It just feels far too different this time around, almost foreign to many. The platform had to make a leap. Otherwise, it would have started falling behind.</p>



<p>And, it is a big <em>ask</em> of the existing community to come along with it, to take that leap together.</p>



<p>It can be scary as a developer whose livelihood has depended on things working a certain way or who has built tools and systems around pre-block WordPress. Many freelancers and agencies had their world turned upside down with the launch of the block editor. It is perfectly OK to feel a bit lost.</p>



<p>Now, it is time for a little tough love. It has been two years. As a professional, you need to have a plan in place already. Whether that is an educational plan for yourself or a transitional plan for your clients, you should already be tackling projects that leverage the block editor. If you are at a point where you have not been building with blocks, you are now behind. However, you can still catch up and continue advancing in your WordPress career.</p>



<p>There are so many changes coming down the pipeline that anyone who plans to develop for WordPress will be in continual education mode for years to come.</p>



<p>When building for clients, the biggest thing to remember is that it is not about you. It is about getting something into the hands of your clients that addresses their specific needs. Freelancers and agencies need to often be the Jacks and Jills of all trades. Sometimes, this even means having a backup CMS or two that you can use that are not named WordPress. It helps to be well-rounded enough to jump around when needed, especially if you are not at a point in your career where you can demand specific work and pass on jobs that would put food on the table.</p>



<p>It is also easy to look at every job as a nail and WordPress as the hammer. Or, even specific plugins as the tool that will always get the job done. I have seen developers in the past rely on tools like ACF, CMB2, or Meta Box but could not code a custom metadata solution when necessary to save their life.  Sometimes a bigger toolbox is necessary.</p>



<p>Every WordPress developer needs a solid, foundational understanding of the languages that WordPress uses. Gone are the days of skating by on HTML, CSS, and PHP knowledge. You need to learn JavaScript deeply. Matt Mullenweg, the co-founder of WordPress, was not joking around when he <a href="https://wptavern.com/state-of-the-word-2015-javascript-and-api-driven-interfaces-are-the-future-of-wordpress">said this back in 2015</a>. It holds true more and more each day. In another five years, it will tough to be a developer in the WordPress world without knowing JavaScript, at least for backend work.</p>



<p>It also depends on what types of sites you are building. If you are primarily handling front-end design, you will likely be able to get by with a lower skill level. You will just need to know the &ldquo;WordPress way&rdquo; of building themes.</p>



<p>Within the next year, you should be able to build just about any theme design with decent CSS and HTML knowledge along with an understanding of how the block system works. Full-site editing and block-based themes will change how we build the front end of the web. It is going to be a challenging transition at first, especially for those of us who are steeped in traditional theme development, but client sites will often be far easier to build.  I highly recommend the twice-monthly <a href="https://make.wordpress.org/themes/">block-based themes meetings</a> if your focus is on the front end.</p>



<h2>Block Templates</h2>



<p class="has-drop-cap">Based on your question, I am going to make some assumptions. You have a history of essentially building out meta boxes via ACF where the client just pops in their data. Then, you format that data on the front end. You are likely mixing this with custom post types (CPTs). This is a fairly common scenario.</p>



<p>One of the great things about the block system is that you can lock the post editor for individual CPTs. WordPress already has you covered with its <a href="https://developer.wordpress.org/block-editor/developers/block-api/block-templates/">block templates feature</a>, which allows you to define just what a post should look like. You can set up which blocks you want to appear and have the client drop their content in. At the moment, this feature is limited to the post type level. However, it should grow more robust over time, particularly when it works alongside the traditional &ldquo;page templates&rdquo; system.</p>



<p>Block templates are a powerful tool in the ol&rsquo; toolbox that will come in handy when building client sites.</p>



<h2>Block Patterns</h2>



<p class="has-drop-cap">You do not have to stop making websites as you are accustomed to at the moment. However, you should start leveraging new block features as they become available and make sense for a specific project. I am a fanatic when it comes to <a href="https://wptavern.com/block-patterns-will-change-everything">block patterns</a>, so my bias will definitely show.</p>



<p>The biggest thing with block patterns and clients is education. For the uninitiated, you will need to spend some time teaching them how to insert a pattern and how it can be used to their advantage. That is the hurdle you must jump.</p>



<p>For many of the users that I have seen introduced to well-designed patterns, they have fallen in love with the feature. Even many who were reluctant to switch to the block editor became far more comfortable working with it after learning how patterns worked. This is not the case for every user or client, but it has been a good introduction point to the block editor for many.</p>



<p>To answer your question regarding patterns: yes, you should absolutely begin to adopt them.</p>



<h2>ACF Is Evolving</h2>



<p class="has-drop-cap">Because you are accustomed to ACF, you should be aware that the framework is evolving to keep up with the block editor. <a href="https://wptavern.com/advanced-custom-fields-5-8-0-introduces-acf-blocks-a-php-framework-for-creating-gutenberg-blocks">Version 5.8.0</a> introduced a PHP framework for creating custom blocks over a year ago. And, it has been improving ever since. There are even projects like <a href="https://wptavern.com/acf-blocks-provides-assortment-of-blocks-built-from-advanced-custom-fields-pro">ACF Blocks</a>, which will provide even more tools for your arsenal.</p>



<p>It is important to learn from what some of the larger agencies are doing. Read up on how <a href="https://webdevstudios.com/2020/09/08/gutenberg-first/">WebDevStudios is tackling block development</a>. The company also has an open-source <a href="https://github.com/WebDevStudios/wds-acf-blocks">block library</a> for ACF.</p>



<h2>Solving Problems</h2>



<p class="has-drop-cap">Your job as a developer is to be a problem solver. Whatever system you are building with is merely a part of your toolset. You need to be able to solve issues regardless of what tool you are using. At the end of the day, it is just code. If you can learn HTML, you can learn CSS. If you can learn those, you can learn PHP. And, if you can manage PHP, you can certainly pick up JavaScript.</p>



<p>A decade or two from now, you will need to learn something else to stay relevant in your career. Web technology changes. You must change with it. Always consider yourself a student and continue your education. Surround yourself and learn from those who are more advanced than you. Emulate, borrow, and steal good ideas. Use what you have learned to make them great.</p>



<p>There is no answer I can give that will be perfect for every scenario. Each client is unique, and you will need to decide the best direction for each.</p>



<p>However, yes, you should already be on the path to building with a block-first mindset if you plan to continue working with WordPress for the long haul. Immerse yourself in the system. Read, study, and build something any chance you get.</p>



<p class="has-white-color has-blue-700-background-color has-text-color has-background text-white bg-blue-700">This is the first post in the Ask the Bartender series.  Have a question of your own? <a href="https://wptavern.com/contact-me/ask-the-bartender">Shoot it over</a>.</p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Wed, 30 Sep 2020 20:35:25 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:14:"Justin Tadlock";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:43;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:91:"WPTavern: Supercharge the Default WordPress Theme With Twentig, a Toolbox for Twenty Twenty";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:30:"https://wptavern.com/?p=105344";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:225:"https://wptavern.com/supercharge-the-default-wordpress-theme-with-twentig-a-toolbox-for-twenty-twenty?utm_source=rss&utm_medium=rss&utm_campaign=supercharge-the-default-wordpress-theme-with-twentig-a-toolbox-for-twenty-twenty";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:6455:"<img />Custom page pattern from the Twentig plugin.



<p class="has-drop-cap">I am often on the hunt for those hidden gems when it comes to block-related plugins. I like to see the interesting places that plugin authors venture. That is why it came as a surprise when <a href="https://twitter.com/Gtarafdarr/status/1310240580140556290">someone recommended</a> I check out the <a href="https://wordpress.org/plugins/twentig/">Twentig plugin</a> a few days ago. Somehow, it has flown under my radar for months. And, it has managed to do this while being one of the more interesting plugins for WordPress I have seen in the past year.</p>



<p>Twentig is a plugin that essentially gives superpowers to the default Twenty Twenty theme.  Diane and Yann Collet are the sibling co-founders and brains behind the plugin.</p>



<p>While I have been generally a fan of Twenty Twenty since it was <a href="https://wptavern.com/twenty-twenty-bundled-in-core-beta-features-overview">first bundled in core</a>, it was almost a bit of a letdown in some ways. It was supposed to be the theme that truly showcased what the block editor could do &mdash; and it does a fine job of styling the default blocks &mdash; but there was a lot of potential left on the table. The Twentig plugin turns Twenty Twenty into something worthier of a showcase for the block editor. It is that missing piece, that extra mile in which WordPress should be marching its default themes.</p>



<p>While the new <a href="https://wptavern.com/first-look-at-twenty-twenty-one-wordpresss-upcoming-default-theme">Twenty Twenty-One</a> default theme is just around the corner, Twentig is breathing new life into the past year&rsquo;s theme. The developers behind the plugin are still fixing bugs and bringing new features users.</p>



<p>Of its 34 reviews on WordPress.org, Twentig has earned a solid five-star rating. That is a nice score for a plugin with only 4,000 active installations. As I said, it has flown under the radar a bit, but the users who have found it have obviously discovered something that adds those extra touches to their sites they need.</p>



<h2>What Does Twentig Do?</h2>



<p class="has-drop-cap">It is a toolbox for Twenty Twenty. The headline feature is its block editor features, such as custom patterns and page layouts. It also offers a slew of customizer options that allow end-users to put their own design spin on the default theme. However, my interest is primarily in how it extends the block editor. </p>



<p>Let&rsquo;s get this out of the way up front. Twentig&rsquo;s one downside is that it adds a significant amount of additional CSS on top of the already-heavy Twenty Twenty and block editor styles. I will blame the current lack of a full design system from WordPress on most of this. Styling for the block editor can easily bloat a stylesheet. Adding an extra 100+ kb per page load might be a blocker for some who would like to try the plugin. Users will need to weigh the trade-offs between the additional features and the added page size.</p>



<p>The thing that makes Twentig special is its extensive patterns and pages library, which offers one-click access to hundreds of layouts specifically catered to the Twenty Twenty theme.</p>



<img />Inserting one of the hero patterns.



<p>It took me a few minutes to figure out how to access the patterns &mdash; mainly because I did not read the manual. I expected to find them mixed in with the core patterns inserter. However, the plugin adds a new sidebar panel to the editor, which users can access by clicking the &ldquo;tw&rdquo; icon. After seeing the list of options, I can understand why they probably would not fit into WordPress&rsquo;s limited block and patterns inserter UI.</p>



<p>It would be easier to list what the plugin does not have than to go through each of the custom patterns and pages.</p>



<p>The one thing that truly sets this plugin apart from the dozens of other block-library types of plugins is that there are no hiccups with the design. Almost every similar plugin or tool I have tested has had CSS conflicts with themes because they are trying to be a tool for every user. Twentig specifically targets the Twenty Twenty theme, which means it does not have to worry about whether it looks good with the other thousands of themes out there. It has one job, which is to extend its preferred theme, and it does it with well-designed block output.</p>



<p>The other aspect of this is that it does not introduce new blocks. Every pattern and page layout option uses the core WordPress blocks, which includes everything from hero sections to testimonials to pricing tables to event listings.  And more.</p>



<p>Twentig does not stop adding features to the block editor with custom patterns. The useful and sometimes fun bits are on the individual block level, and I have yet to explore everything. I continue to discover new settings each time I open my editor.</p>



<p>Whether it is custom pullquote styles, a photo image frame, or an inner border tweak to the Cover block (shown below), the plugin adds little extras that push what users can do with their content.</p>



<img />Inner border style for the Cover block.



<p>Each block also gets some basic top and bottom margin options, which comes in handy when laying out a page. At this point, I am simply looking forward to discovering features I have yet to find.</p>



<h2>Areas Themes Should Explore</h2>



<p class="has-drop-cap">One of the things I dislike about many of these features being within the Twentig plugin is that I would like to see them within the Twenty Twenty theme instead. Obviously not every feature belongs in the theme &mdash; some features firmly land in plugin territory. The default WordPress themes should also leave some room for plugin authors to explore. But, shipping some of the more prominent patterns and styles with Twenty Twenty would make a more robust experience for the average end-user looking to get the most out of blocks.</p>



<p>Block patterns were not a core WordPress feature when Twenty Twenty landed. However, for the upcoming Twenty Twenty-One theme, which is expected to bundle some unique patterns, the design team should explore what the Twentig plugin has brought to the current default. That is the direction that theme development should be heading, and theme developers can learn a lot by <s>stealing</s> borrowing from this plugin.</p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Tue, 29 Sep 2020 22:00:42 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:14:"Justin Tadlock";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:44;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:105:"WPTavern: Coming in Jetpack 9.0: Shortcode Embeds Module Updated to Handle Facebook and Instagram oEmbeds";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:30:"https://wptavern.com/?p=105381";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:253:"https://wptavern.com/coming-in-jetpack-9-0-shortcode-embeds-module-updated-to-handle-facebook-and-instagram-oembeds?utm_source=rss&utm_medium=rss&utm_campaign=coming-in-jetpack-9-0-shortcode-embeds-module-updated-to-handle-facebook-and-instagram-oembeds";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:2938:"<p>Facebook and Instagram are&nbsp;<a href="https://wptavern.com/upcoming-api-change-will-break-facebook-and-instagram-oembed-links-across-the-web-beginning-october-24">dropping unauthenticated oEmbed support</a>&nbsp;on October&nbsp;24. WordPress will be removing both Facebook and Instagram as oEmbed providers in an upcoming release. After evaluating third-party solutions, WordPress VIP is <a href="https://lobby.vip.wordpress.com/2020/09/28/updates-and-recommendations-facebook-and-instagram-changing-oembed-to-require-authentication/">recommending</a> its partners enable Jetpack&rsquo;s <a href="https://jetpack.com/support/shortcode-embeds/">Shortcode Embeds</a> module. Jetpack will be shipping the update in its <a href="https://github.com/Automattic/jetpack/milestone/166">9.0 release</a>, which is anticipated to land prior to the October 24th deadline.</p>



<p>The module is being <a href="https://github.com/Automattic/jetpack/pull/16814">updated</a> to provide a seamless transition for users who might otherwise be negatively impacted by Facebook&rsquo;s upcoming API change. WordPress contributors have run some simulations but are not yet sure what will happen to the display for previously embedded content.</p>



<p>&ldquo;It is possible that they change the contents of the JS file to manipulate cached embeds, perhaps to display a warning that the site is using an old method to embed content or that the request is not properly authenticated,&rdquo; Jonathan Desrosiers commented on the trac <a href="https://core.trac.wordpress.org/ticket/50861#comment:35">ticket</a> for removing the oEmbed providers.</p>



<p>WordPress.com VIP roughly outlined what users can expect if they do not enable a solution to begin authenticating oEmbeds:</p>



<blockquote class="wp-block-quote"><p>By default, WordPress caches oEmbed contents in post metadata. These embeds will continue to display in previously-published content.&nbsp;If you edit older posts in the Block Editor, regardless of whether you update the post by saving changes, the embeds in the post will no longer be cached and will stop displaying.&nbsp;If you view these older posts using the Classic Editor, so long as the post is not re-saved, the embeds will continue to function and display properly. If you update the post content, the embed will cease functioning unless you have a mitigation installed.</p></blockquote>



<p>Although WordPress VIP recommends using the Jetpack module as the best solution, self-hosted WordPress users may want to investigate other options if they are not already using Jetpack. <a href="https://wordpress.org/plugins/oembed-plus/">oEmbed Plus</a> is a free plugin created specifically for solving the problem of WordPress dropping Facebook and Instagram as oEmbed providers but it is more work to set up and configure. It requires users to register as a Facebook developer and create an app to get API credentials.</p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Tue, 29 Sep 2020 21:18:52 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:13:"Sarah Gooding";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:45;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:52:"WPTavern: W3C Selects Craft CMS for Redesign Project";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:30:"https://wptavern.com/?p=105265";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:149:"https://wptavern.com/w3c-selects-craft-cms-for-redesign-project?utm_source=rss&utm_medium=rss&utm_campaign=w3c-selects-craft-cms-for-redesign-project";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:9407:"<p>W3C has <a href="https://w3c.studio24.net/docs/cms-selection-report/">selected Craft CMS</a> over Statamic for its redesign project, after <a href="https://wptavern.com/w3c-drops-wordpress-from-consideration-for-redesign-narrows-cms-shortlist-to-statamic-and-craft">dropping WordPress from consideration</a> in an earlier round of elimination: </p>



<blockquote class="wp-block-quote"><p>In the end, our decision mostly came down to available resources. Craft had already committed to reach AA compliance in Craft 4 (it is currently on version 3.5, the release of version 4 is planned for April 2021). They had also arranged for an external agency to provide them with accessibility issues to tackle weekly. In the end, they decided instead to hire an in-house accessibility specialist to perform assessments and assist the development team in adopting accessibility patterns in the long run.</p><cite><a href="https://w3c.studio24.net/docs/cms-selection-report/">W3C CMS Selection Report</a></cite></blockquote>



<p>Last week we published a <a href="https://wptavern.com/w3c-drops-wordpress-from-consideration-for-redesign-narrows-cms-shortlist-to-statamic-and-craft">post</a> urging W3C to revisit Gutenberg for a fair shake against the proprietary CMS&rsquo;s or consider adopting another open source option. During the selection process, Studio 24, the agency contracted for the redesign, cited its extensive experience with WordPress as the reason for not performing any accessibility testing on more recent versions of Gutenberg. </p>



<p>When asked if the  team contacted anyone from WordPress&rsquo; Accessibility Team during the process or put Gutenberg through the same tests as the proprietary CMS&rsquo;s, Studio 24 founder Simon Jones <a href="https://twitter.com/simonrjones/status/1309817109636157440">confirmed</a> they had not. </p>



<p>&ldquo;No, we only reached out to the two shortlisted CMS&rsquo;s&rdquo; Jones said. &ldquo;I&rsquo;m afraid we didn&rsquo;t have time to do more. We did test GB a few months ago based on editing content &ndash; though it wasn&rsquo;t the only factor in our choice. As an agency we do plan to keep reviewing GB in the future.&rdquo; </p>



<p>In response to our concerns regarding licensing, Jones penned an update titled &ldquo;<a href="https://w3c.studio24.net/updates/on-not-choosing-wordpress/">On not choosing WordPress,</a>&rdquo; which further elaborated on the reasons why the agency was not inclined towards using or evaluating the new editor:</p>



<blockquote class="wp-block-quote"><p>From a business perspective I also believe Gutenberg creates a complexity issue that makes it challenging for use by many agencies who create custom websites for clients; where we have a need to create lots of bespoke blocks and page elements for individual client projects.</p><p>The use of React complicates front-end build. We have very talented front-end developers, however, they are not React experts &ndash; nor should they need to be. I believe front-end should be built as standards-compliant HTML/CSS with JavaScript used to enrich functionality where necessary and appropriate.</p><p>As of yet, we have not found a satisfactory (and profitable) way to build custom Gutenberg blocks for commercial projects.&nbsp;</p></blockquote>



<p>The CMS selection report also stated that W3C needs the CMS to be &ldquo;usable by non-sighted users&rdquo; by the launch date, since some members of the staff who contribute to the website are non-sighted. </p>



<p>Since the most recent version of WordPress was not tested in comparison with the proprietary CMS&rsquo;s, it&rsquo;s unclear how much better they handle accessibility. Ultimately, W3C and Studio 24 were more comfortable moving forward with a proprietary vendor that was able to make certain assurances about the future accessibility of its authoring tool, despite having a smaller pool of contributors.</p>



<p>&ldquo;[I&rsquo;m] also deeply curious since the cursory notes on accessibility for both of the reviewed CMSes seem to highlight a ton of issues like &lsquo;Buttons and Checkboxes are built using div elements&rsquo; or most inputs lacking clear focus styles,&rdquo; Gutenberg technical lead Mat&iacute;as Ventura said. &ldquo;An element like the&nbsp;<em>Calendar</em>&nbsp;for choosing a post date seems entirely inoperable with keyboard on Craft, for example, while WordPress&rsquo; has had significant effort and rounds of feedback poured into that element alone to make it fully operable.&rdquo;</p>



<p>WordPress developer Anthony Burchell commented on how using a relatively new proprietary CMS seemed counter to W3C&rsquo;s stated goal to select an option on the basis of longevity. Craft CMS&rsquo;s continued success is contingent upon its business model and the company&rsquo;s ability to remain profitable. </p>



<p>&ldquo;FOSS have the same opportunity of direct access to developers,&rdquo; Burchell <a href="https://twitter.com/antpb/status/1309883204728430593?ref_src=twsrc%5Etfw%7Ctwcamp%5Etweetembed%7Ctwterm%5E1309883204728430593%7Ctwgr%5Eshare_3&ref_url=https%3A%2F%2Fwptavern.com%2Fwp-admin%2Fpost.php%3Fpost%3D105265action%3Dedit">said</a>. &ldquo;I recognize there are many accessibility shortcomings in popular software, but I think it&rsquo;s more constructive to rally behind and contribute, not use a proprietary CMS that boasts beer budget in their guidelines.&rdquo; </p>



<p>On the other side of the issue, accessibility advocates took the W3C&rsquo;s decision as a referendum on Gutenberg&rsquo;s continued struggles to meet WCAG AA standards. WordPress accessibility specialist Amanda Rush <a href="https://www.customerservant.com/w3c-is-prioritizing-accessibility-over-its-open-source-licensing-preferences-why-is-that-a-bad-thing-again/">said</a> it was &ldquo;nice to see the W3C flip tables over this.&rdquo;</p>



<p>&ldquo;Gutenberg is not mature software,&rdquo; accessibility consultant and WordPress contributor Joe Dolson said in a <a href="https://www.joedolson.com/2020/09/the-w3c-drops-wordpress-from-consideration/">post</a> elaborating on his comments at WPCampus 2020 Online. He emphasized the lack of stability in the project that Studio 24 alluded to when documenting the reasons against using WordPress.</p>



<p>&ldquo;It is still undergoing rapid changes, and has grand goals to add a full-site editing experience for WordPress that almost guarantees that it will continue to undergo rapid changes for the next few years,&rdquo; Dolson said. &ldquo;Why would any organization that is investing a large amount into a site that they presumably hope will last another 10 years want to invest in something this uncertain?&rdquo;</p>



<p>Dolson also said the accessibility improvements he referenced regarding the audit were only a small part of the whole picture.  </p>



<p>&ldquo;They only encompass issues that existed in the spring of 2019,&rdquo; he said. &ldquo;Since then, many features have been added and changed, and those features both resolve issues and have created new ones. The accessibility team is constantly playing catch up to try and provide enough support to improve Gutenberg. And even now, while it is more or less accessible, there are critical features that are not yet implemented. There are entirely new interface patterns introduced on a regular basis that break prior accessibility expectations.&rdquo;</p>



<p>WordPress is also being used by millions of people who are constantly reporting issues to fuel the software&rsquo;s continued refinement, which increases the <a href="https://github.com/WordPress/gutenberg/labels/Accessibility%20%28a11y%29">backlog of issues</a>. Unfortunately, Studio 24 did not properly evaluate Gutenberg against the proprietary CMS&rsquo;s in order to determine if these software projects are in any better shape. </p>



<p>Instead, they decided that Craft CMS&rsquo;s community was more receptive to collaborating on issues without reaching out to WordPress. Given the W3C&rsquo;s stated preference for open source software, WordPress, as the only CMS under consideration with an <a href="https://opensource.org/licenses">OSD-compliant license</a>, should have received the same accessibility evaluation.</p>



<p>&ldquo;I can&rsquo;t make any statements that would be meaningful about the other content management systems under consideration; but if WordPress wants to be taken seriously in environments where accessibility is a legal, ethical, and mission imperative, there&rsquo;s still a lot of work to be done,&rdquo; Dolson said.</p>



<p>Studio 24&rsquo;s evaluation may not have been equitable to the only open source CMS under consideration, but the situation serves to highlight a unique quandary: when using open source software becomes the impractical choice for organizations requiring a high level of accessibility in their authoring tools.</p>



<p>&ldquo;Studio 24 ultimately determined that working with a CMS to make it better was more possible with a smaller, proprietary vendor than with a large open-source project,&rdquo; accessibility advocate Brian DeConinck said. &ldquo;Project leadership would be more receptive, and the smaller community means changes can be made more quickly. That should prompt a lot of soul-searching for&hellip;well, everyone. What does that say about the future of open source?&rdquo;</p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Tue, 29 Sep 2020 04:56:21 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:13:"Sarah Gooding";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:46;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:30:"Gary: More than 280 characters";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:25:"https://pento.net/?p=5405";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:54:"https://pento.net/2020/09/29/more-than-280-characters/";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:5187:"<p>It&#8217;s hard to be nuanced in 280 characters.</p>



<p>The Twitter character limit is a major factor of what can make it so much fun to use: you can read, publish, and interact, in extremely short, digestible chunks. But, it doesn&#8217;t fit every topic, ever time. Sometimes you want to talk about complex topics, having honest, thoughtful discussions. In an environment that encourages hot takes, however, it&#8217;s often easier to just avoid having those discussions. I can&#8217;t blame people for doing that, either: I find myself taking extended breaks from Twitter, as it can easily become overwhelming.</p>



<p>For me, the exception is Twitter threads.</p>



<h2>Twitter threads encourage nuance and creativity.</h2>



<p>Creative masterpieces like this Choose Your Own Adventure are not just possible, they rely on Twitter threads being the way they are.</p>



<div class="wp-block-embed__wrapper">
<blockquote class="twitter-tweet"><p lang="en" dir="ltr">Being Beyoncé’s assistant for the day: DONT GET FIRED THREAD <a href="https://t.co/26ix05Hkhp">pic.twitter.com/26ix05Hkhp</a></p>&mdash; green chyna (@CORNYASSBITCH) <a href="https://twitter.com/CORNYASSBITCH/status/1142591156884127744?ref_src=twsrc%5Etfw">June 23, 2019</a></blockquote>
</div>



<p>Publishing a short essay about your experiences in your job can bring attention to inequality.</p>



<div class="wp-block-embed__wrapper">
<blockquote class="twitter-tweet"><p lang="en" dir="ltr">DOWNTOWN BROOKLYN: I'm working arraignments tonight, representing poor New Yorkers who were arrested yesterday on Thanksgiving. <br /><br />It was the coldest Thanksgiving in more than a century. Tonight's also bitterly cold, even in the courtroom. I'm wearing my scarf &amp; coat.</p>&mdash; Rebecca Kavanagh (@DrRJKavanagh) <a href="https://twitter.com/DrRJKavanagh/status/1066144860619636736?ref_src=twsrc%5Etfw">November 24, 2018</a></blockquote>
</div>



<p>And Tumblr screenshot threads are always fun to read, even when they take a turn for the epic (over 4000 tweets in this thread, and it isn&#8217;t slowing down!)</p>



<div class="wp-block-embed__wrapper">
<blockquote class="twitter-tweet"><p lang="en" dir="ltr">Tumblr textposts thread, probably?</p>&mdash; we are a family forged in bureaucracy (@ex_aItiora) <a href="https://twitter.com/ex_aItiora/status/1165987806621184002?ref_src=twsrc%5Etfw">August 26, 2019</a></blockquote>
</div>



<p>Everyone can think of threads that they&#8217;ve loved reading.</p>



<p>My point is, threads are wildly underused on Twitter. I think I big part of that is the UI for writing threads: while it&#8217;s suited to writing a thread as a series of related tweet-sized chunks, it doesn&#8217;t lend itself to writing, revising, and editing anything more complex.</p>



<p>To help make this easier, I&#8217;ve been working on a tool that will help you publish an entire post to Twitter from your WordPress site, as a thread. It takes care of transforming your post into Twitter-friendly content, you can just&#8230; write. <img src="https://s.w.org/images/core/emoji/13.0.0/72x72/1f642.png" alt="🙂" class="wp-smiley" /></p>



<p>It doesn&#8217;t just handle the tweet embeds from earlier in the thread: it handles handle uploading and attaching any images and videos you&#8217;ve included in your post.</p>



<ul class="blocks-gallery-grid"><li class="blocks-gallery-item"><img width="3264" height="2448" src="https://pento.net/wp-content/uploads/2018/12/mvimg_20181231_0910291833340677198697139.jpg" alt="A selfie of me feeding a giraffe." class="wp-image-3608" /></li><li class="blocks-gallery-item"><img width="4000" height="3000" src="https://pento.net/wp-content/uploads/2018/12/GOPR0365.jpg" alt="A selfie of me on an iceberg south of the Antarctic circle." class="wp-image-3591" /></li><li class="blocks-gallery-item"><img width="3264" height="2448" src="https://pento.net/wp-content/uploads/2018/12/00006IMG_00006_BURST20181002212033_COVER.jpg" alt="A selfie of me with a fire breathing dragon at the Harry Potter themed amusement park in Orlando, Florida." class="wp-image-3604" /></li><li class="blocks-gallery-item"><img width="1793" height="469" src="https://pento.net/wp-content/uploads/2018/12/48944769_986954175890_2085904447019417600_o.jpg" alt="A panoramic view of sunset over Nairobi National Park." class="wp-image-3554" /></li></ul>



<p>All sorts of embeds work, too. <img src="https://s.w.org/images/core/emoji/13.0.0/72x72/1f609.png" alt="😉" class="wp-smiley" /></p>



<div class="wp-block-embed__wrapper">
<div class="jetpack-video-wrapper"></div>
</div>



<p>It&#8217;ll be coming in Jetpack 9.0 (due out October 6), but you can try it now in <a href="https://jetpack.com/download-jetpack-beta/">the latest Jetpack Beta</a>! Check it out and tell me what you think. <img src="https://s.w.org/images/core/emoji/13.0.0/72x72/1f642.png" alt="🙂" class="wp-smiley" /></p>



<p>This might not fix all of Twitter&#8217;s problems, but I hope it&#8217;ll help you enjoy reading and writing on Twitter a little more. <img src="https://s.w.org/images/core/emoji/13.0.0/72x72/1f496.png" alt="💖" class="wp-smiley" /></p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Tue, 29 Sep 2020 02:33:14 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:4:"Gary";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:47;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:100:"WPTavern: Themes Team Releases a Web Fonts Loader, Likely To Prohibit Hotlinking Any Off-Site Assets";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:30:"https://wptavern.com/?p=105363";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:243:"https://wptavern.com/themes-team-releases-a-web-fonts-loader-likely-to-prohibit-hotlinking-any-off-site-assets?utm_source=rss&utm_medium=rss&utm_campaign=themes-team-releases-a-web-fonts-loader-likely-to-prohibit-hotlinking-any-off-site-assets";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:5815:"<p class="has-drop-cap">Last Friday, the WordPress Themes Team <a href="https://make.wordpress.org/themes/2020/09/25/new-package-to-allow-locally-hosting-webfonts/">announced the release</a> of its new <a href="https://github.com/WPTT/webfont-loader">Webfonts Loader project</a>. It is a drop-in script that allows theme authors to load web fonts from the user&rsquo;s site instead of a third-party CDN. The secondary message included in the team&rsquo;s announcement is that it no longer plans to allow themes to hotlink Google Fonts in the future.</p>



<p>Throughout most of the team&rsquo;s history, it has not allowed themes to hotlink or use CDNs for hosting theme assets, such as CSS, JavaScript, and fonts. The one <a href="https://make.wordpress.org/themes/handbook/review/required/#stylesheets-and-scripts">exception to this rule</a> was the use of Google Fonts. This allowed themes to have richer typography options at their disposal from what the team has generally declared a reliable source.</p>



<p>&ldquo;The exception was made because there was no practical way to not have the exception at the time,&rdquo; said Aria Stathopoulos, a Themes Team representative and developer behind the Webfonts Loader project. &ldquo;The exception for Google Fonts was made out of necessity. Now that there is another way, the exception will not be necessary.&rdquo;</p>



<p>In effect, disallowing the Google Fonts CDN would not be a new ban. It would be a removal of an exception to the existing ban.</p>



<p>Google Fonts has become so embedded into the theme developer toolset over the years, there was no way the team could simply pull the plug and prohibit the use of the CDN overnight. If the Themes Team members wanted to focus more on privacy, they would need to build a tool that made it dead simple for theme authors to use.</p>



<p>There is no hard deadline for when the team will remove the exception for Google Fonts, and it is not set in stone at this point. Stathopoulos said removing it has been the goal from the beginning, disallowing all CDNs. However, it took a while to find an efficient way to handle this. With a viable alternative in place, they can discuss moving forward.</p>



<h2>Webfonts Loader for Themes</h2>



<p class="has-drop-cap">The Webfonts Loader project keeps it simple for theme authors. It introduces a new <code>wptt_get_webfont_styles()</code> function that developers can plug in a stylesheet URL. Once a page is loaded with that function call, it will download the fonts locally to a <code>/fonts</code> folder in the user&rsquo;s <code>/wp-content</code> directory. This way, fonts will always be served from the user&rsquo;s site.</p>



<p>The system is not limited to Google Fonts either. Any URL that serves CSS with an <code>@font-face {}</code> rule will work. It does not currently include authentication for CDNs that require API keys, such as Adobe Fonts. However, that is something the team might add in the future.</p>



<p>&ldquo;For end-users, moving away from CDNs and locally hosting web fonts will improve performance (fewer handshake roundtrips for SSL), and is the privacy-conscious choice,&rdquo; said Stathopoulos. &ldquo;The only &lsquo;valid privacy concern&rsquo; is that the web fonts&rsquo; CDN does not disclose information that is fundamental to the GDPR: what information gets logged, for how long these logs remain, how they are processed, if there is any cross-referencing with all the other wealth of information the company has from users, etc. The concern is a lack of disclosure and information. If a site owner doesn&rsquo;t know what kind of information a third-party logs for its visitors, then they should ethically not enforce that on their visitors. With this package, the CDN is removed from the equation and the font still gets served fast &mdash; if not faster.&rdquo;</p>



<h2>A Path to Core WordPress</h2>



<p class="has-drop-cap">Today, there is now a broader focus on privacy concerns related to third-party resources, particularly with tech giants like Google. Such concerns extend to whether third parties are tracking users or collecting data. Additional concerns are around whether sites are disclosing the use of third-party resources, which may be required in some jurisdictions. Site owners who are often unable to work through the web of potential issues are stuck in the middle.</p>



<p>Jono Alderson opened a ticket to <a href="https://core.trac.wordpress.org/ticket/46370">create an API</a> for loading web fonts locally in core WordPress in February 2019. It is a lengthy and detailed proposal, but it has yet to see much buy-in outside of a handful of developers.</p>



<p>&ldquo;If such a script is standardized and included in WordPress core, one of the main benefits would be more respect for the end-user&rsquo;s privacy,&rdquo; said Stathopoulos. &ldquo;In the end, that&rsquo;s all privacy is about: respecting users.&rdquo;</p>



<p>A standard API like Alderson proposes could solve some issues. Namely, it would virtually eliminate any privacy concerns. However, loading fonts locally could allow WordPress to optimize font loading and would create a shared system where plugins and themes do not load duplicate assets because of the current limitations of the enqueuing system. A standard API would also put the responsibility of efficiently loading fonts on WordPress&rsquo;s shoulders instead of theme and plugin developers.</p>



<p>The Themes Team&rsquo;s new project is a solid start and strengthens the current proposal.</p>



<p>&ldquo;If we&rsquo;re serious about WordPress becoming a fast, privacy-friendly platform, we can&rsquo;t rely on theme developers to add and manage fonts without providing a framework to support them,&rdquo; wrote Alderson in the ticket.</p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Mon, 28 Sep 2020 20:58:48 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:14:"Justin Tadlock";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:48;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:87:"WPTavern: Fuxia Scholz First to Pass 100K Reputation Points on WordPress Stack Exchange";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:30:"https://wptavern.com/?p=105282";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:219:"https://wptavern.com/fuxia-scholz-first-to-pass-100k-reputation-points-on-wordpress-stack-exchange?utm_source=rss&utm_medium=rss&utm_campaign=fuxia-scholz-first-to-pass-100k-reputation-points-on-wordpress-stack-exchange";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:5096:"<p><a href="https://stackexchange.com/users/113787/fuxia">Fuxia Scholz</a>, a prolific <a href="https://wordpress.stackexchange.com/">WordPress Stack Exchange</a> (WPSE) contributor, is the first member to reach 100,000 reputation points. The popular Q&amp;A community site rewards expert advice by floating the highest quality answers to the top, allowing users to earn reputation points. The gamified help community has proven to be more motivating for developers than many traditional forums, since the upvotes communicate how useful their answers are to others.</p>



<div class="wp-block-image"><img /></div>



<p>Scholz started on Stack Overflow a few months before WordPress had its own site. She wrote around 50 answers and made connections with other WordPress developers ahead of the site&rsquo;s <a href="https://area51.stackexchange.com/proposals/1500/wordpress-development">beta phase in June 2010</a>. Once the site graduated and got its own logo and design, Scholz started writing more.</p>



<p>&ldquo;One core idea for all Stack Exchange sites is gamification: You earn reputation, and you get access to <a href="https://wordpress.stackexchange.com/help/privileges">certain privileges</a>,&rdquo; Scholz said.</p>



<p>&ldquo;You can say I got a bit addicted. My favorite questions were about problems for which I didn&rsquo;t know the answer, and couldn&rsquo;t find one with a search engine, because no one else had solved that before. I used my answers to teach myself, and I learned a lot this way! In May 2011 <a href="https://stackexchange.com/users/113787/fuxia?tab=reputation">my reputation on WPSE was already higher than on Stack Overflow</a>, and for the next years it went up in a steep curve.&rdquo; Ten years after WPSE launched, Scholz has become the first to reach 100,000 reputation points.</p>



<p>&ldquo;What reputation and karma do is send a message that this is a community with norms, it&rsquo;s not just a place to type words onto the internet. (That would be 4chan.)&rdquo; Stack Overflow co-creator Joel Spolsky <a href="https://www.joelonsoftware.com/2018/04/13/gamification/">said</a>. &ldquo;We don&rsquo;t really exist for the purpose of letting you exercise your freedom of speech. You can get your freedom of speech somewhere else. Our goal is to get the best answers to questions. All the voting makes it clear that we have standards, that some posts are better than others, and that the community itself has some norms about what&rsquo;s good and bad that they express through the vote.&rdquo;</p>



<p>The reputation points were originally inspired by Reddit Karma. Spolsky admits that the points not a perfect system but they do tend to &ldquo;drive a tremendous amount of good behavior.&rdquo; Gamification can shape and encourage certain behaviors but Spolsky said it&rsquo;s a weak force that cannot motivate people to do things they are not already interested in doing. For Scholz, it was the community aspect and an earned sense of ownership and responsibility that kept her hooked.</p>



<p>&ldquo;In 2012, the community elected me as a moderator, and that changed a lot,&rdquo; she said. &ldquo;Now it wasn&rsquo;t just a game anymore, it was a duty. I felt responsible for the site. I still do. I also found some friends on there. We met at WordCamps and in private, and worked together on different projects.&rdquo;</p>



<p>Scholz no longer works in development and said she doesn&rsquo;t care about WordPress anymore, but she is still a regular contributor on the WPSE.</p>



<p>&ldquo;I switched careers and work as a writer, translator, and community manager for <a rel="noreferrer noopener" href="https://t.co/mIhjlVjPv4?amp=1" target="_blank">Chess24.com</a> now,&rdquo; she said. &ldquo;But I still care about the site WordPress Stack Exchange! I keep an eye on new tags, handle flagged posts and comments, try to make every new user feel welcome, and I search for people who are abusing the system &mdash; vote fraud and spam. And, very rarely, I even write an answer, because I still know all this stuff. </p>



<p>&ldquo;Checking the site has become a part of my daily routine, like feeding the cat.&rdquo; </p>



<p>This daily habit has snowballed into Scholz racking up more than 2,000 answers. She is getting upvotes on many of her old answers nearly every day, which is what pushed her over the 100k milestone.</p>



<p>&ldquo;There is a lot to say about the way our site developed over the years,&rdquo; Scholz said. &ldquo;I&rsquo;m not happy about some things. The enthusiasm of the early days is gone. We don&rsquo;t have enough regulars, there is no discussion about the site on <a href="https://t.co/tlRekl6sOt?amp=1">WordPress Development Meta Stack Exchange</a>, and our chat, once very active, funny, and friendly, is now almost dead. </p>



<p>&ldquo;Maybe that&rsquo;s normal, I don&rsquo;t know. But it&rsquo;s still &lsquo;my&rsquo; site. Reputation and badges don&rsquo;t really mean anything for a long time now, but keeping the site working, useful and friendly is more important.&rdquo;</p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Sat, 26 Sep 2020 15:27:03 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:13:"Sarah Gooding";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:49;a:6:{s:4:"data";s:13:"
	
	
	
	
	
	
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:82:"WPTavern: PhotoPress Plugin Seeks to Revolutionize Photography for WordPress Users";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:30:"https://wptavern.com/?p=104770";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:209:"https://wptavern.com/photopress-plugin-seeks-to-revolutionize-photography-for-wordpress-users?utm_source=rss&utm_medium=rss&utm_campaign=photopress-plugin-seeks-to-revolutionize-photography-for-wordpress-users";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:5638:"<p class="has-drop-cap">Peter Adams, the owner of the <a href="https://wordpress.org/plugins/photopress/">PhotoPress plugin</a>, announced a couple of weeks ago that <a href="https://www.photopressdev.com/its-time-for-photopress/">now is the time for his project</a> to take center stage. &ldquo;It&rsquo;s Time for PhotoPress,&rdquo; read the title of his post in which he laid out a four-phase plan for the future of his project.</p>



<p>Adams is no stranger to manipulating WordPress to suit the needs of photographers. He described photography as his first love and second career. He initially found the art of taking photos in high school and set off to college to become a professional photographer in the early &rsquo;90s.</p>



<p>As his university graduation loomed, he was recruited to run web development for an internet ad agency that built websites for Netscape, Bill Clinton&rsquo;s White House, and dozens of Fortune 500 companies. He spent the next 15 years starting or running tech companies before returning to his roots as a photographer.</p>



<p>Today, he photographs for various magazines and companies. And, that&rsquo;s where his PhotoPress project comes in.</p>



<p>&ldquo;As far as WordPress has come, it is at risk of losing an entire generation of photographers to photo website services such as Photoshelter, SmugMug, Squarespace, and PhotoFolio,&rdquo; he said. Adams wants to change that, making WordPress the go-to platform for photographers around the world.</p>



<h2>The Jetpack of Photography Plugins</h2>



<p class="has-drop-cap">If you dig into the history of the PhotoPress plugin on WordPress.org, it seems to have a 15-year history. However, this is not the same plugin that was published a decade and a half ago by a different developer. The original plugin is now defunct, and Adams took over when the name was freed up on the directory.</p>



<p>Adams wrote in his announcement post that WordPress has done a great job of delivering several media features over the years. &ldquo;Yet despite that, there are still many rough edges and missing features that keep WordPress from being the first choice for a photographer that needs to publish a beautiful portfolio of their work, put their image catalog/archive online, or showcase a photo editorial/project.&rdquo;</p>



<p>He outlined a list of 10 specific problem areas that he wants to address in a &ldquo;Jetpack-like&rdquo; plugin for photographers. This is the bread and butter of the first of the planned four phases, which he said is about 80% finished. He had originally planned to develop PhotoPress as a series of separate plugins, each addressing a specific problem. Now, it is a single plugin with modules than can be enabled or disabled.</p>



<p>When asked why the &ldquo;right time&rdquo; is now, Adams explained it is because the Gutenberg (block editor) project is a giant leap forward in usability in terms of creating photography blogs.</p>



<img />PhotoPress Gallery block in the editor.



<p>&ldquo;Photogs are a rare breed of non-technical users with high design sense,&rdquo; he said. &ldquo;Things that I used to have to teach photographers to do using shortcode syntax and custom CSS can now be simple controls with live feedback inside a Gutenberg block. It&rsquo;s really a game-changer for getting people comfortable with customizing things like gallery styling &mdash; which is the number one thing photographers need to do.&rdquo;</p>



<p>The primary piece of the PhotoPress plugin is its custom PhotoPress Gallery block. It allows users to choose between a range of gallery styles, such as columns, masonry, justified, and mosaic. Each style has its own options. Images can also be launched into a slideshow when one is clicked.</p>



<p>Based on some quick tests, the block&rsquo;s front-end output will go farther with some themes than others. This is mainly because of conflicting CSS and issues which can be solved by testing against more themes.</p>



<p>Aside from the block, the plugin can automatically extract image metadata and group that data through custom taxonomies, such as cameras, lenses, locations, keywords, and more. WordPress stores this information out of the box, but it is hidden away as post meta. The plugin uses the taxonomy system to make it manageable for end-users.</p>



<p>Ultimately, Adams set out to create a photography plugin that fits in with the WordPress admin user interface and experience, which he has accomplished.</p>



<h2>The Future of PhotoPress</h2>



<p class="has-drop-cap">The project is still a work in progress. Adams is still moving through Phase I of the four-phase plan. Once it is complete, he can move on to the next steps in the process.</p>



<p>Phase II is to create themes that are designed specifically to work with the PhotoPress plugin. He has three planned thus far. One for handling portfolio sites. Another for creating a stock photo archive. And the last for photojournalism and exhibits. Each will be built on top of his <a href="https://github.com/photopress-dev/frame">photography theme framework</a>.</p>



<p>The themes in Phase II will likely be commercial products. Adams said he needs a way to fund the next phases of the project. He hopes to have this step underway by the end of the year.</p>



<p>For 2021, he wants to begin tackling Phases III and IV. The former will be a website-as-a-service (WaaS) similar to WordPress.com but for photographers. It will begin as a paid project but could have some free options for emerging photographers and students. The final phase is to build an onboarding system.</p>";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Fri, 25 Sep 2020 19:08:15 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:14:"Justin Tadlock";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}}}}}}}}}}}}s:4:"type";i:128;s:7:"headers";O:42:"Requests_Utility_CaseInsensitiveDictionary":1:{s:7:" * data";a:8:{s:6:"server";s:5:"nginx";s:4:"date";s:29:"Tue, 27 Oct 2020 06:35:54 GMT";s:12:"content-type";s:8:"text/xml";s:4:"vary";s:15:"Accept-Encoding";s:13:"last-modified";s:29:"Tue, 27 Oct 2020 06:15:09 GMT";s:15:"x-frame-options";s:10:"SAMEORIGIN";s:4:"x-nc";s:9:"HIT ord 2";s:16:"content-encoding";s:4:"gzip";}}s:5:"build";s:14:"20200501142607";}}