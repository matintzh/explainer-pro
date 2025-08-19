# Explainer Pro

**Explainer Pro** is a lightweight and highly customizable WordPress plugin that enables authors to highlight technical terms in posts and pages. Clicking the highlight opens a popup with rich explanatory content—perfect for glossaries, tutorials, or educational content.

[🔍 View Demo](https://matinsaber.com/explainer-pro/)

---

##  Features

- **Custom Shortcode Generator** — Easy shortcode `[popup_hint term="..." description="..."]` to embed hints anywhere.
- **Flexible Styling Options** — Customize font size, colors, icon size, tooltip box padding, margins, shadows, and more from settings.
- **Custom CSS & JS Support** — Add your own code for full creative control.
- **Responsive & Lightweight** — Designed to work seamlessly on desktop and mobile.
- **Admin & Frontend Separation** — Cleaner performance and better organization.
- **TinyMCE Button** — Quick access to insert hints while editing content.
- **AJAX-powered Shortcode Generator** — Optional admin utility for live shortcode previews.

---

##  Installation

1. **Clone** or download this repository into `wp-content/plugins/explainer-pro`.
2. **Activate** the plugin via the WordPress admin under **Plugins → Installed Plugins**.
3. Navigate to **Settings → Explainer Pro** to configure default styles and behavior.

---

##  Usage

- Use the shortcode manually:
  ```text
  [popup_hint term="Your Term" description="Your Explanation"]
````

* From the admin settings, customize term styles, tooltip box appearance, and other visuals.
* Add your own CSS or JavaScript under **Custom Code** for additional enhancements.

---

## Development

* **Frontend assets** (`popup-hint.css`, `popup-hint.js`) are conditionally enqueued only on singular views to optimize performance.
* **Admin assets** (`popup-hint-admin.css`, `popup-hint-admin.js`) plus shortcode helper UI included via AJAX.
* **Shortcode generator** in admin uses secure AJAX callbacks with nonces.
* **TinyMCE integration** for easy visual hint insertion.

---

## Contributing

Pull requests and issues are welcome! Please follow the project's coding standards and include documentation with your updates.

---

## License

This project is licensed under the **GPL v2 or later**—see the LICENSE file for details.

```

---

Would you like me to help convert this into a `README.md` with proper markdown styling (headings, bullet lists, links)? Or assist with adding badges (e.g. build status, license, WordPress version compatibility)? Let me know—happy to help!
::contentReference[oaicite:0]{index=0}
```
