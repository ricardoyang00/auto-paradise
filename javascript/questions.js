document.addEventListener('DOMContentLoaded', function() {
    function getProductId() {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get('id');
    }
    const submitButton = document.getElementById('submit-question');

    submitButton.addEventListener('click', function() {
        const questionText = document.getElementById('question-text').value.trim();

        if (questionText !== '') {
            const productId = getProductId();
            console.log(productId);
            sendQuestionData(productId, questionText);
        } else {
            alert('Please enter a question before submitting.');
        }
    });

    function sendQuestionData(productId, questionText) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../actions/action_questions.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                window.location.href = `../pages/item.php?id=${productId}`;
                alert('Question submitted successfully. You will receive an notification when the seller answers your question.');
            } else if (xhr.status === 403) {
                alert('You cannot ask questions about your own products.');
            } else if (xhr.status === 400) {
                alert('Missing required parameters. Please try again.');
            } else {
                alert('Failed to submit question. Please try again later.');
            }
        };        
        console.log(questionText);
        const requestBody = `question=${encodeURIComponent(questionText)}&productId=${productId}`;
        xhr.send(requestBody);
    }
});
