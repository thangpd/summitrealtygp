<?php
/**
 * Date: 12/11/20
 * Time: 8:03 PM
 */

return <<<HTML
Hi Admin, <br>
<p></p>
A new user <a href="mailto:{$user_data['user_email']}">{$user_data['Username']}</a> - has successfully registered to your site <a href="mailto:info@summitrealtygp.com">Summit Realty Group, Inc.</a><br>
<p></p>
Please review the user role and details at '<b>Users</b>' menu in your WP dashboard.<br>
<p></p>
Thank You!

HTML;