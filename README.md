# Wire

This Laravel application is a **multi-user platform for creating, managing, and interacting with posts**. It implements features such as likes, comments, categories, user roles, and more.

---

## Features Overview

### 1. **User Management**
- User authentication using Laravel Breeze.
- Role-based access control:
    - **Admin**: Full control over posts, users, and categories.
    - **Author**: Can create and manage their own posts.
    - **General User**: Can view posts, like posts, and leave comments.

### 2. **Post Creation and Management**
- Authors and admins can:
    - Create posts with rich content (text/images).
    - Assign categories and other authors to posts.
    - Edit or delete posts as required.
- Rich text editing support with image upload (via base64 or file storage).
- Tracks likes, views, and comments per post.

### 3. **Category Management**
- Posts can be associated with one or more categories.
- Displays posts by category with filtering.
- Accessible via `/posts/category/{id}` route.

### 4. **Likes System**
- Users can like/unlike posts.
- Like count dynamically updates and tracks liked/unliked status per user.

### 5. **Comments**
- Authenticated users can comment on posts.
- Nested relationship implemented to display comments with user details.

### 6. **Middleware Control**
- Role-based access middleware:
    - **AdminMiddleware** restricts access to admin-only routes.
    - **PostMiddleware** restricts post actions for authors and admins.
- Protects routes and ensures integrity of user operations.

### 7. **Dashboard**
- Displays all posts with:
    - Posts and their associations: categories, author(s), likes, views.
    - Categories filtering.
    - Admin-specific features for managing posts and users.

---

## Middleware

### **AdminMiddleware**
Ensures that only users with the role `admin` can access admin-specific routes. If unauthorized, it redirects the user back to the dashboard with an error message.

### **PostMiddleware**
Restricts post-related actions such as creation or editing to users with `admin` or `author` roles. If unauthorized, it returns a `403 Forbidden` response.

---

## Routes Summary

Here is an overview of the routes and their responsibilities:

### **Public Routes**
- `/`  
  Redirects authenticated users to the dashboard, or displays the welcome page for guests.

---

### **Authenticated Routes**
- **Dashboard**  
  `/dashboard`  
  Displays all posts, categories, and filters (requires login).

- **Profile Management**
    - `/profile`: User profile edit page.
    - `/profile [PATCH]`: Update user profile.
    - `/profile [DELETE]`: Delete user account.

---

### **Author and Admin Routes**
- **Post Management**
    - `GET /posts/create`: Show create post form.
    - `POST /create`: Store new post.

---

### **Admin Routes**
- **User Management**
    - `GET /admin/users`: List all users for admin management.
    - `PUT /admin/users/{id}`: Update a user.
    - `DELETE /admin/users/{id}`: Delete a user.

- **Post Administration**
    - `GET /post/{id}/edit`: Edit posts.
    - `PUT /post/{id}`: Update posts.
    - `DELETE /post/{id}`: Delete posts.

---

### **Post Interaction (Authenticated Users)**
- **View Post**  
  `GET /post/{id}`: Show a single post.

- **Post Likes**  
  `GET /like/{id}`: Like or unlike a post.

- **Post Comments**  
  `POST /comment`: Add a comment to a post.

- **Posts by Category**  
  `GET /posts/category/{id}`: Show all posts in a specific category.

---

## Database Structure

### 1. **Migrations**
- **Users Table**  
  Stores basic user information, including roles (admin/author/user).
- **Categories Table**  
  Manages categories for classifying posts.
- **Posts Table**  
  Stores metadata and content for posts.
- **Likes Table**  
  Tracks user likes for posts.
- **Comments Table**  
  Stores user comments on posts.
- **Category_Post Table**  
  Many-to-many relationship between posts and categories.
- **Post_User Table**  
  Many-to-many relationship for authors collaborating on posts.
- **Views Table**  
  Tracks and counts post views.

### 2. **Post-Related Relationships**
- A **Post** belongs to a **User** (author).
- Posts have:
    - Many comments.
    - Many categories.
    - Many authors (collaboration).
    - Many likes (Like model).
    - Many views.

---

## Core Models and Relationships

### **User Model**
- Extended from `Authenticatable`.
- Relationships:
    - **posts()**: Has many posts authored by the user.

### **Post Model**
- Stores post information, with relationships:
    - **user()**: Belongs to a user (author).
    - **categories()**: Many-to-many relationship with categories.
    - **authors()**: Many-to-many relationship with collaborating authors.
    - **likes()**: Has many likes associated with the post.
    - **comments()**: Has many comments associated with the post.
    - **views()**: Has many views associated with the post.
- Tracks if a post is liked by the authenticated user (`isLikedByUser`).

### **Category Model**
- Categories associated with posts.
- Provides methods for retrieving posts under a specific category.

### **Like Model**
- Tracks likes for posts, associated with both user and post IDs.

---

## Frontend Views

- **Dashboard**: Displays all posts and allows interaction (like, comment, and view).
- **Create Post**: Form to create new posts with categories and collaborators.
- **Edit Post**: Admins can edit post content and metadata.
- **View Post**: Displays single post details, comments, and like status.

---

## Key Functionalities and Behavior

### 1. **Likes**
- Using the `LikeController`, users can toggle like/unlike states for posts.
- Stored efficiently in the `likes` table with boolean status.

### 2. **Post Views**
- Saved automatically upon retrieving a post if it is accessed through the `show` method.

### 3. **Post Comments**
- Comments are stored with user and post associations, supporting nested views where applicable.

### 4. **Post Retrieval and Display**
- Posts include associated data:
    - Categories.
    - Likes and count of likes.
    - Authors.
    - Comments and associated users.
- Content is cleaned to remove potential harmful scripts and HTML.

### 5. **Admin-Specific Controls**
- Admins can manage both users (edit, delete) and posts (edit, delete).

---

## Tools and Dependencies

- **Authentication**: Handled by Laravel Breeze.
- **Rich Text Content**: Managed with integrated file handling for images and post content.
- **Storage System**: Used for base64 and regular image uploads.
- **Category Management**: Integrated with filtering and multi-category posts.
