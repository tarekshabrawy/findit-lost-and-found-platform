# FindIt Lost & Found Platform

FindIt is a full-stack web-based lost and found platform designed to help students report, search, and recover misplaced belongings through a centralized and community-driven system.

The platform allows users to create accounts, publish lost or found item posts, upload images, comment on reports, update item status, and interact with other users through a social-style interface. The system also includes profile management, responsive design, dark/light theme support, and an admin dashboard for moderation.

---

# Features

- User Registration & Authentication
- Lost Item Reporting
- Found Item Reporting
- Image Upload Support
- Community Feed
- Comment System
- Item Status Tracking
- User Profile Management
- Admin Dashboard & Moderation
- Dark/Light Theme Support
- Responsive User Interface

---

# Technologies Used

- PHP
- MySQL
- HTML5
- CSS3
- JavaScript
- XAMPP

---

# System Architecture

FindIt follows a traditional three-layer web architecture:

## Presentation Layer
Handles:
- User Interface
- Responsive Design
- Theme Switching
- Navigation Menu
- Client-side Interaction

Technologies:
- HTML
- CSS
- JavaScript

---

## Application Layer
Handles:
- Authentication
- Session Management
- Post Creation
- Comment Handling
- Profile Management
- Admin Operations

Technology:
- PHP

---

## Data Layer
Handles:
- User Data
- Posts
- Comments
- Images
- Status Tracking

Technology:
- MySQL

---

# Main Modules

## Authentication Module
- User registration
- Login & logout
- Session handling
- Role management

## Community Feed Module
- Lost/found item posts
- Image uploads
- Comments
- Status updates

## Profile Module
- Profile editing
- Profile pictures
- User information management

## Admin Dashboard
- User moderation
- Post moderation
- Comment management

---

# Database Design

The platform uses three main database tables:

| Table | Purpose |
|------|------|
| users | Stores account and profile information |
| posts | Stores lost/found item reports |
| comments | Stores user comments |

---

# Project Structure

```bash
findit-lost-and-found-platform/
│
├── database/
├── uploads/
├── css/
├── js/
├── docs/
├── login.php
├── register.php
├── feed.php
├── profile.php
├── admin_dashboard.php
└── README.md
```

---

# Main Workflow

1. User registers or logs in
2. User creates lost/found item post
3. Image is uploaded and stored
4. Post appears in community feed
5. Other users can comment or interact
6. Item status can be updated
7. Admin can moderate platform content

---

# Future Improvements

- Direct messaging between users
- Advanced search and filtering
- Email notifications
- QR-code item tracking
- AI-based item matching
- Live deployment

---

# Documentation

Full IEEE-style technical documentation is included inside the repository:

```bash
docs/FindIt_IEEE_Documentation.docx
```

---

# Author

Tarek Shabrawy
Ali Hamdy 
Youssef Assem
