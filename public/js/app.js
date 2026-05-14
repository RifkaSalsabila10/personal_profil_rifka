/* ── Scroll Reveal ── */
const reveals = document.querySelectorAll('.reveal');
const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('visible');
      observer.unobserve(entry.target);
    }
  });
}, { threshold: 0.15 });

reveals.forEach(el => observer.observe(el));

// Hero langsung visible tanpa tunggu scroll
document.querySelectorAll('header .reveal').forEach(el => {
  setTimeout(() => el.classList.add('visible'), 200);
});


/* ── Chat Toggle ── */
let chatOpen = false;

function toggleChat() {
  chatOpen = !chatOpen;
  const panel = document.getElementById('chat-panel');
  const icon  = document.getElementById('chat-icon');
  panel.classList.toggle('open', chatOpen);
  icon.className = chatOpen ? 'fa-solid fa-xmark' : 'fa-solid fa-comment-dots';
}

document.getElementById('chat-bubble').addEventListener('click', toggleChat);
document.getElementById('chat-close').addEventListener('click', toggleChat);


/* ── Chatbot Responses ── */
const responses = {
  skill: [
    "Rifka menguasai HTML, CSS, JavaScript, Tailwind CSS, dan Figma untuk frontend. Di backend ia pakai PHP, Laravel, Node.js, dan MySQL. 🛠️",
    "Stack utama Rifka adalah Laravel di backend dan Tailwind CSS di frontend. Untuk tools ia pakai Git."
  ],
  proyek: [
    "Rifka sedang aktif mengerjakan proyek-proyek kuliah dan mandiri sebagai bagian dari perjalanan belajarnya di jurusan TRPL. 🚀",
    "Sebagai mahasiswa TRPL, Rifka terus mengasah skill lewat proyek nyata  dari web sederhana sampai aplikasi berbasis Laravel."
  ],
  kontak: [
    "Kamu bisa hubungi Rifka via email di salsabilarifka5@gmail.com atau lewat Whatsapp. 📩",
    "Hubungi Rifka lewat section Contact di halaman ini, atau langsung email ke salsabilarifka5@gmail.com."
  ],
  halo: [
    "Halo juga! 😊 Senang bertemu kamu, Ada yang ingin ditanyakan tentang Rifka?",
    "Hai! Selamat datang di profil Rifka. Saya siap bantu jawab pertanyaan kamu! 🙌"
  ],
  default: [
    "Pertanyaan menarik! Untuk jawaban lebih detail, silakan hubungi Rifka langsung di salsabilarifka5@gmail.com. 😊",
    "Coba tanya tentang <strong>skill</strong>, <strong>proyek</strong>, atau <strong>kontak</strong> Rifka ",
    "Hmm, saya kurang yakin soal itu. Tapi Rifka pasti bisa jawab langsung jika ada waktu! Cek section Contact di atas. 👆"
  ]
};

function pickResponse(text) {
  const t = text.toLowerCase();
  if (/skill|kemampuan|bisa|keahlian|teknologi|laravel|react/.test(t)) return rand(responses.skill);
  if (/proyek|project|kerja|portfolio|buat|develop/.test(t))           return rand(responses.proyek);
  if (/kontak|hubungi|contact|email|linkedin|hire/.test(t))            return rand(responses.kontak);
  if (/halo|hai|hello|hi|hey|apa kabar|selamat/.test(t))              return rand(responses.halo);
  return rand(responses.default);
}

function rand(arr) {
  return arr[Math.floor(Math.random() * arr.length)];
}


/* ── Chat UI Helpers ── */
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
  el.innerHTML = `
    <div class="typing-dot"></div>
    <div class="typing-dot"></div>
    <div class="typing-dot"></div>
  `;
  box.appendChild(el);
  box.scrollTop = box.scrollHeight;
}

function removeTyping() {
  const el = document.getElementById('typing');
  if (el) el.remove();
}


/* ── Send Message ── */
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

// Trigger kirim pakai tombol atau Enter
document.getElementById('chat-send').addEventListener('click', sendMessage);
document.getElementById('chat-input').addEventListener('keydown', (e) => {
  if (e.key === 'Enter') sendMessage();
});


/* NAVBAR */

// Load navbar dari navbar.html lalu pasang semua logikanya
fetch('navbar.html')
  .then(res => res.text())
  .then(html => {
    const container = document.createElement('div');
    container.innerHTML = html;
    document.body.prepend(container.firstElementChild);
    initNavbar();
  });

function initNavbar() {
  const navbar    = document.getElementById('navbar');
  const toggle    = document.getElementById('nav-toggle');
  const mobileMenu = document.getElementById('nav-mobile');
  const navLinks  = document.querySelectorAll('.nav-link, .nav-link-mobile');

  // ── Scroll: tambah class .scrolled saat user scroll ke bawah
  window.addEventListener('scroll', () => {
    navbar.classList.toggle('scrolled', window.scrollY > 40);
  });

  // ── Hamburger toggle (mobile)
  toggle.addEventListener('click', () => {
    const isOpen = toggle.classList.toggle('open');
    toggle.setAttribute('aria-expanded', isOpen);
    mobileMenu.style.maxHeight = isOpen
      ? mobileMenu.scrollHeight + 'px'
      : '0';
  });

  // ── Tutup mobile menu saat link diklik
  navLinks.forEach(link => {
    link.addEventListener('click', () => {
      toggle.classList.remove('open');
      toggle.setAttribute('aria-expanded', 'false');
      mobileMenu.style.maxHeight = '0';
    });
  });

  // ── Active link berdasarkan section yang sedang terlihat
  const sections = document.querySelectorAll('section[id], header[id]');
  const desktopLinks = document.querySelectorAll('.nav-link');

  const sectionObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        desktopLinks.forEach(link => {
          link.classList.toggle(
            'active',
            link.getAttribute('href') === '#' + entry.target.id
          );
        });
      }
    });
  }, { threshold: 0.4 });

  sections.forEach(sec => sectionObserver.observe(sec));
}