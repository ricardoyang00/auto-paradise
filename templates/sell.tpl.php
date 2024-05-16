<?php declare(strict_types = 1); ?>

<?php function drawSellForm($session, $categories, $brands, $scales) {?>
    <section id="sell">
        <h2>Sell an item</h2>
        <form action="../actions/upload.php" method="post" enctype="multipart/form-data">
            <div class="input-container">
                <label for="image">Upload Images</label>
                <input type="file" id="image" name="image[]" accept="image/*" multiple class="upload-btn" required>
                <div id="image-preview"></div>
            </div>
            <div class="input-container">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" placeholder="e.g. Ferrari SF90" maxlength="40" required>
            </div>
            <div class="input-container">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4" placeholder="e.g. Scale model 99% new" maxlength="500" required></textarea>
            </div>
            <div class="input-container">
                <label for="category">Category</label>
                <select id="category" name="category" required>
                <option value="" selected disabled>Select a category</option>
                <?php foreach($categories as $category){ ?>
                    <option value="<?= $category->id ?>"><?= $category->name ?></option>
                <?php } ?>
                </select>
            </div>
            <div class="input-container">
                <label for="brand">Brand</label>
                <select id="brand" name="brand" required>
                    <option value="" selected disabled>Select a brand</option>
                    <?php foreach($brands as $brand){ ?>
                        <option value="<?= $brand->id ?>"><?= $brand->name ?></option>
                    <?php } ?>
                </select>  
            </div>
            <div class="input-container">
                <label for="scale">Scale</label>
                <select id="scale" name="scale" required>
                    <option value="" selected disabled>Select a scale</option>
                    <?php foreach($scales as $scale){ ?>
                        <option value="<?= $scale->id ?>"><?= $scale->name ?></option>
                    <?php } ?>
                </select>  
            </div>
            <div class="input-container">
                <label for="price">Price</label>
                <input type="number" id="price" name="price" placeholder="€0.00" min="0" step="0.01" max="9999999" required>
            </div>
            <input type="hidden" name="csrf_token" value="<?php echo $session->getCsrfToken(); ?>">
            <button type="upload">Upload</button>
        </form>
    </section>
<?php } ?>