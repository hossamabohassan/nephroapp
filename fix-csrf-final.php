<?php
// Final CSRF Fix - Eliminate 419 Page Expired Errors
echo "<h2>🔧 Final CSRF Fix - Eliminate 419 Page Expired</h2>";

$laravelPath = __DIR__;
if (file_exists('nephroapp')) {
    $laravelPath = __DIR__ . '/nephroapp';
}
chdir($laravelPath);

echo "<div style='background: #f0f8ff; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<strong>📁 Working in:</strong> " . getcwd() . "<br>";
echo "<strong>🎯 Goal:</strong> Permanently fix 419 CSRF errors<br>";
echo "</div>";

// Step 1: Check current session configuration
echo "<h3>Step 1: Diagnose CSRF Issues</h3>";
echo "<div style='background: #f9f9f9; padding: 10px;'>";

// Check .env file
if (file_exists('.env')) {
    $envContent = file_get_contents('.env');
    
    echo "<strong>Current .env session settings:</strong><br>";
    $sessionLines = [];
    $envLines = explode("\n", $envContent);
    
    foreach ($envLines as $line) {
        if (strpos($line, 'SESSION_') === 0 || strpos($line, 'APP_KEY') === 0) {
            $sessionLines[] = $line;
            echo "• " . htmlspecialchars($line) . "<br>";
        }
    }
    
    // Check for issues
    if (strpos($envContent, 'SESSION_DRIVER=file') === false) {
        echo "❌ SESSION_DRIVER not set to file<br>";
    } else {
        echo "✅ SESSION_DRIVER is file<br>";
    }
    
    if (strpos($envContent, 'APP_KEY=base64:') === false) {
        echo "❌ APP_KEY missing or invalid<br>";
    } else {
        echo "✅ APP_KEY is set<br>";
    }
    
} else {
    echo "❌ .env file not found<br>";
}

echo "</div>";

// Step 2: Fix .env file completely
echo "<h3>Step 2: Fix .env Configuration</h3>";
echo "<div style='background: #f9f9f9; padding: 10px;'>";

if (file_exists('.env')) {
    $envContent = file_get_contents('.env');
    
    // Ensure APP_KEY is properly set
    if (strpos($envContent, 'APP_KEY=base64:') === false) {
        $newKey = 'base64:' . base64_encode(random_bytes(32));
        if (strpos($envContent, 'APP_KEY=') !== false) {
            $envContent = preg_replace('/APP_KEY=.*/', "APP_KEY=$newKey", $envContent);
        } else {
            $envContent .= "\nAPP_KEY=$newKey\n";
        }
        echo "✅ Generated new APP_KEY<br>";
    }
    
    // Fix session settings
    $sessionSettings = [
        'SESSION_DRIVER' => 'file',
        'SESSION_LIFETIME' => '120',
        'SESSION_ENCRYPT' => 'false',
        'SESSION_PATH' => '/',
        'SESSION_DOMAIN' => 'null',
        'SESSION_SECURE_COOKIE' => 'false',
        'SESSION_HTTP_ONLY' => 'true',
        'SESSION_SAME_SITE' => 'lax'
    ];
    
    foreach ($sessionSettings as $key => $value) {
        if (strpos($envContent, "$key=") !== false) {
            $envContent = preg_replace("/$key=.*/", "$key=$value", $envContent);
        } else {
            $envContent .= "\n$key=$value\n";
        }
        echo "✅ Set $key=$value<br>";
    }
    
    // Write updated .env
    if (file_put_contents('.env', $envContent)) {
        echo "✅ Updated .env file successfully<br>";
    } else {
        echo "❌ Failed to update .env file<br>";
    }
}

echo "</div>";

// Step 3: Clear all caches and sessions
echo "<h3>Step 3: Clear All Caches and Sessions</h3>";
echo "<div style='background: #f9f9f9; padding: 10px;'>";

$cacheDirs = [
    'bootstrap/cache' => 'Laravel bootstrap cache',
    'storage/framework/cache/data' => 'Application cache',
    'storage/framework/sessions' => 'User sessions',
    'storage/framework/views' => 'Compiled views'
];

