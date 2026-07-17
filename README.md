<div align="center">
  <img src="https://raw.githubusercontent.com/digitalchokro/askchokro/main/docs/assets/logo.png" width="120" alt="AskChokro Logo" />
  <h1 style="border-bottom: none; margin-bottom: 0;">AskChokro WordPress Plugin</h1>
  <p><strong>The High-Performance AI Data Engine for WordPress</strong></p>
  <p>Zero-code AI integration for WordPress using the AskChokro Microservice.</p>

  <p>
    <a href="https://wordpress.org/plugins/askchokro"><img src="https://img.shields.io/badge/WordPress-Plugin-252525.svg?style=for-the-badge&logo=wordpress" alt="WordPress Plugin" /></a>
    <a href="https://opensource.org/licenses/MIT"><img src="https://img.shields.io/badge/License-MIT-252525.svg?style=for-the-badge" alt="License: MIT" /></a>
  </p>
</div>

<br/>
<p align="center">
  <picture>
    <img src="https://raw.githubusercontent.com/digitalchokro/askchokro/main/docs/assets/logo.png" width="800" height="2" style="background: linear-gradient(90deg, transparent, #252525, #8e9eab, #252525, transparent); border-radius: 5px;"/>
  </picture>
</p>
<br/>

## Overview

AskChokro allows you to embed a powerful Natural Language to SQL AI assistant directly into your WordPress site. Engineered for scale, it turns your WordPress database into an interactive analytics engine without writing a single line of code.

**Note:** This plugin requires you to run the AskChokro Microservice (Docker) connected to your WordPress database.

## Features

- **Zero-Code Integration:** Simply drop the `[askchokro]` shortcode on any page or post.
- **Microservice Architecture:** Offloads heavy AI processing to the dedicated AskChokro Node.js microservice.
- **Enterprise Security:** Secured via JWT authentication to ensure only authorized frontend components can query the database.
- **Modern Chat UI:** A sleek, reactive frontend built directly into the WordPress ecosystem.

```mermaid
sequenceDiagram
    participant Browser
    participant WP as WordPress Server
    participant MS as AskChokro Microservice
    participant DB as SQL Database
    
    Browser->>WP: User Types Question
    WP->>WP: Validate JWT & Nonce
    WP->>MS: Forward Question + Credentials
    MS->>DB: Execute AI-Generated SQL
    DB-->>MS: Return Rows
    MS-->>WP: Return Formatted Answer & Chart
    WP-->>Browser: Render Answer to User
```

<br/>
<p align="center">
  <picture>
    <img src="https://raw.githubusercontent.com/digitalchokro/askchokro/main/docs/assets/logo.png" width="800" height="1" style="background: linear-gradient(90deg, transparent, #252525, transparent);"/>
  </picture>
</p>
<br/>

## Installation

1. Upload the plugin files to the `/wp-content/plugins/askchokro` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Navigate to **Settings -> AskChokro** and enter your Microservice URL and JWT Secret.
4. Use the `[askchokro]` shortcode to display the chat interface anywhere on your site.

## Configuration

To securely connect your WordPress site to the AskChokro Microservice, you need to configure the following settings:

- **Microservice URL:** The endpoint where your AskChokro Docker instance is hosted (e.g., `https://api.yourdomain.com/ask`).
- **JWT Secret:** The shared secret used to sign authentication tokens. This must exactly match the secret configured in your microservice environment.

## License

MIT © Digital Chokro
