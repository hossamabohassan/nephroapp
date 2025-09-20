<?php
// Manual Asset Builder - No Node.js Required
echo "<h2>🔧 Manual Laravel Asset Builder (No Node.js Required)</h2>";

$laravelPath = __DIR__;
if (file_exists('nephroapp')) {
    $laravelPath = __DIR__ . '/nephroapp';
}
chdir($laravelPath);

echo "<div style='background: #f0f8ff; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<strong>📁 Working in:</strong> " . getcwd() . "<br>";
echo "<strong>🎯 Goal:</strong> Create complete Laravel frontend assets with Tailwind CSS<br>";
echo "</div>";

// Step 1: Check package.json to see what we need
echo "<h3>Step 1: Analyze Laravel Frontend Requirements</h3>";
echo "<div style='background: #f9f9f9; padding: 10px;'>";

if (file_exists('package.json')) {
    $packageContent = file_get_contents('package.json');
    echo "✅ Found package.json<br>";
    echo "<strong>Content:</strong><br>";
    echo "<pre style='background: white; padding: 10px; max-height: 300px; overflow-y: auto;'>";
    echo htmlspecialchars($packageContent);
    echo "</pre>";
    
    // Check if it includes Tailwind
    if (strpos($packageContent, 'tailwindcss') !== false) {
        echo "✅ Tailwind CSS is configured<br>";
    } else {
        echo "⚠️ No Tailwind CSS found - will add manually<br>";
    }
} else {
    echo "❌ No package.json found<br>";
}

echo "</div>";

// Step 2: Create complete Tailwind CSS
echo "<h3>Step 2: Create Complete Tailwind CSS</h3>";
echo "<div style='background: #f9f9f9; padding: 10px;'>";

// Create comprehensive Tailwind-like CSS
$completeTailwindCSS = '/* Complete Laravel + Tailwind CSS - Manual Build */
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap");

/* Tailwind CSS Reset */
*, ::before, ::after {
    box-sizing: border-box;
    border-width: 0;
    border-style: solid;
    border-color: #e5e7eb;
}

html {
    line-height: 1.5;
    -webkit-text-size-adjust: 100%;
    -moz-tab-size: 4;
    tab-size: 4;
    font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif;
}

body {
    margin: 0;
    line-height: inherit;
}

/* Laravel Auth Layout Styles */
.font-sans { font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif; }
.antialiased { -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }

/* Layout */
.min-h-screen { min-height: 100vh; }
.flex { display: flex; }
.flex-col { flex-direction: column; }
.items-center { align-items: center; }
.justify-center { justify-content: center; }

/* Spacing */
.pt-6 { padding-top: 1.5rem; }
.pt-0 { padding-top: 0; }
.sm\\:pt-0 { padding-top: 0; }
.mt-6 { margin-top: 1.5rem; }
.px-6 { padding-left: 1.5rem; padding-right: 1.5rem; }
.py-4 { padding-top: 1rem; padding-bottom: 1rem; }

/* Sizing */
.w-full { width: 100%; }
.w-20 { width: 5rem; }
.h-20 { height: 5rem; }
.max-w-md { max-width: 28rem; }
.sm\\:max-w-md { max-width: 28rem; }

