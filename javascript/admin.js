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
    var categoryName = document.getElementById("categoryNameInput").value.trim();
    if (categoryName === "") {
        alert("Category name cannot be empty.");
        return;
    }
    console.log("Adding category: " + categoryName);
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200 && xhr.responseText.includes("SUCCESS")) {
                console.log("Operation successful. Reloading page...");
                setTimeout(function() {
                    location.reload();
                }, 1000); 
                alert("Category added successfully.");
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
    var categoryName = document.getElementById("categoryNameInput").value.trim();
    if (categoryName === "") {
        alert("Category name cannot be empty.");
        return;
    }
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200 && xhr.responseText.includes("SUCCESS")) {
                console.log("Operation successful. Reloading page...");
                setTimeout(function() {
                    location.reload();
                }, 1000); 
                alert("Category renamed successfully.");
            } else {
                console.error(xhr.statusText);
            }
        }
    };
    xhr.open("POST", "../actions/action_admin.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("action=categoryId=" + encodeURIComponent(categoryId) + "&categoryName=" + encodeURIComponent(categoryName));
}

function deleteBrand() {
    var confirmation = confirm("Are you sure you want to delete this brand? This action cannot be undone and all products of this brand will be deleted.");
    if (!confirmation) {
        return;
    }
    var brandId = document.getElementById("brand-update").value;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200 && xhr.responseText.includes("SUCCESS")) {
                console.log("Operation successful. Reloading page...");
                setTimeout(function() {
                    location.reload();
                }, 1000); 
                alert("Brand deleted successfully.");
            } else {
                console.error(xhr.statusText);
            }
        }
    };
    xhr.open("POST", "../actions/action_admin.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("action=deleteBrand&brandId=" + encodeURIComponent(brandId));
}

function addBrand() {
    var brandName = document.getElementById("brandNameInput").value.trim();
    if (brandName === "") {
        alert("Brand name cannot be empty.");
        return;
    }
    console.log("Adding brand: " + brandName);
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200 && xhr.responseText.includes("SUCCESS")) {
                console.log("Operation successful. Reloading page...");
                setTimeout(function() {
                    location.reload();
                }, 1000); 
                alert("Brand added successfully.");
            } else {
                console.error(xhr.statusText);
            }
        }
    };
    xhr.open("POST", "../actions/action_admin.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("action=addBrand&brandName=" + encodeURIComponent(brandName));
}

function renameBrand() {
    var brandId = document.getElementById("brand-update").value.trim();
    if (brandId === "") {
        alert("Brand ID cannot be empty.");
        return;
    }
    var brandName = document.getElementById("brandNameInput").value;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200 && xhr.responseText.includes("SUCCESS")) {
                console.log("Operation successful. Reloading page...");
                setTimeout(function() {
                    location.reload();
                }, 1000); 
                alert("Brand renamed successfully.");
            } else {
                console.error(xhr.statusText);
            }
        }
    };
    xhr.open("POST", "../actions/action_admin.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("action=renameBrand&brandId=" + encodeURIComponent(brandId) + "&brandName=" + encodeURIComponent(brandName));
}

function deleteScale() {
    var confirmation = confirm("Are you sure you want to delete this scale? This action cannot be undone and all products of this scale will be deleted.");
    if (!confirmation) {
        return;
    }
    var scaleId = document.getElementById("scale-update").value;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200 && xhr.responseText.includes("SUCCESS")) {
                console.log("Operation successful. Reloading page...");
                setTimeout(function() {
                    location.reload();
                }, 1000); 
                alert("Scale deleted successfully.");
            } else {
                console.error(xhr.statusText);
            }
        }
    };
    xhr.open("POST", "../actions/action_admin.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("action=deleteScale&scaleId=" + encodeURIComponent(scaleId));
}

function addScale() {
    var scaleName = document.getElementById("scaleNameInput").value.trim();
    if (scaleName === "") {
        alert("Scale name cannot be empty.");
        return;
    }
    console.log("Adding scale: " + scaleName);
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200 && xhr.responseText.includes("SUCCESS")) {
                console.log("Operation successful. Reloading page...");
                setTimeout(function() {
                    location.reload();
                }, 1000); 
                alert("Scale added successfully.");
            } else {
                console.error(xhr.statusText);
            }
        }
    };
    xhr.open("POST", "../actions/action_admin.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("action=addScale&scaleName=" + encodeURIComponent(scaleName));
}

function renameScale() {
    var scaleId = document.getElementById("scale-update").value.trim();
    if (scaleId === "") {
        alert("Scale ID cannot be empty.");
        return;
    }
    var scaleName = document.getElementById("scaleNameInput").value;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200 && xhr.responseText.includes("SUCCESS")) {
                console.log("Operation successful. Reloading page...");
                setTimeout(function() {
                    location.reload();
                }, 1000); 
                alert("Scale renamed successfully.");
            } else {
                console.error(xhr.statusText);
            }
        }
    };
    xhr.open("POST", "../actions/action_admin.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("action=renameScale&scaleId=" + encodeURIComponent(scaleId) + "&scaleName=" + encodeURIComponent(scaleName));
}

function showBanPopup() {
    document.getElementById("banPopup").style.display = "block";
}

function closeBanPopup() {
    document.getElementById("banPopup").style.display = "none";
}

function banProduct(productId) {
    var banReason = document.getElementById("banReason").value;

    console.log("Banning product " + productId + " with reason: " + banReason);

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                alert("Product banned successfully.");
            } else {
                alert("Failed to ban product.");
            }
            closeBanPopup(); 
        }
    };
    xhr.open("POST", "../actions/ban_product.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("productId=" + productId + "&banReason=" + encodeURIComponent(banReason));
}

function unbanProduct(productId) {
    console.log("Unbanning product " + productId);

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                alert("Product unbanned successfully.");
            } else {
                alert("Failed to unban product.");
            }
            location.reload();
        }
    };
    xhr.open("POST", "../actions/unban_product.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("productId=" + productId);
}

function promoteUser() {
    var userId = document.getElementById("user-id-promotion").value;
    console.log("Promoting user " + userId);

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            console.log(xhr.responseText);
            var response = JSON.parse(xhr.responseText);
            if (xhr.status === 200 && response.status === "SUCCESS") {
                alert("User promoted successfully.");
            } else {
                alert("Failed to promote user.");
            }
            location.reload();
        }
    };
    xhr.open("POST", "../actions/promote_user.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("userId=" + userId);
}
