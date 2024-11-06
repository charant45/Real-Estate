<?php
require_once 'database.php';
require_once 'auth.php';

if (!is_logged_in()) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
    $location = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_STRING);
    $bedrooms = filter_input(INPUT_POST, 'bedrooms', FILTER_VALIDATE_INT);
    $bathrooms = filter_input(INPUT_POST, 'bathrooms', FILTER_VALIDATE_FLOAT);
    $area = filter_input(INPUT_POST, 'area', FILTER_VALIDATE_INT); // New field for area
    $image_url = filter_input(INPUT_POST, 'image_url', FILTER_SANITIZE_URL);
    $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);

    if ($db->addListing($_SESSION['user_id'], $title, $description, $price, $location, $bedrooms, $bathrooms, $area, $image_url, $type)) {
        $success = "Listing added successfully";
    } else {
        $error = "Failed to add listing";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Listing - Real Estate</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <?php include 'header.php'; ?>

    <main class="container mx-auto mt-8 px-4">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-6">Add New Listing</h1>
            <?php if (isset($success)): ?>
                <p class="text-green-500 mb-4"><?php echo htmlspecialchars($success); ?></p>
            <?php endif; ?>
            <?php if (isset($error)): ?>
                <p class="text-red-500 mb-4"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 font-bold mb-2">Title</label>
                    <input type="text" id="title" name="title" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100">
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 font-bold mb-2">Description</label>
                    <textarea id="description" name="description" rows="4" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100"></textarea>
                </div>
                <div class="mb-4">
                    <label for="price" class="block text-gray-700 font-bold mb-2">Price</label>
                    <input type="number" id="price" name="price" step="0.01" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100">
                </div>
                <div class="mb-4">
                    <label for="location" class="block text-gray-700 font-bold mb-2">Location</label>
                    <input type="text" id="location" name="location" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100">
                </div>
                <div class="mb-4">
                    <label for="bedrooms" class="block text-gray-700 font-bold mb-2">Bedrooms</label>
                    <input type="number" id="bedrooms" name="bedrooms" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100">
                </div>
                <div class="mb-4">
                    <label for="bathrooms" class="block text-gray-700 font-bold mb-2">Bathrooms</label>
                    <input type="number" id="bathrooms" name="bathrooms" step="0.5" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100">
                </div>
                <div class="mb-4">
                    <label for="area" class="block text-gray-700 font-bold mb-2">Area (sqft)</label>
                    <input type="number" id="area" name="area" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100">
                </div>
                <div class="mb-4">
                    <label for="type" class="block text-gray-700 font-bold mb-2">Property Type</label>
                    <select id="type" name="type" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100">
                        <option value="house">House</option>
                        <option value="apartment">Apartment</option>
                        <option value="condo">Condo</option>
                    </select>
                </div>
                <div class="mb-6">
                    <label for="image_url" class="block text-gray-700 font-bold mb-2">Image URL</label>
                    <input type="url" id="image_url" name="image_url" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100">
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-200">Add Listing</button>
            </form>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>

</html>