<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8" />
    <link href="./assets/css/fontawesome.min.css" rel="stylesheet">
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="./assets/css/solid.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Cairo', sans-serif;
        }

        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            width: 100%;
            max-width: 500px;
            margin: 1rem;
        }

        .brand {
            text-align: center;
            margin-bottom: 2rem;
        }

        .brand img {
            width: 180px;
            height: 180px;
            object-fit: contain;
            margin-bottom: 1rem;
            transition: transform 0.3s ease;
        }

        .brand img:hover {
            transform: scale(1.05);
        }

        .card-title {
            color: #2d3748;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 2rem;
            text-align: center;
        }

        .form-control {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-label {
            color: #4a5568;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
        }

        .login-btn {
            background: #3b82f6;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 0.75rem;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
        }

        .login-btn:hover {
            background: #2563eb;
            transform: translateY(-1px);
        }

        .error-alert {
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #dc2626;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            position: absolute;
            margin-top: 33%;

        }

        .error-alert i {
            font-size: 1.25rem;
        }

        @media (max-width: 576px) {
            .login-container {
                margin: 1rem;
                padding: 1.5rem;
            }

            .card-title {
                font-size: 1.25rem;
            }
        }
    </style>
    <title>تسجيل الدخول - محطة تركي العامر</title>
</head>

<body>
    <?php
    include("./config.php");
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $myusername = mysqli_real_escape_string($conn, $_POST['username']);
        $mypassword = mysqli_real_escape_string($conn, $_POST['password']);

        $sql = "SELECT * FROM admin WHERE Username = '$myusername' and Password = '$mypassword'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        $count = mysqli_num_rows($result);

        if ($count == 1) {
            $_SESSION['login_user'] = $myusername;
            header("location: index.php");
        } else {
            echo '<div class="error-alert">
                    <i class="fas fa-exclamation-circle"></i>
                    خطأ في اسم المستخدم أو كلمة المرور
                  </div>';
        }
    }
    ?>

    <div class="login-container">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="brand">
                <img src="./uploads/1.png" alt="Company Logo" />
                <h1 class="card-title">مجموعة تركي عبد العزيز العامر التجارية</h1>
            </div>

            <div class="mb-3">
                <label for="username" class="form-label">اسم المستخدم</label>
                <input type="text"
                    class="form-control"
                    id="username"
                    name="username"
                    required
                    autofocus
                    placeholder="ادخل اسم المستخدم">
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">كلمة المرور</label>
                <input type="password"
                    class="form-control"
                    id="password"
                    name="password"
                    required
                    placeholder="ادخل كلمة المرور">
            </div>

            <button type="submit" class="login-btn">
                <i class="fas fa-sign-in-alt"></i>
                تسجيل الدخول
            </button>
        </form>
    </div>

    <script src="./assets/js/jquery-3.6.1.min.js"></script>
</body>

</html>