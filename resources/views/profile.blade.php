<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Personal Profile — Arkan Davin</title>

  <!-- Google Fonts: Playfair Display + DM Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,800;1,600&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet" />

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            choco:    '#3B1F0E',
            mocha:    '#5C3317',
            terracotta: '#C4622D',
            tan:      '#C8996A',
            cream:    '#F5EBD8',
            parchment:'#EFE0C4',
            sand:     '#D9C4A0',
          },
          fontFamily: {
            display: ['"Playfair Display"', 'serif'],
            body:    ['"DM Sans"', 'sans-serif'],
          },
        },
      },
    };
  </script>

  <style>
    /* ── Base ── */
    *, *::before, *::after { box-sizing: border-box; }
    html { scroll-behavior: smooth; }
    body {
      font-family: 'DM Sans', sans-serif;
      background-color: #F5EBD8;
      color: #3B1F0E;
      min-height: 100vh;
      overflow-x: hidden;
    }

    /* ── Animated grain overlay ── */
    body::before {
      content: '';
      position: fixed;
      inset: 0;
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
      background-size: 200px 200px;
      pointer-events: none;
      z-index: 0;
      opacity: 0.5;
    }

    /* ── Section fade-in ── */
    .reveal {
      opacity: 0;
      transform: translateY(32px);
      transition: opacity 0.7s ease, transform 0.7s ease;
    }
    .reveal.visible {
      opacity: 1;
      transform: translateY(0);
    }

    /* ── Glassmorphism card ── */
    .glass {
      background: rgba(245, 235, 216, 0.55);
      backdrop-filter: blur(18px);
      -webkit-backdrop-filter: blur(18px);
      border: 1px solid rgba(200, 153, 106, 0.35);
      box-shadow: 0 8px 32px rgba(59, 31, 14, 0.1);
    }

    /* ── Decorative blob ── */
    .blob {
      position: absolute;
      border-radius: 50%;
      filter: blur(80px);
      opacity: 0.25;
      pointer-events: none;
    }

    /* ── Skills badge hover ── */
    .skill-badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 6px 14px;
      border-radius: 9999px;
      font-size: 0.82rem;
      font-weight: 500;
      background: rgba(200, 153, 106, 0.25);
      border: 1px solid rgba(200, 153, 106, 0.5);
      color: #5C3317;
      cursor: default;
      transition: background 0.3s, color 0.3s, transform 0.2s, box-shadow 0.3s;
    }
    .skill-badge:hover {
      background: #C4622D;
      color: #F5EBD8;
      border-color: #C4622D;
      transform: translateY(-3px) scale(1.05);
      box-shadow: 0 6px 20px rgba(196, 98, 45, 0.4);
    }

    /* ── Social icon ── */
    .social-link {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 48px; height: 48px;
      border-radius: 50%;
      background: rgba(200, 153, 106, 0.2);
      border: 1px solid rgba(200, 153, 106, 0.45);
      color: #5C3317;
      font-size: 1.1rem;
      transition: all 0.3s;
    }
    .social-link:hover {
      background: #C4622D;
      color: #F5EBD8;
      border-color: #C4622D;
      transform: translateY(-4px);
      box-shadow: 0 8px 22px rgba(196, 98, 45, 0.4);
    }

    /* ── Chat Widget ── */
    #chat-bubble {
      position: fixed;
      bottom: 28px; right: 28px;
      width: 54px; height: 54px;
      border-radius: 50%;
      background: linear-gradient(135deg, #C4622D, #5C3317);
      color: #F5EBD8;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.3rem;
      cursor: pointer;
      box-shadow: 0 6px 24px rgba(92, 51, 23, 0.45);
      z-index: 1000;
      transition: transform 0.3s, box-shadow 0.3s;
    }
    #chat-bubble:hover { transform: scale(1.1); box-shadow: 0 10px 30px rgba(92, 51, 23, 0.55); }

    #chat-panel {
      position: fixed;
      bottom: 96px; right: 28px;
      width: 320px;
      max-height: 440px;
      border-radius: 20px;
      display: flex; flex-direction: column;
      overflow: hidden;
      z-index: 999;
      transform: scale(0.85) translateY(20px);
      transform-origin: bottom right;
      opacity: 0;
      pointer-events: none;
      transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    #chat-panel.open {
      transform: scale(1) translateY(0);
      opacity: 1;
      pointer-events: all;
    }

    #chat-messages {
      flex: 1;
      overflow-y: auto;
      padding: 14px;
      display: flex;
      flex-direction: column;
      gap: 10px;
      scroll-behavior: smooth;
    }
    #chat-messages::-webkit-scrollbar { width: 4px; }
    #chat-messages::-webkit-scrollbar-thumb { background: rgba(200,153,106,0.4); border-radius: 4px; }

    .msg { max-width: 80%; padding: 9px 13px; border-radius: 14px; font-size: 0.82rem; line-height: 1.5; word-break: break-word; }
    .msg-bot { background: rgba(200,153,106,0.25); color: #3B1F0E; border-bottom-left-radius: 4px; align-self: flex-start; }
    .msg-user { background: #C4622D; color: #F5EBD8; border-bottom-right-radius: 4px; align-self: flex-end; }

    .typing-indicator { display: flex; gap: 4px; padding: 10px 14px; }
    .typing-dot {
      width: 7px; height: 7px; border-radius: 50%;
      background: #C4622D; opacity: 0.5;
      animation: typingBounce 1.2s infinite ease-in-out;
    }
    .typing-dot:nth-child(2) { animation-delay: 0.2s; }
    .typing-dot:nth-child(3) { animation-delay: 0.4s; }
    @keyframes typingBounce {
      0%, 80%, 100% { transform: translateY(0); }
      40% { transform: translateY(-6px); opacity: 1; }
    }

    #chat-input-row {
      display: flex;
      padding: 10px;
      gap: 8px;
      border-top: 1px solid rgba(200,153,106,0.3);
    }
    #chat-input {
      flex: 1;
      padding: 9px 13px;
      border-radius: 9999px;
      border: 1px solid rgba(200,153,106,0.5);
      background: rgba(245,235,216,0.8);
      color: #3B1F0E;
      font-size: 0.82rem;
      outline: none;
      transition: border-color 0.2s;
    }
    #chat-input:focus { border-color: #C4622D; }
    #chat-send {
      width: 36px; height: 36px;
      border-radius: 50%;
      background: linear-gradient(135deg, #C4622D, #5C3317);
      color: #F5EBD8;
      border: none; cursor: pointer;
      display: flex; align-items: center; justify-content: center;
      font-size: 0.9rem;
      transition: transform 0.2s, box-shadow 0.2s;
      flex-shrink: 0;
    }
    #chat-send:hover { transform: scale(1.1); box-shadow: 0 4px 12px rgba(196,98,45,0.4); }

    /* Avatar shimmer */
    .avatar-ring {
      background: conic-gradient(#C4622D, #C8996A, #5C3317, #C4622D);
      animation: spin 4s linear infinite;
      border-radius: 50%;
      padding: 3px;
    }
    @keyframes spin { to { transform: rotate(360deg); } }
    .avatar-inner { border-radius: 50%; overflow: hidden; }

    /* Divider line */
    .divider {
      display: flex; align-items: center; gap: 12px;
      color: #C8996A; font-size: 0.75rem; letter-spacing: 0.1em; text-transform: uppercase;
    }
    .divider::before, .divider::after {
      content: ''; flex: 1; height: 1px; background: rgba(200,153,106,0.4);
    }
  </style>
</head>

<body class="relative z-10">

  <!-- ── Background blobs ── -->
  <div class="blob w-96 h-96 bg-terracotta top-[-60px] left-[-80px]"></div>
  <div class="blob w-72 h-72 bg-tan bottom-32 right-[-60px]"></div>
  <div class="blob w-56 h-56 bg-mocha top-1/2 left-1/3"></div>

  <!-- ═══════════════════════════════════════════════════════ HERO / HEADER -->
  <header class="relative min-h-screen flex flex-col items-center justify-center px-6 py-20 text-center">

    <div class="reveal flex flex-col items-center gap-6" style="transition-delay:0.1s">

      <!-- Avatar with spinning ring -->
      <div class="avatar-ring w-36 h-36 flex-shrink-0">
        <div class="avatar-inner w-full h-full bg-parchment flex items-center justify-center">
          <!-- Placeholder: ganti src dengan foto Anda -->
          <img
            src="https://ui-avatars.com/api/?name=Arkan+Davin&background=C4622D&color=F5EBD8&size=256&bold=true&font-size=0.4"
            alt="Foto Profil"
            class="w-full h-full object-cover"
          />
        </div>
      </div>

      <!-- Name & tagline -->
      <div>
        <h1 class="font-display text-5xl md:text-6xl font-extrabold text-choco leading-tight">
          Arkan Davin
        </h1>
        <p class="mt-2 text-tan font-body text-sm tracking-[0.22em] uppercase">
          Full-Stack Developer &nbsp;·&nbsp; UI/UX Enthusiast
        </p>
        <p class="mt-4 max-w-md text-mocha/70 text-base font-light leading-relaxed">
          Merancang pengalaman digital yang bermakna — dari baris kode hingga antarmuka yang membuat pengguna tersenyum.
        </p>
      </div>

      <!-- CTA -->
      <a href="#contact" class="mt-2 inline-flex items-center gap-2 px-7 py-3 rounded-full bg-terracotta text-cream font-medium text-sm shadow-lg hover:bg-mocha transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
        <i class="fa-solid fa-paper-plane text-xs"></i> Let's Connect
      </a>
    </div>

    <!-- Scroll indicator -->
    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 flex flex-col items-center gap-1 text-tan/60 text-xs tracking-widest uppercase animate-bounce">
      <span>Scroll</span>
      <i class="fa-solid fa-chevron-down text-xs"></i>
    </div>
  </header>

  <!-- ═══════════════════════════════════════════════════════ ABOUT ME -->
  <section id="about" class="relative z-10 max-w-3xl mx-auto px-6 py-20">
    <div class="divider reveal mb-10">About Me</div>

    <div class="reveal glass rounded-3xl p-8 md:p-12" style="transition-delay:0.15s">
      <h2 class="font-display text-3xl md:text-4xl font-bold text-choco mb-6">
        Halo, saya <em class="text-terracotta not-italic">Arkan</em> 👋
      </h2>
      <div class="space-y-4 text-mocha/80 leading-relaxed font-light text-base">
        <p>
          Saya seorang pengembang web yang percaya bahwa teknologi terbaik adalah yang tak terlihat — ia bekerja begitu mulus hingga pengguna hanya merasakan kemudahannya, bukan kerumitannya.
        </p>
        <p>
          Dengan pengalaman di ekosistem <strong class="font-medium text-terracotta">Laravel</strong>, <strong class="font-medium text-terracotta">React</strong>, dan desain berbasis sistem, saya menjembatani kesenjangan antara logika backend yang solid dan antarmuka yang terasa intuitif dan memukau.
        </p>
        <p>
          Di luar layar, saya gemar menjelajahi kedai kopi indie, membaca tentang psikologi desain, dan sesekali mengabadikan momen lewat lensa kamera. Setiap proyek bagi saya adalah kanvas — dan saya selalu ingin melukisnya sebaik mungkin.
        </p>
      </div>

      <!-- Mini stats -->
      <div class="mt-8 grid grid-cols-3 gap-4 text-center">
        <div class="rounded-2xl bg-terracotta/10 py-4 px-2">
          <div class="font-display text-3xl font-bold text-terracotta">3+</div>
          <div class="text-xs text-mocha/60 mt-1">Tahun Pengalaman</div>
        </div>
        <div class="rounded-2xl bg-terracotta/10 py-4 px-2">
          <div class="font-display text-3xl font-bold text-terracotta">40+</div>
          <div class="text-xs text-mocha/60 mt-1">Proyek Selesai</div>
        </div>
        <div class="rounded-2xl bg-terracotta/10 py-4 px-2">
          <div class="font-display text-3xl font-bold text-terracotta">∞</div>
          <div class="text-xs text-mocha/60 mt-1">Secangkir Kopi</div>
        </div>
      </div>
    </div>
  </section>

  <!-- ═══════════════════════════════════════════════════════ SKILLS -->
  <section id="skills" class="relative z-10 max-w-3xl mx-auto px-6 py-16">
    <div class="divider reveal mb-10">Skills & Tools</div>

    <div class="reveal glass rounded-3xl p-8 md:p-12" style="transition-delay:0.15s">
      <p class="text-mocha/60 text-sm mb-8 text-center">Hover pada badge untuk melihat skill yang saya kuasai ✨</p>

      <div class="space-y-6">
        <!-- Frontend -->
        <div>
          <p class="text-xs uppercase tracking-widest text-tan mb-3 font-medium">Frontend</p>
          <div class="flex flex-wrap gap-2">
            <span class="skill-badge"><i class="fa-brands fa-html5"></i> HTML5</span>
            <span class="skill-badge"><i class="fa-brands fa-css3-alt"></i> CSS3</span>
            <span class="skill-badge"><i class="fa-brands fa-js"></i> JavaScript</span>
            <span class="skill-badge"><i class="fa-brands fa-react"></i> React</span>
            <span class="skill-badge">⚡ Vite</span>
            <span class="skill-badge">🌊 Tailwind CSS</span>
            <span class="skill-badge">🎨 Figma</span>
          </div>
        </div>

        <!-- Backend -->
        <div>
          <p class="text-xs uppercase tracking-widest text-tan mb-3 font-medium">Backend</p>
          <div class="flex flex-wrap gap-2">
            <span class="skill-badge"><i class="fa-brands fa-php"></i> PHP</span>
            <span class="skill-badge">🔥 Laravel</span>
            <span class="skill-badge"><i class="fa-brands fa-node-js"></i> Node.js</span>
            <span class="skill-badge">🗄️ MySQL</span>
            <span class="skill-badge">🍃 MongoDB</span>
            <span class="skill-badge">🚀 REST API</span>
          </div>
        </div>

        <!-- DevOps & Tools -->
        <div>
          <p class="text-xs uppercase tracking-widest text-tan mb-3 font-medium">DevOps & Tools</p>
          <div class="flex flex-wrap gap-2">
            <span class="skill-badge"><i class="fa-brands fa-git-alt"></i> Git</span>
            <span class="skill-badge"><i class="fa-brands fa-docker"></i> Docker</span>
            <span class="skill-badge">☁️ AWS</span>
            <span class="skill-badge"><i class="fa-brands fa-linux"></i> Linux</span>
            <span class="skill-badge">🔒 CI/CD</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ═══════════════════════════════════════════════════════ CONTACT -->
  <section id="contact" class="relative z-10 max-w-3xl mx-auto px-6 py-16 pb-32">
    <div class="divider reveal mb-10">Get In Touch</div>

    <div class="reveal glass rounded-3xl p-8 md:p-12 text-center" style="transition-delay:0.15s">
      <h2 class="font-display text-3xl font-bold text-choco mb-3">
        Mari Berkolaborasi
      </h2>
      <p class="text-mocha/60 text-sm leading-relaxed max-w-sm mx-auto mb-8">
        Punya ide proyek menarik? Sedang mencari developer untuk tim Anda? Atau sekadar ingin menyapa — pintu saya selalu terbuka.
      </p>

      <!-- Social Icons -->
      <div class="flex items-center justify-center gap-4 flex-wrap">
        <a href="https://linkedin.com/in/arkan-davin" target="_blank" rel="noopener" class="social-link" title="LinkedIn">
          <i class="fa-brands fa-linkedin-in"></i>
        </a>
        <a href="https://github.com/arkan-davin" target="_blank" rel="noopener" class="social-link" title="GitHub">
          <i class="fa-brands fa-github"></i>
        </a>
        <a href="mailto:arkan@example.com" class="social-link" title="Email">
          <i class="fa-solid fa-envelope"></i>
        </a>
        <a href="https://twitter.com/arkan_davin" target="_blank" rel="noopener" class="social-link" title="Twitter / X">
          <i class="fa-brands fa-x-twitter"></i>
        </a>
        <a href="https://instagram.com/arkan.davin" target="_blank" rel="noopener" class="social-link" title="Instagram">
          <i class="fa-brands fa-instagram"></i>
        </a>
      </div>

      <!-- Email CTA -->
      <div class="mt-8 inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-terracotta/10 border border-terracotta/25 text-terracotta text-sm font-medium">
        <i class="fa-solid fa-at text-xs"></i>
        arkan@example.com
      </div>
    </div>
  </section>

  <!-- ═══════════════════════════════════════════════════════ FOOTER -->
  <footer class="relative z-10 text-center text-tan/50 text-xs pb-6 -mt-10 font-light tracking-wide">
    © 2025 Arkan Davin &mdash; crafted with ☕ &amp; passion
  </footer>

  <!-- ═══════════════════════════════════════════════════════ CHAT WIDGET -->
  <!-- Chat Bubble -->
  <div id="chat-bubble" onclick="toggleChat()" title="Chat dengan saya">
    <i class="fa-solid fa-comment-dots" id="chat-icon"></i>
  </div>

  <!-- Chat Panel -->
  <div id="chat-panel" class="glass shadow-2xl shadow-choco/20">
    <!-- Header -->
    <div class="flex items-center gap-3 px-4 py-3 border-b border-tan/25" style="background:rgba(92,51,23,0.08)">
      <div class="w-8 h-8 rounded-full bg-terracotta flex items-center justify-center text-cream text-xs font-bold flex-shrink-0">AD</div>
      <div class="flex-1">
        <div class="text-choco text-sm font-semibold">Arkan's Bot</div>
        <div class="flex items-center gap-1.5 text-xs text-tan/70">
          <span class="w-1.5 h-1.5 rounded-full bg-green-400 inline-block"></span> Online
        </div>
      </div>
      <button onclick="toggleChat()" class="text-tan/60 hover:text-terracotta transition-colors text-sm">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>

    <!-- Messages -->
    <div id="chat-messages">
      <div class="msg msg-bot">
        Halo! 👋 Saya asisten Arkan. Ada yang bisa saya bantu? Coba tanya tentang <strong>skills</strong>, <strong>proyek</strong>, atau cara <strong>menghubungi</strong> Arkan.
      </div>
    </div>

    <!-- Input row -->
    <div id="chat-input-row" style="background:rgba(245,235,216,0.6)">
      <input id="chat-input" type="text" placeholder="Ketik pesan..." autocomplete="off" onkeydown="if(event.key==='Enter') sendMessage()" />
      <button id="chat-send" onclick="sendMessage()">
        <i class="fa-solid fa-paper-plane text-xs"></i>
      </button>
    </div>
  </div>

  <!-- ═══════════════════════════════════════════════════════ SCRIPTS -->
  <script>
    /* ── Scroll reveal ── */
    const reveals = document.querySelectorAll('.reveal');
    const io = new IntersectionObserver((entries) => {
      entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); io.unobserve(e.target); } });
    }, { threshold: 0.15 });
    reveals.forEach(el => io.observe(el));
    // Trigger visible for hero immediately
    document.querySelectorAll('header .reveal').forEach(el => setTimeout(() => el.classList.add('visible'), 200));

    /* ── Chat toggle ── */
    let chatOpen = false;
    function toggleChat() {
      chatOpen = !chatOpen;
      const panel = document.getElementById('chat-panel');
      const icon  = document.getElementById('chat-icon');
      panel.classList.toggle('open', chatOpen);
      icon.className = chatOpen ? 'fa-solid fa-xmark' : 'fa-solid fa-comment-dots';
    }

    /* ── Chatbot logic ── */
    const responses = {
      skill: [
        "Arkan menguasai Laravel, React, Tailwind CSS, MySQL, dan Docker. Ia juga familiar dengan desain UI/UX menggunakan Figma. 🛠️",
        "Stack utamanya adalah PHP/Laravel di backend dan React + Vite di frontend. Untuk DevOps ia menggunakan Docker & CI/CD pipeline."
      ],
      proyek: [
        "Arkan telah menyelesaikan 40+ proyek, mulai dari platform e-commerce, sistem manajemen klinik, hingga dashboard analitik real-time. 🚀",
        "Beberapa proyek unggulannya termasuk API microservices, mobile-first web app, dan design system berbasis komponen."
      ],
      kontak: [
        "Anda bisa menghubungi Arkan via email di arkan@example.com atau melalui LinkedIn. Ia biasanya membalas dalam 24 jam! 📩",
        "Hubungi Arkan lewat form kontak di halaman ini, atau langsung email ke arkan@example.com."
      ],
      halo: [
        "Halo juga! 😊 Senang bertemu Anda. Ada yang ingin Anda tanyakan tentang Arkan?",
        "Hai! Selamat datang di profil Arkan. Saya siap membantu menjawab pertanyaan Anda! 🙌"
      ],
      default: [
        "Pertanyaan menarik! Untuk jawaban lebih detail, silakan hubungi Arkan langsung di arkan@example.com. 😊",
        "Saya masih belajar menjawab semua pertanyaan. Coba tanya tentang <strong>skill</strong>, <strong>proyek</strong>, atau <strong>kontak</strong> Arkan!",
        "Hmm, saya kurang yakin dengan itu. Tapi Arkan pasti bisa menjawabnya langsung! Cek section Contact di atas. 👆"
      ]
    };

    function pickResponse(text) {
      const t = text.toLowerCase();
      if (/skill|kemampuan|bisa|keahlian|teknologi|laravel|react/.test(t)) return rand(responses.skill);
      if (/proyek|project|kerja|portfolio|buat|develop/.test(t)) return rand(responses.proyek);
      if (/kontak|hubungi|contact|email|linkedin|hire/.test(t)) return rand(responses.kontak);
      if (/halo|hai|hello|hi|hey|apa kabar|selamat/.test(t)) return rand(responses.halo);
      return rand(responses.default);
    }
    function rand(arr) { return arr[Math.floor(Math.random() * arr.length)]; }

    function appendMsg(text, type) {
      const box = document.getElementById('chat-messages');
      const el = document.createElement('div');
      el.className = `msg msg-${type}`;
      el.innerHTML = text;
      box.appendChild(el);
      box.scrollTop = box.scrollHeight;
      return el;
    }

    function showTyping() {
      const box = document.getElementById('chat-messages');
      const el = document.createElement('div');
      el.className = 'msg msg-bot typing-indicator';
      el.id = 'typing';
      el.innerHTML = '<div class="typing-dot"></div><div class="typing-dot"></div><div class="typing-dot"></div>';
      box.appendChild(el);
      box.scrollTop = box.scrollHeight;
    }
    function removeTyping() {
      const el = document.getElementById('typing');
      if (el) el.remove();
    }

    function sendMessage() {
      const input = document.getElementById('chat-input');
      const text = input.value.trim();
      if (!text) return;
      input.value = '';

      appendMsg(text, 'user');

      showTyping();
      const delay = 900 + Math.random() * 800;
      setTimeout(() => {
        removeTyping();
        appendMsg(pickResponse(text), 'bot');
      }, delay);
    }
  </script>
</body>
</html>