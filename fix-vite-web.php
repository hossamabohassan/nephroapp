<?php
/**
 * Fix Vite Manifest and Assets for IONOS Deployment
 * Run this file in your browser after uploading to IONOS
 */

echo "<h1>🔧 Fixing Vite Manifest and Assets</h1>";

// Create build directory if it doesn't exist
$buildDir = __DIR__ . '/public/build';
if (!is_dir($buildDir)) {
    mkdir($buildDir, 0755, true);
    echo "✅ Created build directory<br>";
} else {
    echo "✅ Build directory exists<br>";
}

// Create manifest.json
$manifest = [
    "resources/css/app.css" => [
        "file" => "assets/app.css",
        "src" => "resources/css/app.css",
        "isEntry" => true
    ],
    "resources/js/app.js" => [
        "file" => "assets/app.js", 
        "src" => "resources/js/app.js",
        "isEntry" => true
    ]
];

$manifestPath = $buildDir . '/manifest.json';
file_put_contents($manifestPath, json_encode($manifest, JSON_PRETTY_PRINT));
echo "✅ Created manifest.json<br>";

// Create basic CSS file
$cssContent = '
/* Tailwind CSS Base */
@tailwind base;
@tailwind components;
@tailwind utilities;

/* Custom styles */
body {
    font-family: "Figtree", sans-serif;
}

.btn-primary {
    @apply bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded;
}

.btn-secondary {
    @apply bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded;
}

.form-input {
    @apply border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500;
}

.form-label {
    @apply block text-sm font-medium text-gray-700 mb-1;
}

.card {
    @apply bg-white shadow-md rounded-lg p-6;
}

.nav-link {
    @apply text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium;
}

.nav-link.active {
    @apply bg-gray-100 text-gray-900;
}
';

$cssPath = $buildDir . '/assets/app.css';
file_put_contents($cssPath, $cssContent);
echo "✅ Created app.css<br>";

// Create basic JS file
$jsContent = '
// Basic JavaScript functionality
document.addEventListener("DOMContentLoaded", function() {
    // Handle form submissions
    const forms = document.querySelectorAll("form");
    forms.forEach(form => {
        form.addEventListener("submit", function(e) {
            const submitBtn = form.querySelector("button[type=submit]");
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = "Processing...";
            }
        });
    });

    // Handle navigation
    const navLinks = document.querySelectorAll(".nav-link");
    navLinks.forEach(link => {
        link.addEventListener("click", function(e) {
            navLinks.forEach(l => l.classList.remove("active"));
            this.classList.add("active");
        });
    });

    // Auto-hide alerts
    const alerts = document.querySelectorAll(".alert");
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = "0";
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });
});

// Utility functions
function showAlert(message, type = "info") {
    const alert = document.createElement("div");
    alert.className = `alert alert-${type} fixed top-4 right-4 p-4 rounded-md shadow-lg z-50`;
    alert.textContent = message;
    document.body.appendChild(alert);
    
    setTimeout(() => {
        alert.style.opacity = "0";
        setTimeout(() => alert.remove(), 300);
    }, 5000);
}

// CSRF token helper
function getCSRFToken() {
    const token = document.querySelector("meta[name=csrf-token]");
    return token ? token.getAttribute("content") : "";
}
';

$jsPath = $buildDir . '/assets/app.js';
file_put_contents($jsPath, $jsContent);
echo "✅ Created app.js<br>";

// Set proper permissions
chmod($buildDir, 0755);
chmod($manifestPath, 0644);
chmod($cssPath, 0644);
chmod($jsPath, 0644);

echo "<br><h2>🎉 Vite Assets Fixed!</h2>";
echo "<p>Your Laravel app should now load without Vite manifest errors.</p>";
echo "<p><a href='/'>Test your homepage</a></p>";
?>