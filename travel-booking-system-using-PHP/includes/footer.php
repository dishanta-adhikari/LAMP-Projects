<style>
    .main-footer {
        background: linear-gradient(to right, #667eea, #764ba2);
        font-family: 'Inter', sans-serif;
        font-size: 0.9rem;
        color: white;
        box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.3);
        /* top shadow */
    }

    @media (max-width: 768px) {
        .main-footer {
            font-size: 0.8rem;
            padding: 0.7rem;
        }
    }
</style>

<footer class="main-footer text-center py-3">
    <small>© <?= date('Y') ?> TravelBook. All rights reserved.</small>
</footer>