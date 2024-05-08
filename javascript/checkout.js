function toggleUserInfo() {
    var userInfo = document.getElementById('checkoutUserInfo');
    var isExpanded = userInfo.getAttribute('data-expanded') === 'true';
    userInfo.setAttribute('data-expanded', !isExpanded);
}