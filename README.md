📖 Mini Blog (PHP + SQLite)

A simple blog platform built with pure PHP and SQLite.
This project demonstrates PHP fundamentals, including CRUD operations, sessions, pagination, search, categories, and flash messages — without using a framework.

🚀 Features

Create, Read, Update, Delete (CRUD) posts

SQLite database (lightweight, file-based)

Pagination (browse posts page by page)

Search (filter posts by title/content)

Categories (organize posts by topic)

Flash messages (success messages after actions)

Clean UI styling with CSS

Confirmation dialogs for delete actions

Basic security practices:

Prepared statements (prevent SQL injection)

htmlspecialchars() (prevent XSS)

📂 Project Structure
Mini-Blog/
│
├── blog.sqlite        # SQLite database file
├── index.php          # Home page (list + search + pagination + filter)
├── new.php            # Create a new post
├── edit.php           # Edit an existing post
├── delete.php         # Delete a post
├── style.css          # Basic CSS styling
└── README.md          # Project documentation

⚙️ Setup Instructions
1. Clone the repository
git clone https://github.com/yourusername/mini-blog-php.git
cd mini-blog-php

2. Ensure PHP and SQLite are installed

Check versions:

php -v
sqlite3 --version

3. Create the database

Run in terminal:

sqlite3 blog.sqlite


Inside the SQLite shell, create tables:

CREATE TABLE posts (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    content TEXT NOT NULL,
    created_at DATETIME NOT NULL,
    category_id INTEGER
);

CREATE TABLE categories (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL
);

INSERT INTO categories (name) VALUES ('Tech'), ('Lifestyle'), ('News');
.exit

4. Start PHP’s built-in server
php -S localhost:8000


Open your browser at http://localhost:8000/index.php

🛠️ Technologies Used

PHP 8+

SQLite3

PDO (PHP Data Objects) → database abstraction layer

HTML + CSS

📚 Concepts Demonstrated

This project is an educational resource to learn core PHP concepts:

PHP Basics

Embedding PHP in HTML

Variables, arrays, superglobals

Forms & HTTP

Handling GET & POST requests

Processing form data

Database (SQLite)

Connecting with PDO

CRUD queries

Prepared statements

Sessions

Flash messages

State management

Web Features

Pagination (LIMIT OFFSET)

Search (LIKE %term%)

Filtering by category

Security

SQL injection prevention

XSS prevention

🔑 How It Works
Home (index.php)

Shows all posts with pagination and a search bar.

Allows filtering by category.

Provides Edit/Delete actions per post.

New Post (new.php)

Form to create a post with a title, content, and category.

After saving, it redirects with a flash message.

Edit Post (edit.php)

Loads existing post into form.

Allows updating fields.

Delete Post (delete.php)

Deletes a post by ID.

Redirects with flash message.

Flash Messages

Stored in $_SESSION['flash'].

Displayed once, then cleared.

📈 Future Improvements

User authentication (login/register)

Comment system

Rich text editor for posts

File uploads (images in posts)

REST API (JSON responses for frontend frameworks)

Move to OOP (MVC structure)

Deploy to a web server (Apache/Nginx)

👨‍💻 Author

Built with ❤️ by Marcel as part of a PHP learning journey.