foreach ($cacheDirs as $dir => $description) {
    if (is_dir($dir)) {
        $files = glob("$dir/*");
        $deleted = 0;
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
                $deleted++;
            }
        }
        echo "✅ Cleared $deleted files from $description<br>";
    } else {
        if (mkdir($dir, 0755, true)) {
            echo "✅ Created directory: $dir<br>";
        }
    }
}

echo "</div>";

// Step 4: Fix session storage permissions
echo "<h3>Step 4: Fix Session Storage Permissions</h3>";
echo "<div style='background: #f9f9f9; padding: 10px;'>";

$sessionDir = 'storage/framework/sessions';
if (is_dir($sessionDir)) {
    // Try different permission levels
    $permissions = [0755, 0775, 0777];
    
    foreach ($permissions as $perm) {
        if (chmod($sessionDir, $perm)) {
            $currentPerm = substr(sprintf('%o', fileperms($sessionDir)), -4);
            echo "✅ Set $sessionDir permissions to $currentPerm<br>";
            break;
        }
    }
    
    // Test if we can write to session directory
    $testFile = $sessionDir . '/test_write.txt';
    if (file_put_contents($testFile, 'test')) {
        echo "✅ Session directory is writable<br>";
        unlink($testFile);
    } else {
        echo "❌ Session directory is not writable<br>";
    }
} else {
    echo "❌ Session directory does not exist<br>";
}

echo "</div>";

// Step 5: Create CSRF meta tag injection
echo "<h3>Step 5: Inject CSRF Meta Tags</h3>";
echo "<div style='background: #f9f9f9; padding: 10px;'>";

// Check if layouts have CSRF meta tag
$layoutFiles = [
    'resources/views/layouts/app.blade.php',
    'resources/views/layouts/guest.blade.php'
];

foreach ($layoutFiles as $layoutFile) {
    if (file_exists($layoutFile)) {
        $layoutContent = file_get_contents($layoutFile);
        
        if (strpos($layoutContent, 'csrf-token') === false) {
            // Add CSRF meta tag
            $csrfMeta = '    <meta name="csrf-token" content="{{ csrf_token() }}">';
            
            if (strpos($layoutContent, '</head>') !== false) {
                $layoutContent = str_replace('</head>', "$csrfMeta\n</head>", $layoutContent);
                
                if (file_put_contents($layoutFile, $layoutContent)) {
                    echo "✅ Added CSRF meta tag to $layoutFile<br>";
                } else {
                    echo "❌ Failed to update $layoutFile<br>";
                }
            }
        } else {
            echo "✅ CSRF meta tag already exists in $layoutFile<br>";
        }
    } else {
        echo "⚠️ Layout file $layoutFile not found<br>";
    }
}

echo "</div>";

// Step 6: Create enhanced CSRF JavaScript
echo "<h3>Step 6: Enhanced CSRF JavaScript</h3>";
echo "<div style='background: #f9f9f9; padding: 10px;'>";

$csrfJS = '// Enhanced CSRF Protection JavaScript
document.addEventListener("DOMContentLoaded", function() {
    console.log("Enhanced CSRF Protection Loading...");
    
    // Get CSRF token from meta tag
    const csrfMeta = document.querySelector("meta[name=csrf-token]");
    const csrfToken = csrfMeta ? csrfMeta.getAttribute("content") : null;
    
    if (!csrfToken) {
        console.error("CSRF token not found in meta tag");
        return;
    }
    
    console.log("CSRF token found:", csrfToken.substring(0, 10) + "...");
    
    // Function to add CSRF token to form
    function addCSRFTokenToForm(form) {
        // Remove existing token first
        const existingToken = form.querySelector("input[name=_token]");
        if (existingToken) {
            existingToken.remove();
        }
        
        // Add fresh token
        const tokenInput = document.createElement("input");
        tokenInput.type = "hidden";
        tokenInput.name = "_token";
        tokenInput.value = csrfToken;
        form.appendChild(tokenInput);
        
        console.log("Added CSRF token to form");
    }
    
    // Add CSRF token to all forms
    const forms = document.querySelectorAll("form");
    forms.forEach(function(form) {
        addCSRFTokenToForm(form);
        
        // Re-add token before each submit
        form.addEventListener("submit", function(e) {
            addCSRFTokenToForm(form);
            console.log("Refreshed CSRF token before submit");
        });
    });
    
    // Set up CSRF for AJAX requests
    if (typeof axios !== "undefined") {
        axios.defaults.headers.common["X-CSRF-TOKEN"] = csrfToken;
        axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
        console.log("Configured Axios with CSRF token");
    }
    
    // Set up CSRF for fetch requests
    const originalFetch = window.fetch;
    window.fetch = function(url, options = {}) {
        options.headers = options.headers || {};
        options.headers["X-CSRF-TOKEN"] = csrfToken;
        options.headers["X-Requested-With"] = "XMLHttpRequest";
        return originalFetch(url, options);
    };
    
    // Monitor for dynamically added forms
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            mutation.addedNodes.forEach(function(node) {
                if (node.nodeName === "FORM") {
                    addCSRFTokenToForm(node);
                } else if (node.querySelectorAll) {
                    const forms = node.querySelectorAll("form");
                    forms.forEach(function(form) {
                        addCSRFTokenToForm(form);
                    });
                }
            });
        });
    });
    
    observer.observe(document.body, { childList: true, subtree: true });
    
    console.log("Enhanced CSRF Protection Active");
});
';

