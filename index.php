<!doctype html>
<html lang="th">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login Form — แบบฟอร์มล็อกอิน</title>
    <style>
        :root {
            --bg: #f4f7fb;
            --card: #ffffff;
            --accent: #5b6cff;
            --muted: #6b7280;
            --radius: 12px;
            font-family: 'Sarabun', system-ui, -apple-system, "Segoe UI", Roboto, 'Noto Sans', sans-serif;
        }

        * {
            box-sizing: border-box
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--bg), #eef2ff);
            padding: 32px;
        }

        .card {
            width: 100%;
            max-width: 420px;
            background: var(--card);
            border-radius: var(--radius);
            box-shadow: 0 8px 30px rgba(30, 41, 59, 0.08);
            padding: 28px;
        }

        h1 {
            font-size: 20px;
            margin: 0 0 16px
        }

        p.lead {
            margin: 0 0 18px;
            color: var(--muted);
            font-size: 14px
        }

        .form-group {
            margin-bottom: 14px
        }

        label {
            display: block;
            font-size: 13px;
            color: #111827;
            margin-bottom: 6px
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #e6e9ef;
            border-radius: 10px;
            font-size: 15px;
            outline: none;
            transition: box-shadow .12s, border-color .12s;
        }

        input:focus {
            border-color: var(--accent);
            box-shadow: 0 6px 18px rgba(91, 108, 255, 0.08)
        }

        .row {
            display: flex;
            gap: 10px;
            align-items: center
        }

        .remember {
            display: flex;
            gap: 8px;
            align-items: center;
            color: var(--muted);
            font-size: 14px
        }

        .btn {
            display: inline-block;
            width: 100%;
            padding: 11px 14px;
            border-radius: 10px;
            border: 0;
            font-size: 15px;
            cursor: pointer;
            background: var(--accent);
            color: #fff;
            box-shadow: 0 6px 18px rgba(91, 108, 255, 0.18);
        }

        .secondary {
            background: transparent;
            color: var(--accent);
            border: 1px solid #e6e9ef
        }

        .meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 12px
        }

        .helper {
            font-size: 13px;
            color: var(--muted)
        }

        .show-pass {
            background: transparent;
            border: 0;
            color: var(--accent);
            cursor: pointer;
            font-size: 13px
        }

        .error {
            color: #b91c1c;
            font-size: 13px;
            margin-top: 6px
        }

        @media (max-width:480px) {
            .card {
                padding: 20px
            }
        }
    </style>
</head>

<body>
    <main class="card" role="main">
        <h1>เข้าสู่ระบบ</h1>
        <p class="lead">เข้าสู่ระบบด้วยชื่อผู้ใช้ของคุณ</p>

        <!-- ฟอร์มล็อกอิน (ส่งไปยัง /login ด้วย POST) -->
        <form id="loginForm" action="login.php" method="POST" novalidate>

            <div class="form-group">
                <label for="identifier">ชื่อผู้ใช้</label>
                <input id="identifier" name="adminid" type="text" placeholder="username"
                    autocomplete="username" required>
                <div class="error" id="err-identifier" aria-live="polite" style="display:none"></div>
            </div>

            <div class="form-group">
                <label for="password">รหัสผ่าน</label>
                <div class="row">
                    <input id="password" name="password" type="password" placeholder="รหัสผ่าน"
                        autocomplete="current-password" required>
                </div>
                <div style="margin-top:6px;display:flex;justify-content:space-between;align-items:center">
                    <label class="remember"><input type="checkbox" name="remember" value="1"> จำฉันไว้ในระบบ</label>
                    <button type="button" class="show-pass" id="togglePass">แสดงรหัสผ่าน</button>
                </div>
                <div class="error" id="err-password" aria-live="polite" style="display:none"></div>
            </div>

            <button type="submit" class="btn">เข้าสู่ระบบ</button>

            <div class="meta">
                <span class="helper">ยังไม่มีบัญชี? <a href="/register">สมัครสมาชิก</a></span>
                <a class="helper" href="/forgot">ลืมรหัสผ่าน?</a>
            </div>

        </form>

        <script>
            // Toggle show/hide password
            const toggle = document.getElementById('togglePass');
            const pw = document.getElementById('password');
            toggle.addEventListener('click', () => {
                if (pw.type === 'password') { pw.type = 'text'; toggle.textContent = 'ซ่อนรหัสผ่าน'; }
                else { pw.type = 'password'; toggle.textContent = 'แสดงรหัสผ่าน'; }
            });

            // Simple client-side validation
            const form = document.getElementById('loginForm');
            form.addEventListener('submit', (e) => {
                let ok = true;
                const id = document.getElementById('identifier');
                const idErr = document.getElementById('err-identifier');
                const pwErr = document.getElementById('err-password');
                idErr.style.display = 'none'; pwErr.style.display = 'none';

                if (id.value.trim().length < 3) {
                    idErr.textContent = 'กรุณากรอกอีเมลหรือชื่อผู้ใช้อย่างน้อย 3 ตัวอักษร';
                    idErr.style.display = 'block'; ok = false;
                }
                if (pw.value.trim().length < 6) {
                    pwErr.textContent = 'รหัสผ่านต้องมีอย่างน้อย 6 ตัวอักษร';
                    pwErr.style.display = 'block'; ok = false;
                }

                if (!ok) { e.preventDefault(); }
            });
        </script>
    </main>
</body>

</html>