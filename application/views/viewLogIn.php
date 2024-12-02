<div class="mx-auto log-in-form">
<h3>Log in</h3>
<form action="<?php echo WEB_ROOT; ?>api" method="post">
<input type="hidden" name="on_success" value="" />
<input type="hidden" name="on_failure" value="log-in" />
<input type="hidden" name="title" value="Log in" />
<p>Email address:</p>
<p><input name="record[email]" class="{INPUT}" type="text" /></p>
<p>Password:</p>
<p><input name="record[password]" class="{INPUT}" type="password" /></p>
<p class="text-center form-buttons"><button class="{BUTTON}" type="submit" name="action" value="log_in" {BTN_SHOW_LOADER}>Log in</button></p>
</form>
</div>
