<?php
require_once 'database.php';
require_once 'auth.php';

// Fetch all listings initially
$listings = $db->getAllListings();

// Add search functionality
$search = isset($_GET['search']) ? $_GET['search'] : '';
$filter_type = isset($_GET['filter_type']) ? $_GET['filter_type'] : '';
$min_price = isset($_GET['min_price']) ? (int)$_GET['min_price'] : 0;
$max_price = isset($_GET['max_price']) ? (int)$_GET['max_price'] : PHP_INT_MAX;

// Ensure correct filtering conditions are applied
if ($search || $filter_type !== '' || $min_price > 0 || $max_price < PHP_INT_MAX) {
    $listings = array_filter($listings, function ($listing) use ($search, $filter_type, $min_price, $max_price) {
        // Match search term in title or location
        $match_search = empty($search) || stripos($listing['title'], $search) !== false || stripos($listing['location'], $search) !== false;

        // Match property type (case-insensitive)
        $match_type = empty($filter_type) || strtolower($listing['type']) === strtolower($filter_type);

        // Match price range
        $match_price = $listing['price'] >= $min_price && $listing['price'] <= $max_price;

        // Return only listings that match all conditions
        return $match_search && $match_type && $match_price;
    });
}


if (isset($_POST['submit_payment'])) {
    $listing_id = $_POST['listing_id'];
    $payment_method = $_POST['payment_method'];
    $amount = $_POST['amount'];

    try {
        $payment_result = $db->processPayment($listing_id, $payment_method, $amount) ? "Payment processed successfully!" : "Payment processing failed.";
    } catch (Exception $e) {
        $payment_result = "Payment processing error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real Estate Listings</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .modal-content {
            display: none;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            margin: auto;
            width: 90%;
            max-width: 400px;
            z-index: 1000;
        }

        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        footer {
            position: relative;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>

<body class="bg-gray-100">
    <?php include 'header.php'; ?>

    <main class="container mx-auto mt-8 px-4 relative">
        <h1 class="text-4xl font-bold mb-8 text-center text-gray-800">Discover Your Dream Home</h1>

        <!-- Search and Filter Form -->
        <form action="" method="GET" class="mb-8 bg-white p-6 rounded-lg shadow-md">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input type="text" id="search" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Enter location or title" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="filter_type" class="block text-sm font-medium text-gray-700 mb-1">Property Type</label>
                    <select id="filter_type" name="filter_type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Types</option>
                        <option value="house" <?php echo $filter_type == 'house' ? 'selected' : ''; ?>>House</option>
                        <option value="apartment" <?php echo $filter_type == 'apartment' ? 'selected' : ''; ?>>Apartment</option>
                        <option value="condo" <?php echo $filter_type == 'condo' ? 'selected' : ''; ?>>Condo</option>
                    </select>
                </div>
                <div>
                    <label for="min_price" class="block text-sm font-medium text-gray-700 mb-1">Min Price</label>
                    <input type="number" id="min_price" name="min_price" value="<?php echo $min_price; ?>" placeholder="Min Price" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="max_price" class="block text-sm font-medium text-gray-700 mb-1">Max Price</label>
                    <input type="number" id="max_price" name="max_price" value="<?php echo $max_price < PHP_INT_MAX ? $max_price : ''; ?>" placeholder="Max Price" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300">Search Properties</button>
            </div>
        </form>

        <!-- Listings Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php if (empty($listings)): ?>
                <div class="col-span-full flex flex-col items-center justify-center py-16 px-4 text-center bg-white rounded-lg shadow-md">
                    <div class="mb-6 text-6xl" role="img" aria-label="House emoji">🏠</div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Oops! No listings found</h2>
                    <p class="text-xl text-gray-600 mb-8 max-w-md">
                        We couldn't find any properties matching your search criteria. Let's try again!
                    </p>
                    <div class="space-y-4">
                        <p class="text-gray-600">Here are some suggestions:</p>
                        <ul class="text-gray-600 list-disc list-inside text-left">
                            <li>Try using more general keywords</li>
                            <li>Adjust your price range</li>
                            <li>Expand your search area</li>
                            <li>Remove some filters to see more results</li>
                        </ul>
                    </div>
                    <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="mt-8 inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                        Start a New Search
                    </a>
                </div>
            <?php else: ?>
                <?php foreach ($listings as $index => $listing): ?>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden transition duration-300 transform hover:scale-105 relative">
                        <img src="<?php echo htmlspecialchars($listing['image_url']); ?>" alt="<?php echo htmlspecialchars($listing['title']); ?>" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h2 class="text-xl font-semibold mb-2 text-gray-800"><?php echo htmlspecialchars($listing['title']); ?></h2>
                            <p class="text-gray-600 mb-2 font-bold">$<?php echo number_format($listing['price']); ?></p>
                            <p class="text-gray-500 mb-4"><?php echo htmlspecialchars($listing['location']); ?></p>
                            <div class="flex space-x-2">
                                <button onclick="toggleModal('details-<?php echo $index; ?>')" class="flex-1 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-300">View Details</button>
                                <button onclick="toggleModal('payment-<?php echo $index; ?>')" class="flex-1 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition duration-300">Buy Now</button>
                            </div>
                        </div>

                        <!-- Details Modal -->
                        <div id="details-<?php echo $index; ?>" class="modal-content">
                            <h2 class="text-2xl font-bold mb-4 text-gray-800"><?php echo htmlspecialchars($listing['title']); ?></h2>
                            <p class="mb-2"><strong>Bedrooms:</strong> <?php echo htmlspecialchars($listing['bedrooms']); ?></p>
                            <p class="mb-2"><strong>Bathrooms:</strong> <?php echo htmlspecialchars($listing['bathrooms']); ?></p>
                            <p class="mb-2"><strong>Area:</strong> <?php echo htmlspecialchars($listing['area']); ?> sqft</p>
                            <p class="mb-4"><strong>Description:</strong> <?php echo htmlspecialchars($listing['description']); ?></p>
                            <button onclick="toggleModal('details-<?php echo $index; ?>')" class="w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-300">Close</button>
                        </div>

                        <!-- Payment Modal -->
                        <div id="payment-<?php echo $index; ?>" class="modal-content">
                            <h2 class="text-2xl font-bold mb-4 text-gray-800">Payment Options</h2>
                            <form action="" method="POST" class="space-y-4">
                                <input type="hidden" name="listing_id" value="<?php echo $listing['id']; ?>">
                                <input type="hidden" name="amount" value="<?php echo $listing['price'] * 0.9; ?>">
                                <div>
                                    <label for="payment_method_<?php echo $index; ?>" class="block text-sm font-medium text-gray-700 mb-1">Select Payment Method</label>
                                    <select name="payment_method" id="payment_method_<?php echo $index; ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="credit_card">Credit Card</option>
                                        <option value="debit_card">Debit Card</option>
                                        <option value="paypal">PayPal</option>
                                    </select>
                                </div>
                                <div>
                                    <p class="text-lg font-semibold text-gray-800">Discounted Price: $<?php echo number_format($listing['price'] * 0.9, 2); ?></p>
                                </div>
                                <button type="submit" name="submit_payment" class="w-full bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition duration-300">Proceed to Payment</button>
                            </form>
                            <button onclick="toggleModal('payment-<?php echo $index; ?>')" class="w-full mt-4 bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 transition duration-300">Cancel</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>



        <?php if (isset($payment_result)): ?>
            <div id="payment-result" class="fixed bottom-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-md">
                <?php echo $payment_result; ?>
            </div>
        <?php endif; ?>
    </main>

    <?php include 'footer.php'; ?>

    <div class="modal-overlay" id="modal-overlay"></div>

    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
    <script>
        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.style.display = modal.style.display === 'block' ? 'none' : 'block';
        }

        // Hide payment result message after 5 seconds
        setTimeout(function() {
            const paymentResult = document.getElementById('payment-result');
            if (paymentResult) {
                paymentResult.style.display = 'none';
            }
        }, 5000);
    </script>
</body>

</html>