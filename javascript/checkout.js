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

function togglePaymentMethod() {
    var paymentMethod = document.getElementById('paymentMethod');
    var isExpanded = paymentMethod.getAttribute('data-expanded') === 'true';
    paymentMethod.setAttribute('data-expanded', !isExpanded);
}

document.addEventListener('DOMContentLoaded', function() {
    var radioOptions = document.querySelectorAll('.radio-option');
    var shippingCostElement = document.getElementById('shippingCost');
    var totalElement = document.querySelector('.total .checkout-price');
    var subtotal = parseFloat(document.querySelector('.subtotal .checkout-price').textContent.replace('€ ', ''));
    var totalToPayInput = document.getElementById('totalToPayInput');
    
    function updateShippingCost() {
        var selectedOption = document.querySelector('input[name="shippingMethod"]:checked').value;
        var shippingCost = selectedOption === 'standard' ? 0 : 5.99;
        shippingCostElement.innerHTML = 'Estimated shipping: <span class="checkout-price">€ ' + (shippingCost === 0 ? 'Free' : shippingCost.toFixed(2)) + '</span>';
        updateTotal(shippingCost);
    }

    function updateTotal(shippingCost) {
        var total = subtotal + shippingCost;
        totalElement.textContent = '€ ' + total.toFixed(2);
        totalToPayInput.value = total.toFixed(2);
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

function addNameInputListener(elementId) {
    document.getElementById(elementId).addEventListener('input', function (e) {
        var regex = /^[a-zA-Z\s]*$/;
        var input = e.target.value;
        
        if (!regex.test(input)) {
            e.target.value = input.slice(0, -1);
        }
    });
}

addNameInputListener('cardHolder');

document.getElementById('cardNumber').addEventListener('input', function (e) {
    var target = e.target;
    var value = target.value.replace(/\D/g, '');
    var cursorPosition = target.selectionStart;
    
    var formatted = value.replace(/(\d{4})/g, '$1 ').trim();
    
    formatted = formatted.substring(0, 19);
    
    var addedSpaces = formatted.slice(0, cursorPosition).split(' ').length - 1;
    cursorPosition += addedSpaces;
    
    target.value = formatted;

    target.setSelectionRange(cursorPosition, cursorPosition);
});

function addDigitOnlyListener(elementId) {
    document.getElementById(elementId).addEventListener('keypress', function (e) {
        if (!/\d/.test(e.key)) {
            e.preventDefault();
        }
    });
}

addDigitOnlyListener('expiryMonth');
addDigitOnlyListener('expiryYear');
addDigitOnlyListener('cvv');
addDigitOnlyListener('phoneNumber');

function addMonthValidationListener(elementId) {
    const inputElement = document.getElementById(elementId);

    inputElement.addEventListener('blur', function (e) {
        var value = parseInt(e.target.value, 10);

        if (isNaN(value) || value < 1 || value > 12) {
            e.target.value = '';
        } else {
            e.target.value = value.toString().padStart(2, '0');
        }
    });
}

addMonthValidationListener('expiryMonth');

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action="waitPayment.php"]');
    let selectedPaymentMethodInput = document.getElementById('selectedPaymentMethod');
    let paymentDetailsInput = document.getElementById('paymentDetails');
    
    form.addEventListener('submit', function(event) {
        const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;

        let isValid = true;
        let selectedPaymentMethod = '';
        let paymentDetails = '';

        if (paymentMethod === 'creditCard') {
            const cardHolder = document.getElementById('cardHolder').value;
            const cardNumber = document.getElementById('cardNumber').value;
            const expiryMonth = document.getElementById('expiryMonth').value;
            const expiryYear = document.getElementById('expiryYear').value;
            const cvv = document.getElementById('cvv').value;
        
            const cardNumberRegex = /^(\d{4} ){3}\d{4}$/;
            const monthYearRegex = /^\d{2}$/;
            const cvvRegex = /^\d{3}$/;
        
            if (!cardHolder.trim() || !cardNumberRegex.test(cardNumber) || !monthYearRegex.test(expiryMonth) || !monthYearRegex.test(expiryYear) || !cvvRegex.test(cvv) ) {
                alert('Please fill in all the required fields.');
                isValid = false;
            }  else {
                selectedPaymentMethod = 'Credit Card';
                paymentDetails = cardNumber.replace(/\s+/g, '');
            }

        } else if (paymentMethod === 'mbway') {
            const phoneNumber = document.getElementById('phoneNumber').value;
            const phoneNumberRegex = /^\d{9}$/;
        
            if (!phoneNumberRegex.test(phoneNumber)) {
                alert('Phone number must be 9 digits.');
                isValid = false;
            } else {
                selectedPaymentMethod = 'MB WAY';
                paymentDetails = phoneNumber;
            }
        }
        
        if (isValid) {
            selectedPaymentMethodInput.value = selectedPaymentMethod;
            paymentDetailsInput.value = paymentDetails;
        } else {
            event.preventDefault();
        }
    });
});

