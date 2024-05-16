# AutoParadise
## Group ltw06g09

AutoParadise is an marketplace dedicated to buying and selling preloved diecast model cars.

- Bruno Huang (up202207517) - 50%
- Ricardo Yang (up202208465) - 50%

## Install

### Download
```bash
git clone git@github.com:FEUP-LTW-2024/ltw-project-2024-ltw06g09.git

# switch to the correct branch
git checkout final-delivery-v1
```

### Build and run
```bash
# import SQLite database
sqlite3 database/database.db < database/database.sql

# start PHP built-in web server
php -S localhost:9000
```

Access them via web browser at http://localhost:9000

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

- ✅ Register a new account.
- ✅ Log in and out.
- ✅ Edit their profile, including their name, username, password, and email.

**Sellers**  should be able to:

- ✅ List new items, providing details such as category, brand, model, size, and condition, along with images.
- ✅ Track and manage their listed items.
- ✅ Respond to inquiries from buyers regarding their items and add further information if needed.
- ✅ Print shipping forms for items that have been sold.

**Buyers**  should be able to:

- ✅ Browse items using filters like category, price, and condition.
- ✅ Engage with sellers to ask questions or negotiate prices.
- ✅ Add items to a wishlist or shopping cart.
- ✅ Proceed to checkout with their shopping cart (simulate payment process).

**Admins**  should be able to:

- [ ] Elevate a user to admin status.
- ✅ Introduce new item categories, sizes, conditions, and other pertinent entities.
- ✅ Oversee and ensure the smooth operation of the entire system.

**Security**:
We have been careful with the following security aspects:

- ✅ **SQL injection**
- [ ] **Cross-Site Scripting (XSS)**
- [ ] **Cross-Site Request Forgery (CSRF)**

**Password Storage Mechanism**: md5 / sha1 / sha256 / hash_password&verify_password

**Aditional Requirements**:

We also implemented the following additional requirements (you can add more):

- ✅ **Notifications System**
- [ ] **Rating and Review System**
- [ ] **Promotional Features**
- [ ] **Analytics Dashboard**
- [ ] **Multi-Currency Support**
- [ ] **Item Swapping**
- [ ] **API Integration**
- [ ] **Dynamic Promotions**
- [ ] **User Preferences**
- ✅ **Shipping Costs**
- [ ] **Real-Time Messaging System**
- ✅ **Dark Mode**

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

## Contributors
This project was developed for LTW at @FEUP