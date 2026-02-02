<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ESG Reporting - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-xl shadow-lg w-96">
        <h1 class="text-2xl font-bold text-slate-800 mb-6">ESG Admin Login</h1>
        
        <?php if(isset($_GET['error'])): ?>
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
            Invalid email or password
        </div>
        <?php endif; ?>
        
        <form action="process_login.php" method="POST">
            <div class="mb-4">
                <label class="block text-sm font-semibold text-slate-600 mb-2">Email</label>
                <input type="email" name="email" required 
                    class="w-full border border-slate-300 rounded-lg px-4 py-2">
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-semibold text-slate-600 mb-2">Password</label>
                <input type="password" name="password" required 
                    class="w-full border border-slate-300 rounded-lg px-4 py-2">
            </div>
            
            <button type="submit" 
                class="w-full bg-emerald-600 text-white py-3 rounded-lg font-semibold hover:bg-emerald-700">
                Sign In
            </button>
        </form>
    </div>
</body>
</html>