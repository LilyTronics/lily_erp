Installation on Windows with XAMPP
==================================

XAMPP is a hassle free web server running MySQL and PHP (and more, but we do not use that).

Install XAMPP
-------------

Download XAMPP from: https://sourceforge.net/projects/xampp/files/.

You can choose for an installer or a portable version. Both should work.
Download and install XAMPP.

Make sure the Apache and MySQL services are running.

Check the Windows Services app and look for the Apache and MySQL services.
If they are not there, you can install them manually.

To install the services open a command window as administrator and go to the
folder where XAMPP is installed.

To install the Apache service, run: ``apache/bin/httpd -k install``

To install the MySQL service, run: ``mysql/bin/mysqld --install``

Check the Windows Services app again (you may need to refresh the app).
Make sure the services are running, if not, start them manually using the Windows Services app.

If both services are running, check the following web pages.

Test if the XAMPP web page is available at: http://localhost

Test if the MySQL database manager is available at: http://localhost/phpmyadmin

If XAMPP is working as expected, remove all files from the web server folder called ``htdocs``.

Copy or clone the files from the lily_erp repository to ``htdocs``

Open: http://localhost

If everything is OK, you should see the setup configuration page.

If you need to run it on another port, check the Apache manual on how to setup the port.

If you need to run SSL, check the Apache manual for setting up SSL.
