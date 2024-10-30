<span class="w3-dropdown-hover w3-right">
<h5><i class="fa-solid fa-user w3-margin"></i></h5>
<div class="w3-dropdown-content w3-bar-block w3-border w3-card" style="right:0">
<a href="<?php echo WEB_ROOT; ?>my-account" class="w3-bar-item w3-button">My account</a>
<form action="<?php echo WEB_ROOT; ?>api" method="post">
<input type="hidden" name="action" value="log_out" />
<input type="hidden" name="on_success" value="" />
<input type="hidden" name="on_failure" value="" />
<input type="hidden" name="title" value="Log out" />
<button class="w3-bar-item w3-button">Log out</button>
</form>
</div>
</span>
