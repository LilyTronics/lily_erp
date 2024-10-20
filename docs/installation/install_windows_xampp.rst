Installation on Windows with XAMPP
==================================

XAMPP is a hassle free web server running MySQL and PHP (and more, but we do not use that).

Install XAMPP
-------------

Download XAMPP from: https://sourceforge.net/projects/xampp/files/.

You can choose for an installer or a portable version. Both should work.
Download and install XAMPP.

There not much to setup.

Test if the XAMPP web page is available at: http://localhost

If XAMPP is working as expected, remove all files from the web server folder called 'htdocs'.

Copy or clone the files from the lily_erp repository to 'htdocs'

Open: http://localhost

If everything is OK, you should see the setup configuration page.

If you need to run it on another port, check the Apache manual on how to setup the port.

If you need to run SSL, check the Apache manual for setting up SSL.
