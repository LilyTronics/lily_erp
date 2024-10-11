# Database structure

This document describes the database structure

# Tables

| Category   | Table               | Description                                 |
|------------|---------------------|---------------------------------------------|
| general    | user                | Users data                                  |
|            | settings            | Application settings, defaults and per user |
|            |                     |                                             |
| accounting | bank_transaction    | imported transacions from bank accounts     |
|            | general_ledger      | general ledger accounts                     |
|            | journal             | journal entries                             |
|            | vat                 | VAT data                                    |
|            |                     |                                             |
| products   | product             | product data                                |
|            | product_bom         | bom information                             |
|            | bom_requirement     | requirements for a bom                      |
|            |                     |                                             |
| relations  | relation            | relation data                               |
|            | relation_contact    | contact information for the relations       |
|            |                     |                                             |
| puchasing  | purchase_order      | purchase orders data                        |
|            | purchase_order_line | line items for the purchase order           |
|            |                     |                                             |
| sales      | sales_order         | sales order data                            |
|            | sales_order_line    | line items for the sales order              |
