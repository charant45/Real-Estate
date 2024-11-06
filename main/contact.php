<?php
require_once 'auth.php';

$success_message = '';
$error_message = '';

// Check if session has already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the request method is POST to process the form submission
if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    if (verify_csrf_token($_POST['csrf_token'])) {
        $name = sanitize_input($_POST['name']);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $message = sanitize_input($_POST['message']);

        $access_key = '9ac59474-d0d8-462c-a958-89bed64ab94b';

        $data = array(
            'access_key' => $access_key,
            'name' => $name,
            'email' => $email,
            'message' => $message
        );

        $ch = curl_init('https://api.web3forms.com/submit');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);

        if (is_array($result) && isset($result['success']) && $result['success']) {
            if ($db->addContactSubmission($name, $email, $message)) {
                $success_message = "Thank you for your message. We'll get back to you soon!";
            } else {
                $error_message = "Oops! Something went wrong. Please try again later.";
            }
        } else {
            $error_message = "Oops! Something went wrong. Please try again later.";
        }
    } else {
        $error_message = "Invalid CSRF token. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Real Estate</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .tick-circle {
            stroke-dasharray: 166;
            stroke-dashoffset: 166;
            stroke-width: 2;
            stroke-miterlimit: 10;
            stroke: #7ac142;
            fill: none;
            animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
        }
        .tick {
            transform-origin: 50% 50%;
            stroke-dasharray: 48;
            stroke-dashoffset: 48;
            animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
        }
        @keyframes stroke {
            100% {
                stroke-dashoffset: 0;
            }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <?php include 'header.php'; ?>

    <main class="flex-grow container mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold text-center mb-8 text-gray-800">Contact Us</h1>

        <div id="form-container" class="bg-white rounded-lg shadow-lg p-6 md:p-10 max-w-3xl mx-auto">
            <?php if ($error_message): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                    <p><?php echo $error_message; ?></p>
                </div>
            <?php endif; ?>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="space-y-6" id="contactForm">
                <input type="hidden" name="access_key" value="9ac59474-d0d8-462c-a958-89bed64ab94b">
                <input type="hidden" name="subject" value="New contact form submission">
                <input type="hidden" name="from_name" value="Your Website Contact Form">
                <input type="checkbox" name="botcheck" class="hidden" style="display: none;">
                <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" id="name" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                </div>
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                    <textarea id="message" name="message" rows="4" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-150 ease-in-out"></textarea>
                </div>
                <div>
                    <button type="submit" class="w-full bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-300">
                        Send Message
                    </button>
                </div>
            </form>
        </div>

        <?php if ($success_message): ?>
            <div id="success-popup" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                <div class="bg-white rounded-lg p-8 max-w-sm w-full">
                    <div class="text-center">
                        <svg class="checkmark w-16 h-16 mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                            <circle class="tick-circle" cx="26" cy="26" r="25" fill="none"/>
                            <path class="tick" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                        </svg>
                        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Success!</h2>
                        <p class="text-gray-600"><?php echo $success_message; ?></p>
                        <button onclick="closeSuccessPopup()" class="mt-6 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-300">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <?php include 'footer.php'; ?>

    <script>
        function closeSuccessPopup() {
            document.getElementById('success-popup').style.display = 'none';
            document.getElementById('contactForm').reset();
        }
    </script>
</body>
</html>
