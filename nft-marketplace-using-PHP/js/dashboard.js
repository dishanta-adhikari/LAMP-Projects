const paymentModal = document.getElementById('paymentModal');
const payNowBtn = document.getElementById('payNowBtn');
const paymentAlert = document.getElementById('paymentAlert');

let currentNFTId = null;

// When modal opens, fill in NFT info and track NFT ID
paymentModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const title = button.getAttribute('data-title');
    const price = button.getAttribute('data-price');
    currentNFTId = button.getAttribute('data-nftid');

    document.getElementById('nftTitle').textContent = title;
    document.getElementById('nftPrice').textContent = price;

    // Clear inputs
    document.getElementById('cardNumber').value = '';
    document.getElementById('expiry').value = '';
    document.getElementById('cvv').value = '';
});

payNowBtn.addEventListener('click', () => {
    // Close modal
    const modal = bootstrap.Modal.getInstance(paymentModal);
    modal.hide();

    // Show success alert
    paymentAlert.textContent = 'Payment successful! Thank you for your purchase.';
    paymentAlert.classList.remove('d-none');

    // Disable the paid NFT's Pay button and change text & style
    if (currentNFTId) {
        const payButton = document.querySelector(`button.pay-btn[data-nftid="${currentNFTId}"]`);
        if (payButton) {
            payButton.textContent = 'Paid';
            payButton.classList.remove('btn-success');
            payButton.classList.add('btn-secondary');
            payButton.disabled = true;
        }
    }

    // Scroll to alert message
    paymentAlert.scrollIntoView({
        behavior: 'smooth'
    });
});

// Disable the paid NFT's Pay button and change text & style
if (currentNFTId) {
    const payButton = document.querySelector(`button.pay-btn[data-nftid="${currentNFTId}"]`);
    if (payButton) {
        payButton.textContent = 'Paid';
        payButton.disabled = true;
        payButton.classList.remove('nft-pay-btn');
        payButton.classList.add('btn-secondary');
    }
}