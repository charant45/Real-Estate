<?php
// database.php
require_once 'config.php';

class Database
{
    private $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function getAllListings($limit = null, $offset = 0)
    {
        $query = "SELECT * FROM listings ORDER BY created_at DESC";
        if ($limit !== null) {
            $query .= " LIMIT :limit OFFSET :offset";
        }
        $stmt = $this->pdo->prepare($query);
        if ($limit !== null) {
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getListingById($listingId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM listings WHERE id = ?");
        $stmt->execute([$listingId]);
        return $stmt->fetch();
    }

    public function getUserById($userId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch();
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

    public function updateListing($listingId, $title, $description, $price, $location, $bedrooms, $bathrooms, $imageUrl)
    {
        $stmt = $this->pdo->prepare("UPDATE listings SET title = ?, description = ?, price = ?, location = ?, bedrooms = ?, bathrooms = ?, image_url = ? WHERE id = ?");
        return $stmt->execute([$title, $description, $price, $location, $bedrooms, $bathrooms, $imageUrl, $listingId]);
    }

    public function deleteListing($listingId)
    {
        $stmt = $this->pdo->prepare("DELETE FROM listings WHERE id = ?");
        return $stmt->execute([$listingId]);
    }

    public function processPayment($listingId, $paymentMethod, $amount)
    {
        $stmt = $this->pdo->prepare("INSERT INTO payments (listing_id, payment_method, amount, created_at) VALUES (?, ?, ?, NOW())");
        return $stmt->execute([$listingId, $paymentMethod, $amount]);
    }

    public function loginUser($username, $password)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function registerUser($username, $password, $email)
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        return $stmt->execute([$username, $hashed_password, $email]);
    }

    public function searchListings($keyword, $minPrice = null, $maxPrice = null, $bedrooms = null, $bathrooms = null)
    {
        $query = "SELECT * FROM listings WHERE title LIKE :keyword OR description LIKE :keyword";
        $params = [':keyword' => "%$keyword%"];

        if ($minPrice !== null) {
            $query .= " AND price >= :minPrice";
            $params[':minPrice'] = $minPrice;
        }
        if ($maxPrice !== null) {
            $query .= " AND price <= :maxPrice";
            $params[':maxPrice'] = $maxPrice;
        }
        if ($bedrooms !== null) {
            $query .= " AND bedrooms = :bedrooms";
            $params[':bedrooms'] = $bedrooms;
        }
        if ($bathrooms !== null) {
            $query .= " AND bathrooms = :bathrooms";
            $params[':bathrooms'] = $bathrooms;
        }

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function addContactSubmission($name, $email, $message)
    {
        $stmt = $this->pdo->prepare("INSERT INTO contact_submissions (name, email, message) VALUES (?, ?, ?)");
        return $stmt->execute([$name, $email, $message]);
    }
}

$db = new Database();