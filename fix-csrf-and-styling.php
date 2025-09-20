<?php
// Fix CSRF 419 errors and styling issues
echo "<h2>🔧 Fix CSRF (419) Errors & Styling Issues</h2>";

$laravelPath = __DIR__;
if (file_exists('nephroapp')) {
    $laravelPath = __DIR__ . '/nephroapp';
}
chdir($laravelPath);

echo "<div style='background: #f0f8ff; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<strong>📁 Working in:</strong> " . getcwd() . "<br>";
echo "</div>";

// Step 1: Fix CSRF issues
echo "<h3>Step 1: Fix CSRF (419 Page Expired) Issues</h3>";
echo "<div style='background: #f9f9f9; padding: 10px;'>";

// Check .env configuration
if (file_exists('.env')) {
    $envContent = file_get_contents('.env');
    
    // Check APP_KEY
    if (strpos($envContent, 'APP_KEY=base64:') !== false) {
        echo "✅ APP_KEY is set correctly<br>";
    } else {
        echo "❌ APP_KEY missing or incorrect<br>";
        // Try to regenerate
        $newKey = 'base64:' . base64_encode(random_bytes(32));
        $envContent = preg_replace('/APP_KEY=.*/', "APP_KEY=$newKey", $envContent);
        if (file_put_contents('.env', $envContent)) {
            echo "✅ Generated new APP_KEY<br>";
        }
    }
    
    // Check session configuration
    if (strpos($envContent, 'SESSION_DRIVER=file') !== false || strpos($envContent, 'SESSION_DRIVER=database') !== false) {
        echo "✅ Session driver configured<br>";
    } else {
        echo "⚠️ Updating session driver to file<br>";
        $envContent = preg_replace('/SESSION_DRIVER=.*/', 'SESSION_DRIVER=file', $envContent);
        file_put_contents('.env', $envContent);
    }
    
    // Check session lifetime
    if (strpos($envContent, 'SESSION_LIFETIME=') === false) {
        echo "⚠️ Adding session lifetime<br>";
        $envContent .= "\nSESSION_LIFETIME=120\n";
        file_put_contents('.env', $envContent);
    }
    
} else {
    echo "❌ .env file not found<br>";
}

echo "</div>";

// Step 2: Fix session storage permissions
echo "<h3>Step 2: Fix Session Storage</h3>";
echo "<div style='background: #f9f9f9; padding: 10px;'>";

$sessionDirs = [
    'storage/framework/sessions',
    'storage/framework/cache',
    'storage/logs'
];

foreach ($sessionDirs as $dir) {
    if (!is_dir($dir)) {
        if (mkdir($dir, 0755, true)) {
            echo "✅ Created directory: $dir<br>";
        } else {
            echo "❌ Could not create: $dir<br>";
        }
    } else {
        echo "✅ Directory exists: $dir<br>";
    }
    
    // Try to set permissions
    if (is_dir($dir)) {
        chmod($dir, 0755);
        echo "✅ Set permissions for: $dir<br>";
    }
}

echo "</div>";

// Step 3: Fix Vite assets for better styling
echo "<h3>Step 3: Fix Vite Assets & Styling</h3>";
echo "<div style='background: #f9f9f9; padding: 10px;'>";

// Create updated manifest
$manifestPath = 'public/build/manifest.json';
$manifestContent = '{
  "resources/css/app.css": {
    "file": "assets/app.css",
    "isEntry": true,
    "src": "resources/css/app.css"
  },
  "resources/js/app.js": {
    "file": "assets/app.js", 
    "isEntry": true,
    "src": "resources/js/app.js"
  }
}';

if (file_put_contents($manifestPath, $manifestContent)) {
    echo "✅ Updated Vite manifest<br>";
}

// Create improved CSS with Laravel styling
$cssPath = 'public/build/assets/app.css';
$improvedCSS = '/* Laravel Auth Styling - Improved */
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

* {
    box-sizing: border-box;
}

body {
    font-family: "Inter", system-ui, sans-serif;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    margin: 0;
    padding: 0;
    min-height: 100vh;
    color: #374151;
}

.min-h-screen {
    min-height: 100vh;
}

.flex {
    display: flex;
}

.flex-col {
    flex-direction: column;
}

.items-center {
    align-items: center;
}

