<?php

$pageData = $this->getPageData();

$hostName = isset($pageData["record"]["host_name"]) ? $pageData["record"]["host_name"] : "";
$database = isset($pageData["record"]["database"]) ? $pageData["record"]["database"] : "";
$dbUserName = isset($pageData["record"]["db_user_name"]) ? $pageData["record"]["db_user_name"] : "";
$adminEmail = isset($pageData["record"]["admin_email"]) ? $pageData["record"]["admin_email"] : "";
$adminName = isset($pageData["record"]["admin_name"]) ? $pageData["record"]["admin_name"] : "";

?>
<h3>Setup configuration</h3>
<p>It appears there is no configuration present in the system.</p>
<p>Before you can create a configuration, you need to have a database setup first.</p>
<p>Log in to the MySQL database manager and create a database.</p>
<p>You can also use an existing database, but it must be empty. All tables must be removed ('dropped').</p>
<p>Also create a MySQL user for accessing the database with all privileges enabled.</p>
<p>When ready, fill out the following form and the configuration will be created for you.</p>
<form action="<?php echo WEB_ROOT; ?>api" method="post">
<input type="hidden" name="on_success" value="" />
<input type="hidden" name="on_failure" value="setup/create-config" />
<input type="hidden" name="title" value="Create configuration" />
<table class="{TABLE}">
<tr><td>Host name:</td><td><input name="record[host_name]" class="{INPUT}" type="text" value="<?php echo $hostName; ?>" /></td></tr>
<tr><td>Database name:</td><td><input name="record[database]" class="{INPUT}" type="text" value="<?php echo $database; ?>" /></td></tr>
<tr><td>Database user name:</td><td><input name="record[db_user_name]" class="{INPUT}" type="text" value="<?php echo $dbUserName; ?>" /></td></tr>
<tr><td>Database user password:</td><td><input name="record[db_password]" class="{INPUT}" type="password" autocomplete="new-password" /></td></tr>
<tr><td>Repeat database user password:</td><td><input name="record[db_repeat_password]" class="{INPUT}" type="password" autocomplete="new-password" /></td></tr>
</table>
<p>An administrator user needs to be setup for log in and creating user accounts.</p>
<p>Enter the information for the administrator user in the form below.</p>
<table class="{TABLE}">
<tr><td>Email address:</td><td><input name="record[admin_email]" class="{INPUT}" type="text" value="<?php echo $adminEmail; ?>" /></td></tr>
<tr><td>Name:</td><td><input name="record[admin_name]" class="{INPUT}" type="text" value="<?php echo $adminName; ?>" /></td></tr>
<tr><td>Password:</td><td><input name="record[admin_password]" class="{INPUT}" type="password" autocomplete="new-password" /></td></tr>
<tr><td>Repeat password:</td><td><input name="record[admin_repeat_password]" class="{INPUT}" type="password" autocomplete="new-password" /></td></tr>
</table>
<p class="form-buttons"><button class="{BUTTON}" type="submit" name="action" value="create_configuration" {SHOW_LOADER}>Create configuration</button></p>
</form>
