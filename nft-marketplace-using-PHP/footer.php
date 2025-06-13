<style>
    .sticky-footer {
        background: linear-gradient(90deg, #4b0082, #8a2be2);
        color: #f8bbd0;
        /* light pink */
        padding: 0.75rem 0;
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        box-shadow: 0 -2px 8px rgba(138, 43, 226, 0.6);
        font-weight: 600;
        font-size: 0.9rem;
        z-index: 1030;
        text-shadow: 0 0 4px #f8bbd0;
        transition: color 0.3s ease;
    }

    .sticky-footer:hover {
        color: #e91e63;
        /* bright pink on hover */
        text-shadow: 0 0 8px #e91e63;
    }

    body {
        margin: 0;
        padding-bottom: 50px;
        /* reserve footer space */
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<footer class="sticky-footer">
    <div class="container text-center">
        <small>&copy; <?= date('Y') ?> NFT Marketplace. All rights reserved.</small>
    </div>
</footer>