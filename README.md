# Auto Paradise
## Group ltw06g09

<p align="center"><img src="images/logo/auto-paradise-logo-text.png" width=50% ></p>

Auto Paradise is an marketplace dedicated to buying and selling preloved diecast model cars.

- Bruno Huang (up202207517) - 50%
- Ricardo Yang (up202208465) - 50%

## Install

### Download
```bash
git clone git@github.com:FEUP-LTW-2024/ltw-project-2024-ltw06g09.git

cd ltw-project-2024-ltw06g09

# switch to the correct branch
git checkout final-delivery-v2
```

### Build and run
```bash
# import SQLite database
sqlite3 database/database.db < database/database.sql

# start PHP built-in web server
php -S localhost:9000
```

Access them via web browser at http://localhost:9000

## External Libraries

We have used the following external libraries:

- Font Awesome
- Google Fonts
- jsPDF
- html2canvas

## Screenshots

![](images/report/main_page.png)
<p align="center" justify="center">
<b><i>Fig 1. Main page</i></b>
<br></br>

![](images/report/products_page.png)
<p align="center" justify="center">
<b><i>Fig 2. Products page</i></b>
<br></br>

![](images/report/product_details.png)
<p align="center" justify="center">
<b><i>Fig 3. Product details page</i></b>
<br></br>

## Implemented Features

**General**:

- [x] Register a new account.
- [x] Log in and out.
- [x] Edit their profile, including their name, username, password, and email.

**Sellers**  should be able to:

- [x] List new items, providing details such as category, brand, model, size, and condition, along with images.
- [x] Track and manage their listed items.
- [x] Respond to inquiries from buyers regarding their items and add further information if needed.
- [x] Print shipping forms for items that have been sold.

**Buyers**  should be able to:

- [x] Browse items using filters like category, price, and condition.
- [x] Engage with sellers to ask questions or negotiate prices.
- [x] Add items to a wishlist or shopping cart.
- [x] Proceed to checkout with their shopping cart (simulate payment process).

**Admins**  should be able to:

- [x] Elevate a user to admin status.
- [x] Introduce new item categories, sizes, conditions, and other pertinent entities.
- [x] Oversee and ensure the smooth operation of the entire system.

**Security**:
We have been careful with the following security aspects:

- [x] **SQL injection**
- [x] **Cross-Site Scripting (XSS)**
- [x] **Cross-Site Request Forgery (CSRF)**

**Password Storage Mechanism**: hash_password&verify_password

**Aditional Requirements**:

We also implemented the following additional requirements (you can add more):

- [x] **Notifications System**
- [ ] **Rating and Review System**
- [ ] **Promotional Features**
- [ ] **Analytics Dashboard**
- [ ] **Multi-Currency Support**
- [ ] **Item Swapping**
- [ ] **API Integration**
- [ ] **Dynamic Promotions**
- [ ] **User Preferences**
- [x] **Shipping Costs (Fixed Amount)**
- [ ] **Real-Time Messaging System**
- [x] **Dark Mode**
- [x] **Admins can ban products**

## Account Credentials
Feel free to use the following test account credentials to explore our platform

| Username | Password  |
| -------- | --------- |
| user1    | password1 |
| user2    | password2 |
| user3    | password3 |
| user4    | password4 |
| user5    | password5 |
| user6    | password6 |
| user7    | password7 |
| user8    | password8 |
| user9    | password9 |
| user10   | password10|
| admin    | admin     |


## Acknowledgements

This project was developed for the "Linguagens e Tecnologias Web" (LTW) course at @FEUP

Special thanks to Professor [André Restivo](https://sigarra.up.pt/feup/pt/func_geral.formview?p_codigo=353972) for guidance and support throughout the course.

<br>

__© 2024 Auto Paradise, LTW__