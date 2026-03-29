# Ukrbud.lt — Professional Cleaning in Vilnius

A modern multilingual website for the cleaning company **Ukrbud.lt**, specializing in professional post-renovation cleaning, office cleaning, and commercial premises cleaning in Vilnius and surrounding areas.

<img src="header.jpg" alt="Header Section" width="1000" />

## ✨ Key Features of the Website

- **Full Multilingual Support** — 5 languages: Lithuanian, Russian, Ukrainian, English, and Norwegian
- **Interactive Online Price Calculator** for different types of cleaning (post-renovation, offices, commercial spaces)
- **Smart AI Consultant** powered by Grok xAI — a chatbot that speaks first and helps users place an order
- **GDPR-compliant Consent Banner** with the ability to reject and re-accept cookies
- **Beautiful Automated Emails** for order confirmation and 30% discount subscription
- **Partners Section** with links to trusted partner companies
- **Advanced SEO Optimization** with proper hreflang tags, Schema.org markup, and microdata
- **Modern Responsive Design** with smooth animations and high conversion focus

<img src="content.jpg" alt="Main Content Preview" width="1000" />

### GDPR Consent Banner

<img src="gdpr.jpg" alt="GDPR Consent Banner" width="800" />

A modern and user-friendly cookie consent banner that fully complies with GDPR requirements.

**Banner Features:**
- Automatic language detection based on the current page
- Two clear buttons: **"I Agree"** and **"Reject"**
- When rejected, a non-blocking amber warning message appears at the top (does not block the site)
- Option to **"Accept cookies again"** directly from the warning message
- User choice is saved in `localStorage`
- Fully responsive and accessible design

**Supported Languages for the Banner:**
- Lithuanian (LT)
- Russian (RU)
- Ukrainian (UK)
- English (EN)
- Norwegian (NO)

### AI Consultant (Grok xAI)

An intelligent chatbot integrated into the website:

- Automatically opens 4 seconds after page load
- Speaks **first** with a friendly greeting message
- Supports all languages of the site
- Helps the client calculate the price, clarify details, and place an order
- Sends all conversations to the administrator via Telegram
- Saves conversation history for each user

### Our Partners Section

The website features reliable partners:
- **Baltic Clean** — Professional Cleaning Services
- **Meistru.lt** — Repair and Construction Services
- **Bilohash.com** — Web Development & Digital Solutions

### Technical Features

- Single file `gdpr-consent.php` serves all language versions
- Full support for `hreflang` and `canonical` tags for correct indexing
- Extended Schema.org markup (LocalBusiness + Service + FAQPage)
- Beautiful automated HTML emails for order confirmation and 30% discount
- Protection against spam and CSRF attacks
- Fully responsive design (mobile + desktop)

<img src="footer.jpg" alt="Footer Section" width="1000" />

## Supported Languages

| Language      | Code | File          |
|---------------|------|---------------|
| Lithuanian    | lt   | `index.php`   |
| Russian       | ru   | `ru.php`      |
| Ukrainian     | uk   | `ua.php`      |
| English       | en   | `en.php`      |
| Norwegian     | no   | (support added) |

---

### How the GDPR Banner Works

1. On the first visit, a consent banner appears at the bottom of the screen.
2. The user can choose **"I Agree"** or **"Reject"**.
3. If rejected, a soft amber warning message appears at the top with an explanation and a button **"Accept cookies again"**.
4. The user's choice is saved in the browser.

The banner fully complies with GDPR requirements and maintains a good balance between user experience and legal compliance.

---

Ready for use.

Would you like me to expand this description further with sections like **Technical Stack**, **Installation Instructions**, **Project Structure**, or detailed information about how the AI Consultant works?
