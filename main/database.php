<?php
require_once 'config.php';

class Database
{
    private $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }


    public function getAllListings()
    {
        $stmt = $this->pdo->query("SELECT * FROM listings ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById($userId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUserProfile($userId, $email, $phone, $bio)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET email = ?, phone = ?, bio = ? WHERE id = ?");
        return $stmt->execute([$email, $phone, $bio, $userId]);
    }

    public function addListing($userId, $title, $description, $price, $location, $bedrooms, $bathrooms, $imageUrl)
    {
        $stmt = $this->pdo->prepare("INSERT INTO listings (user_id, title, description, price, location, bedrooms, bathrooms, image_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$userId, $title, $description, $price, $location, $bedrooms, $bathrooms, $imageUrl]);
    }

    public function processPayment($listingId, $paymentMethod, $amount)
    {
        $stmt = $this->pdo->prepare("INSERT INTO payments (listing_id, payment_method, amount, created_at) VALUES (?, ?, ?, NOW())");
        return $stmt->execute([$listingId, $paymentMethod, $amount]);
    }

    public function login($username, $password)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function register($username, $password, $email)
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        return $stmt->execute([$username, $hashed_password, $email]);
    }
}

$db = new Database();
