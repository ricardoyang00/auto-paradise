function deleteCategory(categoryId) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Handle success response
                console.log(xhr.responseText);
            } else {
                // Handle error response
                console.error(xhr.statusText);
            }
        }
    };
    xhr.open("POST", "../actions/actions_admin.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("categoryId=" + encodeURIComponent(categoryId));
}

function addCategory(categoryName) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Handle success response
                console.log(xhr.responseText);
            } else {
                // Handle error response
                console.error(xhr.statusText);
            }
        }
    };
    xhr.open("POST", "../actions/actions_admin.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("categoryName=" + encodeURIComponent(categoryName));
}

function renameCategory(categoryId, categoryName) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Handle success response
                console.log(xhr.responseText);
            } else {
                // Handle error response
                console.error(xhr.statusText);
            }
        }
    };
    xhr.open("POST", "../actions/actions_admin.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("categoryId=" + encodeURIComponent(categoryId) + "&categoryName=" + encodeURIComponent(categoryName));
}
