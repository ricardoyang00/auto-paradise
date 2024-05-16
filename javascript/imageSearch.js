function changeImage(imgElement, newImageUrl) {
    if (newImageUrl) {
        imgElement.src = newImageUrl;
    }
}

function resetImage(imgElement, originalImageUrl) {
    imgElement.src = originalImageUrl;
}