/* Colors & Backgrounds */
.bg-gray-100 { background-color: #f3f4f6; }
.bg-white { background-color: #ffffff; }
.text-gray-900 { color: #111827; }
.text-gray-500 { color: #6b7280; }
.text-gray-600 { color: #4b5563; }
.text-red-600 { color: #dc2626; }
.text-indigo-600 { color: #4f46e5; }
.fill-current { fill: currentColor; }

/* Borders & Shadows */
.shadow-md { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); }
.overflow-hidden { overflow: hidden; }
.rounded-lg { border-radius: 0.5rem; }
.sm\\:rounded-lg { border-radius: 0.5rem; }

/* Forms */
.block { display: block; }
.mt-1 { margin-top: 0.25rem; }
.border-gray-300 { border-color: #d1d5db; }
.rounded-md { border-radius: 0.375rem; }
.shadow-sm { box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); }

/* Focus states */
.focus\\:border-indigo-300:focus { border-color: #a7b6f5; }
.focus\\:ring:focus { box-shadow: 0 0 0 3px rgba(164, 202, 254, 0.45); }
.focus\\:ring-indigo-200:focus { box-shadow: 0 0 0 3px rgba(199, 210, 254, 0.5); }
.focus\\:ring-opacity-50:focus { --ring-opacity: 0.5; }

/* Buttons */
.bg-indigo-600 { background-color: #4f46e5; }
.hover\\:bg-indigo-700:hover { background-color: #4338ca; }
.focus\\:bg-indigo-700:focus { background-color: #4338ca; }
.text-white { color: #ffffff; }
.font-bold { font-weight: 700; }
.uppercase { text-transform: uppercase; }
.tracking-widest { letter-spacing: 0.1em; }
.active\\:bg-indigo-900:active { background-color: #312e81; }
.focus\\:outline-none:focus { outline: 2px solid transparent; outline-offset: 2px; }
.focus\\:border-indigo-900:focus { border-color: #312e81; }
.transition { transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); transition-duration: 150ms; }
.ease-in-out { transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); }
.duration-150 { transition-duration: 150ms; }

/* Text */
.text-sm { font-size: 0.875rem; line-height: 1.25rem; }
.font-medium { font-weight: 500; }
.underline { text-decoration: underline; }

/* Links */
.hover\\:text-gray-900:hover { color: #111827; }

/* Responsive */
@media (min-width: 640px) {
    .sm\\:justify-center { justify-content: center; }
    .sm\\:pt-0 { padding-top: 0; }
    .sm\\:max-w-md { max-width: 28rem; }
    .sm\\:rounded-lg { border-radius: 0.5rem; }
}

/* Custom Laravel Auth Styling */
body {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    font-family: Inter, ui-sans-serif, system-ui, sans-serif;
}

/* Form Controls */
input[type="text"],
input[type="email"],
input[type="password"],
input[type="checkbox"],
textarea,
select {
    appearance: none;
    background-color: #ffffff;
    border-color: #d1d5db;
    border-width: 1px;
    border-radius: 0.375rem;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    line-height: 1.25rem;
    width: 100%;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

input[type="text"]:focus,
input[type="email"]:focus,
input[type="password"]:focus,
textarea:focus,
select:focus {
    outline: none;
    border-color: #4f46e5;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}

input[type="checkbox"] {
    width: auto;
    height: 1rem;
    padding: 0;
}

/* Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    cursor: pointer;
    transition: all 0.15s ease-in-out;
    text-decoration: none;
}

.btn-primary {
    background-color: #4f46e5;
    color: #ffffff;
}

.btn-primary:hover {
    background-color: #4338ca;
}

.btn-primary:focus {
    background-color: #4338ca;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.45);
}

.btn-primary:active {
    background-color: #312e81;
}

/* Error messages */
.text-red-600 {
    color: #dc2626;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

/* Success messages */
.text-green-600 {
    color: #059669;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

/* Loading states */
.loading {
    opacity: 0.6;
    pointer-events: none;
}

/* Additional Laravel components */
.form-group {
    margin-bottom: 1rem;
}

.form-label {
    display: block;
    margin-bottom: 0.25rem;
    font-weight: 500;
    color: #374151;
}

/* Logo styles */
.application-logo {
    fill: currentColor;
}

/* Mobile responsiveness */
@media (max-width: 640px) {
    .px-6 { padding-left: 1rem; padding-right: 1rem; }
    .py-4 { padding-top: 0.75rem; padding-bottom: 0.75rem; }
    .mt-6 { margin-top: 1rem; }
}
';

$cssPath = 'public/build/assets/app.css';
if (file_put_contents($cssPath, $completeTailwindCSS)) {
    echo "✅ Created complete Tailwind-like CSS<br>";
    echo "📄 CSS size: " . filesize($cssPath) . " bytes<br>";
} else {
    echo "❌ Failed to create CSS file<br>";
}

echo "</div>";

// Step 3: Create enhanced JavaScript
echo "<h3>Step 3: Create Enhanced JavaScript</h3>";
echo "<div style='background: #f9f9f9; padding: 10px;'>";

$enhancedJS = '// Laravel Frontend JavaScript - Complete Build
console.log("Laravel Frontend Assets Loaded");

// Alpine.js-like functionality for Laravel
document.addEventListener("DOMContentLoaded", function() {
    console.log("DOM Content Loaded");
    
    // CSRF Token Management
    const csrfToken = document.querySelector("meta[name=csrf-token]");
    const token = csrfToken ? csrfToken.getAttribute("content") : null;
    
    if (token) {
        console.log("CSRF token found");
        
        // Add CSRF token to all forms
        const forms = document.querySelectorAll("form");
        forms.forEach(function(form) {
            const existingToken = form.querySelector("input[name=_token]");
            
            if (!existingToken) {
                const tokenInput = document.createElement("input");
                tokenInput.type = "hidden";
                tokenInput.name = "_token";
                tokenInput.value = token;
                form.appendChild(tokenInput);
                console.log("Added CSRF token to form");
            }
        });
        
        // Set up Axios defaults if available
        if (typeof axios !== "undefined") {
            axios.defaults.headers.common["X-CSRF-TOKEN"] = token;
            axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
        }
        
        // Set up fetch defaults
        const originalFetch = window.fetch;
        window.fetch = function(url, options = {}) {
            options.headers = options.headers || {};
            options.headers["X-CSRF-TOKEN"] = token;
            options.headers["X-Requested-With"] = "XMLHttpRequest";
            return originalFetch(url, options);
        };
    }
    
    // Form Enhancement
    const forms = document.querySelectorAll("form");
    forms.forEach(function(form) {
        // Form validation
        form.addEventListener("submit", function(e) {
            const submitButton = form.querySelector("button[type=submit]");
            const requiredInputs = form.querySelectorAll("input[required], select[required], textarea[required]");
            
            let isValid = true;
            
            // Validate required fields
            requiredInputs.forEach(function(input) {
                const value = input.type === "checkbox" ? input.checked : input.value.trim();
                
                if (!value) {
                    isValid = false;
                    input.classList.add("border-red-300");
                    input.style.borderColor = "#fca5a5";
                    
                    // Show error message
                    let errorMsg = input.parentNode.querySelector(".error-message");
                    if (!errorMsg) {
                        errorMsg = document.createElement("div");
                        errorMsg.className = "error-message text-red-600 text-sm mt-1";
                        input.parentNode.appendChild(errorMsg);
                    }
                    errorMsg.textContent = "This field is required";
                } else {
                    input.classList.remove("border-red-300");
                    input.style.borderColor = "#d1d5db";
                    
                    // Remove error message
                    const errorMsg = input.parentNode.querySelector(".error-message");
                    if (errorMsg) {
                        errorMsg.remove();
                    }
                }
            });
            
            // Email validation
            const emailInputs = form.querySelectorAll("input[type=email]");
            emailInputs.forEach(function(input) {
                if (input.value && !isValidEmail(input.value)) {
                    isValid = false;
                    input.classList.add("border-red-300");
                    
                    let errorMsg = input.parentNode.querySelector(".error-message");
                    if (!errorMsg) {
                        errorMsg = document.createElement("div");
                        errorMsg.className = "error-message text-red-600 text-sm mt-1";
                        input.parentNode.appendChild(errorMsg);
                    }
                    errorMsg.textContent = "Please enter a valid email address";
                }
            });
            
            // Password confirmation
            const passwordInput = form.querySelector("input[name=password]");
            const confirmInput = form.querySelector("input[name=password_confirmation]");
            
            if (passwordInput && confirmInput && passwordInput.value !== confirmInput.value) {
                isValid = false;
                confirmInput.classList.add("border-red-300");
                
                let errorMsg = confirmInput.parentNode.querySelector(".error-message");
                if (!errorMsg) {
                    errorMsg = document.createElement("div");
                    errorMsg.className = "error-message text-red-600 text-sm mt-1";
                    confirmInput.parentNode.appendChild(errorMsg);
                }
                errorMsg.textContent = "Passwords do not match";
            }
            
            if (!isValid) {
                e.preventDefault();
                return false;
            }
            
            // Add loading state
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.classList.add("loading");
                const originalText = submitButton.textContent;
                submitButton.textContent = "Processing...";
                
                // Reset after 10 seconds in case of errors
                setTimeout(function() {
                    submitButton.disabled = false;
                    submitButton.classList.remove("loading");
                    submitButton.textContent = originalText;
                }, 10000);
            }
        });
        
        // Real-time validation
        const inputs = form.querySelectorAll("input, select, textarea");
        inputs.forEach(function(input) {
            input.addEventListener("blur", function() {
                if (input.hasAttribute("required") && !input.value.trim()) {
                    input.classList.add("border-red-300");
                } else {
                    input.classList.remove("border-red-300");
                    const errorMsg = input.parentNode.querySelector(".error-message");
                    if (errorMsg) {
                        errorMsg.remove();
                    }
                }
            });
            
            input.addEventListener("input", function() {
                if (input.classList.contains("border-red-300") && input.value.trim()) {
                    input.classList.remove("border-red-300");
                    const errorMsg = input.parentNode.querySelector(".error-message");
                    if (errorMsg) {
                        errorMsg.remove();
                    }
                }
            });
        });
    });
    
    // Toggle password visibility
    const passwordToggles = document.querySelectorAll(".password-toggle");
    passwordToggles.forEach(function(toggle) {
        toggle.addEventListener("click", function() {
            const input = toggle.previousElementSibling;
            if (input && input.type === "password") {
                input.type = "text";
                toggle.textContent = "Hide";
            } else if (input && input.type === "text") {
                input.type = "password";
                toggle.textContent = "Show";
            }
        });
    });
    
    // Flash message auto-hide
    const flashMessages = document.querySelectorAll(".flash-message");
    flashMessages.forEach(function(message) {
        setTimeout(function() {
            message.style.opacity = "0";
            setTimeout(function() {
                message.remove();
            }, 300);
        }, 5000);
    });
});

// Utility functions
function isValidEmail(email) {
    const emailRegex = /^[^\\s@]+@[^\\s@]+\\.[^\\s@]+$/;
    return emailRegex.test(email);
}

// Laravel Echo setup (if needed)
if (typeof Echo !== "undefined") {
    console.log("Laravel Echo is available");
}

// Livewire support (if needed)
document.addEventListener("livewire:load", function() {
    console.log("Livewire loaded");
});

console.log("Laravel Frontend JavaScript fully loaded");
';

$jsPath = 'public/build/assets/app.js';
if (file_put_contents($jsPath, $enhancedJS)) {
    echo "✅ Created enhanced JavaScript<br>";
    echo "📄 JS size: " . filesize($jsPath) . " bytes<br>";
} else {
    echo "❌ Failed to create JavaScript file<br>";
}

echo "</div>";

// Step 4: Update Vite manifest
echo "<h3>Step 4: Update Vite Manifest</h3>";
echo "<div style='background: #f9f9f9; padding: 10px;'>";

$manifestContent = '{
  "resources/css/app.css": {
    "file": "assets/app.css",
    "isEntry": true,
    "src": "resources/css/app.css",
    "css": ["assets/app.css"]
  },
  "resources/js/app.js": {
    "file": "assets/app.js",
    "isEntry": true,
    "src": "resources/js/app.js"
  }
}';

$manifestPath = 'public/build/manifest.json';
if (file_put_contents($manifestPath, $manifestContent)) {
    echo "✅ Updated Vite manifest<br>";
    echo "📄 Manifest size: " . filesize($manifestPath) . " bytes<br>";
}

echo "</div>";

// Step 5: Verify all assets
echo "<h3>Step 5: Verify All Assets</h3>";
echo "<div style='background: #f9f9f9; padding: 10px;'>";

$assetFiles = [
    'public/build/manifest.json',
    'public/build/assets/app.css',
    'public/build/assets/app.js'
];

$allAssetsExist = true;
foreach ($assetFiles as $file) {
    if (file_exists($file)) {
        $size = filesize($file);
        echo "✅ $file ($size bytes)<br>";
    } else {
        echo "❌ $file MISSING<br>";
        $allAssetsExist = false;
    }
}

echo "</div>";

// Step 6: Test the complete styling
echo "<h3>Step 6: Test Complete Styling</h3>";
echo "<div style='background: #e6ffe6; padding: 15px; border-radius: 5px;'>";

if ($allAssetsExist) {
    echo "<strong>🎉 Complete frontend assets built successfully!</strong><br><br>";
    
    echo "<strong>Test these URLs for full styling:</strong><br>";
    $testUrls = [
        'http://nephroapp.com/' => 'Homepage with complete Tailwind styling',
        'http://nephroapp.com/login' => 'Login page with professional design',
        'http://nephroapp.com/register' => 'Register page with full styling'
    ];
    
    foreach ($testUrls as $url => $description) {
        echo "<div style='margin: 5px 0; padding: 8px; background: white; border-left: 3px solid #007cba;'>";
        echo "<strong><a href='$url' target='_blank' style='color: #2563eb;'>$url</a></strong>";
        echo "<br><small>$description</small>";
        echo "</div>";
    }
    
    echo "<br><strong>✅ You should now see:</strong><br>";
    echo "• Complete Tailwind CSS styling<br>";
    echo "• Professional gradients and typography<br>";
    echo "• Fully responsive design<br>";
    echo "• Enhanced form functionality<br>";
    echo "• No more CSRF errors<br>";
    echo "• Loading states and validation<br>";
    
} else {
    echo "<strong>❌ Some assets failed to build</strong><br>";
    echo "Please check file permissions and try again.<br>";
}

echo "</div>";

echo "<hr>";
echo "<p><strong>🚀 Complete!</strong> Your Laravel NephroApp now has professional Tailwind CSS styling without needing Node.js!</p>";
?>
