Lily ERP (Community Edition)
==============================================

This is the documentation for the Lily ERP system.

The Lily ERP software is free ERP software for self-employed or small companies who need more than
just accounting software. You can find a lot of cheap accounting software but most of them lack in
ERP and PLM functionality (ERP: enterprise resource planning; PLM: product lifecycle management).

This documentation will guide you through the setup and usage of the ERP system.

Before we start, just a note:

This ERP system will contain detailed information about your company and security is very important.
Make sure to test the software on a local server before deploying it to a server connected to the
outside world.

The software works very well with SSL and has a configuration setting to force SSL conections.
Make sure to enable this setting properly and test if the connection is really SSL, before putting
any sensitive data into the database. Also make sure that non-SSL requests are properly redirected
to SSL requests.

Also make sure to regular backup the database to prevent data loss.

This software is provided as is. Source code is freely available and can be modified to your needs.
Please know that we cannot accept any liability for any damage to your company or loss of data when
using this software.

Nevertheless we hope you enjoy using this software as much as we did enjoy making it an using it
ourselves.

| Regards,
| LilyTronics

The source code is available at: https://github.com/LilyTronics/lily_erp

If you want to post an issue (bug, feature request, etc.): https://github.com/LilyTronics/lily_erp/issues

If you rather want direct contact: erp@lilytronics.nl


.. toctree::
   :maxdepth: 1
   :caption: Contents:

   Home           <self>
   Installation   <installation/installation.rst>
   Setup          <configuration/setup.rst>
