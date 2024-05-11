function deleteCategory() {
    var confirmation = confirm("Are you sure you want to delete this category? This action cannot be undone and all products in this category will be deleted.");
    if (!confirmation) {
        return;
    }
    var categoryId = document.getElementById("category-update").value;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200 && xhr.responseText.includes("SUCCESS")) {
                console.log("Operation successful. Reloading page...");
                setTimeout(function() {
                    location.reload();
                }, 1000); 
                alert("Category deleted successfully.");
            } else {
                console.error(xhr.statusText);
            }
        }
    };
    xhr.open("POST", "../actions/action_admin.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("action=deleteCategory&categoryId=" + encodeURIComponent(categoryId));
}

function addCategory() {
    var categoryName = document.getElementById("categoryNameInput").value;
    console.log("Adding category: " + categoryName);
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200 && xhr.responseText.includes("SUCCESS")) {
                console.log("Operation successful. Reloading page...");
                setTimeout(function() {
                    location.reload();
                }, 1000); 
            } else {
                console.error(xhr.statusText);
            }
        }
    };
    xhr.open("POST", "../actions/action_admin.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("action=addCategory&categoryName=" + encodeURIComponent(categoryName));
}

function renameCategory() {
    var categoryId = document.getElementById("category-update").value;
    var categoryName = document.getElementById("categoryNameInput").value;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200 && xhr.responseText.includes("SUCCESS")) {
                console.log("Operation successful. Reloading page...");
                setTimeout(function() {
                    location.reload();
                }, 1000); 
            } else {
                console.error(xhr.statusText);
            }
        }
    };
    xhr.open("POST", "../actions/action_admin.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("action=categoryId=" + encodeURIComponent(categoryId) + "&categoryName=" + encodeURIComponent(categoryName));
}
