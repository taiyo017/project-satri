# Laravel CMS Application

A comprehensive Content Management System built with Laravel 12, featuring dynamic page management, course/career portals, and enterprise-grade two-factor authentication.

## Features

### Content Management
- **Dynamic Page Builder**: Create and manage pages with customizable sections and fields
- **Service Management**: Showcase services with rich content
- **Project Portfolio**: Display projects with galleries and details
- **Team Members**: Manage team profiles with photos and descriptions
- **Testimonials**: Collect and display client testimonials
- **FAQ System**: Organize frequently asked questions

### Course Management
- **Course Categories**: Organize courses by category
- **Course Listings**: Full course management with syllabi
- **Course Applications**: Handle student applications with email notifications
- **Application Tracking**: Mark applications as read, forward emails, export data

### Career Portal
- **Job Categories**: Organize job postings by category
- **Career Listings**: Post and manage job opportunities
- **Application Management**: Process job applications with built-in tools
- **Bulk Operations**: Export applications, send bulk emails

### Gallery System
- **Gallery Categories**: Organize media by category
- **Media Management**: Upload and manage images
- **Trash System**: Soft delete with restore functionality
- **Bulk Operations**: Manage multiple items at once

### Contact Management
- **Contact Form**: Public contact form with spam protection (rate limiting)
- **Contact Inbox**: View and manage contact submissions
- **Reply System**: Respond to contacts directly from the dashboard
- **Export Functionality**: Export contact data to Excel

### Security Features
- **Enhanced Two-Factor Authentication (2FA)**:
  - Bcrypt-hashed verification codes (not stored as plain text)
  - Email-based 6-digit codes with 10-minute expiration
  - 30-second resend cooldown with countdown timer
  - Rate limiting (3 resend attempts per minute)
  - Automatic code expiration on new code generation
  - Session-based verification flow
  
- **Authentication**:
  - Laravel Breeze integration
  - Password reset functionality
  - Email verification
  - Profile management

## Tech Stack

- **Framework**: Laravel 12 (PHP 8.2+)
- **Frontend**: 
  - Tailwind CSS 3.4
  - Alpine.js 3.4
  - Vite 7.0
- **Database**: SQLite (configurable to MySQL/PostgreSQL)
- **Email**: Configurable mail drivers
- **Queue**: Database-based queue system
- **Excel Export**: Maatwebsite Excel 3.1

## Requirements

- PHP 8.2 or higher
- Composer
- Node.js & NPM
- SQLite (or MySQL/PostgreSQL)

## Installation

### Quick Setup
```bash
composer setup
```

This command will:
1. Install PHP dependencies
2. Copy `.env.example` to `.env`
3. Generate application key
4. Run database migrations
5. Install NPM dependencies
6. Build frontend assets

### Manual Setup
```bash
# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate

# Build assets
npm run build
```

## Configuration

### Environment Variables
Edit `.env` file to configure:

```env
# Application
APP_NAME="Your CMS Name"
APP_URL=http://localhost

# Database (SQLite by default)
DB_CONNECTION=sqlite

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-username
MAIL_PASSWORD=your-password
MAIL_FROM_ADDRESS=noreply@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Initial Settings
After installation, log in to the admin panel and configure:
1. Navigate to `/settings`
2. Set up site name, logo, and contact information
3. Configure email settings for 2FA and notifications

## Development

### Start Development Server
```bash
composer dev
```

This runs concurrently:
- Laravel development server (port 8000)
- Queue worker
- Log viewer (Laravel Pail)
- Vite dev server (hot reload)

### Individual Commands
```bash
# Start Laravel server
php artisan serve

# Watch frontend assets
npm run dev

# Run queue worker
php artisan queue:listen

