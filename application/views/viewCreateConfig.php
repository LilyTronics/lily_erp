<h3>Setup configuration</h3>
<p>It appears there is no configuration present in the system.</p>
<p>Before you can create a configuration, you need to have a database setup first.</p>
<p>Log in to the MySQL database manager and create a database.</p>
<p>You can also use an existing database, but it must be empty. All tables must be removed ('dropped').</p>
<p>Also create a user for accessing the database with all privileges enabled.</p>
<p>When ready, fill out the following form and the configuration will be created for you.</p>
<table class="{TABLE}">
<tr><td>Host name:</td><td><input name="record_field" id="host_name" class="{INPUT}" type="text" /></td></tr>
<tr><td>Database name:</td><td><input name="record_field" id="database" class="{INPUT}" type="text" /></td></tr>
<tr><td>Database user name:</td><td><input name="record_field" id="db_user_name" class="{INPUT}" type="text" /></td></tr>
<tr><td>Database user password:</td><td><input name="record_field" id="db_password" class="{INPUT}" type="password" autocomplete="new-password" /></td></tr>
<tr><td>Repeat database user password:</td><td><input name="record_field" id="db_repeat_password" class="{INPUT}" type="password" autocomplete="new-password" /></td></tr>
</table>
<p>An administrator user needs to be setup for log in and creating user accounts.</p>
<p>Enter the information for the administrator user in the form below.</p>
<table class="{TABLE}">
<tr><td>Email address:</td><td><input name="record_field" id="admin_email" class="{INPUT}" type="text" /></td></tr>
<tr><td>Name:</td><td><input name="record_field" id="admin_name" class="{INPUT}" type="text" /></td></tr>
<tr><td>Password:</td><td><input name="record_field" id="admin_password" class="{INPUT}" type="password" autocomplete="new-password" /></td></tr>
<tr><td>Repeat password:</td><td><input name="record_field" id="admin_repeat_password" class="{INPUT}" type="password" autocomplete="new-password" /></td></tr>
</table>
<p><button class="{BUTTON}" onclick="sendForm('create_configuration', 'Create configuration', '')">Submit</button></p>
