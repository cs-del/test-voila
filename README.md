# VOILA - Content Management System

A modern, feature-rich content management system built with Laravel 12 for managing articles, categories, comments, and user interactions.

## 🚀 Features

### 📝 Content Management
- **Article Management**: Create, edit, delete, and manage articles with rich content
- **Category System**: Organize articles with multiple categories per article
- **SEO-Friendly URLs**: All articles and categories use slug-based routing
- **Featured Images**: Support for featured images on articles
- **Draft/Publish System**: Save articles as drafts or publish them directly
- **Published Date Management**: Control when articles go live

### 💬 Interactive Features
- **Comment System**: Readers can comment on articles with moderation workflow
- **Comment Approval**: Admin can approve, reject, or moderate comments
- **Contact Form**: Built-in contact form for visitor inquiries
- **User Authentication**: Secure login and registration system

### 🛡️ Admin Panel
- **Admin Dashboard**: Comprehensive overview of all system statistics
- **Content Management**: Full CRUD operations for articles, categories, comments
- **User Management**: Role-based access control (admin/user)
- **Bulk Actions**: Perform bulk operations on comments and contacts
- **Status Management**: Toggle article status and manage comment approvals

### 🎨 User Experience
- **Responsive Design**: Mobile-friendly interface
- **Modern UI**: Clean, professional design
- **Fast Performance**: Optimized for speed and SEO

## 🛠️ Technology Stack

- **Backend**: Laravel 12 (PHP 8.2+)
- **Frontend**: Blade templates with Quill.js rich text editor
- **Database**: SQLite (default), MySQL, PostgreSQL supported
- **Authentication**: Custom authentication system built with Laravel's core Auth
- **JavaScript**: Quill.js for rich text editing

## 📋 Requirements

- PHP 8.2 or higher
- Composer
- Node.js and NPM
- SQLite database (default), with MySQL/PostgreSQL support available
- Web server (Apache/Nginx)

## 🚀 Installation & Setup

### 1. Clone the Repository
```bash
git clone <https://github.com/cs-del/test-voila>
cd voila
```

### 2. Install PHP Dependencies
```bash
composer install
```

### 3. Environment Configuration
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Configure Environment Variables
Edit `.env` file and update the following:

**For SQLite (default - no additional configuration needed):**
```env
DB_CONNECTION=sqlite
```

**For MySQL:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=voila_db
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

**For PostgreSQL:**
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=voila_db
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Database Setup
```bash
# Run migrations
php artisan migrate

# (Optional) Seed the database
php artisan db:seed
```

### 6. Install Frontend Dependencies
```bash
npm install
```

### 7. Build Assets
```bash
# For development
npm run dev

# For production
npm run build
```

### 8. Create Storage Link
```bash
php artisan storage:link
```

## 🚀 Running the Application

### Development Server
```bash
# Start Laravel development server
php artisan serve

# In another terminal, start Vite for hot reloading
npm run dev
```

### Using the Setup Script
The project includes a convenient setup script:
```bash
composer run setup
```

### Using the Development Script
For a complete development environment with concurrent processes:
```bash
composer run dev
```
This starts:
- Laravel development server
- Queue worker
- Log viewer
- Vite development server

## 🔧 Configuration

### Admin User Setup
The system uses a custom authentication system built from scratch. To create an admin user:

1. Register a new account through the registration form (default role: 'user')
2. Update the user's role in the database or via tinker:
   ```bash
   php artisan tinker
   ```
   ```php
   $user = User::where('email', 'your@email.com')->first();
   $user->role = 'admin';
   $user->save();
   ```

### File Upload Configuration
The system supports featured image uploads for articles. Ensure your `storage/app/public` directory is properly configured and accessible.

## 📁 Project Structure

```
voila/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/          # Admin panel controllers
│   │   ├── ArticleController.php
│   │   ├── CategoryController.php
│   │   ├── CommentController.php
│   │   ├── ContactController.php
│   │   └── AuthController.php
│   ├── Models/
│   │   ├── Article.php
│   │   ├── Category.php
│   │   ├── Comment.php
│   │   ├── Contact.php
│   │   └── User.php
│   └── ...
├── database/
│   ├── migrations/         # Database schema
│   └── seeders/           # Sample data
├── resources/
│   ├── views/
│   │   ├── admin/         # Admin panel views
│   │   ├── auth/          # Authentication views
│   │   ├── frontend/      # Public-facing views
│   │   └── layouts/       # Layout templates
│   ├── css/              # Stylesheets
│   └── js/               # JavaScript files
├── routes/
│   └── web.php           # Application routes
└── public/               # Static assets
```

## 🔐 Routes & Access Control

### Public Routes
- `/` - Homepage with published articles
- `/article/{slug}` - Individual article view
- `/category/{slug}` - Category archive
- `/contact` - Contact form
- `/login` - User login
- `/register` - User registration

### Admin Routes (requires admin role)
- `/admin` - Admin dashboard
- `/admin/articles` - Article management
- `/admin/categories` - Category management
- `/admin/comments` - Comment moderation
- `/admin/contacts` - Contact inquiries

## 🎯 Usage Guide

### Creating Articles
1. Log in as an admin user
2. Navigate to Admin → Articles → Create Article
3. Fill in the article details:
   - Title and slug (auto-generated from title)
   - Excerpt (summary)
   - Content (rich text editor)
   - Featured image
   - Categories (multiple selection)
   - Status (Draft/Published)
4. Click "Save Article"

### Managing Categories
1. Go to Admin → Categories
2. Create new categories with:
   - Name and unique slug
   - Description
   - Color coding (optional)
   - Status (active/inactive)

### Comment Moderation
1. Visit Admin → Comments
2. View all comments with their status (pending/approved/rejected)
3. Approve or reject individual comments
4. Use bulk actions for multiple comments

### Contact Management
1. View all contact submissions in Admin → Contacts
2. Mark messages as reviewed
3. Use bulk actions for multiple contacts

## 🧪 Testing

Run the test suite:
```bash
composer run test
```

## 🚀 Deployment

### Production Setup
```bash
# Install dependencies for production
composer install --optimize-autoloader --no-dev

# Build assets for production
npm run build

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set appropriate file permissions
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

