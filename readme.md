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

> For optimal development experience, install the [Markdown Viewer extension](https://chromewebstore.google.com/detail/markdown-viewer/ckkdlimhmcjmikdlpkmbgfkaikojcbjk) in your browser.
