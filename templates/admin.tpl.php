<?php declare(strict_types = 1); ?>

<?php function drawAdminSection($categories, $brands, $scales) { ?>
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
                    <option value="<?= $brand->id ?>"><?= $brand->name ?></option>
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
                    <option value="<?= $scale->id ?>"><?= $scale->name ?></option>
                <?php } ?>
            </select>
            <input type="text" id="scaleNameInput" name="scaleName" placeholder="Enter scale name">
            <div class="button-container">
                <button onclick="deleteScale()" id="delete-scale-btn" class="delete-btn">Delete</button>
                <button onclick="renameScale()" id="rename-scale-btn" class="rename-btn">Rename</button>
                <button onclick="addScale()" id="add-scale" class="save-btn">Add new scale</button>
            </div>
        </div>
    </div>
<?php } ?>