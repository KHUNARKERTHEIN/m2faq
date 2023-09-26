# magento-faq- extension

Overview: FAQ extension allows to create a dedicated FAQ page, where all customer concerns are gathered in one place. The FAQs are displayed on one page with collapse/expand the feature.

Features

This module lets you answer questions from your customers, it also allows you to create your own queries to display essential information. You can add any number of FAQ’s.


New Features

Editor for adding FAQ.
You can create a FAQ group.
Different Groups can be published.
Multiple groups can be published on one page.

Adding & Managing FAQ

Admin can add a new FAQ.
Admin can enable/disable any FAQ.
Admin can also delete an already existing FAQ from the list.

Adding & Managing FAQ Groups

Admin can delete/ change the status of any FAQ group.
Admin can add a new FAQ group.

FAQ Search functionality:
Customers can search for faqs using keywords related to faq and its content.
FAQ helpfulness voting:
Customers can vote if the answer is helpful or not.
Customers can see helpfulness ratings of FAQs.

For Admin
 Admin can control when he wants to show the ratings.

Search Engine Optimization:

Admin:
For every FAQ, three fields can be assigned via admin meta title, meta description and url key for making faq search friendly.


# Installation Instruction

* Copy the content of the repo to the Magento 2 app/code/Ksolves/FAQ
* Run command:
<b>php bin/magento setup:upgrade</b>
* Run Command:
<b>php bin/magento setup:di:compile</b>
* Run Command:
<b>php bin/magento setup:static-content:deploy</b>
* Now Flush Cache: <b>php bin/magento cache:flush</b>
