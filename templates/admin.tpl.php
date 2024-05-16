<?php 
declare(strict_types = 1); 
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/product.class.php');
?>

<?php function drawAdminSection($categories, $brands, $scales, $bannedProducts) { ?>
    <h2>Admin Section</h2>
    <div id="admin" class="account-content">
        <div class="admin-content">
            <h3>Categories</h3>
            <select id="category-update" name="category-update" required>
                <option value="" disabled>Select a category</option>
                <?php foreach($categories as $category){ ?>
                    <option value="<?= $category->id ?>"><?= htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8') ?></option>
                <?php } ?>
            </select>
            <input type="text" id="categoryNameInput" name="categoryName" placeholder="Enter category name">
            <div class="button-container">
                <button onclick="deleteCategory()" id="delete-category-btn" class="delete-btn">Delete</button>
                <button onclick="renameCategory()" id="rename-category-btn" class="rename-btn">Rename</button>
                <button onclick="addCategory()" id="add-category" class="save-btn">Add new category</button>
            </div>

            <h3>Brands</h3>
            <select id="brand-update" name="brand-update" required>
                <option value="" disabled>Select a Brand</option>
                <?php foreach($brands as $brand){ ?>
                    <option value="<?= $brand->id ?>"><?= htmlspecialchars($brand->name, ENT_QUOTES, 'UTF-8') ?></option>
                <?php } ?>
            </select>
            <input type="text" id="brandNameInput" name="brandName" placeholder="Enter brand name">
            <div class="button-container">
                <button onclick="deleteBrand()" id="delete-brand-btn" class="delete-btn">Delete</button>
                <button onclick="renameBrand()" id="rename-brand-btn" class="rename-btn">Rename</button>
                <button onclick="addBrand()" id="add-brand" class="save-btn">Add new brand</button>
            </div>

            <h3>Scales</h3>
            <select id="scale-update" name="scale-update" required>
                <option value="" disabled>Select a Scale</option>
                <?php foreach($scales as $scale){ ?>
                    <option value="<?= $scale->id ?>"><?= htmlspecialchars($scale->name, ENT_QUOTES, 'UTF-8') ?></option>
                <?php } ?>
            </select>
            <input type="text" id="scaleNameInput" name="scaleName" placeholder="Enter scale name">
            <div class="button-container">
                <button onclick="deleteScale()" id="delete-scale-btn" class="delete-btn">Delete</button>
                <button onclick="renameScale()" id="rename-scale-btn" class="rename-btn">Rename</button>
                <button onclick="addScale()" id="add-scale" class="save-btn">Add new scale</button>
            </div>
        </div>

        <div class="banned-products">
            <?php 
                $db = getDatabaseConnection();
                if (!empty($bannedProducts)) { ?>
                    <h3>Banned Products</h3>
            <?php }    
            foreach($bannedProducts as $product) { ?>
                <div class="banned-product">
                    <a href="../pages/item.php?id=<?=$product->id;?>"><?=$product->title;?></a>
                    <p><?= Product::getBannedReason($db, $product->id); ?></p>
                    <div id="banned-date"><?= Product::getBannedDate($db, $product->id); ?></div>
                    <button onclick="unbanProduct(<?= $product->id ?>)" class="save-btn">Unban</button>
                </div>
            <?php } ?>
        </div>

        <div class="promotion-section">
            <h3><i class="fa-solid fa-crown"></i> Promote user</h3>
            <input type="text" id="user-id-promotion" name="user-id-promotion" placeholder="Enter user ID">
            <button onclick="promoteUser()" id="promote-user" class="save-btn">Promote as Admin</button>
        </div>
    </div>
<?php } ?>