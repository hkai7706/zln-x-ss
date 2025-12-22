
  <style>

    nav {
      position: fixed;
      top: 0;
      width: 100%;
      background: rgba(0, 0, 0, 0.3);
      backdrop-filter: blur(10px);
      padding: 1rem 2rem;
      z-index: 1000;
      transition: all 0.3s;
    }

    nav.scrolled {
      background: rgba(0, 0, 0, 0.6);
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    }

    .nav-container {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .logo {
      font-size: 1.5rem;
      font-weight: bold;
      background: linear-gradient(45deg, #ff6b9d, #ffa07a);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      z-index: 1001;
    }

    .nav-links {
      display: flex;
      gap: 2rem;
      list-style: none;
    }

    .nav-links a {
      color: #fff;
      text-decoration: none;
      transition: all 0.3s;
      position: relative;
    }

    .nav-links a:hover {
      color: #ff6b9d;
    }

    .nav-links a::after {
      content: '';
      position: absolute;
      bottom: -5px;
      left: 0;
      width: 0;
      height: 2px;
      background: #ff6b9d;
      transition: width 0.3s;
    }

    .nav-links a:hover::after {
      width: 100%;
    }

    /* Hamburger Menu */
    .hamburger {
      display: none;
      flex-direction: column;
      cursor: pointer;
      z-index: 1001;
    }

    .hamburger span {
      width: 25px;
      height: 3px;
      background: #fff;
      margin: 3px 0;
      transition: all 0.3s;
      border-radius: 2px;
    }

    .hamburger.active span:nth-child(1) {
      transform: rotate(45deg) translate(8px, 8px);
    }

    .hamburger.active span:nth-child(2) {
      opacity: 0;
    }

    .hamburger.active span:nth-child(3) {
      transform: rotate(-45deg) translate(8px, -8px);
    }

    /* Tablet Responsive */
    @media (max-width: 1024px) {
      nav {
        padding: 1rem 1.5rem;
      }

      .nav-links {
        gap: 1.5rem;
      }

      .nav-links a {
        font-size: 0.95rem;
      }
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
      nav {
        padding: 1rem;
      }

      .logo {
        font-size: 1.2rem;
      }

      .hamburger {
        display: flex;
      }

      .nav-links {
        position: fixed;
        top: 0;
        right: -100%;
        height: 100vh;
        width: 70%;
        max-width: 300px;
        background: rgba(0, 0, 0, 0.95);
        backdrop-filter: blur(10px);
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 2rem;
        transition: right 0.3s ease-in-out;
        box-shadow: -5px 0 20px rgba(0, 0, 0, 0.5);
      }

      .nav-links.active {
        right: 0;
      }

      .nav-links li {
        opacity: 0;
        transform: translateX(50px);
        transition: all 0.3s ease-in-out;
      }

      .nav-links.active li {
        opacity: 1;
        transform: translateX(0);
      }

      .nav-links.active li:nth-child(1) { transition-delay: 0.1s; }
      .nav-links.active li:nth-child(2) { transition-delay: 0.2s; }
      .nav-links.active li:nth-child(3) { transition-delay: 0.3s; }
      .nav-links.active li:nth-child(4) { transition-delay: 0.4s; }
      .nav-links.active li:nth-child(5) { transition-delay: 0.5s; }
      .nav-links.active li:nth-child(6) { transition-delay: 0.6s; }

      .nav-links a {
        font-size: 1.2rem;
      }
    }

    /* Small Mobile Devices */
    @media (max-width: 480px) {
      nav {
        padding: 0.75rem;
      }

      .logo {
        font-size: 1rem;
      }

      .hamburger span {
        width: 22px;
        height: 2.5px;
      }

      .nav-links {
        width: 80%;
      }

      .nav-links a {
        font-size: 1.1rem;
      }
    }

    /* Extra Small Devices */
    @media (max-width: 360px) {
      .logo {
        font-size: 0.9rem;
      }

      .nav-links {
        width: 85%;
      }

      .nav-links a {
        font-size: 1rem;
      }
    }

  </style>

  <nav id="navbar">
    <div class="nav-container">
   <a href="/" style="text-decoration:none;" >   <div class="logo">Zay & Shwe ❤️</div></a>
      <div class="hamburger" id="hamburger">
        <span></span>
        <span></span>
        <span></span>
      </div>
      <ul class="nav-links" id="navLinks">
        <li><a href="/">Home</a></li>
        <li><a href="#message">Message</a></li>
      <li><a href="{{ url('/gallery') }}">Gallery</a></li>
        <li><a href="#timeline">Timeline</a></li>
        <li><a href="{{ url('/keepsakes') }}">Memories</a></li>
        <li><a href="#countdown">Countdown</a></li>
      </ul>
    </div>
  </nav>



  <script>
    // Hamburger menu toggle
    const hamburger = document.getElementById('hamburger');
    const navLinks = document.getElementById('navLinks');

    hamburger.addEventListener('click', () => {
      hamburger.classList.toggle('active');
      navLinks.classList.toggle('active');
    });

    // Close menu when clicking on a link
    document.querySelectorAll('.nav-links a').forEach(link => {
      link.addEventListener('click', () => {
        hamburger.classList.remove('active');
        navLinks.classList.remove('active');
      });
    });

    // Close menu when clicking outside
    document.addEventListener('click', (e) => {
      if (!e.target.closest('.nav-container')) {
        hamburger.classList.remove('active');
        navLinks.classList.remove('active');
      }
    });

    // Navbar scroll effect
    window.addEventListener('scroll', () => {
      const navbar = document.getElementById('navbar');
      if (navbar) {
        navbar.classList.toggle('scrolled', window.scrollY > 100);
      }
    });

    // Smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
          target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
        }
      });
    });
  </script>
