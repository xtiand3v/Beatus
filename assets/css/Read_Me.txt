Libries/Plugins Used:[and custom css/scrips]

CSS
- Bootstrap v4.5
    -Refer to the online documentation for this library [https://getbootstrap.com]. note browse the documentation of version 4.5
- Custom Style Sheets
    - All custom style sheets are located inside the [assets/css/styles.css], and some minor styles are located the file itself.


JS
- jQuery v1.4.0
    - Custom javascripts functions are mostly written using jQuery. To learn the use of each scripts refer to jquery documentations [http://jquery.com]

*Developed using XAMPP v3.2.4 which has PHP version 7.2.28
    -This project will run up to the latest PHP version

*The project PHP backend scripts are written using OOP (Object-Oriented Programming)
    -All CRUD action scripts are on the "admin_class.php" file and the triggers are jor the functions are in the "ajax.php"

*All forms can be found in this project was submitted using Ajax XHTTP Request.
    - Each submit functions scripts are located inside the file itself.

*The project Interface are all compiled inside the index.php. 
*The assets (CSS/JS) links are all listed at the header.php file. If you want to import external file, write your links header
* For the TopBar Navigation (NavBar), the scripts are written in "topbar.php" file.
* For the Side Navigations (Side Bar Menu), the scripts are written in "navbar.php" file.
* For the content views, each page content views are written in the file itself. to know the content filename refer to the URL link [localhost/cms/index.php?page=*] (*) is the name of file which uses .php file extention.Example for dashboard or home page [http://localhost/cms/index.php?page=home] = home.php is the file name of the content view.

-- Template Structure --
******************************************************************************
*                       -- topbar.php --                                     *
******************************************************************************
*                    *                                                       *
*                    *                                                       *
*                    *                                                       *
*                    *                                                       *
*                    *                                                       *
*                    *                                                       *
*    navbar.php      *                  $_GET['page'].php                    *
*                    *                                                       *
*                    *                                                       *
*                    *                                                       *
*                    *                                                       *
*                    *                                                       *
*                    *                                                       *
*                    *                                                       *
*                    *                                                       *
******************************************************************************


*For the POS Side, same structure and nature of coding as stated above.

*Custome Universal Functions - JS scripts
-uni_modal() - universal modal, opens a modal containing a external file in the body.
    *parameters:
        * paramater 1= Title of the modal
        * paramater 2= external file path
        * parameter 3 = modal size ['md-large','large']

-_conf() - serve as dynamic confirmation dialog before executing an action such as delete functions.
     *parameters:
        * paramater 1=  confirmation message [string]
        * paramater 2= function name to be executed [string]
        * parameter 3 = dunction parameters [array]  

- alert_toast() - dynamic popup message 
     *parameters:
        * paramater 1= message [string]
        * paramater 2= popup type ['success','danger','info','warning']


Features:
*Dashboard -home.php
    -Display Pie Graph for Top 5 Most Moving Items (using Chart.js) [https://www.chartjs.org]
    -Display notifation of Items that needs to restock

*Sales- sales.php
    -Display the list of sales records.
    -Update sales Record
    -delete sales Record

*POS - pos/home.php
    - Sales Management
    - Open's a printable receipt window after creating new sales record. -receipt.php

*Purchase Order - purchase_order.php
    -Display list of purchase orders
    -Create new purchase order. manage_po.php
    -Edit purchase order. manage_po.php
    -Delete purchase order.

*Receiving - receiving.php
    - Display list of received orders from Purchase order
    - Requires a purchase order to received
    - receive order . (manage_receiving.php)
    - New entry choose purchase order.(choose_po.php)
    - Edit receiving order. manage_receiving.php
    - Delete Receiving
    - Reorder . manage_reorder.php

*Inventory - inventory.php
    -Display Stock availability
        -In stocks table in the database type values are [1=IN/Receiving,2=Out/Sales/Back Order]

*Back Order - back_order.php
    -Display list of back orders
    -Create new Back order. manage_bo.php
    -Edit Back order. manage_bo.php
    - Delete Back Order

*Supplier List - suppliers.php
    - List of suppliers
    - Create New Supplier
    - Edit Supplier
    - Delete Supplier

*Product/Item List - products.php
    - List of products
    - Create New products
    - Edit products
    - Delete products

*Sales Report List - sales_report.php
    - Printable Sales Report (Monthly)

*Sales Statistic - sales_statistic.php
    -Display a Pie Graph for Sales (Chart.js)

*Users List. users.php
    - List of users
    - Create New users . manage_user.php
    - Edit users . manage_user.php
    - Delete users
        