# Groovehunt

A community-driven marketplace for buying and selling physical music formats like vinyl records, CDs, and cassettes. Users can create their own music collections, track historical prices for specific releases and connect with other collectors. Built with Laravel, Vue.js, and Inertia.js.

![License](https://img.shields.io/badge/license-MIT-blue.svg)
![PHP](https://img.shields.io/badge/PHP-8.1%2B-777BB4.svg)
![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20.svg)
![Vue.js](https://img.shields.io/badge/Vue.js-3.x-4FC08D.svg)

## Features

### Core Functionality

- Buy and sell physical music formats
- Create and manage personal collections
- Track your music library with detailed metadata
- Advanced search functionality powered by Typesense
- Social authentication options
- Mobile-responsive design

### For Buyers

- Advanced search with filters (format, genre, condition, price)
- Wishlist management
- Seller ratings and reviews
- Real-time chat with sellers
- Collection tracking and statistics

### For Sellers

- Easy listing creation with bulk upload option
- Inventory management tools
- Sales analytics dashboard
- Automated pricing suggestions
- Secure payment processing

## 🛠 Tech Stack

- **Backend:** Laravel 10.x
- **Frontend:** Vue.js 3.x with Composition API
- **SSR:** Inertia.js
- **Database:** PostgreSQL
- **Search Engine:** Laravel Scout with Typesense
- **Authentication:** Laravel Breeze + Socialite
- **File Storage:** Laravel Storage with AWS S3
- **Real-time Features:** Laravel Echo & Pusher
- **Payment Processing:** Stripe

## 📋 Prerequisites

Before installation, ensure you have:

- PHP >= 8.1
- Composer
- Node.js >= 16.x
- PostgreSQL >= 14.0
- Git
- [Typesense](https://typesense.org/docs/guide/install-typesense.html#option-2-local-machine-install) server running locally or hosted

## 🚀 Installation

1. **Clone the repository**

   ```bash
   git clone https://github.com/your_username/groovehunt.git
   cd groovehunt
   ```

2. **Install PHP dependencies**

   ```bash
   composer install
   ```

3. **Install Node.js dependencies**

   ```bash
   npm install
   ```

4. **Environment Setup**

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure your `.env` file with:**

   ```env
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password

   TYPESENSE_API_KEY=your_typesense_api_key
   TYPESENSE_HOST=localhost
   TYPESENSE_PORT=8108
   TYPESENSE_PROTOCOL=http

   GITHUB_CLIENT_ID=your_github_client_id
   GITHUB_CLIENT_SECRET=your_github_client_secret
   GITHUB_REDIRECT_URI=http://localhost:8000/auth/github/callback

   AWS_ACCESS_KEY_ID=your_aws_key
   AWS_SECRET_ACCESS_KEY=your_aws_secret
   AWS_DEFAULT_REGION=your_region
   AWS_BUCKET=your_bucket

   STRIPE_KEY=your_stripe_public_key
   STRIPE_SECRET=your_stripe_secret_key

   PUSHER_APP_ID=your_pusher_app_id
   PUSHER_APP_KEY=your_pusher_key
   PUSHER_APP_SECRET=your_pusher_secret
   PUSHER_APP_CLUSTER=your_pusher_cluster
   ```

6. **Database Setup**

   ```bash
   php artisan migrate
   php artisan db:seed
   ```

7. **Link Storage**

   ```bash
   php artisan storage:link
   ```

8. **Build Assets**

   ```bash
   npm run build
   ```

9. **Start the Development Server**
   ```bash
   php artisan serve
   ```

Visit `http://localhost:8000` to view the application.

## 💻 Development

1. **Start the Laravel development server**

   ```bash
   php artisan serve
   ```

2. **Watch for frontend changes**

   ```bash
   npm run dev
   ```

3. **Index existing records in Typesense**
   ```bash
   php artisan scout:import "App\Models\Record"
   ```

## 🧪 Testing

```bash
# Run PHP tests
php artisan test

# Run JavaScript tests
npm run test

# Run e2e tests
npm run test:e2e
```

## 📁 Project Structure

```
groovehunt/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Resources/
│   ├── Models/
│   └── Services/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── js/
│   │   ├── Components/
│   │   ├── Layouts/
│   │   └── Pages/
│   └── views/
└── routes/
    ├── api.php
    └── web.php
```

## 🌟 Collection Features

### Managing Collections

- Create multiple collections
- Add records from marketplace or manual entry
- Import collections from Discogs
- Track collection value and statistics
- Share collections publicly or keep private
- Generate collection insights and reports

### Collection Organization

- Custom tags and categories
- Condition grading
- Purchase history tracking
- Notes and annotations
- Want list management
- Duplicate detection

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch
   ```bash
   git checkout -b feature/AmazingFeature
   ```
3. Commit your changes
   ```bash
   git commit -m 'Add some AmazingFeature'
   ```
4. Push to the branch
   ```bash
   git push origin feature/AmazingFeature
   ```
5. Open a Pull Request

## 📝 License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.

## 🆘 Support

For support, please:

- Create an issue in the GitHub repository
- Join our Discord community [link]
- Check out our [documentation](docs/README.md)

## 🙏 Acknowledgments

- [Laravel](https://laravel.com)
- [Vue.js](https://vuejs.org)
- [Inertia.js](https://inertiajs.com)
- [Typesense](https://typesense.org)