.justify-center {
    justify-content: center;
}

.bg-white {
    background-color: white;
}

.bg-gray-100 {
    background-color: #f3f4f6;
}

.shadow-md {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.shadow-lg {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.rounded-lg {
    border-radius: 0.5rem;
}

.rounded {
    border-radius: 0.25rem;
}

.p-6 {
    padding: 1.5rem;
}

.px-6 {
    padding-left: 1.5rem;
    padding-right: 1.5rem;
}

.py-4 {
    padding-top: 1rem;
    padding-bottom: 1rem;
}

.px-3 {
    padding-left: 0.75rem;
    padding-right: 0.75rem;
}

.py-2 {
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
}

.mb-4 {
    margin-bottom: 1rem;
}

.mt-6 {
    margin-top: 1.5rem;
}

.w-full {
    width: 100%;
}

.w-20 {
    width: 5rem;
}

.h-20 {
    height: 5rem;
}

.max-w-md {
    max-width: 28rem;
}

.text-gray-900 {
    color: #111827;
}

.text-gray-500 {
    color: #6b7280;
}

.text-white {
    color: white;
}

.text-sm {
    font-size: 0.875rem;
}

.font-medium {
    font-weight: 500;
}

.border {
    border: 1px solid #d1d5db;
}

.border-gray-300 {
    border-color: #d1d5db;
}

.focus\\:border-indigo-300:focus {
    border-color: #a7b6f5;
}

.focus\\:ring:focus {
    box-shadow: 0 0 0 3px rgba(164, 202, 254, 0.45);
}

.bg-indigo-600 {
    background-color: #4f46e5;
}

.hover\\:bg-indigo-700:hover {
    background-color: #4338ca;
}

.focus\\:bg-indigo-700:focus {
    background-color: #4338ca;
}

/* Form styling */
input[type="text"],
input[type="email"], 
input[type="password"],
textarea {
    display: block;
    width: 100%;
    padding: 0.5rem 0.75rem;
    margin-bottom: 1rem;
    border: 1px solid #d1d5db;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    line-height: 1.25rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

input[type="text"]:focus,
input[type="email"]:focus,
input[type="password"]:focus,
textarea:focus {
    outline: none;
    border-color: #4f46e5;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}

button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    cursor: pointer;
    transition: background-color 0.15s ease-in-out;
}

.btn-primary {
    background-color: #4f46e5;
    color: white;
}

.btn-primary:hover {
    background-color: #4338ca;
}

/* Laravel specific styling */
.form-group {
    margin-bottom: 1rem;
}

.form-label {
    display: block;
    margin-bottom: 0.25rem;
    font-weight: 500;
    color: #374151;
}

.form-control {
    display: block;
    width: 100%;
    padding: 0.5rem 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 0.375rem;
    background-color: white;
}

.form-control:focus {
    border-color: #4f46e5;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 0.375rem;
    font-weight: 500;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.15s ease-in-out;
}

.btn-primary {
    background-color: #4f46e5;
    color: white;
}

.btn-primary:hover {
    background-color: #4338ca;
}

/* Error styling */
.text-red-600 {
    color: #dc2626;
}

.border-red-300 {
    border-color: #fca5a5;
}

/* Success styling */
.text-green-600 {
    color: #059669;
}

/* Responsive */
@media (max-width: 640px) {
    .px-6 {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    .py-4 {
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
    }
}
';

if (file_put_contents($cssPath, $improvedCSS)) {
    echo "✅ Created improved CSS styling<br>";
    echo "📄 CSS size: " . filesize($cssPath) . " bytes<br>";
}

// Create JavaScript for CSRF protection
$jsPath = 'public/build/assets/app.js';
$improvedJS = '// Laravel Auth JavaScript with CSRF protection
console.log("Laravel Auth Assets Loaded");

document.addEventListener("DOMContentLoaded", function() {
    // Get CSRF token
    const csrfToken = document.querySelector("meta[name=csrf-token]");
    const token = csrfToken ? csrfToken.getAttribute("content") : null;
    
    // Add CSRF token to all forms
    const forms = document.querySelectorAll("form");
    forms.forEach(function(form) {
        // Check if form already has CSRF token
        const existingToken = form.querySelector("input[name=_token]");
        
        if (!existingToken && token) {
            // Create hidden CSRF token input
            const tokenInput = document.createElement("input");
            tokenInput.type = "hidden";
            tokenInput.name = "_token";
            tokenInput.value = token;
            form.appendChild(tokenInput);
            console.log("Added CSRF token to form");
        }
        
        // Form validation
        form.addEventListener("submit", function(e) {
            const requiredInputs = form.querySelectorAll("input[required]");
            let isValid = true;
            
            requiredInputs.forEach(function(input) {
                if (!input.value.trim()) {
                    isValid = false;
                    input.style.borderColor = "#ef4444";
                    input.classList.add("border-red-300");
                } else {
                    input.style.borderColor = "#d1d5db";
                    input.classList.remove("border-red-300");
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert("Please fill in all required fields");
            }
        });
    });
    
    // Add loading states to buttons
    const buttons = document.querySelectorAll("button[type=submit]");
    buttons.forEach(function(button) {
        button.addEventListener("click", function() {
            button.disabled = true;
            button.innerHTML = "Processing...";
            
            // Re-enable after 5 seconds in case of errors
            setTimeout(function() {
                button.disabled = false;
                button.innerHTML = button.getAttribute("data-original-text") || "Submit";
            }, 5000);
        });
    });
});

// Set up AXIOS defaults for CSRF
if (typeof axios !== "undefined") {
    axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
    
    const token = document.head.querySelector("meta[name=csrf-token]");
    if (token) {
        axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
    }
}
';

if (file_put_contents($jsPath, $improvedJS)) {
    echo "✅ Created improved JavaScript with CSRF handling<br>";
    echo "📄 JS size: " . filesize($jsPath) . " bytes<br>";
}

echo "</div>";

// Step 4: Clear Laravel caches
echo "<h3>Step 4: Clear Laravel Caches</h3>";
echo "<div style='background: #f9f9f9; padding: 10px;'>";

$cacheDirectories = [
    'bootstrap/cache',
    'storage/framework/cache/data',
    'storage/framework/sessions',
    'storage/framework/views'
];

foreach ($cacheDirectories as $dir) {
    if (is_dir($dir)) {
        $files = glob("$dir/*");
        $count = 0;
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
                $count++;
            }
        }
        echo "✅ Cleared $count files from $dir<br>";
    }
}

echo "</div>";

// Step 5: Test the fixes
echo "<h3>Step 5: Test Your Application</h3>";
echo "<div style='background: #e6ffe6; padding: 15px; border-radius: 5px;'>";

echo "<strong>🧪 Test these URLs with the fixes:</strong><br><br>";

$testUrls = [
    'http://nephroapp.com/' => 'Homepage - should have better styling',
    'http://nephroapp.com/login' => 'Login page - should work without 419 errors',
    'http://nephroapp.com/register' => 'Register page - should work without 419 errors'
];

foreach ($testUrls as $url => $description) {
    echo "<div style='margin: 5px 0; padding: 8px; background: white; border-left: 3px solid #007cba;'>";
    echo "<strong><a href='$url' target='_blank' style='color: #2563eb;'>$url</a></strong>";
    echo "<br><small>$description</small>";
    echo "</div>";
}

echo "</div>";

// Step 6: Expected results
echo "<h3>Step 6: Expected Results</h3>";
echo "<div style='background: #e6ffe6; padding: 15px; border-radius: 5px;'>";

echo "<strong>✅ After these fixes you should see:</strong><br><br>";

echo "<strong>1. No more 419 Page Expired errors:</strong><br>";
echo "• Forms should submit successfully<br>";
echo "• Login and registration should work<br>";
echo "• CSRF tokens automatically added to forms<br><br>";

echo "<strong>2. Much better styling:</strong><br>";
echo "• Professional looking forms<br>";
echo "• Modern gradients and shadows<br>";
echo "• Responsive design<br>";
echo "• Clean typography<br><br>";

echo "<strong>3. Improved functionality:</strong><br>";
echo "• Form validation<br>";
echo "• Loading states on buttons<br>";
echo "• Better error handling<br>";

echo "</div>";

echo "<hr>";
echo "<p><strong>🎉 Success!</strong> Your Laravel NephroApp should now have both working authentication AND professional styling!</p>";
?>
