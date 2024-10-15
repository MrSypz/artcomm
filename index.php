<?php
session_start();
require 'common/session.php';
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MrSypz</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/navbarleft.css">
    <link rel="stylesheet" href="css/cardcontent.css">
    <link rel="stylesheet" href="css/fontstyle.css">
    <link rel="stylesheet" href="css/content.css">
</head>
<body>
<nav class="navbar">
    <div class="logo">
        <a href="index.php"><h1 class="logo">Sypztep</h1></a>
    </div>
    <div class='dropdown'>
        <?php if (isLoggedIn()): ?>
            <a href='#'>Profile</a>
            <div class='dropdown-content'>
                <a href="common/action/logout.php">Logout</a>
            </div>
        <?php else: ?>
            <a href="api/discord_login.php">Login with Discord</a>
        <?php endif; ?>
    </div>
</nav>

<header class="header">
    <img src="resource/assets/header/banner.jfif" alt="Art Banner">
    <div class="header-text">
        <h2>Welcome to My Art Portfolio</h2>
        <p>Explore and enjoy the creative artworks throughout the year</p>
        <?php if(isset($_SESSION['user_id'])):?>
        <a href="common/form/order.php" class="btn">Order Commission</a>
        <?php else: ?>
            <a href="common/form/order.php" class="btn" onclick="return false;">Login First</a>
        <?php endif; ?>
    </div>
</header>
<div class="content-container">
    <nav class="navbar_content">
        <a href="#" data-section="common/content/tos.html" data-style="css/textstyle.css">Terms of Service</a>
        <a href="#" data-section="common/content/pricing.html" data-style="css/textstyle.css">Pricing</a>
        <a href="#" data-section="faq.html" data-style="css/faq.css">FAQ</a>
        <a href="#" data-section="contact.html" data-style="css/contact.css">Contact</a>
    </nav>
    <main class="main-content" id="mainContent">
        <div class="card-container" id="cardContainer"></div>
    </main>
</div>

<script>
    window.addEventListener('scroll', function () {
        const header = document.querySelector('.header');
        const scrollY = window.scrollY;

        if (scrollY > 100) {
            header.classList.add('hidden');
        } else {
            header.classList.remove('hidden');
        }
    });
    document.addEventListener('DOMContentLoaded', () => {
        const links = document.querySelectorAll('.navbar_content a');
        const mainContent = document.getElementById('mainContent');

        loadContent('common/content/tos.html', 'css/textstyle.css');

        links.forEach(link => {
            link.addEventListener('click', (event) => {
                event.preventDefault();
                const section = link.getAttribute('data-section');
                const stylesheet = link.getAttribute('data-style');
                loadContent(section, stylesheet);
            });
        });

        function loadContent(section, stylesheet) {
            fetch(section)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(html => {
                    mainContent.innerHTML = html; // Insert the loaded HTML into the main content area
                    loadStylesheet(stylesheet); // Load the associated CSS
                })
                .catch(error => {
                    console.error('Error loading the content:', error);
                    mainContent.innerHTML = '<p>Error loading content.</p>'; // Display an error message
                });
        }

        function loadStylesheet(stylesheet) {
            const existingLink = document.getElementById('dynamic-stylesheet');
            if (existingLink) {
                existingLink.parentNode.removeChild(existingLink);
            }

            const link = document.createElement('link');
            link.id = 'dynamic-stylesheet';
            link.rel = 'stylesheet';
            link.href = stylesheet;
            document.head.appendChild(link);
        }
    });


</script>


<script src="scripts/Card.js"></script>
</body>
</html>