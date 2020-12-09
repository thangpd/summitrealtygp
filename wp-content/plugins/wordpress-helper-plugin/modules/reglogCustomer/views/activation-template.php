<?php
/**
 * Date: 12/2/20
 * Time: 10:20 PM
 */

$html = <<<HTML
<div class="almost-there" style="color:white; padding:20px;">
<p>Almost there!</p>
<p>We've sent an email to {$user_data['email']}</p>
<br>
<p>In the email is a link that will complete your account creation. Please check your email and click that link to continue!</p>
</div>
HTML;


echo $html;