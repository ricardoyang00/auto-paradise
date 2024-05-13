document.getElementById('downloadPdf').addEventListener('click', function () {
    html2canvas(document.querySelector('.receipt-container'), { scale: 2 }).then(canvas => {
        const imgData = canvas.toDataURL('image/png');

        const pdf = new window.jspdf.jsPDF({
            orientation: 'p',
            unit: 'px',
            format: [canvas.width, canvas.height]
        });

        pdf.addImage(imgData, 'PNG', 0, 0, canvas.width, canvas.height);

        pdf.save("receipt.pdf");
    }).catch(error => {
        console.error('Error generating canvas:', error);
    });
});