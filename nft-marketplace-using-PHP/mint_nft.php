<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['artwork_id'])) {
    $userID = $_SESSION['user_id'];
    $artworkID = (int)$_POST['artwork_id'];

    // Check if user already owns NFT of this artwork (optional)
    $stmt = $pdo->prepare("SELECT * FROM nft WHERE Owner_User_ID = ? AND Artwork_ID = ?");
    $stmt->execute([$userID, $artworkID]);
    if ($stmt->fetch()) {
        $_SESSION['message'] = "You already own this NFT.";
        header("Location: dashboard");
        exit;
    }

    // Generate unique token
    $token = bin2hex(random_bytes(16)); // 32-character secure token

    // Insert NFT with token
    $stmt = $pdo->prepare("INSERT INTO nft (Owner_User_ID, Artwork_ID, token) VALUES (?, ?, ?)");
    $stmt->execute([$userID, $artworkID, $token]);

    $_SESSION['message'] = "NFT minted successfully!";
    header("Location: dashboard");
    exit;
}

header("Location: index");
exit;
