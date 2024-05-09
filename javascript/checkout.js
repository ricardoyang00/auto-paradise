function toggleUserInfo() {
    var userInfo = document.getElementById('checkoutUserInfo');
    var isExpanded = userInfo.getAttribute('data-expanded') === 'true';
    userInfo.setAttribute('data-expanded', !isExpanded);
}

function toggleShippingMethod() {
    var shippingMethod = document.getElementById('shippingMethod');
    var isExpanded = shippingMethod.getAttribute('data-expanded') === 'true';
    shippingMethod.setAttribute('data-expanded', !isExpanded);
}

document.addEventListener('DOMContentLoaded', function() {
    var radioOptions = document.querySelectorAll('.radio-option');
    var shippingCostElement = document.getElementById('shippingCost');
    var totalElement = document.querySelector('.total .checkout-price');
    var subtotal = parseFloat(document.querySelector('.subtotal .checkout-price').textContent.replace('€ ', ''));

    function updateShippingCost() {
        var selectedOption = document.querySelector('input[name="shippingMethod"]:checked').value;
        var shippingCost = selectedOption === 'standard' ? 0 : 5.99;
        shippingCostElement.innerHTML = 'Estimated shipping: <span class="checkout-price">€ ' + (shippingCost === 0 ? 'Free' : shippingCost.toFixed(2)) + '</span>';
        updateTotal(shippingCost);
    }

    function updateTotal(shippingCost) {
        var total = subtotal + shippingCost;
        totalElement.textContent = '€ ' + total.toFixed(2);
    }

    radioOptions.forEach(function(option) {
        option.addEventListener('click', function(event) {
            event.stopPropagation();
            if (event.target.tagName !== 'INPUT') {
                this.querySelector('input[type="radio"]').checked = true;
            }
            updateShippingCost();
        });
    });

    updateShippingCost();
});