<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Login — MAHIR · Universitas Ibnu Sina</title>
  <meta name="description" content="Portal login resmi Sistem Manajemen dan Administrasi Hibah Universitas Ibnu Sina.">
  <link href="{{ asset('assets/img/logouis.png') }}" rel="icon">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@600;700;800;900&display=swap" rel="stylesheet">

  <!-- Login CSS -->
  <link href="{{ asset('assets/css/login.css') }}" rel="stylesheet">
</head>

<body class="login-body">

  {{-- ── Interactive Network Canvas Background ── --}}
  <canvas id="networkCanvas"></canvas>

  {{-- ── Center Stage ── --}}
  <div class="login-stage">

    {{-- Top brand --}}
    <div class="brand-row">
      <img src="{{ asset('assets/img/logouis.png') }}" alt="UIS" class="brand-logo">
      <div>
        <p class="brand-name">Universitas Ibnu Sina</p>
        <p class="brand-loc">Batam, Kepulauan Riau</p>
      </div>
    </div>

    {{-- Login Card --}}
    <div class="lcard">

      {{-- Animated border --}}
      <div class="lcard-border"></div>

      {{-- Card Header --}}
      <div class="lcard-head">
        <div class="lcard-head-deco1"></div>
        <div class="lcard-head-deco2"></div>
        <div class="lcard-emblem">
          <img src="{{ asset('assets/img/logouis.png') }}" alt="UIS" class="lcard-emblem-img">
          <div class="lcard-emblem-ring r1"></div>
          <div class="lcard-emblem-ring r2"></div>
        </div>
        <h1 class="lcard-sys">MAHIR</h1>
        <p class="lcard-full">Manajemen &amp; Administrasi Hibah Ibnu Sina</p>
        <div class="lcard-head-divider"></div>
        <h2 class="lcard-welcome">Selamat Datang</h2>
        <p class="lcard-sub">Masuk menggunakan akun yang telah didaftarkan oleh administrator</p>
      </div>

      {{-- Alerts --}}
      @if(session('error'))
      <div class="lcard-msg lcard-msg-err">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
        <span>{{ session('error') }}</span>
      </div>
      @endif

      @if(session('success'))
      <div class="lcard-msg lcard-msg-ok">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
        <span>{{ session('success') }}</span>
      </div>
      @endif

      {{-- Form --}}
      <form class="lcard-form" method="POST" action="{{ route('login.post') }}" id="loginForm">
        @csrf

        <div class="lcard-field">
          <label class="lcard-label" for="username">Username</label>
          <div class="lcard-igroup">
            <span class="lcard-igroup-pre">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </span>
            <input type="text" id="username" name="username" class="lcard-input {{ $errors->has('username') ? 'has-error' : '' }}" placeholder="Masukkan username Anda" value="{{ old('username') }}" autocomplete="username" autofocus>
          </div>
          @error('username')<p class="lcard-err-msg">{{ $message }}</p>@enderror
        </div>

        <div class="lcard-field">
          <label class="lcard-label" for="password">Password</label>
          <div class="lcard-igroup">
            <span class="lcard-igroup-pre">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </span>
            <input type="password" id="password" name="password" class="lcard-input {{ $errors->has('password') ? 'has-error' : '' }}" placeholder="Masukkan password Anda" autocomplete="current-password">
            <button type="button" class="lcard-eye" id="togglePwd" tabindex="-1">
              <svg id="eyeShow" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
              <svg id="eyeHide" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
            </button>
          </div>
          @error('password')<p class="lcard-err-msg">{{ $message }}</p>@enderror
        </div>

        <div class="lcard-options">
          <label class="lcard-switch-lbl" for="rememberMe">
            <input type="checkbox" id="rememberMe" name="remember" value="1">
            <span class="lcard-toggle"></span>
            <span>Ingat saya</span>
          </label>
        </div>

        <button type="submit" class="lcard-btn" id="submitBtn">
          <span id="btnText">Masuk ke Sistem</span>
          <span id="btnLoad" style="display:none" class="lcard-btn-loading">
            <span class="lcard-spin"></span> Memverifikasi...
          </span>
          <span class="lcard-btn-glow"></span>
        </button>

      </form>

      {{-- Footer --}}
      <div class="lcard-foot">
        <span>
          <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/></svg>
          Dilindungi enkripsi SSL
        </span>
        <span class="lcard-foot-sep"></span>
        <span>
          <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
          admin@ibnu-sina.ac.id
        </span>
      </div>

    </div>
    {{-- /Card --}}

    <p class="stage-copy">MAHIR v1.0 &mdash; &copy; {{ date('Y') }} Universitas Ibnu Sina</p>

  </div>

  <script>
    const pwd = document.getElementById('password');
    document.getElementById('togglePwd').addEventListener('click', function() {
      const isHidden = pwd.type === 'password';
      pwd.type = isHidden ? 'text' : 'password';
      document.getElementById('eyeShow').style.display = isHidden ? 'none' : 'block';
      document.getElementById('eyeHide').style.display = isHidden ? 'block' : 'none';
    });

    document.getElementById('loginForm').addEventListener('submit', function() {
      document.getElementById('btnText').style.display = 'none';
      document.getElementById('btnLoad').style.display = 'flex';
      document.getElementById('submitBtn').disabled = true;
    });
  </script>

  <script>
  /* ── Interactive Network Canvas ── */
  (function() {
    var canvas = document.getElementById('networkCanvas');
    var ctx = canvas.getContext('2d');
    var W, H, nodes = [], mouse = { x: -9999, y: -9999 };

    var NODE_COUNT     = 45; // Reduced from 90 for a cleaner, less crowded look
    var CONNECT_DIST   = 180;
    var MOUSE_RADIUS   = 200;
    var MOUSE_FORCE    = 0.12;
    var NODE_SPEED     = 0.25; // Slower, more elegant movement

    /* Premium elegant palette: Subtle whites/greens for nodes, gold for accents */
    var COLORS = ['rgba(255,255,255,0.4)', 'rgba(0,166,81,0.5)', 'rgba(255,255,255,0.2)'];

    function resize() {
      W = canvas.width  = window.innerWidth;
      H = canvas.height = window.innerHeight;
    }

    function randBetween(a, b) { return a + Math.random() * (b - a); }

    function createNode() {
      var angle = Math.random() * Math.PI * 2;
      var speed = randBetween(0.1, NODE_SPEED);
      var color = COLORS[Math.floor(Math.random() * COLORS.length)];
      return {
        x:     Math.random() * W,
        y:     Math.random() * H,
        vx:    Math.cos(angle) * speed,
        vy:    Math.sin(angle) * speed,
        r:     randBetween(1.5, 3.0), // Slightly smaller nodes
        color: color,
        alpha: randBetween(0.4, 0.8)
      };
    }

    function init() {
      nodes = [];
      for (var i = 0; i < NODE_COUNT; i++) nodes.push(createNode());
    }

    function draw() {
      ctx.clearRect(0, 0, W, H);

      /* Update positions */
      for (var i = 0; i < nodes.length; i++) {
        var n = nodes[i];

        /* Mouse repulsion */
        var dx = n.x - mouse.x;
        var dy = n.y - mouse.y;
        var dist = Math.sqrt(dx * dx + dy * dy);
        if (dist < MOUSE_RADIUS && dist > 0) {
          var force = (1 - dist / MOUSE_RADIUS) * MOUSE_FORCE;
          n.vx += (dx / dist) * force;
          n.vy += (dy / dist) * force;
        }

        /* Speed cap */
        var spd = Math.sqrt(n.vx * n.vx + n.vy * n.vy);
        if (spd > NODE_SPEED * 2.5) {
          n.vx = (n.vx / spd) * NODE_SPEED * 2.5;
          n.vy = (n.vy / spd) * NODE_SPEED * 2.5;
        }

        /* Friction */
        n.vx *= 0.994;
        n.vy *= 0.994;

        n.x += n.vx;
        n.y += n.vy;

        /* Wrap edges */
        if (n.x < -20)  n.x = W + 20;
        if (n.x > W+20) n.x = -20;
        if (n.y < -20)  n.y = H + 20;
        if (n.y > H+20) n.y = -20;
      }

      /* Draw lines */
      for (var i = 0; i < nodes.length; i++) {
        for (var j = i + 1; j < nodes.length; j++) {
          var a = nodes[i], b = nodes[j];
          var ddx = a.x - b.x, ddy = a.y - b.y;
          var d = Math.sqrt(ddx*ddx + ddy*ddy);
          if (d < CONNECT_DIST) {
            var lineAlpha = (1 - d / CONNECT_DIST) * 0.25; // More subtle lines
            ctx.beginPath();
            ctx.moveTo(a.x, a.y);
            ctx.lineTo(b.x, b.y);
            ctx.strokeStyle = 'rgba(255,255,255,' + lineAlpha + ')';
            ctx.lineWidth = 0.6;
            ctx.stroke();
          }
        }
      }

      /* Draw mouse glow connections (Premium Gold) */
      for (var i = 0; i < nodes.length; i++) {
        var n = nodes[i];
        var dx = n.x - mouse.x;
        var dy = n.y - mouse.y;
        var d = Math.sqrt(dx*dx + dy*dy);
        if (d < MOUSE_RADIUS) {
          var la = (1 - d / MOUSE_RADIUS) * 0.6;
          ctx.beginPath();
          ctx.moveTo(mouse.x, mouse.y);
          ctx.lineTo(n.x, n.y);
          ctx.strokeStyle = 'rgba(255, 215, 0,' + la + ')';
          ctx.lineWidth = 1.0;
          ctx.stroke();
        }
      }

      /* Draw mouse cursor dot (Premium Gold) */
      if (mouse.x > 0 && mouse.x < W) {
        var grad = ctx.createRadialGradient(mouse.x, mouse.y, 0, mouse.x, mouse.y, 40);
        grad.addColorStop(0,   'rgba(255, 215, 0, 0.15)');
        grad.addColorStop(1,   'rgba(255, 215, 0, 0)');
        ctx.beginPath();
        ctx.arc(mouse.x, mouse.y, 40, 0, Math.PI * 2);
        ctx.fillStyle = grad;
        ctx.fill();
        
        ctx.beginPath();
        ctx.arc(mouse.x, mouse.y, 2.5, 0, Math.PI * 2);
        ctx.fillStyle = 'rgba(255, 215, 0, 0.9)';
        ctx.fill();
      }

      /* Draw nodes */
      for (var i = 0; i < nodes.length; i++) {
        var n = nodes[i];
        var g = ctx.createRadialGradient(n.x, n.y, 0, n.x, n.y, n.r * 2.5);
        g.addColorStop(0, n.color);
        g.addColorStop(1, 'rgba(0,0,0,0)');
        ctx.beginPath();
        ctx.arc(n.x, n.y, n.r * 2.5, 0, Math.PI * 2);
        ctx.fillStyle = g;
        ctx.globalAlpha = n.alpha * 0.5;
        ctx.fill();

        ctx.beginPath();
        ctx.arc(n.x, n.y, n.r, 0, Math.PI * 2);
        ctx.fillStyle = n.color;
        ctx.globalAlpha = n.alpha;
        ctx.fill();
      }

      ctx.globalAlpha = 1;
      requestAnimationFrame(draw);
    }

    window.addEventListener('resize', function() { resize(); init(); });
    window.addEventListener('mousemove', function(e) { mouse.x = e.clientX; mouse.y = e.clientY; });
    window.addEventListener('mouseleave', function() { mouse.x = -9999; mouse.y = -9999; });

    resize();
    init();
    draw();
  })();
  </script>

</body>
</html>