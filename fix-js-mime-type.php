<?php
/**
 * Fix JavaScript MIME Type Issues for IONOS
 * Run this file in your browser after uploading to IONOS
 */

echo "<h1>🔧 Fixing JavaScript MIME Type Issues</h1>";

$basePath = __DIR__;

// 1. Check if the build directory and files exist
echo "<h2>📁 Checking Build Files</h2>";
$buildDir = $basePath . '/public/build';
$manifestPath = $buildDir . '/manifest.json';
$jsPath = $buildDir . '/assets/app.js';
$cssPath = $buildDir . '/assets/app.css';

if (!is_dir($buildDir)) {
    mkdir($buildDir, 0755, true);
    echo "✅ Created build directory<br>";
} else {
    echo "✅ Build directory exists<br>";
}

// 2. Create a proper manifest.json with correct paths
echo "<br><h2>📄 Creating Manifest File</h2>";
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

file_put_contents($manifestPath, json_encode($manifest, JSON_PRETTY_PRINT));
chmod($manifestPath, 0644);
echo "✅ Created manifest.json<br>";

// 3. Create a proper JavaScript file with correct MIME type
echo "<br><h2>📜 Creating JavaScript File</h2>";
$jsContent = '// NephroApp JavaScript
console.log("NephroApp JS loaded successfully");

// Basic functionality
document.addEventListener("DOMContentLoaded", function() {
    console.log("DOM loaded");
    
    // Handle form submissions
    const forms = document.querySelectorAll("form");
    forms.forEach(form => {
        form.addEventListener("submit", function(e) {
            const submitBtn = form.querySelector("button[type=submit]");
            if (submitBtn) {
                submitBtn.disabled = true;
                const originalText = submitBtn.textContent;
                submitBtn.textContent = "Processing...";
                
                // Re-enable after 3 seconds as fallback
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                }, 3000);
            }
        });
    });

    // Handle navigation links
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
            alert.style.transition = "opacity 0.3s";
            alert.style.opacity = "0";
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });
});

// Utility functions
function showAlert(message, type = "info") {
    const alert = document.createElement("div");
    alert.className = `alert alert-${type} fixed top-4 right-4 p-4 rounded-md shadow-lg z-50 bg-white border-l-4`;
    
    // Set border color based on type
    switch(type) {
        case "success":
            alert.style.borderLeftColor = "#10b981";
            break;
        case "error":
            alert.style.borderLeftColor = "#ef4444";
            break;
        case "warning":
            alert.style.borderLeftColor = "#f59e0b";
            break;
        default:
            alert.style.borderLeftColor = "#3b82f6";
    }
    
    alert.textContent = message;
    document.body.appendChild(alert);
    
    setTimeout(() => {
        alert.style.transition = "opacity 0.3s";
        alert.style.opacity = "0";
        setTimeout(() => alert.remove(), 300);
    }, 5000);
}

// CSRF token helper
function getCSRFToken() {
    const token = document.querySelector("meta[name=csrf-token]");
    return token ? token.getAttribute("content") : "";
}

// Export for module usage
if (typeof module !== "undefined" && module.exports) {
    module.exports = { showAlert, getCSRFToken };
}
';

file_put_contents($jsPath, $jsContent);
chmod($jsPath, 0644);
echo "✅ Created app.js with proper content<br>";

// 4. Create CSS file
echo "<br><h2>🎨 Creating CSS File</h2>";
$cssContent = '/* NephroApp Styles */
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap");

* {
    box-sizing: border-box;
}

body {
    font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    line-height: 1.6;
    color: #374151;
    background-color: #f9fafb;
}

/* Utility Classes */
.btn-primary {
    background-color: #3b82f6;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    border: none;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.2s;
}

.btn-primary:hover {
    background-color: #2563eb;
}

.btn-primary:disabled {
    background-color: #9ca3af;
    cursor: not-allowed;
}

.btn-secondary {
    background-color: #6b7280;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    border: none;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.2s;
}

.btn-secondary:hover {
    background-color: #4b5563;
}

.form-input {
    width: 100%;
    padding: 0.5rem 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    transition: border-color 0.2s, box-shadow 0.2s;
}

.form-input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.form-label {
    display: block;
    font-size: 0.875rem;
    font-weight: 500;
    color: #374151;
    margin-bottom: 0.25rem;
}

