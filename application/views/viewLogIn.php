<div class="w3-content log-in-form">
<h3>Log in</h3>
<form action="<?php echo WEB_ROOT; ?>api" method="post">
<input type="hidden" name="action" value="log_in" />
<input type="hidden" name="on_success" value="" />
<input type="hidden" name="on_failure" value="log-in" />
<input type="hidden" name="title" value="Log in" />
<p>Email address:</p>
<p><input name="record_field" id="email" class="{INPUT}" type="text" /></p>
<p>Password:</p>
<p><input name="record_field" id="password" class="{INPUT}" type="password" /></p>
<p class="w3-center"><button class="{BUTTON}" onclick="showModalLoader()">Log in</button></p>
</form>
</div>
