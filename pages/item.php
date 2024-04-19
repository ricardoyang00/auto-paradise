<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../templates/common.tpl.php');
    drawHeader();
?>

<section id="item">
    <div class="container">
        <div class="image">
            <img src="../images/products/product_1.jpg" alt="Product Image">
        </div>
        <div class="title">
            <h2>Product Category</h2>
            <h1>Product Title</h1>
            <h3>€99.99</h3>
            <button>Buy Now</button>
            <button class="add-wishlist"><a href="#"><i class="fa-regular fa-heart"></i></a></button>
            
        </div>
        <div class="seller-info">
            <h2>Seller Information</h2>
            <p class="name">John Doe</p>
            <p class="location"><i class="fa-solid fa-location-dot"></i> City, Country</p>
        </div>
        <div class="description">
            <h2>Description</h2>
            <p>Description text Description textDescription textDescription textDescription textDescription textDescription textDescription textDescription textDescription textDescription textDescription textDescription textDescription textDescription textDescription textDescription textDescription textDescription textDescription textDescription textDescription textDescription textDescription textDescription textDescription textDescription textDescription textDescription textDescription textDescription textDescription text</p>
        </div>
        <div class="qna">
            <h2>Q&A</h2>
            <form>
                <textarea placeholder="Ask a question..."></textarea>
                <button type="submit">Submit</button>
            </form>
            <div class="qa-item">
                <p><strong>Q:</strong> Question text?</p>
                <p><strong>A:</strong> Answer text...</p>
            </div>
        </div>
    </div>
</section>


<?php drawFooter(); ?>