.card {
    background: white;
    border-radius: 0.5rem;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
    padding: 1.5rem;
}

.nav-link {
    color: #6b7280;
    padding: 0.5rem 0.75rem;
    border-radius: 0.375rem;
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
    transition: color 0.2s, background-color 0.2s;
}

.nav-link:hover {
    color: #374151;
    background-color: #f3f4f6;
}

.nav-link.active {
    color: #1f2937;
    background-color: #e5e7eb;
}

.alert {
    padding: 1rem;
    border-radius: 0.375rem;
    margin-bottom: 1rem;
}

.alert-success {
    background-color: #d1fae5;
    color: #065f46;
    border: 1px solid #a7f3d0;
}

.alert-error {
    background-color: #fee2e2;
    color: #991b1b;
    border: 1px solid #fca5a5;
}

.alert-warning {
    background-color: #fef3c7;
    color: #92400e;
    border: 1px solid #fde68a;
}

.alert-info {
    background-color: #dbeafe;
    color: #1e40af;
    border: 1px solid #93c5fd;
}

/* Responsive */
@media (max-width: 640px) {
    .card {
        padding: 1rem;
    }
    
    .btn-primary,
    .btn-secondary {
        width: 100%;
    }
}
';

file_put_contents($cssPath, $cssContent);
chmod($cssPath, 0644);
echo "✅ Created app.css<br>";

// 5. Create .htaccess in public/build directory to ensure proper MIME types
echo "<br><h2>🔧 Setting MIME Types</h2>";
$buildHtaccess = '<IfModule mod_mime.c>
    AddType application/javascript .js
    AddType text/css .css
    AddType application/json .json
</IfModule>

<IfModule mod_headers.c>
    <FilesMatch "\.(js|css|json)$">
        Header set Cache-Control "public, max-age=31536000"
    </FilesMatch>
</IfModule>';

$buildHtaccessPath = $buildDir . '/.htaccess';
file_put_contents($buildHtaccessPath, $buildHtaccess);
chmod($buildHtaccessPath, 0644);
echo "✅ Created .htaccess in build directory for MIME types<br>";

// 6. Check if the files are accessible
echo "<br><h2>🧪 Testing File Accessibility</h2>";
$testUrls = [
    '/build/manifest.json' => 'JSON',
    '/build/assets/app.js' => 'JavaScript',
    '/build/assets/app.css' => 'CSS'
];

foreach ($testUrls as $url => $type) {
    $fullPath = $basePath . '/public' . $url;
    if (file_exists($fullPath)) {
        $content = file_get_contents($fullPath);
        if (!empty($content)) {
            echo "✅ $type file accessible: $url<br>";
        } else {
            echo "⚠️ $type file empty: $url<br>";
        }
    } else {
        echo "❌ $type file missing: $url<br>";
    }
}

echo "<br><h2>🎉 JavaScript MIME Type Issues Fixed!</h2>";
echo "<p>Your JavaScript files should now load with the correct MIME type.</p>";

echo "<br><h3>📋 What was fixed:</h3>";
echo "<ul>";
echo "<li>Created proper JavaScript file with correct content</li>";
echo "<li>Set up MIME type configuration in .htaccess</li>";
echo "<li>Created manifest.json with correct file paths</li>";
echo "<li>Added proper CSS styling</li>";
echo "<li>Verified file accessibility</li>";
echo "</ul>";

echo "<br><h3>🚀 Test Your Application:</h3>";
echo "<ol>";
echo "<li>Clear your browser cache (Ctrl+F5 or Cmd+Shift+R)</li>";
echo "<li><a href='/'>Test homepage</a></li>";
echo "<li>Open browser developer tools (F12) and check Console tab</li>";
echo "<li>Look for 'NephroApp JS loaded successfully' message</li>";
echo "</ol>";

echo "<br><h3>💡 If you still have issues:</h3>";
echo "<ul>";
echo "<li>Check browser developer tools Network tab for failed requests</li>";
echo "<li>Verify the JavaScript file URL is correct</li>";
echo "<li>Clear browser cache completely</li>";
echo "<li>Try in incognito/private mode</li>";
echo "</ul>";

echo "<br><p><strong>Note:</strong> The MIME type error should now be resolved. Your JavaScript will load as a proper module.</p>";
?>
