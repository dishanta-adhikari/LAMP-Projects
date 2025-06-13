<?php
session_start();
include "db.php";
include "header.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login");
    exit;
}

$userID = $_SESSION['user_id'];

// Fetch user's NFTs with payment status
$stmt = $pdo->prepare("
    SELECT nft.NFT_ID, a.Title, a.Photo, a.Price, nft.Is_Paid, nft.token
    FROM nft
    JOIN artwork a ON nft.Artwork_ID = a.Artwork_ID
    WHERE nft.Owner_User_ID = ?
");

$stmt->execute([$userID]);
$ownedNFTs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="./css/dashboard.css">
<div class="container my-4">
    <h1>Your NFTs</h1>
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success"><?= $_SESSION['message'];
                                            unset($_SESSION['message']); ?></div>
    <?php endif; ?>

    <div id="paymentAlert" class="alert alert-success d-none nft-payment-alert" role="alert"></div>

    <div class="row">
        <?php foreach ($ownedNFTs as $nft): ?>
            <div class="col-md-4">
                <div class="card mb-3 shadow-sm nft-card">
                    <img src="<?= htmlspecialchars($nft['Photo']) ?>" class="card-img-top nft-card-img" alt="<?= htmlspecialchars($nft['Title']) ?>">
                    <div class="card-body">
                        <h5 class="card-title nft-card-title"><?= htmlspecialchars($nft['Title']) ?></h5>
                        <p class="nft-price-text"><strong>Price:</strong> $<?= number_format($nft['Price'], 2) ?></p>

                        <?php if ($nft['Is_Paid']): ?>
                            <a
                                href="<?= htmlspecialchars($nft['Photo']) ?>"
                                class="btn btn-primary nft-download-btn"
                                download="<?= preg_replace('/\s+/', '_', $nft['Title']) ?>.<?= pathinfo($nft['Photo'], PATHINFO_EXTENSION) ?>">
                                Download
                            </a>
                            <p class="mt-2">
                                <strong>Token:</strong>
                                <code class="text-break"><?= htmlspecialchars($nft['token']) ?></code>
                            </p>
                        <?php else: ?>
                            <button
                                class="btn nft-pay-btn pay-btn btn-success"
                                data-bs-toggle="modal"
                                data-bs-target="#paymentModal"
                                data-title="<?= htmlspecialchars($nft['Title']) ?>"
                                data-price="<?= number_format($nft['Price'], 2) ?>"
                                data-nftid="<?= $nft['NFT_ID'] ?>">
                                Pay to Download
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="paymentModalLabel">NFT Payment</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>NFT:</strong> <span id="nftTitle"></span></p>
                <p><strong>Price:</strong> $<span id="nftPrice"></span></p>
                <hr>
                <p>This is a fake payment modal for demo purposes only.</p>
                <div class="mb-3">
                    <label for="cardNumber" class="form-label">Card Number</label>
                    <input type="text" class="form-control" id="cardNumber" placeholder="1234 5678 9012 3456" />
                </div>
                <div class="row">
                    <div class="col">
                        <label for="expiry" class="form-label">Expiry</label>
                        <input type="text" class="form-control" id="expiry" placeholder="MM/YY" />
                    </div>
                    <div class="col">
                        <label for="cvv" class="form-label">CVV</label>
                        <input type="text" class="form-control" id="cvv" placeholder="123" />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button id="payNowBtn" type="button" class="btn btn-success">Pay Now</button>
            </div>
        </div>
    </div>
</div>

<script>
    const paymentModal = document.getElementById('paymentModal');
    const payNowBtn = document.getElementById('payNowBtn');
    const paymentAlert = document.getElementById('paymentAlert');

    let currentNFTId = null;

    paymentModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        currentNFTId = button.getAttribute('data-nftid');

        document.getElementById('nftTitle').textContent = button.getAttribute('data-title');
        document.getElementById('nftPrice').textContent = button.getAttribute('data-price');

        document.getElementById('cardNumber').value = '';
        document.getElementById('expiry').value = '';
        document.getElementById('cvv').value = '';
    });

    payNowBtn.addEventListener('click', () => {
        if (!currentNFTId) return;

        const modal = bootstrap.Modal.getInstance(paymentModal);
        modal.hide();

        const formData = new FormData();
        formData.append('nft_id', currentNFTId);

        fetch('process_payment', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    paymentAlert.textContent = 'Payment successful! Thank you.';
                    paymentAlert.classList.remove('d-none');

                    paymentAlert.scrollIntoView({
                        behavior: 'smooth'
                    });

                    // Reload page to update buttons permanently
                    setTimeout(() => {
                        location.reload();
                    }, 1300);
                } else {
                    alert('Payment failed: ' + data.message);
                }
            })
            .catch(err => {
                alert('Error occurred. Please try again.');
                console.error(err);
            });
    });
</script>

<?php include "footer.php"; ?>