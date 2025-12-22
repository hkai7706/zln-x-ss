  

    <style>
  

        footer {
            width: 100%;
            background: linear-gradient(135deg, #ec6b9fff 0%, #ffe4f0 100%);
            padding: 60px 40px 40px;rgba(195, 107, 195, 1)rgba(171, 71, 111, 1)
            position: relative;
            overflow: hidden;
            box-shadow: 0 -4px 20px rgba(235, 86, 108, 0.65);
        }

        footer::before {
            content: '♥';
            position: absolute;
            top: -20px;
            left: 15%;
            font-size: 40px;
            color: rgba(255, 182, 193, 0.3);
            animation: float 6s ease-in-out infinite;
        }

        footer::after {
            content: '♥';
            position: absolute;
            bottom: 30px;
            right: 20%;
            font-size: 30px;
            color: rgba(255, 182, 193, 0.25);
            animation: float 8s ease-in-out infinite 2s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(10deg); }
        }
  .social-icons {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .social-icon {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            cursor: pointer;
            backdrop-filter: blur(10px);
        }

        .social-icon:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .footer-logo {
            font-size: 28px;
            color: #d4526e;
            margin-bottom: 30px;
            font-weight: 300;
            letter-spacing: 2px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .footer-logo::before,
        .footer-logo::after {
            content: '❤';
            font-size: 20px;
            opacity: 0.7;
        }

        .footer-nav {
            display: flex;
            justify-content: center;
            gap: 50px;
            margin-bottom: 35px;
            flex-wrap: wrap;
        }

        .footer-nav a {
            color: #a0516d;
            text-decoration: none;
            font-size: 16px;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            position: relative;
            padding: 5px 0;
        }

        .footer-nav a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 1px;
            background: #d4526e;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .footer-nav a:hover {
            color: #d4526e;
        }

        .footer-nav a:hover::after {
            width: 100%;
        }

        .divider {
            width: 60px;
            height: 1px;
            background: linear-gradient(90deg, transparent, #ffb6c1, transparent);
            margin: 25px auto;
        }

        .footer-message {
            color: #8d4a5e;
            font-size: 14px;
            line-height: 1.8;
            font-style: italic;
            margin-bottom: 20px;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .footer-bottom {
            color: #a0738f;
            font-size: 13px;
            letter-spacing: 0.5px;
        }

        .heart-accent {
            display: inline-block;
            color: #d4526e;
            animation: pulse 2s ease-in-out infinite;
            margin: 0 3px;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        @media (max-width: 768px) {
            footer {
                padding: 50px 25px 30px;
            }

            .footer-nav {
                gap: 30px;
            }

            .footer-logo {
                font-size: 24px;
            }

            .footer-nav a {
                font-size: 15px;
            }
        }
    </style>
</head>
<body>
    <footer>
        <div class="footer-content">
            <div class="footer-logo">
                Forever Yours
            </div>
            
            <nav class="footer-nav">
                <a href="#about">About Us</a>
                <a href="#story">Our Love Story</a>
                <a href="#contact">Contact</a>
            </nav>
            
            <div class="divider"></div>
            
  <div class="social-icons">
                <div class="social-icon">♥</div>
                <div class="social-icon">✉</div>
                <div class="social-icon">★</div>
                <div class="social-icon">♫</div>
            </div>

            <p class="footer-message">
                Every love story is beautiful, but ours is my favorite
            </p>
            
            <div class="footer-bottom">
                © 2024 Made with <span class="heart-accent">♥</span> for you
            </div>
        </div>
    </footer>

  
  
  

   