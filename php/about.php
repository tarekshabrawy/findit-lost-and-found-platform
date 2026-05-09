<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - FindIt</title>
    <link rel="stylesheet" href="/css/base.css">
<link rel="stylesheet" href="/css/layout.css">
<link rel="stylesheet" href="/css/components.css">
</head>
<body>
    <?php include '../includes/navbar.php'; ?>

    <div class="container about-container">
        <div class="about-hero">
            <h1>About FindIt</h1>
            <p class="subtitle">Connecting Lost Items with Their Rightful Owners</p>
        </div>

        <div class="about-content">
            <section class="about-section">
                <h2>Our Mission</h2>
                <p>
                    FindIt is dedicated to helping people recover lost items and connect with those who have found them.
                    We believe that every lost item deserves a second chance, and every finder deserves recognition for their kindness.
                </p>
            </section>

            <section class="about-section">
                <h2>What We Do</h2>
                <p>
                    FindIt provides a platform where users can:
                </p>
                <ul>
                    <li>Post about items they've lost or found</li>
                    <li>Browse items posted by other community members</li>
                    <li>Connect with others to reunite lost items with their owners</li>
                    <li>Manage their profile and search history</li>
                </ul>
            </section>

            <section class="about-section">
                <h2>How It Works</h2>
                <ol>
                    <li><strong>Register:</strong> Create an account to get started</li>
                    <li><strong>Post:</strong> Add details about items you've lost or found</li>
                    <li><strong>Search:</strong> Browse the feed to find matching items</li>
                    <li><strong>Connect:</strong> Message other users to arrange returns</li>
                    <li><strong>Reunite:</strong> Help restore lost items to their owners</li>
                </ol>
            </section>

            <section class="about-section">
                <h2>Our Values</h2>
                <div class="values-grid">
                    <div class="value-item">
                        <h3>Trust</h3>
                        <p>We maintain a safe and trustworthy community for all users.</p>
                    </div>
                    <div class="value-item">
                        <h3>Compassion</h3>
                        <p>We understand the frustration of losing something important.</p>
                    </div>
                    <div class="value-item">
                        <h3>Community</h3>
                        <p>Together, we're stronger and more effective at helping each other.</p>
                    </div>
                </div>
            </section>

            <section class="about-section">
                <h2>Need Help?</h2>
                <p>
                    If you have any questions or need assistance, please feel free to contact our support team or explore our FAQ section.
                </p>
                <a href="index.php" class="btn-primary">Back to Home</a>
            </section>
        </div>
    </div>

    <style>
        .about-container {
            max-width: 900px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .about-hero {
            text-align: center;
            margin-bottom: 50px;
            padding: 40px 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
        }

        .about-hero h1 {
            font-size: 2.5em;
            margin: 0 0 10px 0;
        }

        .about-hero .subtitle {
            font-size: 1.2em;
            opacity: 0.9;
        }

        .about-section {
            margin-bottom: 40px;
            padding: 30px;
            background-color: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }

        .about-section h2 {
            color: #333;
            margin-top: 0;
            margin-bottom: 15px;
        }

        .about-section p {
            color: #666;
            line-height: 1.6;
            margin: 10px 0;
        }

        .about-section ul,
        .about-section ol {
            color: #666;
            line-height: 1.8;
            margin-left: 20px;
        }

        .about-section li {
            margin-bottom: 10px;
        }

        .values-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .value-item {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .value-item h3 {
            color: #667eea;
            margin-top: 0;
        }

        .value-item p {
            color: #666;
            margin: 10px 0 0 0;
        }

        .btn-primary {
            display: inline-block;
            background-color: #667eea;
            color: white;
            padding: 12px 30px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
            margin-top: 15px;
        }

        .btn-primary:hover {
            background-color: #764ba2;
        }

        @media (max-width: 768px) {
            .about-hero h1 {
                font-size: 1.8em;
            }

            .about-section {
                padding: 20px;
            }
        }
    </style>

    <script src="../js/menu.js"></script>
</body>
</html>