# View logs
php artisan pail
```

## Two-Factor Authentication

### Enabling 2FA
1. Log in to your account
2. Go to Profile or Settings
3. Enable "Two-Factor Authentication"
4. On next login, you'll receive a 6-digit code via email

### Security Implementation
- Codes are stored as **bcrypt hashes** (not plain text)
- Database breach won't expose usable codes
- Codes expire after 10 minutes
- Used codes are immediately deleted
- Rate limiting prevents brute force attacks



### Default Routes
- Dashboard: `/dashboard`
- Pages: `/pages`
- Services: `/services`
- Projects: `/projects`
- Team Members: `/team-members`
- Courses: `/courses`
- Careers: `/careers`
- Galleries: `/galleries`
- Contacts: `/contacts`
- Settings: `/settings`

## Frontend Routes

- Home: `/` (redirects to `/home`)
- Dynamic Pages: `/{slug}`
- Course Details: `/course/{slug}`
- Career Details: `/career/{slug}`
- Contact Form: `/contact-submit` (POST)

## Testing

```bash
composer test
```

Or run PHPUnit directly:
```bash
php artisan test
```

## Database Structure

### Core Tables
- `users` - Admin users with 2FA support
- `settings` - Site-wide configuration
- `pages` - Dynamic pages
- `sections` - Page sections with fields
- `section_fields` - Dynamic field data

### Content Tables
- `services` - Service listings
- `projects` - Project portfolio
- `team_members` - Team profiles
- `testimonials` - Client testimonials
- `faqs` - FAQ entries

### Course System
- `course_categories` - Course categories
- `courses` - Course listings
- `course_syllabi` - Course curriculum
- `course_applications` - Student applications

### Career System
- `job_categories` - Job categories
- `careers` - Job postings
- `career_applications` - Job applications

### Other
- `galleries` & `gallery_categories` - Media management
- `contacts` & `contact_replies` - Contact management
- `two_factor_logins` - 2FA verification codes (hashed)

## Security Best Practices

### Implemented
- ✅ Bcrypt password hashing
- ✅ CSRF protection on all forms
- ✅ Rate limiting on sensitive endpoints
- ✅ Two-factor authentication with hashed codes
- ✅ Session regeneration on login
- ✅ SQL injection protection (Eloquent ORM)
- ✅ XSS protection (Blade templating)

### Recommendations
- Use HTTPS in production
- Configure proper CORS policies
- Set up regular database backups
- Monitor failed login attempts
- Keep dependencies updated
- Use environment-specific configurations

## Deployment

### Production Checklist
- [ ] Set `APP_ENV=production` in `.env`
- [ ] Set `APP_DEBUG=false`
- [ ] Configure production database
- [ ] Set up mail server (SMTP/SES/Mailgun)
- [ ] Run `composer install --optimize-autoloader --no-dev`
- [ ] Run `npm run build`
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Run `php artisan view:cache`
- [ ] Set up queue worker as daemon
- [ ] Configure proper file permissions
- [ ] Set up SSL certificate
- [ ] Configure backup strategy

### Queue Worker (Production)
```bash
# Using Supervisor (recommended)
php artisan queue:work --tries=3 --timeout=90

# Or use Laravel Horizon for Redis queues
```

## Maintenance

### Clear Caches
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Database Maintenance
```bash
# Run migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Fresh install (WARNING: deletes all data)
php artisan migrate:fresh
```

## Troubleshooting

### 2FA Issues
- **"Invalid code" error**: Ensure mail is configured correctly and codes are being sent
- **Codes not working**: Run `php artisan migrate` to ensure hash migration is applied
- **Can't resend code**: Wait for 30-second countdown or check rate limiting

### General Issues
- **500 Error**: Check `storage/logs/laravel.log`
- **Permission errors**: Ensure `storage/` and `bootstrap/cache/` are writable
- **Asset not loading**: Run `npm run build` and clear browser cache

## Contributing

This is a private project. For questions or issues, contact the development team.

## License

This project is proprietary software. All rights reserved.

## Support

For technical support or questions:
- Check the documentation in this README
- Review the detailed guides (TWO_FACTOR_*.md files)
- Contact the development team

---

**Built with Laravel** - The PHP Framework for Web Artisans
