<?php declare(strict_types = 1); ?>

<?php function drawFilter($scales, $categories, $brands) {?>
    <aside id="filter">
        <h1>Filter by</h1>
        <form id="filter-form" action="#" method="get">
            <div class="search-name">
                <input type="text" id="search-name" name="search-name">
            </div>
            <div class="filter-scale">
                <h2>Scale</h2>
                <ul>
                    <?php foreach($scales as $scale){ ?>
                        <li><input type="checkbox" id="scale_<?= $scale->id ?>" name="scale[]" value="<?= $scale->id ?>"><label for="scale_<?= $scale->id ?>"><?= $scale->name ?></label></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="filter-category">
                <h2>Category</h2>
                <ul>
                    <?php foreach($categories as $category){ ?>
                        <li><input type="checkbox" id="category_<?= $category->id ?>" name="category[]" value="<?= $category->id ?>"><label for="category_<?= $category->id ?>"><?= $category->name ?></label></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="filter-brand">
                <h2>Brand</h2>
                <ul>
                    <?php foreach($brands as $brand){ ?>
                        <li><input type="checkbox" id="brand_<?= $brand->id ?>" name="brand[]" value="<?= $brand->id ?>"><label for="brand_<?= $brand->id ?>"><?= $brand->name ?></label></li>
                    <?php } ?>
                </ul>
            </div>
        </form>
    </aside> 
<?php } ?>