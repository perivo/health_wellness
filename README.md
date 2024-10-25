# Health & Wellness Web Application

## Overview
The **Health & Wellness Web Application** is a responsive, feature-rich platform that promotes healthy living through personalized diet plans, yoga exercises, and informative articles. Built for both users and administrators, this application provides a user-friendly interface for accessing health resources, managing personal profiles, and engaging with a supportive wellness community. The administrator dashboard enables streamlined content and user management, ensuring the platform remains informative, secure, and up-to-date.

## Features
### User Features
- **Personal Profile**: Users can create and customize profiles, adding health metrics such as height, weight, and dietary preferences.
- **Diet Planner**: Tailored diet suggestions based on personal preferences and goals.
- **Yoga Exercises**: Access a library of yoga poses and exercises with descriptions and images.
- **Health Articles**: Explore articles on health and wellness curated by the admin.
- **Contact Form**: Users can send inquiries or feedback directly to the admin.

### Admin Features
- **Dashboard**: Admins can monitor platform activity, manage users, and gain insights.
- **User Management**: View, edit, or delete user accounts.
- **Content Management**: Publish, update, and delete articles and yoga exercises.
- **Contact Messages**: View and respond to messages from users via the contact form.

---

## Project Structure
```plaintext
health_wellness/
├── assets/
│   ├── css/
│   │   └── style.css           # Custom CSS styles
│   ├── js/
│   │   └── scripts.js          # JavaScript functionality
│   └── images/                 # Application images
├── auth/
│   ├── login.php               # User login page
│   ├── logout.php              # User logout page
│   └── register.php            # User registration page
├── admin/
│   ├── dashboard.php           # Admin dashboard
│   ├── manage_users.php        # User management by admin
│   ├── manage_articles.php     # Article management by admin
│   ├── manage_contacts.php     # Contact messages management
│   └── admin_login.php         # Admin login page
├── includes/
│   ├── db.php                  # Database connection
│   ├── header.php              # Header with navigation
│   ├── footer.php              # Footer with common scripts
│   └── functions.php           # Commonly used functions
├── pages/
│   ├── home.php                # Home page with about and articles
│   ├── exercises.php           # Yoga exercises page
│   ├── diet_planner.php        # Diet planner page
│   ├── profile.php             # User profile page
│   └── contact.php             # Contact form for users
├── README.md                   # Project documentation
└── sql/
    └── schema.sql              # Database schema
```

---

## Technologies Used
- **Frontend**: HTML5, CSS3, JavaScript, [Bootstrap](https://getbootstrap.com/) for responsive design.
- **Backend**: PHP (version 7.4+)
- **Database**: MySQL/MariaDB for storing user, content, and contact data.
- **Version Control**: Git for tracking changes and collaboration.

---

## Setup Instructions

### Prerequisites
- **Web Server**: Apache/Nginx
- **Database**: MySQL or MariaDB
- **PHP**: Version 7.4 or higher
- **Git**: For cloning and version control

### Installation

1. **Clone the Repository**
    ```bash
    git clone https://github.com/perivo/health_wellness.git
    cd health_wellness
    ```

2. **Database Configuration**
    - Import the database schema file located in `sql/`:
      ```sql
      mysql -u root -p health_wellness < sql/schema.sql
      ```
    - Update the database configuration in `includes/db.php`:
      ```php
      $servername = "localhost";
      $username = "your_db_username";
      $password = "your_db_password";
      $dbname = "health_wellness";
      ```

3. **Admin Account Setup**
    - To create an admin, insert a new entry in the `admins` table with a hashed password. For example:
      ```sql
      INSERT INTO admins (username, email, password) 
      VALUES ('admin', 'admin@example.com', 'hashed_password');
      ```

4. **Run the Application**
    - Access the project by navigating to the local URL (e.g., `http://localhost/health_wellness/pages/home.php`) on your browser.

### Usage

- **User Registration/Login**: Users can create an account or log in to access health resources and manage their profiles.
- **Admin Access**: The admin panel is accessible via `admin/admin_login.php`, where admin credentials allow for full access to user and content management features.

---

## Database Schema
### Tables
1. **users**: Stores user details including personal information and health metrics.
2. **admins**: Contains admin credentials for the backend dashboard.
3. **articles**: Stores health and wellness articles.
4. **yoga_exercises**: Contains yoga exercises with descriptions and images.
5. **diet_plans**: Holds diet plan details and descriptions.
6. **contact_messages**: Captures user messages sent through the contact form.

### Relationships
- **User & Diet Plans**: Many-to-Many (via user_diet_preferences table).
- **User & Articles**: One-to-Many relationship, enabling users to access multiple articles.
- **Admin & Content**: Admin has control over all platform content.

---

## Contributing

Contributions are welcome! To get started:
1. Fork the repository.
2. Create a new branch:
    ```bash
    git checkout -b feature-name
    ```
3. Make your changes and commit them:
    ```bash
    git commit -m 'Add new feature'
    ```
4. Push to your fork and create a pull request.

---

## Author
- **Name**: Ivo Pereira
- **Email**: [ivopereiraix3@gmail.com](mailto:ivopereiraix3@gmail.com)
- **GitHub**: [perivo](https://github.com/perivo)
- **Contact**: WhatsApp +91 9403765835

---

## License
This project is licensed under the MIT License - see the LICENSE file for details.

## Acknowledgments
This project is designed as a part of an initiative to promote health and wellness awareness and offers a platform for users to engage in self-care practices through structured diet and exercise plans.