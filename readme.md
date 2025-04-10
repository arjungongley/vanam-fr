# Vanam - Professional Supplier Portal

> A modern, responsive web platform for Vanam SARL's supplier and customer interactions.

## Overview

Vanam is a professional B2B supplier platform specializing in sports equipment and cosmetics distribution since 1985. This repository contains the frontend codebase for Vanam's web presence.

## Key Features

- Responsive design optimized for all devices
- Modern UI with Tailwind CSS
- Interactive product showcases
- Customer testimonial carousel using Swiper.js
- SEO-optimized structure
- Contact form integration
- Privacy policy and terms & conditions pages
- Enhanced security headers configuration

## Tech Stack

- **HTML5** - Semantic markup structure
- **CSS3/Tailwind CSS** - Utility-first styling framework
- **JavaScript** - Vanilla JS for interactive features
- **Swiper.js** - Touch-enabled slider library

## Project Structure

```
vanam-fr/
├── css/
│   └── style.css          # Compiled Tailwind CSS
├── images/               # Image assets
├── js/
│   └── script.js         # Core JavaScript functionality
├── src/
│   └── input.css        # Tailwind source CSS
├── index.html           # Homepage
├── contact.html         # Contact page
├── privacy-policy.html  # Privacy policy
├── terms-and-conditions.html
├── package.json         # Project dependencies
└── tailwind.config.js   # Tailwind configuration
```

## Development Guide

### Prerequisites

- Node.js and npm installed
- Basic knowledge of HTML, CSS, and JavaScript
- Understanding of Tailwind CSS

### Creating New Pages

1. Create a new HTML file using the following template:

```html
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Vanam</title>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" /> <!-- Include for sliders -->
        <link rel="stylesheet" href="css/style.css" />
    </head>
    <body class="bg-white">
        <!-- Your content here -->
        
        <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>  <!-- Include for sliders -->
        <script src="js/script.js"></script>
    </body>
</html>
```

2. After adding new Tailwind classes, rebuild the CSS:

```bash
npm run build:css
```

### Important Notes

- The `src/input.css` file is essential for Tailwind CSS compilation - do not remove it
- Always include `script.js` for core functionality
- Include Swiper.js files only if you need slider functionality
- Maintain consistent styling using Tailwind utility classes

## Browser Support

The website is optimized for modern browsers including:
- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)

## Security Configuration

### Netlify Deployment
Security headers are automatically configured through the `netlify.toml` file in the root directory.

### Nginx Server Configuration
If deploying to a custom Nginx server, add the following configuration to your server block:

```nginx
server {
    # ... other server configurations ...

    # Security Headers
    add_header Strict-Transport-Security "max-age=31536000; includeSubDomains; preload" always;
    add_header Content-Security-Policy "default-src 'self' https:; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://unpkg.com https://fonts.googleapis.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://unpkg.com; img-src 'self' data: https:; font-src 'self' https://fonts.gstatic.com; connect-src 'self' https:; frame-src 'self' https:; object-src 'none'" always;
    add_header X-Frame-Options "DENY" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header Referrer-Policy "strict-origin-when-cross-origin" always;
    add_header Permissions-Policy "accelerometer=(), camera=(), geolocation=(), gyroscope=(), magnetometer=(), microphone=(), payment=(), usb=()" always;
    add_header X-XSS-Protection "1; mode=block" always;

    # SSL Configuration (recommended)
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_prefer_server_ciphers on;
    ssl_ciphers ECDHE-ECDSA-AES128-GCM-SHA256:ECDHE-RSA-AES128-GCM-SHA256:ECDHE-ECDSA-AES256-GCM-SHA384:ECDHE-RSA-AES256-GCM-SHA384:ECDHE-ECDSA-CHACHA20-POLY1305:ECDHE-RSA-CHACHA20-POLY1305:DHE-RSA-AES128-GCM-SHA256:DHE-RSA-AES256-GCM-SHA384;

    # Enable OCSP stapling
    ssl_stapling on;
    ssl_stapling_verify on;
    resolver 8.8.8.8 8.8.4.4 valid=300s;
    resolver_timeout 5s;

    # Additional security measures
    server_tokens off;
    client_max_body_size 10M;
    keepalive_timeout 65;
}
```

### Security Headers Explanation

1. **Strict-Transport-Security**: Forces HTTPS connections
2. **Content-Security-Policy**: Controls resource loading permissions
3. **X-Frame-Options**: Prevents clickjacking attacks
4. **X-Content-Type-Options**: Prevents MIME type sniffing
5. **Referrer-Policy**: Controls referrer information sharing
6. **Permissions-Policy**: Restricts browser feature access
7. **X-XSS-Protection**: Additional XSS protection for older browsers

### SSL Configuration
- Uses modern TLS protocols (1.2 and 1.3)
- Implements secure cipher suites
- Enables OCSP stapling
- Disables server tokens
- Sets reasonable limits for request body size and keepalive

> For optimal development experience, install the [Markdown Viewer extension](https://chromewebstore.google.com/detail/markdown-viewer/ckkdlimhmcjmikdlpkmbgfkaikojcbjk) in your browser.
