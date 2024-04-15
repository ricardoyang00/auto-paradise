<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../templates/common.tpl.php');
    drawHeader();
?>

<section id="sell">
  <h2>Sell an item</h2>
  <form action="#" method="post" enctype="multipart/form-data">
      <div class="input-container">
          <label for="image">Upload Images</label>
          <input type="file" id="image" name="image" accept="image/*">
      </div>
      <div class="input-container">
          <label for="title">Title</label>
          <input type="text" id="title" name="title" placeholder="e.g. Ferrari SF90" required>
      </div>
      <div class="input-container">
          <label for="description">Description</label>
          <textarea id="description" name="description" rows="4" placeholder="e.g. Scale model 99% new" required></textarea>
      </div>
      <div class="input-container">
          <label for="category">Category</label>
          <select id="category" name="category" required>
              <option value="" selected disabled>Select a category</option>
              <option value="civil_cars">Civil Cars</option>
              <option value="dtm">DTM</option>
              <option value="f1">F1</option>
              <option value="le_mans">Le Mans</option>
              <option value="other_competitions">Other Competitions</option>
              <option value="rally">Rally</option>
              <option value="hotwheels">Hotwheels</option>
              <option value="other">Others</option>
          </select>
      </div>
      <div class="input-container">
          <label for="brand">Brand</label>
          <select id="brand" name="brand" required>
              <option value="" selected disabled>Select a brand</option>
              <option value="Acura">Acura</option>
              <option value="Alfa Romeo">Alfa Romeo</option>
              <option value="Aston Martin">Aston Martin</option>
              <option value="Audi">Audi</option>
              <option value="Bentley">Bentley</option>
              <option value="BMW">BMW</option>
              <option value="Bugatti">Bugatti</option>
              <option value="Buick">Buick</option>
              <option value="Cadillac">Cadillac</option>
              <option value="Chevrolet">Chevrolet</option>
              <option value="Chrysler">Chrysler</option>
              <option value="Dodge">Dodge</option>
              <option value="Ferrari">Ferrari</option>
              <option value="Fiat">Fiat</option>
              <option value="Ford">Ford</option>
              <option value="Genesis">Genesis</option>
              <option value="GMC">GMC</option>
              <option value="Honda">Honda</option>
              <option value="Hyundai">Hyundai</option>
              <option value="Infiniti">Infiniti</option>
              <option value="Jaguar">Jaguar</option>
              <option value="Jeep">Jeep</option>
              <option value="Kia">Kia</option>
              <option value="Lamborghini">Lamborghini</option>
              <option value="Land Rover">Land Rover</option>
              <option value="Lexus">Lexus</option>
              <option value="Lincoln">Lincoln</option>
              <option value="Lotus">Lotus</option>
              <option value="Maserati">Maserati</option>
              <option value="Mazda">Mazda</option>
              <option value="McLaren">McLaren</option>
              <option value="Mercedes-Benz">Mercedes-Benz</option>
              <option value="Mini">Mini</option>
              <option value="Mitsubishi">Mitsubishi</option>
              <option value="Nissan">Nissan</option>
              <option value="Pagani">Pagani</option>
              <option value="Porsche">Porsche</option>
              <option value="Ram">Ram</option>
              <option value="Rolls-Royce">Rolls-Royce</option>
              <option value="Subaru">Subaru</option>
              <option value="Tesla">Tesla</option>
              <option value="Toyota">Toyota</option>
              <option value="Volkswagen">Volkswagen</option>
              <option value="Volvo">Volvo</option>
              <option value="Other">Others</option>
          </select>  
      </div>
      <div class="input-container">
          <label for="price">Price</label>
          <input type="number" id="price" name="price" placeholder="€0.00" required>
      </div>
      <button type="upload">Upload</button>
  </form>
</section>

<?php drawFooter(); ?>