$jsPath = 'public/build/assets/csrf.js';
if (file_put_contents($jsPath, $csrfJS)) {
    echo "✅ Created enhanced CSRF JavaScript<br>";
    echo "📄 Size: " . filesize($jsPath) . " bytes<br>";
}

// Update main app.js to include CSRF
$mainJSPath = 'public/build/assets/app.js';
if (file_exists($mainJSPath)) {
    $mainJS = file_get_contents($mainJSPath);
    if (strpos($mainJS, 'Enhanced CSRF Protection') === false) {
        $mainJS = $csrfJS . "\n\n" . $mainJS;
        file_put_contents($mainJSPath, $mainJS);
        echo "✅ Enhanced main app.js with CSRF protection<br>";
    }
}

echo "</div>";

// Step 7: Test CSRF configuration
echo "<h3>Step 7: Test CSRF Configuration</h3>";
echo "<div style='background: #e6ffe6; padding: 15px; border-radius: 5px;'>";

echo "<strong>🧪 Test these URLs to verify CSRF is fixed:</strong><br><br>";

$testUrls = [
    'http://nephroapp.com/login' => 'Login page - try logging in',
    'http://nephroapp.com/register' => 'Register page - try creating account',
    'http://nephroapp.com/' => 'Homepage - verify no errors'
];

foreach ($testUrls as $url => $description) {
    echo "<div style='margin: 5px 0; padding: 8px; background: white; border-left: 3px solid #007cba;'>";
    echo "<strong><a href='$url' target='_blank' style='color: #2563eb;'>$url</a></strong>";
    echo "<br><small>$description</small>";
    echo "</div>";
}

echo "<br><strong>✅ What to expect:</strong><br>";
echo "• Forms should submit without 419 Page Expired errors<br>";
echo "• Login and registration should work normally<br>";
echo "• No CSRF-related errors in browser console<br>";
echo "• Sessions should persist properly<br>";

echo "</div>";

// Step 8: Troubleshooting guide
echo "<h3>Step 8: If 419 Errors Persist</h3>";
echo "<div style='background: #fff3cd; padding: 15px; border-radius: 5px;'>";

echo "<strong>🔧 Additional steps to try:</strong><br><br>";

echo "<strong>1. Clear browser cache completely:</strong><br>";
echo "• Press Ctrl+Shift+Delete (Windows) or Cmd+Shift+Delete (Mac)<br>";
echo "• Clear all cookies and site data<br>";
echo "• Try incognito/private browsing<br><br>";

echo "<strong>2. Check server configuration:</strong><br>";
echo "• IONOS might have session restrictions<br>";
echo "• Contact IONOS about PHP session settings<br>";
echo "• Verify PHP version is 8.2+<br><br>";

echo "<strong>3. Alternative: Disable CSRF temporarily:</strong><br>";
echo "• Edit app/Http/Middleware/VerifyCsrfToken.php<br>";
echo "• Add routes to \$except array for testing<br>";
echo "• (Not recommended for production)<br><br>";

echo "<strong>4. Check Laravel logs:</strong><br>";
echo "• storage/logs/laravel.log<br>";
echo "• Look for session or CSRF-related errors<br>";

echo "</div>";

echo "<hr>";
echo "<p><strong>🎯 This comprehensive fix should eliminate all 419 Page Expired errors!</strong></p>";
?>
