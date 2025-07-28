# Google OAuth Login Setup Guide

## Overview
This guide will help you set up Google OAuth login for your Laravel application.

## Prerequisites
- Laravel application with Laravel Socialite installed
- Google Cloud Console account
- Database access

## Step 1: Database Migration
Run the migration to add social login fields to the users table:

```bash
php artisan migrate
```

## Step 2: Google Cloud Console Setup

### 2.1 Create a Google Cloud Project
1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select an existing one
3. Enable the Google+ API (if not already enabled)

### 2.2 Create OAuth 2.0 Credentials
1. Go to "APIs & Services" > "Credentials"
2. Click "Create Credentials" > "OAuth 2.0 Client IDs"
3. Choose "Web application" as the application type
4. Add your domain to "Authorized JavaScript origins":
   - `http://localhost:8000` (for local development)
   - `https://yourdomain.com` (for production)
5. Add your callback URL to "Authorized redirect URIs":
   - `http://localhost:8000/login/google/callback` (for local development)
   - `https://yourdomain.com/login/google/callback` (for production)
6. Click "Create"
7. Copy the Client ID and Client Secret

## Step 3: Configure Application Settings

### 3.1 Admin Panel Configuration
1. Log in to your application as an admin
2. Go to Settings > Social Login
3. Enable Google Login
4. Enter your Google Client ID and Client Secret
5. Save the settings

### 3.2 Environment Variables (Optional)
You can also set these in your `.env` file:
```
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URI=https://yourdomain.com/login/google/callback
```

## Step 4: Test the Integration

### 4.1 Test Login
1. Go to your login page
2. You should see a "Continue with Google" button
3. Click the button to test the OAuth flow
4. Complete the Google authentication
5. You should be redirected back to your application and logged in

### 4.2 Check User Creation
- New users will be created automatically with their Google profile information
- Existing users with the same email will be logged in directly
- Profile pictures from Google will be downloaded and stored locally

## Features Implemented

### ✅ What's Working
- Google OAuth integration with Laravel Socialite
- Admin panel configuration for Google credentials
- Automatic user creation from Google profiles
- Profile picture download and storage
- Proper styling with Google branding
- Route protection and middleware
- Database fields for social login data

### 🔧 Technical Details
- **Controller**: `app/Http/Controllers/Auth/SocialController.php`
- **Routes**: `/login/{provider}` and `/login/{provider}/callback`
- **Settings**: Admin panel > Settings > Social Login
- **Database**: Added `provider` and `provider_id` fields to users table
- **Styling**: Custom CSS for Google button branding

### 🎨 UI Components
- Google-styled login button with proper colors
- Social login divider
- Responsive design
- Font Awesome Google icon

## Troubleshooting

### Common Issues

1. **"Invalid redirect URI" error**
   - Make sure the callback URL in Google Console matches exactly
   - Check for trailing slashes or protocol mismatches

2. **"Client ID not found" error**
   - Verify the Client ID is correctly entered in admin settings
   - Check if the Google Cloud project is active

3. **Database connection issues**
   - Ensure your database is running
   - Check your database configuration in `.env`

4. **Styling not loading**
   - Verify the CSS file path: `public/auth/css/social-login.css`
   - Check browser console for 404 errors

### Debug Steps
1. Check Laravel logs: `storage/logs/laravel.log`
2. Verify Google API is enabled in Google Cloud Console
3. Test database connection
4. Clear application cache: `php artisan cache:clear`

## Security Considerations

1. **HTTPS Required**: Use HTTPS in production for secure OAuth flow
2. **Client Secret**: Keep your Google Client Secret secure
3. **Redirect URIs**: Only add trusted domains to authorized redirect URIs
4. **User Validation**: The system validates email addresses from Google

## Support

If you encounter any issues:
1. Check the Laravel logs
2. Verify Google Cloud Console settings
3. Test with a fresh browser session
4. Ensure all required packages are installed

## Files Modified/Created

### New Files
- `public/auth/css/social-login.css` - Google button styling
- `database/migrations/2025_07_28_125036_add_social_login_fields_to_users_table.php` - Database migration
- `GOOGLE_LOGIN_SETUP.md` - This setup guide

### Modified Files
- `config/services.php` - Added Google OAuth configuration
- `app/Models/User.php` - Added social login fields to fillable array
- `app/Http/Controllers/Auth/SocialController.php` - Already existed, handles OAuth flow
- `resources/views/auth/login.blade.php` - Added Google login button
- `resources/views/layouts/auth.blade.php` - Added CSS section support
- `resources/views/backend/admin/administration/general_settings/settings.blade.php` - Added social login settings
- `resources/language/English---us.php` - Added language strings
- `routes/web.php` - Added route names for social login

## Next Steps

1. Run the database migration
2. Set up Google OAuth credentials
3. Configure the settings in admin panel
4. Test the login flow
5. Customize styling if needed

Your Google OAuth login is now ready to use! 🎉 