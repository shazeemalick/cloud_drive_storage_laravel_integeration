# CloudDrive Microservice 🚀

A premium, folder-based Google Drive storage microservice built with Laravel. This platform allows users to manage multiple Google Drive accounts, create folders, and upload/download assets through both a beautiful web dashboard and a RESTful API.

Designed to be integrated as a backend storage layer for task management platforms, freelance marketplaces, or any application requiring cloud asset management.

## ✨ Key Features

- **Dual-Drive Support**: Connect and manage multiple Google Drive accounts (Primary & Secondary) simultaneously.
- **Email-Based Authentication**: Seamless, password-less entry for users using only their email addresses.
- **RESTful API**: Full API support for external integrations (Create Folders, Upload Files, Download Assets).
- **Intelligent Routing**: Automatically routes file uploads to the correct Google Drive account based on folder selection.
- **Premium Dashboard**: A modern, high-end "Command Center" UI for visual asset management.
- **MySQL Persistence**: Tracks file metadata, folder hierarchies, and disk associations locally for ultra-fast retrieval.

## 🛠️ Tech Stack

- **Backend**: Laravel 12.x
- **Storage**: Google Drive API (via `yaza/laravel-google-drive-storage`)
- **Database**: MySQL 8.x
- **API Security**: Laravel Sanctum
- **Frontend**: Blade with Modern Vanilla CSS (Glassmorphism & Radial Gradients)

## 🚀 Getting Started

### Prerequisites

- PHP 8.2 or higher
- Composer
- MySQL Database
- Google Cloud Console Project (with Drive API enabled)

### Installation

1. **Clone the repository**:
   ```bash
   git clone https://github.com/yourusername/clouddrive-microservice.git
   cd clouddrive-microservice
   ```

2. **Install dependencies**:
   ```bash
   composer install
   ```

3. **Environment Setup**:
   Copy the example environment file and configure your credentials:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Configuration**:
   Update your `.env` with your MySQL credentials and run migrations:
   ```bash
   php artisan migrate
   ```

### 🔑 Google Drive Configuration

Add your Google API credentials to the `.env` file:

```env
# PRIMARY DRIVE
GOOGLE_DRIVE_CLIENT_ID=your_id
GOOGLE_DRIVE_CLIENT_SECRET=your_secret
GOOGLE_DRIVE_REFRESH_TOKEN=your_refresh_token
GOOGLE_DRIVE_FOLDER=uploads

# SECONDARY DRIVE (Optional)
GOOGLE_DRIVE_CLIENT_ID_TWO=your_id_2
GOOGLE_DRIVE_CLIENT_SECRET_TWO=your_secret_2
GOOGLE_DRIVE_REFRESH_TOKEN_TWO=your_refresh_token_2
GOOGLE_DRIVE_FOLDER_TWO=uploads
```

## 📡 API Usage

The microservice provides clean endpoints for external platform integration.

| Method | Endpoint | Description |
| :--- | :--- | :--- |
| `POST` | `/api/drive/folders` | Create a folder on Drive & get its ID |
| `POST` | `/api/drive/upload` | Upload a file to a specific folder |
| `GET` | `/api/drive/files/{id}` | Retrieve file metadata |
| `GET` | `/api/drive/download/{id}` | Direct file download stream |

For full details, refer to the [API Documentation](api_documentation.txt).

## 🌍 Deployment

To host this on platforms like Hostinger:
1. Ensure PHP version is 8.2+.
2. Point your domain to the `/public` directory.
3. Run `php artisan optimize` for production speed.
4. See `deployment_guide.txt` for detailed troubleshooting.

## 📄 License

The Laravel framework is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
