<?php
// We need the .env variables for the Key ID on the frontend
require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
?>
<!DOCTYPE HTML>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <title>Make a Donation - Astu Foundation</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <style>
        body {
            background-color: #f4f7f6;
        }

        .donation-page-wrapper {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-top: 50px;
            margin-bottom: 50px;
        }

        .form-section {
            padding: 50px;
        }

        .impact-section {
            background-image: linear-gradient(rgba(19, 137, 153, 0.8), rgba(13, 90, 102, 0.9)), url('https://images.unsplash.com/photo-1593113646773-428c64a9f158?q=80&w=2070&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            color: #fff;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .impact-section h3 {
            font-weight: 700;
        }

        .impact-section .impact-item {
            display: flex;
            align-items: center;
            margin-top: 20px;
        }

        .impact-section .impact-item i {
            font-size: 2rem;
            margin-right: 15px;
        }

        .amount-selection-cards {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 25px;
        }

        .amount-card {
            border: 2px solid #e9ecef;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .amount-card:hover {
            border-color: #138999;
            color: #138999;
        }

        .amount-card.active {
            background-color: #138999;
            color: #fff;
            border-color: #138999;
            transform: scale(1.05);
        }

        .form-control {
            padding: 12px;
        }

        .btn-primary {
            background-color: #DF5311;
        }


        .btn-primary:hover {
            background-color: #f7b89b;
        }
    </style>
</head>

<body>


    <?php require 'header.php'; ?>

    <div class="breatcome-area">
        <div class="container">
            <div class="breatcome-content">
                <div class="breatcome-title">
                    <h1>Make a Donation</h1>
                </div>
                <div class="bratcome-text">
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li>Donation</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="new-donation-area">
        <div class="container">
            <div class="donation-page-wrapper">
                <div class="row g-0">
                    <div class="col-lg-7">
                        <div class="form-section">
                            <h2 class="mb-2">Secure Donation</h2>
                            <p class="text-muted mb-4">Your support helps us continue our mission.</p>
                            <div id="payment-status" class="mb-3"></div>

                            <form id="donation-form">
                                <h5>1. Select an Amount (₹)</h5>
                                <div class="amount-selection-cards">
                                    <div class="amount-card" data-amount="500">₹500</div>
                                    <div class="amount-card" data-amount="1000">₹1,000</div>
                                    <div class="amount-card" data-amount="2500">₹2,500</div>
                                    <div class="amount-card" data-amount="5000">₹5,000</div>
                                </div>
                                <div class="mb-4">
                                    <label for="amount" class="form-label">Or Enter a Custom Amount</label>
                                    <input type="number" class="form-control" id="amount" placeholder="e.g., 1500" required>
                                </div>

                                <h5 class="mt-4">2. Personal Information</h5>
                                <div class="row mt-3">
                                    <div class="col-12 mb-3">
                                        <label for="name" class="form-label">Full Name</label>
                                        <input type="text" class="form-control" id="name" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control" id="email" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control" id="phone" required>
                                    </div>
                                </div>

                                <div class="d-grid mt-4">
                                    <button type="submit" id="donate-btn" class="btn btn-primary btn-lg">Donate Now</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="impact-section">
                            <h3>Your Contribution Makes a World of Difference</h3>
                            <p class="mt-3">Every donation, no matter the size, brings us one step closer to our goal. Your generosity fuels our projects and brings hope to communities.</p>
                            <div class="impact-item">
                                <i class="bi bi-book"></i>
                                <div><strong>Education</strong><br>Provide learning materials for a child.</div>
                            </div>
                            <div class="impact-item">
                                <i class="bi bi-heart-pulse"></i>
                                <div><strong>Health</strong><br>Support our medical outreach programs.</div>
                            </div>
                            <div class="impact-item">
                                <i class="bi bi-house"></i>
                                <div><strong>Shelter</strong><br>Help provide a safe place for those in need.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require 'footer.php'; ?>

    <script src="assets/js/vendor/jquery-3.6.2.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('donation-form');
            const amountInput = document.getElementById('amount');
            const amountCards = document.querySelectorAll('.amount-card'); // Changed from buttons to cards
            const donateBtn = document.getElementById('donate-btn');
            const paymentStatus = document.getElementById('payment-status');
            const razorpayKeyId = "<?= $_ENV['RAZORPAY_KEY_ID'] ?>";

            // New logic for amount selection cards
            amountCards.forEach(card => {
                card.addEventListener('click', function() {
                    // Remove 'active' class from all cards
                    amountCards.forEach(c => c.classList.remove('active'));
                    // Add 'active' class to the clicked card
                    this.classList.add('active');
                    // Update the input field value
                    amountInput.value = this.dataset.amount;
                });
            });

            // Clear card selection if user types a custom amount
            amountInput.addEventListener('input', function() {
                amountCards.forEach(c => c.classList.remove('active'));
            });

            donateBtn.addEventListener('click', async function(event) {
                event.preventDefault();
                event.stopPropagation();

                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                donateBtn.disabled = true;
                donateBtn.innerText = 'Processing...';
                paymentStatus.innerHTML = '';

                const formData = {
                    amount: amountInput.value,
                    name: document.getElementById('name').value,
                    email: document.getElementById('email').value,
                    phone: document.getElementById('phone').value,
                };

                // 1. Create a Razorpay Order
                const orderResponse = await fetch('create_order.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        amount: formData.amount
                    })
                });

                // Check for server errors before trying to parse JSON
                if (!orderResponse.ok) {
                    paymentStatus.innerHTML = `<div class="alert alert-danger">Could not connect to the payment server. Please try again later.</div>`;
                    donateBtn.disabled = false;
                    donateBtn.innerText = 'Donate Now';
                    return;
                }

                const orderData = await orderResponse.json();

                if (!orderData.id) {
                    paymentStatus.innerHTML = `<div class="alert alert-danger">Error creating order. Please try again.</div>`;
                    donateBtn.disabled = false;
                    donateBtn.innerText = 'Donate Now';
                    return;
                }

                // 2. Open Razorpay Checkout
                const options = {
                    key: razorpayKeyId,
                    amount: orderData.amount,
                    currency: "INR",
                    name: "Astu Foundation",
                    description: "Donation for a good cause",
                    order_id: orderData.id,
                    handler: async function(response) {
                        // 3. Verify the payment
                        const verificationData = {
                            razorpay_payment_id: response.razorpay_payment_id,
                            razorpay_order_id: response.razorpay_order_id,
                            razorpay_signature: response.razorpay_signature,
                            name: formData.name,
                            email: formData.email,
                            phone: formData.phone,
                            amount: formData.amount
                        };

                        const verifyResponse = await fetch('verify_payment.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(verificationData)
                        });
                        const verifyResult = await verifyResponse.json();

                        if (verifyResult.status === 'success') {
                            paymentStatus.innerHTML = `<div class="alert alert-success">Thank you! Your donation was successful.</div>`;
                            form.reset();
                            amountCards.forEach(c => c.classList.remove('active'));
                        } else {
                            paymentStatus.innerHTML = `<div class="alert alert-danger">Payment verification failed. Please contact us.</div>`;
                        }
                        donateBtn.disabled = false;
                        donateBtn.innerText = 'Donate Now';
                    },
                    prefill: {
                        name: formData.name,
                        email: formData.email,
                        contact: formData.phone
                    },
                    theme: {
                        color: "#138999"
                    },
                    modal: {
                        ondismiss: function() {
                            paymentStatus.innerHTML = `<div class="alert alert-warning">Payment was not completed.</div>`;
                            donateBtn.disabled = false;
                            donateBtn.innerText = 'Donate Now';
                        }
                    }
                };

                const rzp = new Razorpay(options);
                rzp.open();
            });
        });
    </script>
</body>

</html>