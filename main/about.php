<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Real Estate</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <?php include 'header.php'; ?>

    <main class="flex-grow container mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold text-center mb-8">About Us</h1>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1200&q=80" alt="Modern building" class="w-full h-64 object-cover">
            <div class="p-6 md:p-10">
                <h2 class="text-3xl font-bold mb-4">Our Story</h2>
                <p class="text-gray-600 mb-6">Founded in 2023, Real Estate has been at the forefront of the property market in Visakhapatnam for over 1 years. Our journey began with a simple mission: to help people find their dream homes and make sound property investments. Today, we've grown into a trusted name in the real estate industry, known for our integrity, expertise, and commitment to client satisfaction.</p>
                
                <h2 class="text-3xl font-bold mb-4">Our Mission</h2>
                <p class="text-gray-600 mb-6">At Real Estate, our mission is to provide exceptional real estate services that exceed our clients' expectations. We strive to make the process of buying, selling, or renting property as smooth and stress-free as possible. Our team of experienced professionals is dedicated to guiding you through every step of your real estate journey, ensuring that you make informed decisions that align with your goals and dreams.</p>

                <h2 class="text-3xl font-bold mb-4">Why Choose Us?</h2>
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-xl font-semibold mb-2">Local Expertise</h3>
                        <p class="text-gray-600">With deep roots in Visakhapatnam, we have unparalleled knowledge of the local property market, neighborhoods, and trends.</p>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold mb-2">Client-Centric Approach</h3>
                        <p class="text-gray-600">We put our clients' needs first, offering personalized services tailored to your unique requirements and preferences.</p>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold mb-2">Comprehensive Services</h3>
                        <p class="text-gray-600">From property search to legal guidance, we offer end-to-end services to make your real estate experience seamless.</p>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold mb-2">Transparency and Integrity</h3>
                        <p class="text-gray-600">We believe in honest communication and ethical practices, ensuring you have all the information you need to make confident decisions.</p>
                    </div>
                </div>

                <div class="mt-10">
                    <h2 class="text-3xl font-bold mb-4">Our Team</h2>
                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <img src="https://res.cloudinary.com/dhja9jrwn/image/upload/v1730902322/php-project/avinash1_iyvqxs.jpg" alt="Avinash" class="w-32 h-32 rounded-full mx-auto mb-4 object-cover">
                            <h3 class="text-xl font-semibold">Koppaka Venkata Avinash</h3>
                            <p class="text-gray-600">Founder & CEO</p>
                        </div>
                        <div class="text-center">
                            <img src="https://res.cloudinary.com/dhja9jrwn/image/upload/v1730902004/php-project/guna1_drhbna.jpg" alt="Gunavanth Kumar" class="w-32 h-32 rounded-full mx-auto mb-4 object-cover">
                            <h3 class="text-xl font-semibold">E.L.Gunavanth Kumar</h3>
                            <p class="text-gray-600">Head of Sales</p>
                        </div>
                        <div class="text-center">
                            <img src="https://res.cloudinary.com/dhja9jrwn/image/upload/v1730901649/php-project/pooji_nwa5wg.jpg" alt="Poojith" class="w-32 h-32 rounded-full mx-auto mb-4 object-cover">
                            <h3 class="text-xl font-semibold">V.R Poojith Reddy</h3>
                            <p class="text-gray-600">Senior Property Consultant</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
