# platform-social-media
🌐 Mini Social Media Platform

A beginner-friendly PHP social media web application built while learning backend web development, PHP, MySQL, PDO, authentication, file uploads, and CRUD operations.

The project allows users to create accounts, log in, create posts with images, search posts, view post details, manage their profiles, and delete their own posts.

✨ Features
👤 Authentication
User registration
Email validation
Password strength validation
Password confirmation
Password hashing using password_hash()
User login
Password verification using password_verify()
Authentication using cookies
Logout functionality
📝 Posts
Create new posts
Add text to posts
Upload images with posts
Image preview before uploading
View posts in a global feed
View individual post details
Delete your own posts
Automatically remove the uploaded image when a post is deleted
🔎 Search
Search posts by their text
Display search results
Search page and global feed search
👤 Profile
View the logged-in user's name
Edit full name
Change password
Verify the current password before changing it
Validate the strength of the new password
🛡️ Validation & Security

The project includes several backend validation and security practices:

PDO prepared statements
Password hashing with password_hash()
Password verification with password_verify()
Email validation with filter_var()
Input sanitization when displaying user-generated content using htmlspecialchars()
Image extension validation
Image type validation using getimagesize()
Maximum image size of 5MB
Users can only delete their own posts
🛠️ Technologies Used
PHP
MySQL
PDO
HTML5
CSS3
JavaScript
📂 Main Project Structure
project/
│
├── projectregistercs333.php   # User registration
├── projectlogin333.php        # User login
├── projecthome333.php         # Global feed
├── projectcreate333.php       # Create a post
├── projectdetail333.php       # View post details
├── projectdelete333.php       # Delete own posts
├── editprofile.php            # Edit profile / change password
├── projectsearch333.php       # Search posts
├── logout333.php              # Logout
├── nav333.php                 # Navigation
├── con.php                    # Database connection
├── project.css               # Project styling
│
└── uploads/                   # Uploaded post images

🗄️ Database

The project uses a MySQL database with users and posts.

The main tables are:

users

Stores user account information such as:

User ID
Full name
Email
Password hash
posts

Stores post information such as:

Post ID
User ID
Post text
Image path
Creation date

The posts.user_id connects posts to their authors.

🚀 How to Run
1. Install a local PHP environment

You can use a local development environment such as XAMPP, WAMP, or another PHP/MySQL server.

2. Create the database

Create a MySQL database and add the required users and posts tables.

3. Configure the database connection

Update con.php with your database credentials.

4. Start the PHP server

Place the project inside your local server directory and start PHP/MySQL.

5. Open the project

Open the registration page in your browser and create an account.

Then:

Register
   ↓
Login
   ↓
Global Feed
   ↓
Create Post
   ↓
View Post
   ↓
Search / Delete / Edit Profile

📚 What I Learned

This project helped me practice several important backend concepts:

PHP form handling
$_POST and $_GET
Cookies
Authentication
Password hashing
Password verification
PDO
Prepared SQL statements
MySQL database interaction
CRUD operations
File uploads
Image validation
Server-side validation
SQL JOIN
Searching with LIKE
Working with the DOM and JavaScript
Building multiple connected PHP pages
🤖 AI Assistance

AI was used during the development of this project as a learning and styling assistant.

The CSS design and visual styling were developed with AI assistance.

The PHP project logic, database operations, authentication flow, validation, post functionality, and other features were developed as part of my learning and practice.

I used AI mainly to help improve the visual design and to understand and troubleshoot parts of the project.

📌 Project Status

This is a learning project and is not intended to be a production-ready social media platform.

I plan to continue improving it as I learn more about PHP, databases, authentication, security, and web development.

🎯 Future Improvements

Possible improvements for future versions:

Better session-based authentication
CSRF protection
More advanced image security
Pagination for posts
User profiles
Likes and comments
Better search functionality
Improved mobile UI
More advanced authorization
Cleaner project architecture
👨‍💻 About

This project is part of my journey learning web development and backend programming with PHP and MySQL.
