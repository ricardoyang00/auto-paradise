<?php

declare (strict_types = 1);
require_once(__DIR__ . '/../../utils/session.php');
require_once(__DIR__ . '/../../database/connection.db.php');
require_once(__DIR__ . '/../../database/user.class.php');
require_once(__DIR__ . '/../../database/category.class.php');
require_once(__DIR__ . '/../../database/brand.class.php');
require_once(__DIR__ . '/../../database/scale.class.php');

$section = new Session();
if (!$section->isLoggedIn()) {
    header('Location: ../../pages/login.php');
    exit();
}

$db = getDatabaseConnection();
$username = $section->getUsername();
$user = User::getUserByUsername($db, $username);

if (!User::isAdmin($db, $username)) {
    header('Location: ../../pages/account.php');
    exit();
}

$categories = Category::getAllCategories($db);
$brands = Brand::getAllBrands($db);
$scales = Scale::getAllScales($db);

?>
<h2>Admin Section</h2>
<div id="admin" class="account-content">
    <div class="admin-content">
        <h3>Categories</h3>
        <select id="category-update" name="category-update" required>
            <option value="" disabled>Select a category</option>
            <?php foreach($categories as $category){ ?>
                <option value="<?= $category->id ?>"><?= $category->name ?></option>
            <?php } ?>
        </select>
        <input type="text" name="categoryName" placeholder="Enter category name">
        <div class="button-container">
            <button id="delete-category-btn" class="delete-btn">Delete</button>
            <button id="rename-category-btn" class="rename-btn">Rename</button>
            <button id="add-category" class="save-btn">Add new category</button>
        </div>

        <h3>Brands</h3>
        <select id="brand-update" name="brand-update" required>
            <option value="" disabled>Select a Brand</option>
            <?php foreach($brands as $brand){ ?>
                <option value="<?= $brand->id ?>"><?= $brand->name ?></option>
            <?php } ?>
        </select>
        <input type="text" name="brandName" placeholder="Enter brand name">
        <div class="button-container">
            <button id="delete-brand-btn" class="delete-btn">Delete</button>
            <button id="rename-brand-btn" class="rename-btn">Rename</button>
            <button id="add-brand" class="save-btn">Add new brand</button>
        </div>

        <h3>Scales</h3>
        <select id="scale-update" name="scale-update" required>
            <option value="" disabled>Select a Scale</option>
            <?php foreach($scales as $scale){ ?>
                <option value="<?= $scale->id ?>"><?= $scale->name ?></option>
            <?php } ?>
        </select>
        <input type="text" name="scaleName" placeholder="Enter scale name">
        <div class="button-container">
            <button id="delete-scale-btn" class="delete-btn">Delete</button>
            <button id="rename-scale-btn" class="rename-btn">Rename</button>
            <button id="add-scale" class="save-btn">Add new scale</button>
        </div>
    </div>
</div>
