# Lily ERP

ERP system for free. With free we mean really free.

You can sponsor our work on: https://github.com/sponsors/LilyTronics

## Working features
What is working:
* Dashboard with access to the modules and show statistics per module
* Accounting module
  * Show the balance sheet
  * Import bank transactions from a MT940 file.
  * Reconsile bank transactions, with automatic prediction based on previous reconciliations, for faster processing.
  * Edit journal items.
  * Edit the chart of accounts
* User management (simple user management, needs more improvement)
* Setup page for initial configuration settings
* Administrator pages for changing settings, accessing log files and database.

## Roadmap
* Relations management (customers, suppliers etc).
* Product management (bill of materials, product lifecycle management, engineering changes).
* Purchase order management.
* Inventory management.
* Manufacturing order management.
* Sales order management.
* Create web site with demo database.
* Launch of first release.

## Documentation
Documentation available on [Read the Docs](https://lily-erp.readthedocs.io/en/latest/)

[![Documentation Status](https://readthedocs.org/projects/lily-erp/badge/?version=latest)](https://lily-erp.readthedocs.io/en/latest/?badge=latest)

## Interaction
Have ideas, questions or anything you like to share? Go to our [discussions page](https://github.com/LilyTronics/lily_erp/discussions).

## Cloning
The repository using a sub module in php_framework. To clone with sub module use:

```
git clone --recurse-submodules https://github.com/LilyTronics/lily_erp.git
```

In case you alread cloned the repository and want to clone the submodules use:

```
git submodule update --init --recursive
```

## Branches
All on going development (unstable and untested) is in the *development* branch.

All releases (stable and tested) is in the *release* branch.

Production servers must use the *release* branch.

If you ran into a bug, make sure to test it on the *release* branch.
