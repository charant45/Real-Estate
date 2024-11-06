<?php
require_once 'auth.php';

// Debugging: Check if the user is logged in
if (is_logged_in()) {
    echo "<!-- User is logged in -->";
} else {
    echo "<!-- User is not logged in -->";
}
?>
<?php require_once 'auth.php'; ?>
<header class="bg-white shadow-md">
    <nav class="container mx-auto px-4 py-4 flex justify-between items-center">
        <a href="index.php" class="text-2xl font-bold text-blue-500">Real Estate</a>
        <ul class="flex space-x-4">
            <li><a href="index.php" class="text-gray-600 hover:text-blue-500">Home</a></li>
            <?php if (is_logged_in()): ?>
                <li><a href="add_listing.php" class="text-gray-600 hover:text-blue-500">Add Listing</a></li>
                <li><a href="profile.php" class="text-gray-600 hover:text-blue-500">Profile</a></li>
                <li><a href="logout.php" class="text-gray-600 hover:text-blue-500">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php" class="text-gray-600 hover:text-blue-500">Login</a></li>
                <li><a href="register.php" class="text-gray-600 hover:text-blue-500">Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>