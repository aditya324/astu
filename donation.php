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


                            <div class="mb-4">
                                <div class="btn-group w-100" role="group">
                                    <input type="radio" class="btn-check" name="donation_type" id="one-time" value="one-time" autocomplete="off" checked>
                                    <label class="btn btn-outline-primary" for="one-time">One-Time</label>

                                    <input type="radio" class="btn-check" name="donation_type" id="monthly" value="monthly" autocomplete="off">
                                    <label class="btn btn-outline-primary" for="monthly">Monthly</label>
                                </div>
                            </div>
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

    // donation.php (bottom of the file)

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('donation-form');
            const amountInput = document.getElementById('amount');
            const amountCards = document.querySelectorAll('.amount-card');
            const donateBtn = document.getElementById('donate-btn');
            const paymentStatus = document.getElementById('payment-status');
            const razorpayKeyId = "<?= $_ENV['RAZORPAY_KEY_ID'] ?>";

            // Amount selection card logic (no changes here)
            amountCards.forEach(card => {
                card.addEventListener('click', function() {
                    amountCards.forEach(c => c.classList.remove('active'));
                    this.classList.add('active');
                    amountInput.value = this.dataset.amount;
                });
            });

            amountInput.addEventListener('input', function() {
                amountCards.forEach(c => c.classList.remove('active'));
            });

            // Main donation button event listener
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

                const donationType = document.querySelector('input[name="donation_type"]:checked').value;

                // =======================================================
                // CORE LOGIC: Check if it's a one-time or monthly donation
                // =======================================================

                if (donationType === 'monthly') {
                    /************************
                     * HANDLE MONTHLY DONATION
                     ************************/
                    try {
                        // 1. Create a Subscription on the server
                        const subResponse = await fetch('create_subscription.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(formData)
                        });
                        const subData = await subResponse.json();

                        if (!subData.id) {
                            throw new Error(subData.error || 'Could not create subscription.');
                        }

                        // 2. Open Razorpay Checkout for Subscriptions
                        const options = {
                            key: razorpayKeyId,
                            subscription_id: subData.id,
                            name: "Astu Foundation (Monthly)",
                            description: `Monthly donation of ₹${formData.amount}`,
                            handler: function(response) {
                                // This handler just confirms the subscription has started.
                                // The actual payment verification happens via webhooks.
                                paymentStatus.innerHTML = `<div class="alert alert-success">Thank you! Your monthly donation is now active.</div>`;
                                form.reset();
                                amountCards.forEach(c => c.classList.remove('active'));
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
                                    paymentStatus.innerHTML = `<div class="alert alert-warning">Subscription was not completed.</div>`;
                                    donateBtn.disabled = false;
                                    donateBtn.innerText = 'Donate Now';
                                }
                            }
                        };
                        const rzp = new Razorpay(options);
                        rzp.open();

                    } catch (error) {
                        paymentStatus.innerHTML = `<div class="alert alert-danger">Error: ${error.message}</div>`;
                        donateBtn.disabled = false;
                        donateBtn.innerText = 'Donate Now';
                    }

                } else {
                    /************************
                     * HANDLE ONE-TIME DONATION (Your existing code)
                     ************************/
                    try {
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
                        const orderData = await orderResponse.json();
                        if (!orderData.id) {
                            throw new Error('Could not create order.');
                        }

                        // 2. Open Razorpay Checkout for Orders
                        const options = {
                            key: razorpayKeyId,
                            amount: orderData.amount,
                            currency: "INR",
                            name: "Astu Foundation",
                            description: "Donation for a good cause",
                            order_id: orderData.id,
                            handler: async function(response) {
                                // 3. Verify the payment (your existing logic)
                                response.name = formData.name;
                                response.email = formData.email;
                                response.phone = formData.phone;
                                response.amount = formData.amount;

                                const verifyResponse = await fetch('verify_payment.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify(response)
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
                    } catch (error) {
                        paymentStatus.innerHTML = `<div class="alert alert-danger">Error: ${error.message}</div>`;
                        donateBtn.disabled = false;
                        donateBtn.innerText = 'Donate Now';
                    }
                }
            });
        });
    </script>
</body>

</html>